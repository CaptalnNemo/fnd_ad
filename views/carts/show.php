<div class="col-md-12">
  <h3 class="title-lst-cart">Danh sách sản phẩm trong giỏ hàng</h3>
  <div class="table-responsive col-md-10 col-md-push-1">
    <table class="table  cart-table">
      <thead>
      <tr>
        <th>Sản phẩm</th>
        <th class="text-right">Đơn giá</th>
        <th>Số lượng</th>
        <th class="text-right">Tổng tiền</th>
        <th></th>
        <th></th>
      </tr>
      </thead>
      <?php
      $total_amount = 0;
      foreach ($cartItems as $cartItem) {
        $total_amount += $cartItem->amount;
        ?>
        <tr class="tr-cart-item" data-price="<?= $cartItem->product->price ?>" data-amount="<?= $cartItem->amount ?>">
          <td class="cart-item-image">
            <a href="<?= get_route('products', 'showProduct', null, array('id' => $cartItem->product_id)) ?>">
              <img src="<?= getProductFirstImage($cartItem->product) ?>" class="img-responsive"/>
              <span class="cart-item-name"><?= $cartItem->product->name ?></span>
            </a>
          </td>
          <td class="cart-item-price td-padding-top text-right">
            <span class="price"><?= number_format($cartItem->product->price, 0, ",", ".") ?> VND</span>
          </td>
          <td class="cart-item-quantity">
            <div class="quantity">
              <input type="number" name="quantity" value="<?= $cartItem->quantity ?>" class="quantity-txt form-control"
                     size="4">
            </div>
          </td>
          <td class="cart-item-subtotal td-padding-top text-right">
            <span class="amount"><?= number_format($cartItem->amount, 0, ",", ".") ?> VND</span>
          </td>
          <td style="width: 20px;padding-left: 0px; padding-right: 0px;">
            <button type="button" class="btn btn-in-cart btn-save btn-info"
                    data-product-id="<?= $cartItem->product_id ?>" title="Lưu sửa đổi">
              <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </button>
          </td>
          <td style="width: 20px;padding-left: 0px; padding-right: 0px;">
            <button type="button" class="btn btn-in-cart btn-delete btn-info"
                    data-product-id="<?= $cartItem->product_id ?>" title="Xoá sản phẩm">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
          </td>
        </tr>
      <?php } ?>

      <tr>
        <td class="product-payment" colspan="3">Thành tiền</td>
        <td class="text-right">
          <span class="total-price"
                data-value="<?= $total_amount ?>"><?= number_format($total_amount, 0, ",", ".") ?> VND</span>
        </td>
        <td colspan="2" class="text-right">
          <?php if (count($cartItems) > 0) {
            if (logged_in()) { ?>
              <button type="button" class="btn btn-pay btn-info" data-toggle="collapse"
                      data-target=".form-infor-customer">Tiếp tục
              </button>
            <?php } else { ?>
              <a href="<?= get_route('sessions', 'newSession') ?>" class="btn btn-pay btn-info">Tiếp tục
              </a>
            <?php }
          } ?>
        </td>
      </tr>
    </table>
  </div>

</div>

<form action="<?= get_route('orders', 'createOrder') ?>" class="col-md-6 col-md-push-3 form-infor-customer collapse"
      method="POST">
  <h4>Hãy nhập thông tin người nhận</h4>
  <input type="hidden" name="amount" value="<?= $total_amount ?>" id="total_amount">
  <div class="form-group">
    <label>Họ và tên <span class="red-star">*</span></label>
    <input type="text" class="form-control" name="receiver_name" required>
  </div>
  <div class="form-group">
    <label>Số điện thoại <span class="red-star">*</span></label>
    <input type="text" class="form-control" name="receiver_phone" required>
  </div>
  <div class="form-group">
    <label>Địa chỉ <span class="red-star">*</span></label>
    <input type="text" class="form-control" name="receiver_address" required>
  </div>
  <div class="form-group">
    <label>Ghi chú</label>
    <textarea class="form-control" rows="5" id="comment" name="note"></textarea>
  </div>
  <button type="submit" class="btn btn-order btn-info">Đặt hàng</button>
</form>


<script type="text/javascript">
  $(function () {
    $('.quantity-txt').change(function () {
      var $tr_product = $(this).closest('.tr-cart-item');
      var old_amount = parseInt($tr_product.data('amount'));
      var price = parseInt($tr_product.data('price'));
      var quantity = parseInt($(this).val());
      var new_amount = price * quantity;
      $tr_product.find('.amount').html($.number(new_amount, 0, ',', '.') + ' VND');
      var total_amount = parseInt($('.total-price').data('value')) + new_amount - old_amount;
      $tr_product.data('amount', new_amount);
      $('.total-price').data('value', total_amount);
      $('.total-price').html($.number(total_amount, 0, ',', '.') + ' VND');
    });

    $('.btn-save').click(function () {
      $.ajax({
        url: 'index.php?controller=carts&action=updateCart',
        type: 'POST',
        dataType: 'JSON',
        data: {
          quantity: $(this).closest('.tr-cart-item').find('.quantity-txt').val(),
          product_id: $(this).data('product-id')
        },
        success: function (data) {
          $('.number-product').html(data.total_product);
          $('#total_amount').val(data.total_amount);
          $().toastmessage('showSuccessToast', 'Đã cập nhật số lượng sản phẩm trong giỏ hàng');
        }
      });
    });

    $('.btn-delete').click(function () {
      if (confirm('Xác nhận xoá?')) {
        var $tr_product = $(this).closest('.tr-cart-item');
        $.ajax({
          url: 'index.php?controller=carts&action=destroyCart&product_id=' + $(this).data('product-id'),
          type: 'GET',
          dataType: 'JSON',
          success: function (data) {
            var amount = parseInt($tr_product.data('amount'));
            var total_amount = parseInt($('.total-price').data('value')) - amount;
            $('.total-price').data('value', total_amount);
            $('.total-price').html($.number(total_amount, 0, ',', '.') + ' VND');
            $('.number-product').html(data.total_product);
            if (data.total_product == 0) {
              $('.btn-pay').hide();
            }
            $('#total_amount').val(data.total_amount);
            $tr_product.slideUp();
            $().toastmessage('showSuccessToast', 'Đã loại bỏ sản phẩm khỏi giỏ hàng');
          }
        });
      }
    });
  });
</script>
