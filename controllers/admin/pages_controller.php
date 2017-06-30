<?php
require_once('models/user.php');
require_once('models/product.php');
require_once('models/order.php');

class PagesController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'pages';
  }

  public function home()
  {
    $users_count = count(User::allUsers());
    $products_count = count(Product::all());
    $orders_count = count(Order::all());
    $total_amount = Order::totalAmount();
    $num_of_orders = Order::getRecordInMonth(@$_POST['month']);

    $data = array(
      'users_count' => $users_count,
      'products_count' => $products_count,
      'orders_count' => $orders_count,
      'total_amount' => $total_amount,
      'num_of_orders' => $num_of_orders
    );
    $this->render('home', $data);
  }

  public function error()
  {
    $this->render('error');
  }
}

?>
