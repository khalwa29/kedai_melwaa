<?php

namespace App\Controllers;
use App\Models\PesananModel;

class Order extends BaseController
{
    protected $pesananModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
    }

    // Form order
    public function create()
    {
        $menu = $this->request->getGet('menu');        // Ambil menu dari query string
        $kategori = $this->request->getGet('kategori'); // Ambil kategori dari query string

        // Jika mau tampilkan semua menu kategori tertentu di dropdown
        $menuList = $this->pesananModel->getMenu($kategori);

        $data = [
            'selected_menu' => $menu,
            'kategori' => $kategori,
            'menuList' => $menuList
        ];

        return view('v_order', $data);
    }

    // Simpan data pesanan
    public function store()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'menu' => $this->request->getPost('menu'),
                'jumlah' => $this->request->getPost('jumlah'),
                'catatan' => $this->request->getPost('catatan')
            ];

            $this->pesananModel->simpan($data);

            return redirect()->to(site_url('order/thankyou'));
        }
    }

    // Halaman sukses
    public function thankyou()
    {
        return view('v_order_thankyou');
    }
}
