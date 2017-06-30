<?php
require_once('models/feedback.php');

class FeedbacksController extends BaseController
{
  function __construct()
  {
    $this->folder = 'feedbacks';
  }

  public function createFeedback()
  {
    $item = new Feedback(NULL, current_user()->id, @$_POST['content']);
    $rs = Feedback::insert($item);
    if ($rs) {
      $result = array('status' => 'success', 'message' => 'Gửi góp ý thành công');
    } else {
      $result = array('status' => 'failed', 'message' => 'Gửi góp ý không thành công');
    }
    die(json_encode($result));
  }
}
