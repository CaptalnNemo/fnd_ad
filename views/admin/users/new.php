<section class="content-header">
  <div class="title">
    <span>Thêm mới người dùng</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-6 col-md-offset-3">
        <form action="<?= get_route('users', 'createUser', 'admin') ?>" method="post">
          <div class="form-group">
            <label>Tên người dùng</label>
            <input type="text" class="form-control" name="name" value="<?= @$_POST['name'] ?>">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?= @$_POST['email'] ?>">
          </div>
          <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" name="phone" value="<?= @$_POST['phone'] ?>">
          </div>
          <div class="form-group">
            <label>Vai trò</label>
            <select class="form-control" name="is_admin">
              <option value="0" <?= @$_POST['is_admin'] ? '' : 'selected' ?>>Người dùng</option>
              <option value="1" <?= @$_POST['is_admin'] ? 'selected' : '' ?>>Quản trị viên</option>
            </select>
          </div>
          <div class="form-group">
            <label>Trạng thái</label>
            <div class="form-control">
              <label>
                <input type="radio" name="activated" value="1" <?= @$_POST['activated'] ? 'checked' : '' ?>> Kích hoạt
              </label>&nbsp;
              <label>
                <input type="radio" name="activated" value="0" <?= @$_POST['activated'] ? '' : 'checked' ?>> Không kích
                hoạt
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
