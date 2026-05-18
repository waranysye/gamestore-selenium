<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;

class ExampleModel extends Model
{
    protected $table          = 'games';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false; // Set false jika di table games tidak ada kolom deleted_at
    protected $allowedFields  = [
        'title', 
        'description', 
        'price', 
        'cover_image', 
        'game_file', 
        'category_id', 
        'size'
    ];
    protected $useTimestamps  = true;
}