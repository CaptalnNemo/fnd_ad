<?php
require_once('models/order.php');

class User
{
  public $id;
  public $email;
  public $password;
  public $name;
  public $phone;
  public $activated;
  public $is_admin;

  function __construct($id, $email, $password, $name, $phone, $activated = 1, $is_admin = 0)
  {
    $this->id = $id;
    $this->email = $email;
    $this->password = $password;
    $this->name = $name;
    $this->phone = $phone;
    $this->activated = $activated;
    $this->is_admin = $is_admin;
  }

  static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM users');

    foreach ($req->fetchAll() as $item) {
      $list[] = new User($item['id'], $item['email'], $item['password'], $item['name'], $item['phone'], $item['activated'], $item['is_admin']);
    }

    return $list;
  }

  static function find($id)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM users WHERE id = :id');
    $req->execute(array('id' => $id));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new User($item['id'], $item['email'], $item['password'], $item['name'], $item['phone'], $item['activated'], $item['is_admin']);
    }
    return null;
  }

  static function findByEmail($email)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM users WHERE email=:email');
    $req->execute(array('email' => $email));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new User($item['id'], $item['email'], $item['password'], $item['name'], $item['phone'], $item['activated'], $item['is_admin']);
    }
    return null;
  }

  static function attempt($email, $password)
  {
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
    $req->execute(array('email' => $email, 'password' => md5($password)));
    $item = $req->fetch();
    if (isset($item['id'])) {
      return new User($item['id'], $item['email'], $item['password'], $item['name'], $item['phone'], $item['activated'], $item['is_admin']);
    }
    return null;
  }


  static function insert($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO users(email, password, name, phone, activated, is_admin)
        VALUES(:email, :password, :name, :phone, :activated, :is_admin)");
    $rs = $query->execute(array('email' => $item->email, 'password' => $item->password, 'name' => $item->name, 'phone' => $item->phone, 'activated' => $item->activated, 'is_admin' => $item->is_admin));
    if ($rs) {
      return $db->lastInsertId();
    }
    return $rs;
  }

  static function update($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("UPDATE users SET email=:email, password=:password, name=:name, phone=:phone, activated=:activated, is_admin=:is_admin
        WHERE id=:id");
    $rs = $query->execute(array('email' => $item->email, 'password' => $item->password, 'name' => $item->name, 'phone' => $item->phone, 'activated' => $item->activated, 'is_admin' => $item->is_admin, 'id' => $item->id));
    return $rs;
  }

  static function destroy($item)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM users WHERE id=:id");
    $rs = $query->execute(array('id' => $item->id));
    return $rs;
  }

  function getListOrders()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare('SELECT * FROM orders WHERE user_id=:user_id');
    $req->execute(array('user_id' => $this->id));

    foreach ($req->fetchAll() as $item) {
      $list[] = new Order($item['id'], $item['user_id'], $item['receiver_name'], $item['receiver_address'], $item['receiver_phone'], $item['note'], $item['amount'], $item['status']);
    }

    return $list;
  }

  static function allUsers()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM users WHERE is_admin=0');

    foreach ($req->fetchAll() as $item) {
      $list[] = new User($item['id'], $item['email'], $item['password'], $item['name'], $item['phone'], $item['activated'], $item['is_admin']);
    }

    return $list;
  }

  function validate()
  {
    $rs = true;
    if ($this->email) {
      $user = User::findByEmail($this->email);
      if ($user && $user->id != $this->id) {
        $_SESSION['form_errors'][] = "Email đã tồn tại trong hệ thống";
        $rs = false;
      }
    } else {
      $_SESSION['form_errors'][] = "Email chưa được nhập";
      $rs = false;
    }
    if (@$_POST['password']) {
      if ($_POST['password'] != @$_POST['confirm_password']) {
        $_SESSION['form_errors'][] = "Mật khẩu không trùng khớp";
        $rs = false;
      }
    } else if (!$this->id) {
      $_SESSION['form_errors'][] = "Mật khẩu chưa được nhập";
      $rs = false;
    }
    return $rs;
  }
}
