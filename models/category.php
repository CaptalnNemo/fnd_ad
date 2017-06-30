<?php
require_once('models/product.php');

class Category
{
  public $id;
  public $name;
  public $parent_id;

  function __construct($id, $name, $parent_id)
  {
    $this->id = $id;
    $this->name = $name;
    $this->parent_id = $parent_id;
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM categories');

    foreach ($req->fetchAll() as $item) {
      $list[] = new Category($item['id'], $item['name'], $item['parent_id']);
    }

    return $list;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM categories WHERE id = :id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Category($item['id'], $item['name'], $item['parent_id']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO categories(name, parent_id) VALUE (:name,:parent_id)");
    $rs = $query->execute(array('name' => $item->name, 'parent_id' => $item->parent_id));
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE categories SET name=:name, parent_id=:parent_id WHERE id=:id");
    $rs = $query->execute(array('name' => $item->name, 'parent_id' => $item->parent_id, 'id' => $item->id));
    return $rs;
  }

  static function destroy($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM categories WHERE id=:id");
    $rs = $query->execute(array('id' => $item->id));
    if ($rs) {
      foreach ($item->children() as $child) {
        Category::destroy($child);
      }
    }
    return $rs;
  }

  function getParentName()
  {
    $parent = Category::find($this->parent_id);
    if ($parent) return $parent->name;
    return '';
  }

  function getInStockProducts()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM products WHERE status=1 AND category_id=:category_id');
    $req->execute(array('category_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Product($item['id'], $item['name'], $item['price'], $item['description'], $item['category_id'], $item['status']);
    }

    return $list;
  }

  static function getRootCategories()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM categories WHERE parent_id=0');

    foreach ($req->fetchAll() as $item) {
      $list[] = new Category($item['id'], $item['name'], $item['parent_id']);
    }

    return $list;
  }

  static function idsWhereNameContain($k)
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT id FROM categories WHERE name LIKE :k');
    $req->execute(array('k' => "%$k%"));

    foreach ($req->fetchAll() as $item) {
      $list[] = $item['id'];
    }

    return $list;
  }

  function children()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM categories WHERE parent_id=:parent_id');
    $req->execute(array('parent_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Category($item['id'], $item['name'], $item['parent_id']);
    }

    return $list;
  }
}
