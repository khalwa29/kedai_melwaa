<?php
namespace App\Controllers;
use App\Models\PesananModel;

class Pesanan extends BaseController
{
    public function index()
    {
        $model = new PesananModel();
        $data['menu'] = $model->getMenu();
        return view('order', $data);
    }

    public function simpan()
    {
        $model = new PesananModel();
        $model->save([
            'nama' => $this->request->getPost('nama'),
            'menu' => implode(", ", $this->request->getPost('menu')),
            'jumlah' => $this->request->getPost('jumlah'),
            'catatan' => $this->request->getPost('catatan'),
        ]);
        $id = $model->getInsertID();
        return redirect()->to("/pesanan/struk/$id");
    }

    public function struk($id)
    {
        $model = new PesananModel();
        $data['pesanan'] = $model->getPesanan($id);
        return view('struk', $data);
    }
}
