<?php
require_once('models/cart_item.php');
require_once('models/order.php');
require_once('models/order_detail.php');

class OrdersController extends BaseController
{
  function __construct()
  {
    $this->folder = 'orders';
  }

  function createOrder()
  {
    $item = new Order(null, current_user()->id, @$_POST['receiver_name'], @$_POST['receiver_address'], @$_POST['receiver_phone'], @$_POST['note'], @$_POST['amount']);
    $rs = Order::insert($item);
    if ($rs) {
      foreach (CartItem::all() as $item) {
        $orderDetail = new OrderDetail($rs, $item->product_id, $item->quantity, $item->product->price);
        OrderDetail::insert($orderDetail);
      }
      unset($_SESSION['cart']);
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Thêm mới đơn hàng thành công');
      redirect_to(get_route('orders', 'showOrder', null, array('id' => $rs)));
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Thêm mới đơn hàng thất bại');
      redirect_to(get_route('carts', 'showCart'));
    }
  }

  function showOrder()
  {
    $order = Order::find($_GET['id']);
    if ($order) {
      $data = array('title' => 'Chi tiết đơn hàng', 'order' => $order);
      $this->render('show', $data);
    } else {
      $_SESSION['message'] = array('class' => 'warning', 'content' => 'Không tìm thấy đơn hàng');
      redirect_to(root());
    }
  }
}
