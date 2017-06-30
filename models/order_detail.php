<?php
require_once('models/product.php');

class OrderDetail
{
  public $order_id;
  public $product_id;
  public $product;
  public $price;
  public $quantity;
  public $amount;

  function __construct($order_id, $product_id, $quantity, $price)
  {
    $this->order_id = $order_id;
    $product = Product::find($product_id);
    $this->product_id = $product_id;
    $this->product = $product;
    $this->price = $price;
    $this->quantity = $quantity;
    $this->amount = $this->quantity * $product->price;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM order_details WHERE id=:id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new OrderDetail($item['order_id'], $item['product_id'], $item['quantity'], $item['price']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO order_details(order_id, product_id, quantity, price) VALUE (:order_id, :product_id, :quantity, :price)");
    $rs = $query->execute(array('order_id' => $item->order_id, 'product_id' => $item->product_id, 'quantity' => $item->quantity, 'price' => $item->price));
    return $rs;
  }
}
