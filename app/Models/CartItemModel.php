<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cart_id',
        'game_id',
        'price',
        'created_at',
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

    /**
     * Cek apakah game sudah ada di cart
     */
    public function isGameInCart(int $cartId, int $gameId): bool
    {
        return (bool) $this
            ->where('cart_id', $cartId)
            ->where('game_id', $gameId)
            ->first();
    }

    /**
     * Ambil item cart + detail game
     */
    public function getCartItems(int $cartId): array
{
    return $this->select('
            cart_items.id,
            cart_items.price,
            games.title,
            games.cover_image,
            categories.name AS genre
        ')
        ->join('games', 'games.id = cart_items.game_id')
        ->join('categories', 'categories.id = games.category_id')
        ->where('cart_items.cart_id', $cartId)
        ->findAll();
}

}
