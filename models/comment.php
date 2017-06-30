<?php
require_once('models/user.php');

class Comment
{
  public $id;
  public $user_id;
  public $product_id;
  public $content;
  public $user;

  public function __construct($id, $user_id, $product_id, $content)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->product_id = $product_id;
    $this->content = $content;
    $this->user = User::find($user_id);
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM comments WHERE id=:id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Comment($item['id'], $item['user_id'], $item['product_id'], $item['content']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO comments(user_id, product_id, content) VALUE (:user_id, :product_id, :content)");
    $rs = $query->execute(array('user_id' => $item->user_id, 'product_id' => $item->product_id, 'content' => $item->content));
    if ($rs) return $db->lastInsertId();
    return $rs;
  }

  static function destroy($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM comments WHERE id=:id");
    $rs = $query->execute(array('id' => $item->id));
    return $rs;
  }
}
