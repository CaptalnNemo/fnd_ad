<?php
require_once('models/cart_item.php');
$totalCartProduct = 0;
foreach (CartItem::all() as $cartItem) {
  $totalCartProduct += $cartItem->quantity;
}
?>
<header class="navbar navbar-inverse navbar-fixed-top custom-navbar">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand logo" href="<?= root() ?>">
        <img src="views/assets/images/foodndrink.png" class="img-responsive">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="my-navbar">
      <ul class="nav navbar-nav">
        <li><a href="<?= get_route('products', 'index') ?>"><i class="fa fa-product-hunt"></i> Sản phẩm</a></li>
        <li class="title-number-product" title="Có <?= $totalCartProduct ?> sản phẩm trong giỏ hàng">
          <a href="<?= get_route('carts', 'showCart') ?>" class="icon-bag-cart">
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            <span class="number-product"><?= $totalCartProduct ?></span>
          </a>
        </li>
      </ul>

      <div class="col-sm-3 col-md-3 find-input">
        <form action="<?= root() ?>" method="get" class="navbar-form" role="search">
          <input type="hidden" name="controller" value="products">
          <input type="hidden" name="action" value="index">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="k" value="<?= @$_GET['k'] ?>">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search head-search-icon"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <ul class="nav navbar-nav navbar-right management-user">
        <?php if (logged_in()) { ?>
          <li>
            <a href="<?= get_route('users', 'showUser', null, array('id' => current_user()->id)) ?>">
              <i class="fa fa-user"></i> <?= current_user()->name ?>
            </a>
          </li>
          <?php if (is_admin()) { ?>
            <li><a href="<?= root('admin') ?>"><i class="fa fa-cogs"></i> Quản lý</a></li>
          <?php } else { ?>
            <li><a href="#" data-toggle="modal" data-target="#feedback-modal"><i class="fa fa-envelope"></i> Góp ý</a></li>
          <?php } ?>
          <li><a href="<?= get_route('sessions', 'destroySession') ?>"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
        <?php } else { ?>
          <li><a href="<?= get_route('users', 'newUser') ?>"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
          <li><a href="<?= get_route('sessions', 'newSession') ?>"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</header>

<div class="modal fade" id="feedback-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="feedback_form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Góp ý cho cửa hàng</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="feedback_content">Nội dung</label>
            <textarea name="content" id="feedback_content" cols="30" rows="10" class="form-control vresize"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Gửi góp ý</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(function () {
    $('#feedback_form').submit(function (event) {
      event.preventDefault();
      $.ajax({
        url: 'index.php?controller=feedbacks&action=createFeedback',
        type: 'POST',
        dataType: 'JSON',
        data: {
          content: $('#feedback_content').val()
        },
        success: function (result) {
          if (result.status == 'success') {
            $().toastmessage('showSuccessToast', result.message);
            $('#feedback_content').val('');
            $('#feedback-modal').modal('hide');
          } else {
            $().toastmessage('showErrorToast', result.message);
          }
        }
      });
    });
  });
</script>
