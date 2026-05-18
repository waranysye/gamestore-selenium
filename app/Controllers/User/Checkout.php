<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\PaymentTransactionModel;
use App\Models\UserGameModel;
use App\Models\GameModel;

class Checkout extends BaseController
{
    protected $cart;
    protected $cartItem;
    protected $order;
    protected $orderDetail;
    protected $payment;
    protected $userGame;
    protected $game;

    public function __construct()
    {
        $this->cart        = new CartModel();
        $this->cartItem    = new CartItemModel();
        $this->order       = new OrderModel();
        $this->orderDetail = new OrderDetailModel();
        $this->payment     = new PaymentTransactionModel();
        $this->userGame    = new UserGameModel();
        $this->game        = new GameModel();
    }

    // ==========================
    // CHECKOUT PAGE
    // ==========================
    public function index()
    {
        $userId = session()->get('user_id');

        $buyNowGameId = session()->get('buy_now_item');

        // BUY NOW
        if ($buyNowGameId) {

            $owned = $this->userGame
                ->where('user_id', $userId)
                ->where('game_id', $buyNowGameId)
                ->first();

            if ($owned) {
                session()->remove('buy_now_item');
                return redirect()->to('/library');
            }

            $game = $this->game->find($buyNowGameId);

            if (!$game) {
                return redirect()->to('/');
            }

            $items = [[
                'game_id'     => $game['id'],
                'title'       => $game['title'],
                'cover_image' => $game['cover_image'],
                'price'       => $game['price']
            ]];

            return view('User/checkout', [
                'items' => $items,
                'total' => $game['price'],
                'mode'  => 'buy_now'
            ]);
        }

        // CART
        $cart = $this->cart->where('user_id', $userId)->first();

        if (!$cart) {
            return redirect()->to('/cart');
        }

        $items = $this->cartItem
            ->select('cart_items.*, games.title, games.cover_image')
            ->join('games', 'games.id = cart_items.game_id')
            ->where('cart_id', $cart['id'])
            ->findAll();

        if (!$items) {
            return redirect()->to('/cart');
        }

        $total = array_sum(array_column($items, 'price'));

        return view('User/checkout', [
            'items' => $items,
            'total' => $total,
            'mode'  => 'cart'
        ]);
    }

    // ==========================
    // BUY NOW
    // ==========================
    public function buyNow()
    {
        $gameId = $this->request->getPost('game_id');

        if (!$gameId) {
            return redirect()->back();
        }

        session()->set('buy_now_item', $gameId);

        return redirect()->to('/checkout');
    }

    // ==========================
    // CANCEL ORDER
    // ==========================
    public function cancel($orderId)
    {
        $order = $this->order->find($orderId);

        if (!$order) {
            return redirect()->to('/');
        }

        $this->order->update($orderId, [
            'status' => 'cancelled'
        ]);

        $this->payment
            ->where('order_id', $orderId)
            ->set(['status' => 'failed'])
            ->update();

        return redirect()->to('/payment/status/' . $orderId);
    }

    // ==========================
    // CONFIRM PAYMENT
    // ==========================
    public function confirm()
    {
        $userId        = session()->get('user_id');
        $paymentMethod = $this->request->getPost('payment_method');

        if (!$paymentMethod) {
            return redirect()->back();
        }

        $buyNowGameId = session()->get('buy_now_item');

        // =====================
        // BUY NOW MODE
        // =====================
        if ($buyNowGameId) {

            $game = $this->game->find($buyNowGameId);

            if (!$game) {
                return redirect()->to('/');
            }

            $items = [[
                'game_id' => $game['id'],
                'price'   => $game['price']
            ]];

            $total = $game['price'];

            session()->remove('buy_now_item');

        } else {

            // =====================
            // CART MODE
            // =====================
            $cart = $this->cart->where('user_id', $userId)->first();

            if (!$cart) {
                return redirect()->to('/cart');
            }

            $items = $this->cartItem
                ->where('cart_id', $cart['id'])
                ->findAll();

            if (!$items) {
                return redirect()->to('/cart');
            }

            $total = array_sum(array_column($items, 'price'));
        }

        // =====================
        // CREATE ORDER (PENDING)
        // =====================
        $orderId = $this->order->insert([
            'user_id'     => $userId,
            'total_price' => $total,
            'status'      => 'pending'
        ]);

        // =====================
        // SAVE ORDER DETAILS
        // =====================
        foreach ($items as $item) {
            $this->orderDetail->insert([
                'order_id' => $orderId,
                'game_id'  => $item['game_id'],
                'price'    => $item['price']
            ]);
        }

        // =====================
        // PAYMENT PENDING
        // =====================
        $this->payment->insert([
            'order_id'       => $orderId,
            'payment_method' => $paymentMethod,
            'transaction_id' => 'TXN-' . time(),
            'gross_amount'   => $total,
            'status'         => 'pending',
            'paid_at'        => null
        ]);

        // =====================
        // CLEAR CART
        // =====================
        if (isset($cart)) {
            $this->cartItem->where('cart_id', $cart['id'])->delete();
        }

        return redirect()->to('/payment/status/' . $orderId);
    }

    // ==========================
    // PAYMENT STATUS
    // ==========================
    public function status($orderId)
    {
        $order = $this->order->find($orderId);

        if (!$order) {
            return redirect()->to('/');
        }

        $payment = $this->payment
            ->where('order_id', $orderId)
            ->first();

        if (!$payment) {
            return redirect()->to('/');
        }

        $items = $this->orderDetail
            ->select('order_details.*, games.title')
            ->join('games', 'games.id = order_details.game_id')
            ->where('order_id', $orderId)
            ->findAll();

        return view('User/paymentstatus', [
            'order'   => $order,
            'payment' => $payment,
            'items'   => $items
        ]);
    }
}