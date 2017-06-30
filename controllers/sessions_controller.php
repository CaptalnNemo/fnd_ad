<?php
require_once('models/user.php');

class SessionsController extends BaseController
{
  function __construct()
  {
    $this->folder = 'sessions';
  }

  public function newSession()
  {
    $data = array('title' => 'Đăng nhập hệ thống');
    $this->render('new', $data);
  }

  public function createSession()
  {
    $user = User::attempt($_POST['email'], $_POST['password']);
    if (!is_null($user) && $user->activated) {
      $_SESSION['user'] = serialize($user);
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Đăng nhập thành công!');
      redirect_to(root());
    } else {
      if (!is_null($user)) {
        $_SESSION['message'] = array('class' => 'warning', 'content' => 'Tài khoản của bạn đã bị khoá!');
      } else {
        $_SESSION['message'] = array('class' => 'danger', 'content' => 'Sai thông tin đăng nhập!');
      }
      $this->render('new');
    }
  }

  public function destroySession()
  {
    if (logged_in()) {
      unset($_SESSION['user']);
      $_SESSION['message'] = array('class' => 'info', 'content' => 'Bạn vừa đăng xuất khỏi hệ thống!');
    }
    redirect_to(get_route('sessions', 'newSession'));
  }
}
