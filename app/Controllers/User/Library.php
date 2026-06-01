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

    /**
     * LIBRARY PAGE
     */
    public function index()
    {
        $userId = session()->get('user_id');

        // 🔒 SECURITY CHECK
        if (!$userId) {
            return redirect()->to('/login');
        }

        $games = $this->userGameModel
            ->select('
                games.id,
                games.title,
                games.cover_image,
                games.game_file,
                games.size,
                categories.name as category,
                user_games.installed
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

    /**
     * DOWNLOAD GAME
     */
    public function download($gameId)
    {
        $userId = session()->get('user_id');

        // 🔒 SECURITY CHECK
        if (!$userId) {
            return redirect()->to('/login');
        }

        $this->userGameModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->set(['installed' => 1])
            ->update();

        return redirect()->to('/download/game/' . $gameId);
    }

    /**
     * UNINSTALL GAME
     */
    public function uninstall($gameId)
    {
        $userId = session()->get('user_id');

        // 🔒 SECURITY CHECK
        if (!$userId) {
            return redirect()->to('/login');
        }

        $this->userGameModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->set(['installed' => 0])
            ->update();

        return redirect()->to('/library')
            ->with('success', 'Game berhasil dihapus dari perangkat');
    }
}