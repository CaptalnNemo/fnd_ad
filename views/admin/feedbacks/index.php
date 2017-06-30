<section class="content-header">
  <div class="title">
    <span>Quản lý góp ý</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr>
          <th>Người gửi</th>
          <th>Ngày gửi</th>
          <th>Nội dung</th>
          <th>Tình trạng</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($feedbacks as $feedback) { ?>
          <tr>
            <td><?= $feedback->user->name ?></td>
            <td><?= $feedback->created_at ?></td>
            <td><?= $feedback->content ?></td>
            <td>
              <select name="status" class="feedback-status form-control" data-feedback-id="<?= $feedback->id ?>">
                <option value="0" <?= $feedback->status == 0 ? 'selected' : '' ?>>
                  Chưa xem
                </option>
                <option value="1" <?= $feedback->status == 1 ? 'selected' : '' ?>>
                  Đã xem
                </option>
              </select>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script type="text/javascript">
  $(function () {
    $.fn.dataTable.ext.order['dom-select'] = function (settings, col) {
      return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
        return $('select', td).val();
      });
    }

    $('.datatable').DataTable({
      'aaSorting': [],
      'columns': [
        null,
        null,
        null,
        {'orderDataType': 'dom-select'}
      ]
    });

    $('.datatable').on('change', '.feedback-status', function () {
      $.ajax({
        url: 'index.php?namespace=admin&controller=feedbacks&action=updateFeedback&id=' + $(this).data('feedback-id'),
        method: 'POST',
        dataType: 'JSON',
        data: {
          status: $(this).val()
        },
        success: function (data) {
          if (data.status == 'success') {
            $().toastmessage('showSuccessToast', data.message);
          } else {
            $().toastmessage('showErrorToast', data.message);
          }
        }
      });
    });
  });
</script>
