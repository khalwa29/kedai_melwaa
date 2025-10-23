<?php

namespace App\Controllers;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $data['orders'] = $this->orderModel->findAll();
        return view('admin/v_order', $data);
    }
}
