<?php

namespace App\Controllers;
use App\Models\MenuModel;

class MenuController extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        $data['menus'] = $this->menuModel->findAll();
        return view('admin/v_menu', $data);
    }

    public function create()
    {
        return view('admin/v_menu_create');
    }

    public function store()
    {
        $file = $this->request->getFile('foto');
        $namaFile = $file->getRandomName();
        $file->move('img/menu', $namaFile);

        $this->menuModel->save([
            'menu' => $this->request->getPost('menu'),
            'kategori' => $this->request->getPost('kategori'),
            'harga' => $this->request->getPost('harga'),
            'foto' => $namaFile
        ]);

        return redirect()->to('menu');
    }

    public function edit($id)
    {
        $data['menu'] = $this->menuModel->find($id);
        return view('admin/v_menu_edit', $data);
    }

    public function update($id)
    {
        $menuLama = $this->menuModel->find($id);

        $file = $this->request->getFile('foto');
        if ($file->getError() == 4) {
            $namaFile = $menuLama['foto'];
        } else {
            $namaFile = $file->getRandomName();
            $file->move('img/menu', $namaFile);
            @unlink('img/menu/'.$menuLama['foto']);
        }

        $this->menuModel->update($id, [
            'menu' => $this->request->getPost('menu'),
            'kategori' => $this->request->getPost('kategori'),
            'harga' => $this->request->getPost('harga'),
            'foto' => $namaFile
        ]);

        return redirect()->to('menu');
    }

    public function delete($id)
    {
        $menu = $this->menuModel->find($id);
        if ($menu) {
            @unlink('img/menu/' . $menu['foto']);
        }
        $this->menuModel->delete($id);
        return redirect()->to('menu');
    }
}
