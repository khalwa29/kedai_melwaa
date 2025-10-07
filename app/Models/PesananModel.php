<?php
namespace App\Models;
use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'tb_pesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama','menu','jumlah','catatan','created_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    public function simpan($data)
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    public function get($id)
    {
        return $this->find($id);
    }

    public function getMenu($kategori)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_menu')->where('kategori', $kategori)->get()->getResultArray();
    }
}
