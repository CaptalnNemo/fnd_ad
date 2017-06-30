<?php
require_once('models/rating.php');
require_once('models/product.php');

class RatingsController extends BaseController
{
  function __construct()
  {
    $this->folder = 'ratings';
  }

  function createRating()
  {
    if (logged_in()) {
      $item = new Rating(NULL, current_user()->id, @$_POST['product_id'], @$_POST['score']);
      $rs = Rating::insert($item);
      if ($rs) {
        $product = Product::find($item->product_id);
        $product_rating = renderRatingStar(floor($product->rating));
        $result = array('status' => 'success', 'message' => 'Đánh giá thành công', 'product_rating' => $product_rating);
      } else {
        $result = array('status' => 'failed', 'message' => 'Đánh giá không thành công');
      }
    } else {
      $result = array('status' => 'failed', 'message' => 'Bạn phải đăng nhập!');
    }
    die(json_encode($result));
  }

  public function updateRating()
  {
    $item = Rating::find(current_user()->id, @$_POST['product_id']);
    $item->score = @$_POST['score'];
    $rs = Rating::update($item);
    if ($rs) {
      $product = Product::find($item->product_id);
      $product_rating = renderRatingStar(floor($product->rating));
      $result = array('status' => 'success', 'message' => 'Đánh giá thành công', 'product_rating' => $product_rating);
    } else {
      $result = array('status' => 'failed', 'message' => 'Đánh giá không thành công');
    }
    die(json_encode($result));
  }
}
