<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once('db.php');
require_once('helpers/application_helper.php');

if (!@$_SESSION['cart']) $_SESSION['cart'] = array();

if (isset($_GET['controller'])) {
  $controller = $_GET['controller'];
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  } else {
    $action = 'index';
  }
} else {
  $controller = 'pages';
  $action = 'home';
}
$namespace = @$_GET['namespace'];
require_once('routes.php');
