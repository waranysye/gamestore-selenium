<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserGameModel;
use App\Models\GameModel;

class Download extends BaseController
{
    protected $userGameModel;
    protected $gameModel;

    public function __construct()
    {
        $this->userGameModel = new UserGameModel();
        $this->gameModel     = new GameModel();
    }

    /**
     * DOWNLOAD GAME FILE
     * URL: /download/game/{game_id}
     */
    public function game($gameId)
    {
        // 1️⃣ Pastikan user login
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // 2️⃣ Cek apakah user memiliki game ini
        $ownedGame = $this->userGameModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        if (!$ownedGame) {
            // Tidak punya game → redirect ke library
            return redirect()
                ->to('/library')
                ->with('error', 'You do not own this game.');
        }

        // 3️⃣ Ambil data game
        $game = $this->gameModel->find($gameId);
        if (!$game || empty($game['game_file'])) {
            return redirect()
                ->to('/library')
                ->with('error', 'Game file not found.');
        }

        // 4️⃣ Lokasi file
        $filePath = ROOTPATH . 'public/uploads/games/' . $game['game_file'];

        if (!file_exists($filePath)) {
            return redirect()
                ->to('/library')
                ->with('error', 'File does not exist on server.');
        }

        // 5️⃣ Download response
        return $this->response->download($filePath, null);
    }
}