<?php
require_once('models/user.php');

class UsersController extends BaseController
{
  function __construct()
  {
    $this->folder = 'users';
  }

  public function newUser()
  {
    $data = array('title' => 'Đăng ký tài khoản');
    $this->render('new', $data);
  }

  public function createUser()
  {
    $item = new User(null, @$_POST['email'], md5(@$_POST['password']), @$_POST['name'], @$_POST['phone']);
    if ($item->validate()) {
      $rs = User::insert($item);
      if ($rs) {
        $item->id = $rs;
        $_SESSION['user'] = serialize($item);
        $_SESSION['message'] = array('class' => 'success', 'content' => 'Đăng ký tài khoản thành công');
        redirect_to(root());
      } else {
        $_SESSION['message'] = array('class' => 'danger', 'content' => 'Đăng ký tài khoản thất bại');
        $data = array('title' => 'Đăng ký tài khoản');
        $this->render('new', $data);
      }
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Đăng ký tài khoản thất bại');
      $data = array('title' => 'Đăng ký tài khoản');
      $this->render('new', $data);
    }
  }

  function showUser()
  {
    $user = User::find($_GET['id']);
    $data = array('title' => 'Thông tin người dùng', 'user' => $user);
    $this->render('show', $data);
  }

  function editUser()
  {
    $user = User::find($_GET['id']);
    $data = array('title' => 'Cập nhật thông tin người dùng', 'user' => $user);
    $this->render('edit', $data);
  }

  public function updateUser()
  {
    $item = User::find($_GET['id']);
    $item->email = @$_POST['email'];
    $item->name = @$_POST['name'];
    $item->phone = @$_POST['phone'];
    if (@$_POST['password']) {
      $item->password = md5($_POST['password']);
    }
    if ($item->validate()) {
      $rs = User::update($item);
      if ($rs) {
        $item->id = $rs;
        $_SESSION['user'] = serialize($item);
        $_SESSION['message'] = array('class' => 'success', 'content' => 'Cập nhật thông tin thành công');
        redirect_to(get_route('users', 'showUser', null, array('id' => $item->id)));
      } else {
        $_SESSION['message'] = array('class' => 'danger', 'content' => 'Cập nhật thông tin thất bại');
        $data = array('title' => 'Cập nhật thông tin người dùng', 'user' => $item);
        $this->render('edit', $data);
      }
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Cập nhật thông tin thất bại');
      $data = array('title' => 'Cập nhật thông tin người dùng', 'user' => $item);
      $this->render('edit', $data);
    }
  }
}
