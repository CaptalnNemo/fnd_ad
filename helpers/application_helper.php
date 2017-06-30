<?php
require_once 'models/user.php';

function logged_in()
{
  if (current_user()) {
    return true;
  }
  return false;
}

function is_admin()
{
  if (logged_in()) {
    return current_user()->is_admin;
  }
  return false;
}

function current_user()
{
  return unserialize(@$_SESSION['user']);
}

function display_title($title)
{
  if (isset($title)) {
    return $title . ' - Food and Drink';
  }
  return 'Food and Drink';
}

function redirect_to($route)
{
  header("Location: $route");
  exit;
}

function get_route($controller, $action, $namespace = null, $params = array())
{
  $namespace_param = $namespace ? "namespace=$namespace&" : '';
  $url = "index.php?{$namespace_param}controller=$controller&action=$action";
  if (!empty($params)) {
    foreach ($params as $key => $value) {
      $url .= "&$key=$value";
    }
  }
  return $url;
}

function root($namespace = null)
{
  $url = 'index.php';
  if ($namespace) {
    $url = $url . "?namespace=$namespace";
  }
  return $url;
}

function renderProductImages($images)
{
  $html = '<div class="row">';
  foreach ($images as $image) {
    $html .= '<div class="col-md-3">
      <div class="product-image">
        <span class="delete-image" data-id="' . $image->id . '"><i class="fa fa-remove"></i></span>
        <img src="' . $image->image . '">
       </div>
     </div>';
  }
  $html .= '</div>';
  return $html;
}

function remove_dir($path)
{
  if (is_dir($path)) {
    $files = array_diff(scandir($path), array('.', '..'));
    foreach ($files as $file) {
      unlink(realpath($path) . '/' . $file);
    }
    return rmdir($path);
  }
  return null;
}

function getProductFirstImage($product)
{
  $images = $product->getImages();
  if (count($images) > 0) {
    return $images[0]->image;
  }
  return 'views/assets/images/no-image.png';
}

function order_status($status)
{
  switch ($status) {
    case 0:
      return 'Đang chờ';
    case 1:
      return 'Chấp nhận';
    case 2:
      return 'Từ chối';
  }
  return '';
}

function renderOrderDetails($order)
{
  $html = '';
  foreach ($order->getOrderDetails() as $orderDetail) {
    $html .= '<tr>
      <td class="cart-item-image">
        <img src="' . getProductFirstImage($orderDetail->product) . '" class="img-responsive"/> &nbsp;
        <span class="cart-item-name">' . $orderDetail->product->name . '</span>
      </td>
      <td class="cart-item-quantity td-padding-top">
        <span class="quantity">' . $orderDetail->quantity . '</span>
      </td>
      <td class="cart-item-subtotal td-padding-top">
        <span class="price">' . number_format($orderDetail->price, 0, ',', ' . ') . ' VND </span >
      </td >
      <td class="cart-item-subtotal td-padding-top" >
        <span class="total-price" > ' . number_format($orderDetail->amount, 0, ',', ' . ') . ' VND </span >
      </td >
    </tr > ';
  }
  return $html;
}

function renderRatingStar($score)
{
  $html = '<span class="lst-star">';
  for ($i = 1; $i <= $score; $i++) {
    $html .= '<i class="fa fa-star"></i>';
  }
  for ($i = $score + 1; $i <= 5; $i++) {
    $html .= '<i class="fa fa-star-o"></i>';
  }
  $html .= '</span>';
  return $html;
}

function renderComment($comment)
{
  $html = '<div class="comment panel panel-default" data-comment-id="' . $comment->id . '">
    <div class="panel-heading">
      <a href="' . get_route('users', 'showUser', null, array('id' => $comment->user->id)) . '">
        <strong>' . $comment->user->name . '</strong>
      </a>';
  if (logged_in() && (is_admin() || current_user()->id == $comment->user_id)) {
    $html .= '<span class="remove-comment-btn pull-right">
      <i class="fa fa-remove" ></i >
    </span >';
  }
  $html .= '</div>
    <div class="panel-body">' . $comment->content . '</div>
  </div>';
  return $html;
}
