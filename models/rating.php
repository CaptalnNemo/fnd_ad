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
    $query = $db->prepare("CALL sp_insert_rating(:user_id, :product_id, :score)");
    $rs = $query->execute(array('user_id' => $item->user_id, 'product_id' => $item->product_id, 'score' => $item->score));
    if ($rs) return $query->fetch()[0];
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("CALL sp_update_rating(:id, :score)");
    $rs = $query->execute(array('score' => $item->score, 'id' => $item->id));
    return $rs;
  }
}
