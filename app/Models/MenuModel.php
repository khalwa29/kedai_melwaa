<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'tb_menu';   // sesuai nama tabel di database
    protected $allowedFields = ['menu','harga','kategori', 'foto'];
    protected $returnType = 'object';
}
