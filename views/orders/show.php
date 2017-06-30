<div class="col-md-12">
  <h4 class="txt-detail-order">Chi tiết hóa đơn</h4>
  <div class="container">
    <div class="infor-customer col-md-4 col-xs-12 col-sm-4">
      <div class="panel panel-info">
        <div class="panel-heading text-center">Thông tin khách hàng</div>
        <table class="table table-responsive receiver_infomation">
          <tr>
            <th>Họ và tên</th>
            <td><?= $order->receiver_name ?></td>
          </tr>
          <tr>
            <th>Số điện thoại</th>
            <td><?= $order->receiver_phone ?></td>
          </tr>
          <tr>
            <th>Địa chỉ</th>
            <td><?= $order->receiver_address ?></td>
          </tr>
          <tr>
            <th>Ghi chú</th>
            <td><?= $order->note ?></td>
          </tr>
          <tr>
            <th>Ngày đặt</th>
            <td><?= $order->created_at ?></td>
          </tr>
          <tr>
            <th>Trạng thái</th>
            <td><strong><?= order_status($order->status) ?></strong></td>
          </tr>
        </table>

      </div>
    </div>
    <div class="infor-lst-product col-md-8 col-xs-12 col-sm-8">
      <div class="panel panel-info">
        <div class="panel-heading text-center">Chi tiết hóa đơn</div>
        <table class="table table-hover table-responsive table-striped">
          <thead>
          <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($order->getOrderDetails() as $orderDetail) { ?>
            <tr>
              <td class="cart-item-image">
                <a href="<?= get_route('products', 'showProduct', null, array('id' => $orderDetail->product_id)) ?>">
                  <img src="<?= getProductFirstImage($orderDetail->product) ?>" class="img-responsive"/>
                  <span class="cart-item-name"><?= $orderDetail->product->name ?></span>
                </a>
              </td>
              <td class="cart-item-quantity td-padding-top">
                <span class="quantity"><?= $orderDetail->quantity ?></span>
              </td>
              <td class="cart-item-subtotal td-padding-top">
                <span class="price"><?= number_format($orderDetail->price, 0, ',', '.') ?> VND</span>
              </td>
              <td class="cart-item-subtotal td-padding-top">
                <span class="total-price"><?= number_format($orderDetail->amount, 0, ',', '.') ?> VND</span>
              </td>
            </tr>
          <?php } ?>
          <tr class="total_bill">
            <td><span class="product-payment pull-left">Thành tiền</span></td>
            <td></td>
            <td></td>
            <td class="total-price"><?= number_format($order->amount, 0, ',', '.') ?> VND</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
