<h1 class="text-center">Đăng ký tài khoản</h1>
<div class="col-md-6 col-md-offset-3">
  <?php include_once('views/shareds/form_errors.php'); ?>
  <form action="<?= get_route('users', 'createUser') ?>" method="post">
    <div class="form-group">
      <label>Email *</label>
      <input type="email" class="form-control" name="email" value="<?= @$_POST['email'] ?>" required>
    </div>
    <div class="form-group">
      <label>Mật khẩu *</label>
      <input type="password" class="form-control" name="password" value="<?= @$_POST['password'] ?>" required>
    </div>
    <div class="form-group">
      <label>Nhập lại mật khẩu *</label>
      <input type="password" class="form-control" name="confirm_password" value="<?= @$_POST['confirm_password'] ?>" required>
    </div>
    <div class="form-group">
      <label>Tên người dùng *</label>
      <input type="text" class="form-control" name="name" value="<?= @$_POST['name'] ?>" required>
    </div>
    <div class="form-group">
      <label>Số điện thoại *</label>
      <input type="text" class="form-control" name="phone" value="<?= @$_POST['phone'] ?>" required>
    </div>
    <div class="text-right">
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
  </form>
</div>
