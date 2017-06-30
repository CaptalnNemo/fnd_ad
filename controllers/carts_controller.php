<?php
require_once('models/cart_item.php');

class CartsController extends BaseController
{
  function __construct()
  {
    $this->folder = 'carts';
  }

  function createCart()
  {
    if ($cartItem = CartItem::find($_POST['product_id'])) {
      $cartItem->quantity += $_POST['quantity'];
      CartItem::update($cartItem);
    } else {
      $cartItem = new CartItem($_POST['product_id'], $_POST['quantity']);
      CartItem::insert($cartItem);
    }
    $total_product = 0;
    foreach (CartItem::all() as $cartItem) {
      $total_product += $cartItem->quantity;
    }
    $result = array('total_product' => $total_product);
    die(json_encode($result));
  }

  function updateCart()
  {
    if ($cartItem = CartItem::find($_POST['product_id'])) {
      $cartItem->quantity = $_POST['quantity'];
      CartItem::update($cartItem);
    }
    $total_product = 0;
    $total_amount = 0;
    foreach (CartItem::all() as $cartItem) {
      $total_product += $cartItem->quantity;
      $total_amount += $cartItem->amount;
    }
    $result = array('total_product' => $total_product, 'total_amount' => $total_amount);
    die(json_encode($result));
  }

  function showCart()
  {
    $cartItems = CartItem::all();
    $data = array('title' => 'Chi tiết giỏ hàng', 'cartItems' => $cartItems);
    $this->render('show', $data);
  }

  function destroyCart()
  {
    if ($cartItem = CartItem::find($_GET['product_id'])) {
      CartItem::destroy($cartItem);
    }
    $total_product = 0;
    $total_amount = 0;
    foreach (CartItem::all() as $cartItem) {
      $total_product += $cartItem->quantity;
      $total_amount += $cartItem->amount;
    }
    $result = array('total_product' => $total_product, 'total_amount' => $total_amount);
    die(json_encode($result));
  }
}
