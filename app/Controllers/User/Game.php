<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\GameImageModel;
use App\Models\GameModel;
use App\Models\UserGameModel;

class Game extends BaseController
{
    protected GameModel $gameModel;
    protected GameImageModel $gameImageModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
        $this->gameImageModel = new GameImageModel();
    }

    public function detail($id)
    {
        $game = $this->gameModel->getGameDetail($id);

        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userId = session()->get('user_id');
        $isLoggedIn = !empty($userId);

        $inCart = false;
        $owned = false;
        $downloaded = false;

        if ($isLoggedIn) {
            $cartModel = new CartModel();
            $cartItemModel = new CartItemModel();
            $userGameModel = new UserGameModel();

            $cart = $cartModel->getUserCart($userId);

            if ($cart) {
                $inCart = $cartItemModel
                    ->where('cart_id', $cart['id'])
                    ->where('game_id', $id)
                    ->first() ? true : false;
            }

            $owned = $userGameModel->userOwnsGame($userId, $id);

            if ($owned) {
                $row = $userGameModel
                    ->where('user_id', $userId)
                    ->where('game_id', $id)
                    ->first();

                $downloaded = !empty($row['installed']);
            }
        }

        $images = $this->gameImageModel->getImagesByGame($id);

        return view('User/detail', [
            'game'         => $game,
            'images'       => $images,
            'relatedGames' => [],
            'inCart'       => $inCart,
            'owned'        => $owned,
            'downloaded'   => $downloaded,
            'isLoggedIn'   => $isLoggedIn
        ]);
    }
}