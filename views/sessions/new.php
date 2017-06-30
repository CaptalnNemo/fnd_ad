<div class="login-box">
  <div class="login-logo">
    Đăng nhập hệ thống
  </div>

  <div class="login-box-body">
    <form action="<?= get_route('sessions', 'createSession') ?>" method="post">
      <div class="form-group">
        <label>Email:</label>
        <div class="input-group">
          <input type="text" class="form-control" name="email" value="<?= @$_POST['email'] ?>">
          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        </div>
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" value="<?= @$_POST['password'] ?>">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
    </form>
  </div>
</div>
