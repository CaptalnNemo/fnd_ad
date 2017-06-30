<section class="content-header">
  <div class="title">
    <span>Thêm mới danh mục sản phẩm</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-6 col-md-offset-3">
        <form action="<?= get_route('categories', 'createCategory', 'admin') ?>" method="post">
          <div class="form-group">
            <label>Tên danh mục sản phẩm</label>
            <input type="text" class="form-control" name="name" value="<?= @$_POST['name'] ?>">
          </div>
          <div class="form-group">
            <label for="parent_id">Danh mục cha</label>
            <select class="form-control" name="parent_id" id="parent_id">
              <option value="0">Chọn danh mục</option>
              <?php foreach ($categories as $select_category) { ?>
                <option value="<?= $select_category->id ?>" <?= $select_category->id == @$_POST['parent_id'] ? 'selected' : '' ?>>
                  <?= $select_category->name ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
