<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table            = 'games';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'description',
        'price',
        'cover_image',
        'game_file',
        'category_id',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

     /**
     * TRENDING GAMES (LIMIT 4)
     */
    public function getTrendingGames(int $limit = 4): array
    {
        return $this->select('
                games.id,
                games.title,
                games.price,
                games.cover_image,
                categories.name AS category_name
            ')
            ->join('categories', 'categories.id = games.category_id')
            ->orderBy('games.created_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    /**
     * LATEST GAMES (LIMIT 4)
     */
    public function getLatestGames(int $limit = 4): array
    {
        return $this->select('
                games.id,
                games.title,
                games.price,
                games.cover_image,
                categories.name AS category_name
            ')
            ->join('categories', 'categories.id = games.category_id')
            ->orderBy('games.created_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    /**
     * GAME DETAIL
     */
    public function getGameDetail(int $id): ?array
    {
        return $this->select('
                games.*,
                categories.name AS category_name
            ')
            ->join('categories', 'categories.id = games.category_id')
            ->where('games.id', $id)
            ->first();
    }

    /**
     * SEARCH GAMES
     */
    public function searchGames(string $keyword): array
    {
        return $this->select('
                games.id,
                games.title,
                games.price,
                games.cover_image,
                categories.name AS category_name
            ')
            ->join('categories', 'categories.id = games.category_id')
            ->like('games.title', $keyword)
            ->orderBy('games.created_at', 'DESC')
            ->findAll();
    }
}
