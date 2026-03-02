<?php

namespace App\Models;

use CodeIgniter\Model;

class UserGameModel extends Model
{
    protected $table            = 'user_games';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'game_id',
        'order_detail_id',
        'acquired_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

public function getUserLibrary(int $userId): array
    {
        return $this->select('
                games.id,
                games.title,
                games.cover_image,
                games.game_file,
                user_games.acquired_at
            ')
            ->join('games', 'games.id = user_games.game_id')
            ->where('user_games.user_id', $userId)
            ->orderBy('user_games.acquired_at', 'DESC')
            ->findAll();
    }

    /*
    |--------------------------------------------------------------------------
    | Check If User Already Owns Game (BOOLEAN)
    |--------------------------------------------------------------------------
    */
     public function userOwnsGame($userId, $gameId): bool
    {
        return $this->where([
            'user_id' => $userId,
            'game_id' => $gameId
        ])->countAllResults() > 0;
    }
}
