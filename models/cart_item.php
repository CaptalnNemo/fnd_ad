<?php
require_once('models/product.php');

class CartItem
{
  public $product_id;
  public $product;
  public $quantity;
  public $amount;

  function __construct($product_id, $quantity)
  {
    $product = Product::find($product_id);
    $this->product_id = $product_id;
    $this->product = $product;
    $this->quantity = $quantity;
    $this->amount = $this->quantity * $product->price;
  }

  static function all()
  {
    $list = [];
    if (@$_SESSION['cart']) {
      foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $list[] = new CartItem($product_id, $quantity);
      }
    }

    return $list;
  }

  static function find($product_id)
  {
    if (isset($_SESSION['cart'][$product_id])) {
      return new CartItem($product_id, @$_SESSION['cart'][$product_id]);
    } else {
      return null;
    }
  }

  static function insert($item)
  {
    $_SESSION['cart'][$item->product_id] = $item->quantity;
    return true;
  }

  static function update($item)
  {
    $_SESSION['cart'][$item->product_id] = $item->quantity;
    return true;
  }

  static function destroy($item)
  {
    unset($_SESSION['cart'][$item->product_id]);
    return true;
  }
}
