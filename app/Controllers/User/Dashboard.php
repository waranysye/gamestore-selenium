<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;

class Dashboard extends BaseController
{
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    // =============================
    // STORE PAGE
    // =============================
    public function index()
    {
        $categorySlug = $this->request->getGet('category');

        $builder = $this->gameModel
            ->select('games.*, categories.name as category_name, categories.slug')
            ->join('categories', 'categories.id = games.category_id');

        // FILTER CATEGORY
        if ($categorySlug) {
            $builder->where('categories.slug', $categorySlug);
        }

        $games = $builder->findAll();

        return view('User/index', [
            'games'          => $games,
            'activeCategory' => $categorySlug ?? 'all',
            'activePage'     => 'store',
            'trending'       => $this->gameModel->getTrending(4),
            'latest'         => $this->gameModel->getLatest(4),
        ]);
    }

    // =============================
    // DETAIL PAGE
    // =============================
    public function detail($id)
    {
        $game = $this->gameModel
            ->select('games.*, categories.name as category_name')
            ->join('categories', 'categories.id = games.category_id')
            ->find($id);

        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // CEK CART DI SESSION
        $cart = session()->get('cart') ?? [];

        // TRUE jika game sudah ada di cart
        $inCart = isset($cart[$id]);

        return view('User/detail', [
            'game'       => $game,
            'activePage' => 'store',
            'inCart'     => $inCart
        ]);
    }
}