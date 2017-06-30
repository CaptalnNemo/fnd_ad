<?php

class BaseController
{
  protected $namespace;
  protected $folder;

  function __construct($namespace = null)
  {
    $this->namespace = $namespace;
    if (isset($this->namespace)) {
      $this->check_login();
      $this->check_admin();
    }
  }

  function render($view, $data = array())
  {
    if (isset($this->namespace)) {
      $view_folder = 'views/' . $this->namespace;
    } else {
      $view_folder = 'views';
    }
    $view_file = $view_folder . '/' . $this->folder . '/' . $view . '.php';
    if (is_file($view_file)) {
      extract($data);
      ob_start();
      require_once($view_file);
      $content = ob_get_clean();
      require_once($view_folder . '/layouts/application.php');
    } else {
      redirect_to(get_route('pages', 'error'));
    }
  }

  protected function check_login()
  {
    if (!logged_in()) {
      $_SESSION['message'] = array('class' => 'warning', 'content' => 'Bạn chưa đăng nhập!');
      redirect_to(get_route('sessions', 'newSession'));
    }
  }

  protected function check_admin()
  {
    if (!is_admin()) {
      $_SESSION['message'] = array('class' => 'warning', 'content' => 'Bạn không có quyền truy cập trang này!');
      redirect_to(root());
    }
  }
}
