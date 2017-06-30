<section class="content-header">
  <div class="title">
    <span>Quản lý danh mục sản phẩm</span>
    <a href="<?= get_route('categories', 'newCategory', 'admin') ?>" class="btn btn-primary pull-right">
      <i class="fa fa-plus"></i> Thêm mới
    </a>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr>
          <th>Tên danh mục</th>
          <th>Danh mục cha</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category) { ?>
          <tr>
            <td><?= $category->name ?></td>
            <td><?= $category->getParentName() ?></td>
            <td class="text-center">
              <a href="<?= get_route('categories', 'editCategory', 'admin', array('id' => $category->id)) ?>">
                <button class="btn btn-info"><i class="fa fa-pencil"></i></button>
              </a>
              <a href="<?= get_route('categories', 'destroyCategory', 'admin', array('id' => $category->id)) ?>"
                 onClick="return confirm('Xác nhận xóa?')">
                <button class="btn btn-danger"><i class="fa fa-remove"></i></button>
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
        {'targets': 2, 'orderable': false}
      ]
    });
  });
</script>
