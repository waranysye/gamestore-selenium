<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;

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

    $data = [
        'games'          => $builder->findAll(),
        'activeCategory' => $category ?? 'all'
    ];

    return view('User/index', [
    'games' => $data['games'],
    'activePage' => 'store',
    'activeCategory' => $data['activeCategory']
]);
}

    /**
     * GAME DETAIL (LOGIN REQUIRED – via route filter)
     */
    public function detail($id)
    {
        $game = $this->gameModel->getGameDetail($id);

        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('User/detail', compact('game'));
    }

    /**
     * SEARCH GAME (LOGIN REQUIRED)
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