<section class="content-header">
  <div class="title">
    <span>Quản lý đơn hàng</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr>
          <th>Mã đơn hàng</th>
          <th>Người đặt</th>
          <th>Ngày đặt</th>
          <th>Người nhận</th>
          <th>Số điện thoại</th>
          <th>Số tiền</th>
          <th></th>
          <th>Tình trạng</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) { ?>
          <tr>
            <td><?= $order->id ?></td>
            <td><?= $order->user->name ?></td>
            <td><?= $order->created_at ?></td>
            <td><?= $order->receiver_name ?></td>
            <td><?= $order->receiver_phone ?></td>
            <td><?= number_format($order->amount, 0, ',', '.') ?> VND</td>
            <td class="text-center">
              <button class="btn btn-primary view-order-detail" data-order-id="<?= $order->id ?>">Xem</button>
            </td>
            <td>
              <select name="status" class="order_status form-control" data-order-id="<?= $order->id ?>">
                <?php for ($i = 0; $i < 3; $i++) { ?>
                  <option value="<?= $i ?>" <?= $order->status == $i ? 'selected' : '' ?>>
                    <?= order_status($i) ?>
                  </option>
                <?php } ?>
              </select>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div id="order-details" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Chi tiết đơn hàng</h4>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-responsive table-striped">
          <thead>
          <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
          </tr>
          </thead>
          <tbody class="body">

          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(function () {
    $.fn.dataTable.ext.order['dom-select'] = function (settings, col) {
      return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
        return $('select', td).val();
      });
    }

    $('.datatable').DataTable({
      'aaSorting': [],
      'columnDefs': [
        {'targets': 6, 'orderable': false}
      ],
      'columns': [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        {'orderDataType': 'dom-select'}
      ]
    });

    $('.datatable').on('change', '.order_status', function () {
      $.ajax({
        url: 'index.php?namespace=admin&controller=orders&action=updateOrder&id=' + $(this).data('order-id'),
        method: 'POST',
        dataType: 'JSON',
        data: {
          status: $(this).val()
        },
        success: function (data) {
          if (data.status == 'success') {
            $().toastmessage('showSuccessToast', 'Cập nhật trạng thái đơn hàng thành công');
          } else {
            $().toastmessage('showErrorToast', 'Không thể cập nhật trạng thái đơn hàng');
          }
        }
      });
    });

    $('.datatable').on('click', '.view-order-detail', function () {
      $.ajax({
        url: 'index.php?namespace=admin&controller=orders&action=showOrder&id=' + $(this).data('order-id'),
        method: 'GET',
        success: function (data) {
          $('#order-details .body').html(data);
          $('#order-details').modal();
        }
      })
    })
  });
</script>
