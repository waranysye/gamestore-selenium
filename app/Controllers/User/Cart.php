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
        return redirect()->to('/login');
    }

    // Ambil cart user
    $cart = $this->cartModel->getUserCart($userId);

    if (!$cart) {
        return view('User/cart', [
            'cartItems' => []
        ]);
    }

    // Ambil item dari CartItemModel (pakai function yang sudah ada)
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

        // Ambil game
        $game = $this->gameModel->find($gameId);

        if (!$game) {
            return redirect()->back()->with('error', 'Game not found.');
        }

        // Ambil / buat cart
        $cart = $this->cartModel->getUserCart($userId);

        if (!$cart) {
            $cartId = $this->cartModel->insert([
                'user_id' => $userId
            ]);
        } else {
            $cartId = $cart['id'];
        }

        // Cegah game dobel
        if ($this->cartItemModel->isGameInCart($cartId, $gameId)) {
            return redirect()->back()
                ->with('error', 'Game already in cart.');
        }

        // Insert cart item
        $this->cartItemModel->insert([
            'cart_id' => $cartId,
            'game_id' => $gameId,
            'price'   => $game['price'], // snapshot harga
        ]);

        return redirect()->to('/cart')
            ->with('success', 'Game added to cart.');
    }

    /**
     * REMOVE ITEM
     */
    public function remove($id)
    {
        $this->cartItemModel->delete($id);
        return redirect()->to('/cart');
    }
}