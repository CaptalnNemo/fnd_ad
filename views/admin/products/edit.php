<section class="content-header">
  <div class="title">
    <span>Sửa thông tin sản phẩm</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-6 col-md-offset-3">
        <form action="<?= get_route('products', 'updateProduct', 'admin', array('id' => $_GET['id'])) ?>" method="post">
          <div class="form-group">
            <label>Tên sản phẩm</label>
            <input type="text" class="form-control" name="name" value="<?= $product->name ?>">
          </div>
          <div class="form-group">
            <label>Giá bán</label>
            <input type="number" min="0" class="form-control" name="price" value="<?= $product->price ?>">
          </div>
          <div class="form-group">
            <label>Mô tả</label>
            <textarea class="form-control vresize" name="description"><?= $product->description ?></textarea>
          </div>
          <div class="form-group">
            <label>Danh mục</label>
            <select class="form-control" name="category_id" id="category_id">
              <option value="0">Chọn danh mục</option>
              <?php foreach ($categories as $category) {
                if ($category->parent_id == 0) continue;
                ?>
                <option value="<?= $category->id ?>"
                  <?= $category->id == $product->category_id ? 'selected' : '' ?>>
                  <?= $category->name ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Trạng thái</label>
            <div class="form-control">
              <label>
                <input type="radio" name="status" value="1" <?= $product->status ? 'checked' : '' ?>> Còn hàng
              </label>&nbsp;
              <label>
                <input type="radio" name="status" value="0" <?= $product->status ? '' : 'checked' ?>> Hết hàng
              </label>
            </div>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
