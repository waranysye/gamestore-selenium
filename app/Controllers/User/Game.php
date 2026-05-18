<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\CartModel;
use App\Models\UserGameModel;

class Game extends BaseController
{
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    public function detail($id)
    {
        $game = $this->gameModel
            ->select('games.*, categories.name as category_name')
            ->join('categories', 'categories.id = games.category_id')
            ->where('games.id', $id)
            ->first();

        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userId = session()->get('user_id');

        // default guest state
        $inCart = false;
        $owned = false;
        $downloaded = false;

        // hanya hitung kalau login
        if ($userId) {

            $cartModel = new CartModel();

            $inCart = $cartModel
                ->where('user_id', $userId)
                ->where('game_id', $id)
                ->first() ? true : false;

            $userGameModel = new UserGameModel();

            $owned = $userGameModel->userOwnsGame($userId, $id);

            if ($owned) {
                $row = $userGameModel
                    ->where('user_id', $userId)
                    ->where('game_id', $id)
                    ->first();

                $downloaded = !empty($row['installed']);
            }
        }

        return view('User/detail', [
            'game'       => $game,
            'images'     => [],
            'inCart'     => $inCart,
            'owned'      => $owned,
            'downloaded' => $downloaded,
            'isGuest'    => !$userId // 🔥 penting untuk UI control
        ]);
    }
}