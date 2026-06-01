<?php

namespace App\Models;

use CodeIgniter\Model;

class GameImageModel extends Model
{
    protected $table            = 'game_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'game_id',
        'image',
        'created_at',
        'updated_at',
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
    protected $validationRules      = [
        'game_id' => 'required|is_natural_no_zero',
        'image'   => 'required|max_length[255]',
    ];
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

    public function getImagesByGame(int $gameId): array
    {
        return $this->select('id, game_id, image')
                    ->where('game_id', $gameId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    public function deleteImagesByGame(int $gameId): bool
    {
        return $this->where('game_id', $gameId)->delete();
    }
}
