<?php

namespace App\Models;
use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'tb_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['menu', 'kategori', 'harga', 'foto'];
}
