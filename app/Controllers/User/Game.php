<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;

class Game extends BaseController
{
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    public function detail($slug)
    {
        $game = $this->gameModel
            ->select('games.*, categories.name as category')
            ->join('categories', 'categories.id = games.category_id')
            ->where('games.slug', $slug)
            ->first();

        if (!$game) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('User/game_detail', compact('game'));
    }
}