<?php
require_once('models/category.php');
require_once('models/product.php');

class ProductsController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
    $this->folder = 'products';
  }

  public function index()
  {
    $products = Product::all();
    $data = array('title' => 'Quản lý sản phẩm', 'products' => $products);
    $this->render('index', $data);
  }

  public function newProduct()
  {
    $categories = Category::all();
    $data = array('title' => 'Thêm mới sản phẩm', 'categories' => $categories);
    $this->render('new', $data);
  }

  public function createProduct()
  {
    $item = new Product(null, @$_POST['name'], @$_POST['price'], @$_POST['description'], @$_POST['category_id'], @$_POST['status']);
    $rs = Product::insert($item);
    if ($rs) {
      $path = 'uploads/products/' . $rs . '/';
      if (is_dir($path) || (!is_dir($path) && mkdir($path, 0777, true))) {
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
          $fileName = $path . time() . '_' . $_FILES['images']['name'][$i];
          move_uploaded_file($_FILES['images']['tmp_name'][$i], $fileName);
          if (is_file($fileName)) {
            $item = new ProductImage(null, $rs, $fileName);
            ProductImage::insert($item);
          }
        }
      }
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Thêm mới sản phẩm thành công');
      redirect_to(get_route('products', 'index', 'admin'));
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Thêm mới sản phẩm thất bại');
      $categories = Category::all();
      $data = array('title' => 'Thêm mới sản phẩm', 'categories' => $categories);
      $this->render('new', $data);
    }
  }

  public function editProduct()
  {
    $product = Product::find($_GET['id']);
    $categories = Category::all();
    $data = array('title' => 'Sửa thông tin sản phẩm', 'product' => $product, 'categories' => $categories);
    $this->render('edit', $data);
  }

  public function updateProduct()
  {
    $item = Product::find($_GET['id']);
    $item->name = @$_POST['name'];
    $item->price = @$_POST['price'];
    $item->description = @$_POST['description'];
    $item->category_id = @$_POST['category_id'];
    $item->status = @$_POST['status'];
    $rs = Product::update($item);
    if ($rs) {
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Sửa thông tin sản phẩm thành công');
      redirect_to(get_route('products', 'index', 'admin'));
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Sửa thông tin sản phẩm thất bại');
      $categories = Category::all();
      $data = array('title' => 'Sửa thông tin sản phẩm', 'product' => $item, 'categories' => $categories);
      $this->render('edit', $data);
    }
  }

  public function destroyProduct()
  {
    $item = Product::find($_GET['id']);
    if (Product::destroy($item)) {
      $_SESSION['message'] = array('class' => 'success', 'content' => 'Xoá sản phẩm thành công');
    } else {
      $_SESSION['message'] = array('class' => 'danger', 'content' => 'Không thể xoá sản phẩm');
    }
    redirect_to(get_route('products', 'index', 'admin'));
  }

  public function showImages()
  {
    $product = Product::find($_GET['id']);
    if ($product) {
      echo renderProductImages($product->getImages());
    } else {
      echo '';
    }
  }
}
