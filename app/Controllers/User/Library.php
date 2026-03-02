<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserGameModel;

class Library extends BaseController
{
    protected $userGameModel;

    public function __construct()
    {
        $this->userGameModel = new UserGameModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $games = $this->userGameModel
    ->select('
        games.id,
        games.title,
        games.cover_image,
        games.game_file,
        games.size,
        categories.name as category
    ')
    ->join('games', 'games.id = user_games.game_id')
    ->join('categories', 'categories.id = games.category_id', 'left')
    ->where('user_games.user_id', $userId)
    ->orderBy('user_games.acquired_at', 'DESC')
    ->findAll();

        return view('User/library', [
    'games' => $games,
    'activePage' => 'library'
]);
    }
}