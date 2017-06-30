<?php
require_once('models/feedback.php');

class FeedbacksController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'feedbacks';
  }

  public function index()
  {
    $feedbacks = Feedback::all();
    $data = array('title' => 'Quản lý góp ý', 'feedbacks' => $feedbacks);
    $this->render('index', $data);
  }

  public function updateFeedback()
  {
    $item = Feedback::find($_GET['id']);
    $item->status = @$_POST['status'];
    $rs = Feedback::update($item);
    if ($rs) {
      $data = array('status' => 'success', 'message' => 'Cập nhật trạng thái thành công');
    } else {
      $data = array('status' => 'failed', 'message' => 'Cập nhật trạng thái không thành công');
    }
    die(json_encode($data));
  }
}
