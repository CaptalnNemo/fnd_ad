<?php
require_once('models/product_image.php');

class ProductImagesController extends BaseController
{
  function __construct()
  {
    parent::__construct('admin');
  }

  public function createProductImage()
  {
    $path = 'uploads/products/' . $_POST['product_id'] . '/';
    if (!is_dir($path) && !mkdir($path, 0777, true)) {
      $result = array('status' => 'failed', 'message' => 'Lỗi không thể tải file lên!');
    } else {
      $fileName = $path . time() . '_' . $_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'], $fileName);
      if (is_file($fileName)) {
        $item = new ProductImage(null, $_POST['product_id'], $fileName);
        if (ProductImage::insert($item)) {
          $product = Product::find($item->product_id);
          $result = array('status' => 'success', 'message' => 'Tải lên thành công!', 'data' => renderProductImages($product->getImages()));
        } else {
          unlink($fileName);
          $result = array('status' => 'failed', 'message' => 'Lỗi không thể lưu vào CSDL!');
        }
      } else {
        $result = array('status' => 'failed', 'message' => 'Lỗi không thể lưu file!');
      }
    }
    die(json_encode($result));
  }

  public function destroyProductImage()
  {
    $item = ProductImage::find($_GET['id']);
    if (ProductImage::destroy($item)) {
      $product = Product::find($item->product_id);
      $result = array('status' => 'success', 'message' => 'Xoá ảnh thành công!', 'data' => renderProductImages($product->getImages()));
    } else {
      $result = array('status' => 'failed', 'message' => 'Lỗi không thể xoá file!');
    }
    die(json_encode($result));
  }
}
