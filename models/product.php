<?php
require_once('models/category.php');
require_once('models/product_image.php');
require_once('models/rating.php');
require_once('models/comment.php');

class Product
{
  public $id;
  public $name;
  public $price;
  public $description;
  public $category_id;
  public $status;
  public $rating;

  public function __construct($id, $name, $price, $description, $category_id, $status)
  {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->description = $description;
    $this->category_id = $category_id;
    $this->status = $status;
    $this->rating = 0;
    $ratings = $this->getRatings();
    if (count($ratings) > 0) {
      foreach ($ratings as $rating) {
        $this->rating += $rating->score;
      }
      $this->rating /= count($ratings);
    }
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM products');

    foreach ($req->fetchAll() as $item) {
      $list[] = new Product($item['id'], $item['name'], $item['price'], $item['description'], $item['category_id'], $item['status']);
    }

    return $list;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM products WHERE id = :id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Product($item['id'], $item['name'], $item['price'], $item['description'], $item['category_id'], $item['status']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO products(name, price, description, category_id, status)
      VALUE (:name, :price, :description, :category_id, :status)");
    $rs = $query->execute(array('name' => $item->name, 'price' => $item->price, 'description' => $item->description, 'category_id' => $item->category_id, 'status' => $item->status));
    if ($rs) return $db->lastInsertId();
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE products SET name=:name, price=:price, description=:description, category_id=:category_id, status=:status WHERE id=:id");
    $rs = $query->execute(array('name' => $item->name, 'price' => $item->price, 'description' => $item->description, 'category_id' => $item->category_id, 'status' => $item->status, 'id' => $item->id));
    return $rs;
  }

  static function destroy($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM products WHERE ID=:id");
    $rs = $query->execute(array('id' => $item->id));
    if ($rs) {
      remove_dir('uploads/products/' . $item->id);
    }
    return $rs;
  }

  function getCategoryName()
  {
    $category = Category::find($this->category_id);
    if ($category) return $category->name;
    return '';
  }

  function getImages()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM product_images WHERE product_id=:product_id');
    $req->execute(array('product_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new ProductImage($item['id'], $item['product_id'], $item['image']);
    }

    return $list;
  }

  function getRelateProducts($num)
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM products WHERE status=1 AND category_id=:category_id AND id<>:id ORDER BY RAND() LIMIT :num');
    $req->bindValue(':category_id', $this->category_id);
    $req->bindValue(':id', $this->id);
    $req->bindValue(':num', $num, PDO::PARAM_INT);
    $req->execute();

    foreach ($req->fetchAll() as $item) {
      $list[] = new Product($item['id'], $item['name'], $item['price'], $item['description'], $item['category_id'], $item['status']);
    }

    return $list;
  }

  function getRatings()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM ratings WHERE product_id=:product_id');
    $req->execute(array('product_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Rating($item['id'], $item['user_id'], $item['product_id'], $item['score']);
    }

    return $list;
  }

  function getRatingBy($user)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM ratings WHERE product_id=:product_id AND user_id=:user_id');
    $req->execute(array('product_id' => $this->id, 'user_id' => $user->id));
    $item = $req->fetch();
    if ($item['id']) {
      return new Rating($item['id'], $item['user_id'], $item['product_id'], $item['score']);
    }

    return null;
  }

  function getComments()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM comments WHERE product_id=:product_id ORDER BY id DESC');
    $req->execute(array('product_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Comment($item['id'], $item['user_id'], $item['product_id'], $item['content']);
    }

    return $list;
  }

  static function containKeywordOrInCategories($k, $category_ids)
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM products WHERE status=1 AND name LIKE :k OR category_id IN (:category_ids)');
    $req->execute(array('k' => "%$k%", 'category_ids' => implode(',', $category_ids)));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Product($item['id'], $item['name'], $item['price'], $item['description'], $item['category_id'], $item['status']);
    }

    return $list;
  }
}
