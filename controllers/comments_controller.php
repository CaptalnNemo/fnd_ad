<?php
require_once('models/comment.php');

class CommentsController extends BaseController
{
  function __construct()
  {
    $this->folder = 'comments';
  }

  public function createComment()
  {
    $item = new Comment(NULL, current_user()->id, @$_POST['product_id'], @$_POST['content']);
    $rs = Comment::insert($item);
    if ($rs) {
      $item->id = $rs;
      $result = array('status' => 'success', 'message' => 'Gửi bình luận thành công', 'comment' => renderComment($item));
    } else {
      $result = array('status' => 'failed', 'message' => 'Gửi bình luận không thành công');
    }
    die(json_encode($result));
  }

  public function destroyComment()
  {
    $item = Comment::find($_GET['id']);
    $rs = Comment::destroy($item);
    if ($rs) {
      $result = array('status' => 'success', 'message' => 'Xoá bình luận thành công');
    } else {
      $result = array('status' => 'failed', 'message' => 'Xoá bình luận không thành công');
    }
    die(json_encode($result));
  }
}
