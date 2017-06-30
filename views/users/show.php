<div class="col-md-12">
  <h4 class="txt-detail-order">Hồ sơ người dùng</h4>
  <div class="container">
    <div class="infor-customer col-md-4 col-xs-12 col-sm-4">
      <div class="panel panel-info">
        <div class="panel-heading text-center">Thông tin</div>
        <table class="table table-responsive receiver_infomation">
          <tr>
            <th>Họ và tên</th>
            <td><?= $user->name ?></td>
          </tr>
          <tr>
            <th>Số điện thoại</th>
            <td><?= $user->phone ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?= $user->email ?></td>
          </tr>
          <tr>
            <th>Trạng thái</th>
            <td><?= $user->activated ? 'Kích hoạt' : 'Không kích hoạt' ?></td>
          </tr>
          <tr>
            <td colspan="2" class="text-right">
              <a href="<?= get_route('users', 'editUser', null, array('id' => $user->id)) ?>"
                 class="btn btn-info"><i class="fa fa-pencil"></i> Cập nhật</a>
            </td>
          </tr>
        </table>

      </div>
    </div>
    <div class="infor-lst-product col-md-8 col-xs-12 col-sm-8">
      <div class="panel panel-info">
        <div class="panel-heading text-center">Lịch sử đặt hàng</div>
        <div class="table-history">
          <table class="table table-striped table-responsive table-hover">
            <thead>
            <tr>
              <th>Mã đơn hàng</th>
              <th>Ngày đặt hàng</th>
              <th>Tổng tiền</th>
              <th>Tình trạng</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($user->getListOrders() as $order) { ?>
              <tr>
                <td class="code-order"><?= $order->id ?></td>
                <td class="time-order">17/12/2010</td>
                <td class="total-price-order"><?= number_format($order->amount, 0, ',', '.') ?> VND</td>
                <td class="status"><?= order_status($order->status) ?></td>
                <td class="view-detail">
                  <a href="<?= get_route('orders', 'showOrder', null, array('id' => $order->id)) ?>">Xem chi tiết</a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
