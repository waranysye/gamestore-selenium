<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\GameModel;

class Game extends BaseController
{
    public function index()
    {
        $model = new GameModel();

        $games = $model->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data' => $games
        ]);
    }

    public function show($id)
    {
        $model = new GameModel();

        $game = $model->find($id);

        return $this->response->setJSON([
            'status' => true,
            'data' => $game
        ]);
    }
}