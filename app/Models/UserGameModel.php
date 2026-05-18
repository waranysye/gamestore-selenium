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

    protected $allowedFields = [
        'user_id',
        'game_id',
        'order_detail_id',
        'acquired_at',
        'installed' // ✅ FIX WAJIB
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;

    protected $beforeInsert = [];
    protected $afterInsert  = [];
    protected $beforeUpdate = [];
    protected $afterUpdate  = [];
    protected $beforeFind   = [];
    protected $afterFind    = [];
    protected $beforeDelete = [];
    protected $afterDelete  = [];

    // ==========================
    // USER LIBRARY
    // ==========================
    public function getUserLibrary(int $userId): array
    {
        return $this->select('
                games.id,
                games.title,
                games.cover_image,
                games.game_file,
                games.size,
                user_games.installed,
                user_games.acquired_at
            ')
            ->join('games', 'games.id = user_games.game_id')
            ->where('user_games.user_id', $userId)
            ->orderBy('user_games.acquired_at', 'DESC')
            ->findAll();
    }

    // ==========================
    // CHECK OWNERSHIP
    // ==========================
    public function userOwnsGame(int $userId, int $gameId): bool
    {
        return $this->where([
            'user_id' => $userId,
            'game_id' => $gameId
        ])->countAllResults() > 0;
    }

    // ==========================
    // ADD GAME TO LIBRARY
    // ==========================
    public function addGame(
        int $userId,
        int $gameId,
        ?int $orderDetailId = null
    ): bool {
        if ($this->userOwnsGame($userId, $gameId)) {
            return false;
        }

        return $this->insert([
            'user_id'         => $userId,
            'game_id'         => $gameId,
            'order_detail_id' => $orderDetailId,
            'acquired_at'     => date('Y-m-d H:i:s'),
            'installed'       => 0 // ✅ default state
        ]) ? true : false;
    }

    // ==========================
    // REMOVE GAME FROM LIBRARY
    // ==========================
    public function removeGame(int $userId, int $gameId): bool
    {
        // ⚠️ tetap dipertahankan, tapi diberi makna jelas:
        // ini REMOVE OWNERSHIP (bukan uninstall)

        return $this->where([
            'user_id' => $userId,
            'game_id' => $gameId
        ])->delete() ? true : false;
    }

    // ==========================
    // INSTALL GAME (DOWNLOAD)
    // ==========================
    public function installGame(int $userId, int $gameId): bool
    {
        return $this->where([
            'user_id' => $userId,
            'game_id' => $gameId
        ])->set(['installed' => 1])->update();
    }

    // ==========================
    // UNINSTALL GAME
    // ==========================
    public function uninstallGame(int $userId, int $gameId): bool
    {
        return $this->where([
            'user_id' => $userId,
            'game_id' => $gameId
        ])->set(['installed' => 0])->update();
    }
}