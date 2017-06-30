<?php
require_once('models/order_detail.php');
require_once('models/user.php');

class Order
{
  public $id;
  public $user_id;
  public $receiver_name;
  public $receiver_address;
  public $receiver_phone;
  public $note;
  public $amount;
  public $status;
  public $created_at;
  public $user;

  public function __construct($id, $user_id, $receiver_name, $receiver_address, $receiver_phone, $note, $amount, $created_at = null, $status = 0)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->receiver_name = $receiver_name;
    $this->receiver_address = $receiver_address;
    $this->receiver_phone = $receiver_phone;
    $this->note = $note;
    $this->amount = $amount;
    $this->created_at = $created_at ? $created_at : time();
    $this->status = $status;
    $this->user = User::find($user_id);
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM orders ORDER BY status ASC, created_at DESC');

    foreach ($req->fetchAll() as $item) {
      $list[] = new Order($item['id'], $item['user_id'], $item['receiver_name'], $item['receiver_address'], $item['receiver_phone'], $item['note'], $item['amount'], $item['created_at'], $item['status']);
    }

    return $list;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM orders WHERE id = :id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new Order($item['id'], $item['user_id'], $item['receiver_name'], $item['receiver_address'], $item['receiver_phone'], $item['note'], $item['amount'], $item['created_at'], $item['status']);
    }
    return null;
  }

  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO orders(user_id, receiver_name, receiver_address, receiver_phone, note, amount, status)
      VALUE (:user_id, :receiver_name, :receiver_address, :receiver_phone, :note, :amount, :status)");
    $rs = $query->execute(array('user_id' => $item->user_id, 'receiver_name' => $item->receiver_name, 'receiver_address' => $item->receiver_address, 'receiver_phone' => $item->receiver_phone, 'note' => $item->note, 'amount' => $item->amount, 'status' => $item->status));
    if ($rs) return $db->lastInsertId();
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE orders SET status=:status WHERE id=:id");
    $rs = $query->execute(array('status' => $item->status, 'id' => $item->id));
    return $rs;
  }

  function getOrderDetails()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM order_details WHERE order_id=:order_id');
    $req->execute(array('order_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new OrderDetail($item['order_id'], $item['product_id'], $item['quantity'], $item['price']);
    }

    return $list;
  }

  static function totalAmount()
  {
    $db = DB::getInstance();
    $query = $db->query("SELECT SUM(amount) AS total_amount FROM orders WHERE status=1");
    $rs = $query->fetch();
    return $rs['total_amount'];
  }

  static function getRecordInMonth($month)
  {
    $first_day = $month ? $month . '-01' : date('Y-m-01');

    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT COUNT(*) AS num_of_orders, SUM(amount) AS total_amount, DAY(created_at) AS day
      FROM orders WHERE status=1 AND created_at BETWEEN :first_day AND LAST_DAY(:first_day) GROUP BY DAY(created_at)');
    $req->execute(array('first_day' => $first_day));

    foreach ($req->fetchAll() as $item) {
      $list[$item['day']]['num_of_orders'] = $item['num_of_orders'];
      $list[$item['day']]['total_amount'] = $item['total_amount'];
    }

    $result = array();
    for ($i = 1; $i <= date('t', strtotime($first_day)); $i++) {
      $result['xAxis'][] = $i;
      $result['series']['num_of_orders'][] = @$list[$i] ? intval($list[$i]['num_of_orders']) : 0;
      $result['series']['total_amount'][] = @$list[$i] ? intval($list[$i]['total_amount']) : 0;
    }

    return $result;
  }
}
