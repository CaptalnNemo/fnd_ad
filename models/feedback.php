<?php
require_once('models/user.php');

class Feedback
{
  public $id;
  public $user_id;
  public $content;
  public $created_at;
  public $status;
  public $user;

  public function __construct($id, $user_id, $content, $created_at = null, $status = 0)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->content = $content;
    $this->created_at = $created_at ? $created_at : time();
    $this->status = $status;
    $this->user = User::find($user_id);
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM feedbacks ORDER BY status ASC, created_at DESC');

    foreach ($req->fetchAll() as $item) {
      $list[] = new Feedback($item['id'], $item['user_id'], $item['content'], $item['created_at'], $item['status']);
    }

    return $list;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM feedbacks WHERE id=:id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Feedback($item['id'], $item['user_id'], $item['content'], $item['created_at'], $item['status']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO feedbacks(user_id, content) VALUE (:user_id, :content)");
    $rs = $query->execute(array('user_id' => $item->user_id, 'content' => $item->content));
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE feedbacks SET status=:status WHERE id=:id");
    $rs = $query->execute(array('status' => $item->status, 'id' => $item->id));
    return $rs;
  }
}
