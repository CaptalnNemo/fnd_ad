<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li>
        <a href="<?= root('admin') ?>">
          <i class="fa fa-home"></i> <span>Trang quản lý</span>
        </a>
      </li>
      <li class="header">CHỨC NĂNG CHÍNH</li>
      <li>
        <a href="<?= get_route('users', 'index', 'admin') ?>">
          <i class="fa fa-user-o"></i> <span>Quản lý người dùng</span>
        </a>
      </li>
      <li>
        <a href="<?= get_route('categories', 'index', 'admin') ?>">
          <i class="fa fa-server"></i> <span>Quản lý danh mục sản phẩm</span>
        </a>
      </li>
      <li>
        <a href="<?= get_route('products', 'index', 'admin') ?>">
          <i class="fa fa-product-hunt"></i> <span>Quản lý sản phẩm</span>
        </a>
      </li>
      <li>
        <a href="<?= get_route('orders', 'index', 'admin') ?>">
          <i class="fa fa-shopping-bag"></i> <span>Quản lý đơn hàng</span>
        </a>
      </li>
      <li>
        <a href="<?= get_route('feedbacks', 'index', 'admin') ?>">
          <i class="fa fa-envelope"></i> <span>Quản lý góp ý</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
