<?php
require_once('models/product.php');

class ProductImage
{
  public $id;
  public $product_id;
  public $image;

  public function __construct($id, $product_id, $image)
  {
    $this->id = $id;
    $this->product_id = $product_id;
    $this->image = $image;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM product_images WHERE id = :id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new ProductImage($item['id'], $item['product_id'], $item['image']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO product_images(product_id, image) VALUE (:product_id, :image)");
    $rs = $query->execute(array('product_id' => $item->product_id, 'image' => $item->image));
    return $rs;
  }

  static function destroy($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM product_images WHERE ID=:id");
    $rs = $query->execute(array('id' => $item->id));
    if ($rs && is_file($item->image)) {
      unlink($item->image);
    }
    return $rs;
  }
}
