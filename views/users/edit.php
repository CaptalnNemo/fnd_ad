<h1 class="text-center">Đăng ký tài khoản</h1>
<div class="col-md-6 col-md-offset-3">
  <?php include_once('views/shareds/form_errors.php'); ?>
  <form action="<?= get_route('users', 'updateUser', null, array('id' => $user->id)) ?>" method="post">
    <div class="form-group">
      <label>Email *</label>
      <input type="email" class="form-control" name="email" value="<?= $user->email ?>" required>
    </div>
    <div class="form-group">
      <label>Tên người dùng *</label>
      <input type="text" class="form-control" name="name" value="<?= $user->name ?>" required>
    </div>
    <div class="form-group">
      <label>Số điện thoại *</label>
      <input type="text" class="form-control" name="phone" value="<?= $user->phone ?>" required>
    </div>
    <fieldset>
      <legend>Đổi mật khẩu (để trống nếu giữ nguyên)</legend>
      <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" class="form-control" name="password" value="<?= @$_POST['password'] ?>">
      </div>
      <div class="form-group">
        <label>Nhập lại mật khẩu mới</label>
        <input type="password" class="form-control" name="confirm_password" value="<?= @$_POST['confirm_password'] ?>">
      </div>
    </fieldset>
    <div class="text-right">
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
  </form>
</div>
