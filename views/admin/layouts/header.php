<header class="main-header">
  <a href="<?= root() ?>" class="logo">
    <span class="logo-mini">
      <b class="logo-highlight">F</b>n<b class="logo-highlight">D</b>
    </span>
    <span class="logo-lg">
      <b class="logo-highlight">Food</b>n<b class="logo-highlight">Drink</b>
    </span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span><?= current_user()->name ?></span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?= get_route('users', 'showUser', null, array('id' => current_user()->id)) ?>">
                <i class="fa fa-user"></i>
                <span>Trang cá nhân</span>
              </a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="<?= get_route('sessions', 'destroySession') ?>">
                <i class="fa fa-sign-out"></i>
                <span>Đăng xuất</span>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>
</header>
