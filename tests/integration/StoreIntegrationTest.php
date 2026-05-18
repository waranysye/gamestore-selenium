<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\GameModel;

class StoreIntegrationTest extends BaseIntegrationTest
{
    public function testGameCanBeFetched()
{
    $catModel = new \App\Models\CategoryModel();
    $gameModel = new \App\Models\GameModel();

    $catId = $catModel->insert(['name' => 'RPG']);
    $gameId = $gameModel->insert([
        'title' => 'Elden Ring', 
        'category_id' => $catId, 
        'price' => 500000,
        'stock' => 10
    ]);

    $game = $gameModel->getGameDetail($gameId); // Gunakan ID yang baru dibuat

    $this->assertIsArray($game);
}

    public function testTrendingGames()
    {
        $model = new GameModel();

        $games = $model->getTrendingGames(2);

        $this->assertIsArray($games);
    }
}