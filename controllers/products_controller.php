<?php
require_once('models/category.php');
require_once('models/product.php');

class ProductsController extends BaseController
{
  function __construct()
  {
    $this->folder = 'products';
  }

  public function index()
  {
    if (@$_GET['k']) {
      $category_ids = Category::idsWhereNameContain($_GET['k']);
      $products = Product::containKeywordOrInCategories($_GET['k'], $category_ids);
    } else {
      $products = Product::all();
    }
    $categories = Category::all();
    $data = array('products' => $products, 'categories' => $categories, 'title' => 'Danh sách sản phẩm');
    $this->render('index', $data);
  }

  public function showProduct()
  {
    $categories = Category::all();
    $product = Product::find($_GET['id']);
    if (current_user()) {
      $rating = $product->getRatingBy(current_user());
      $rated_score = $rating ? $rating->score : 0;
    } else {
      $rated_score = 0;
    }
    $comments = $product->getComments();
    $data = array('title' => $product->name, 'categories' => $categories, 'product' => $product, 'rated_score' => $rated_score, 'comments' => $comments);
    $this->render('show', $data);
  }
}
