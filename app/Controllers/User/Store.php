<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\UserGameModel;

class Store extends BaseController
{
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    /**
     * STORE DASHBOARD (PUBLIC)
     */
    public function index()
    {
        $category = $this->request->getGet('category');

        $builder = $this->gameModel
            ->select('games.*, categories.name as category_name, categories.slug')
            ->join('categories', 'categories.id = games.category_id');

        if ($category) {
            $builder->where('categories.slug', $category);
        }

        return view('User/index', [
            'games'          => $builder->findAll(),
            'activePage'     => 'store',
            'activeCategory' => $category ?? 'all'
        ]);
    }

    /**
     * GAME DETAIL (PUBLIC + PERSONALIZED STATE)
     */
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
        $isLoggedIn = !empty($userId);

        $inCart = false;
        $owned = false;
        $downloaded = false;

        if ($isLoggedIn) {

            $cartModel = new CartModel();
            $cartItemModel = new CartItemModel();
            $userGameModel = new UserGameModel();

            // 🔥 FIX: pakai cart_items, bukan cart
            $cart = $cartModel->getUserCart($userId);

            if ($cart) {
                $inCart = $cartItemModel
                    ->where('cart_id', $cart['id'])
                    ->where('game_id', $id)
                    ->first() ? true : false;
            }

            // ownership check
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
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    /**
     * SEARCH GAME
     */
    public function search()
    {
        $keyword = trim($this->request->getGet('q'));

        $games = [];

        if ($keyword) {
            $games = $this->gameModel->searchGames($keyword);
        }

        return view('User/search', [
            'games'   => $games,
            'keyword' => $keyword
        ]);
    }
}