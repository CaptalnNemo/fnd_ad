<?php
require_once('models/order.php');

class OrdersController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'orders';
  }

  function index()
  {
    $orders = Order::all();
    $data = array('orders' => $orders, 'title' => 'Quản lý đơn hàng');
    $this->render('index', $data);
  }

  public function showOrder()
  {
    $order = Order::find($_GET['id']);
    die(renderOrderDetails($order));
  }

  public function updateOrder()
  {
    $item = Order::find($_GET['id']);
    $item->status = @$_POST['status'];
    $rs = Order::update($item);
    if ($rs) {
      $data = array('status' => 'success');
    } else {
      $data = array('status' => 'failed');
    }
    die(json_encode($data));
  }
}
