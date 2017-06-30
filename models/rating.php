<?php
class Rating
{
  public $id;
  public $user_id;
  public $product_id;
  public $score;

  public function __construct($id, $user_id, $product_id, $score)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->product_id = $product_id;
    $this->score = $score;
  }

  static function find($user_id, $product_id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM ratings WHERE user_id=:user_id AND product_id=:product_id');
    $req->execute(array('user_id' => $user_id, 'product_id' => $product_id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Rating($item['id'], $item['user_id'], $item['product_id'], $item['score']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO ratings(user_id, product_id, score) VALUE (:user_id, :product_id, :score)");
    $rs = $query->execute(array('user_id' => $item->user_id, 'product_id' => $item->product_id, 'score' => $item->score));
    if ($rs) return $db->lastInsertId();
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE ratings SET user_id=:user_id, product_id=:product_id, score=:score WHERE id=:id");
    $rs = $query->execute(array('user_id' => $item->user_id, 'product_id' => $item->product_id, 'score' => $item->score, 'id' => $item->id));
    return $rs;
  }
}
