<?php
require_once('models/category.php');

class CategoriesController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'categories';
  }

  function index()
  {
    $categories = Category::all();
    $data = array('categories' => $categories, 'title' => 'Quản lý danh mục sản phẩm');
    $this->render('index', $data);
  }

  function newCategory()
  {
    $categories = Category::getRootCategories();
    $data = array('title' => 'Thêm mới danh mục sản phẩm', 'categories' => $categories);
    $this->render('new', $data);
  }

  function createCategory()
  {
    $item = new Category(NULL, @$_POST['name'], @$_POST['parent_id']);
    $rs = Category::insert($item);
    if ($rs) {
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Thêm mới danh mục sản phẩm thành công');
      redirect_to(get_route('categories', 'index', 'admin'));
    } else {
      $categories = Category::getRootCategories();
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Thêm mới danh mục sản phẩm thất bại');
      $data = array('title' => 'Thêm mới danh mục sản phẩm', 'categories' => $categories);
      $this->render('new', $data);
    }
  }

  function editCategory()
  {
    $categories = Category::getRootCategories();
    $category = Category::find($_GET['id']);
    $data = array('category' => $category, 'title' => 'Sửa danh mục sản phẩm', 'categories' => $categories);
    $this->render('edit', $data);
  }

  public function updateCategory()
  {
    $item = Category::find($_GET['id']);
    $item->name = @$_POST['name'];
    $item->parent_id = @$_POST['parent_id'];
    $rs = Category::update($item);
    if ($rs) {
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Sửa danh mục sản phẩm thành công');
      redirect_to(get_route('categories', 'index', 'admin'));
    } else {
      $categories = Category::getRootCategories();
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Sửa danh mục sản phẩm thất bại');
      $data = array('title' => 'Sửa danh mục sản phẩm', 'categories' => $categories, 'category' => $item);
      $this->render('edit', $data);
    }
  }

  public function destroyCategory()
  {
    $item = Category::find($_GET['id']);
    if (Category::destroy($item)) {
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Xoá danh mục sản phẩm thành công');
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Không thể xoá danh mục sản phẩm');
    }
    redirect_to(get_route('categories', 'index', 'admin'));
  }

}
