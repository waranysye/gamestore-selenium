<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\GameModel;

class Cart extends BaseController
{
    protected CartModel $cartModel;
    protected CartItemModel $cartItemModel;
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->cartModel     = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->gameModel     = new GameModel();
    }

    /**
     * CART PAGE
     */
    public function index()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'));
        }

        $cart = $this->cartModel->getUserCart($userId);

        if (!$cart) {
            return view('User/cart', [
                'cartItems' => []
            ]);
        }

        $cartItems = $this->cartItemModel->getCartItems($cart['id']);

        return view('User/cart', [
            'cartItems' => $cartItems
        ]);
    }

    /**
     * ADD GAME TO CART
     */
    public function add($gameId)
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to(base_url('login'));
        }

        $game = $this->gameModel->find($gameId);

        if (!$game) {
            return redirect()->to(base_url('cart'))
                ->with('error', 'Game not found');
        }

        $cart = $this->cartModel->getUserCart($userId);

        if (!$cart) {
            $cartId = $this->cartModel->insert([
                'user_id' => $userId
            ]);
        } else {
            $cartId = $cart['id'];
        }

        // 🔥 FIX: cegah duplicate item
        $exists = $this->cartItemModel->isGameInCart($cartId, $gameId);

        if (!$exists) {
            $this->cartItemModel->insert([
                'cart_id' => $cartId,
                'game_id' => $gameId,
                'price'   => $game['price'],
            ]);
        }

        // ✅ SELALU REDIRECT KE CART (STABIL UNTUK SELENIUM)
        return redirect()->to(base_url('cart'));
    }

    /**
     * REMOVE ITEM
     */
    public function remove($id)
{
    $userId = session()->get('user_id');
    if (!$userId) {
        return redirect()->to(base_url('login'));
    }

    $cart = $this->cartModel->getUserCart($userId);
    
    // Cari item berdasarkan ID primary key-nya
    $item = $this->cartItemModel->where([
        'id'      => $id, 
        'cart_id' => $cart['id']
    ])->first();

    if ($item) {
        // Gunakan $item['id'] untuk memastikan kita menghapus baris yang benar
        $this->cartItemModel->delete($item['id']);
    }

    return redirect()->to(base_url('cart'));
}
}