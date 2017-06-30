<section class="content-header">
  <div class="title">
    <span>Quản lý người dùng</span>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr>
          <th>Tên</th>
          <th>Email</th>
          <th>Số điện thoại</th>
          <th>Vai trò</th>
          <th>Trạng thái</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?><?php if ($user->id == current_user()->id) continue; ?>
          <tr>
            <td><?= $user->name ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->phone ?></td>
            <td><?= $user->is_admin ? 'Quản trị viên' : 'Người dùng' ?></td>
            <td class="<?= $user->activated ? 'bg-success' : 'bg-danger' ?>">
              <?= $user->activated ? 'Kích hoạt' : 'Không kích hoạt' ?>
            </td>
            <td class="text-center">
              <a href="<?= get_route('users', 'editUser', 'admin', array('id' => $user->id)) ?>">
                <button class="btn btn-info"><i class="fa fa-pencil"></i></button>
              </a>
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
    $('.datatable').DataTable({
      'aaSorting': [],
      'columnDefs': [
        {'targets': 5, 'orderable': false}
      ]
    });
  });
</script>
