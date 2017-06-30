<?php
require_once('models/category.php');

class PagesController extends BaseController
{
  function __construct()
  {
    $this->folder = 'pages';
  }

  public function home()
  {
    $categories = Category::all();
    $data = array('categories' => $categories);
    $this->render('home', $data);
  }

  public function error()
  {
    $this->render('error');
  }
}
