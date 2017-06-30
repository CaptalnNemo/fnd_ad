<?php
require_once('models/category.php');

class CategoriesController extends BaseController
{
  function __construct()
  {
    $this->folder = 'categories';
  }

  public function showCategory()
  {
    $categories = Category::all();
    $category = Category::find($_GET['id']);
    $products = $category->getInStockProducts();
    $data = array('title' => $category->name, 'category' => $category, 'categories' => $categories, 'products' => $products);
    $this->render('show', $data);
  }
}
