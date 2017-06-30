<?php
require_once('models/order.php');

class StatisticsController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'statistics';
  }

  public function getStatistic()
  {
    $num_of_orders = Order::getRecordInMonth(@$_POST['month']);
    die(json_encode($num_of_orders));
  }
}
