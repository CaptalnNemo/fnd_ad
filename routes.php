<?php
  require_once('controllers/base_controller.php');

  if (isset($namespace) && $namespace == 'admin') {
    $controllers = include_once('configs/admin_controllers.php');
  } else {
    $controllers = include_once('configs/controllers.php');
  }

  if (array_key_exists($controller, $controllers) && in_array($action, $controllers[$controller])) {
    call($controller, $action);
  } else {
    call('pages', 'error');
  }

  function call($controller, $action) {
    global $namespace;
    if (isset($namespace)) {
      $controller_file = 'controllers/' . $namespace . '/' . $controller . '_controller.php';
    } else {
      $controller_file = 'controllers/' . $controller . '_controller.php';
    }
    include_once($controller_file);
    $klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
    $controller = new $klass;
    $controller->$action();
  }
?>
