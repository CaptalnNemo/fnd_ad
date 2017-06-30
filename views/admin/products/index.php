<section class="content-header">
  <div class="title">
    <span>Quản lý sản phẩm</span>
    <a href="<?= get_route('products', 'newProduct', 'admin') ?>" class="btn btn-primary pull-right"><i
        class="fa fa-plus"></i> Thêm mới</a>
  </div>
</section>

<section class="content">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr>
          <th>Tên</th>
          <th>Giá bán</th>
          <th>Mô tả</th>
          <th>Danh mục</th>
          <th>Trạng thái</th>
          <th>Ảnh</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) { ?>
          <tr>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td title="<?= $product->description ?>"><?= mb_substr($product->description, 0, 60) ?>...</td>
            <td><?= $product->getCategoryName() ?></td>
            <td
              class="<?= $product->status ? 'bg-success' : 'bg-danger' ?>"><?= $product->status ? 'Còn hàng' : 'Hết hàng  ' ?></td>
            <td class="text-center">
              <a href="#" class="show-product-images" data-id="<?= $product->id ?>"
                 data-name="<?= $product->name ?>">Xem</a>
            </td>
            <td class="text-center">
              <a href="<?= get_route('products', 'editProduct', 'admin', array('id' => $product->id)) ?>"
                 class="btn btn-info">
                <i class="fa fa-pencil"></i>
              </a>
              <a href="<?= get_route('products', 'destroyProduct', 'admin', array('id' => $product->id)) ?>"
                 onClick="return confirm('Xác nhận xóa?')" class="btn btn-danger">
                <i class="fa fa-remove"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div id="product-images" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Quản lý ảnh cho sản phẩm <span class="product-name"></span></h4>
      </div>
      <div class="modal-body">
        <form class="form-upload-image" method="post" enctype="multipart/form-data">
          <input type="hidden" name="product_id" id="product_id"/>
          <div class="form-group">
            <input id="product_image" type="file" name="product_image" class="form-control" accept="image/*"/>
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Tải lên</button>
          </div>
        </form>
        <div class="images"></div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(function () {
    $('.datatable').DataTable({
      'aaSorting': [],
      'columnDefs': [
        {'targets': 5, 'orderable': false},
        {'targets': 6, 'orderable': false}
      ]
    });

    $('.datatable').on('click', '.show-product-images', function (event) {
      event.preventDefault();
      $('.product-name').html($(this).data('name'));
      var product_id = $(this).data('id');
      $('#product_id').val(product_id);
      $.ajax({
        url: 'index.php?namespace=admin&controller=products&action=showImages&id=' + product_id,
        method: 'GET',
        success: function (data) {
          $('#product-images .images').html(data);
          $('#product-images').modal();
        }
      });
    });

    $('.form-upload-image').submit(function (event) {
      event.preventDefault();
      var form_data = new FormData();
      form_data.append('file', $('#product_image').prop('files')[0]);
      form_data.append('product_id', $('#product_id').val());
      $.ajax({
        url: 'index.php?namespace=admin&controller=product_images&action=createProductImage',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        datatType: 'JSON',
        success: function (result) {
          result = JSON.parse(result);
          if (result.status == 'success') {
            $('#product-images .images').html(result.data);
            $('#product_image').val('');
            $().toastmessage('showSuccessToast', result.message);
          } else {
            $().toastmessage('showErrorToast', result.message);
          }
        }
      });
    });

    $('#product-images').on('click', '.delete-image', function () {
      if (confirm('Xác nhận xoá?')) {
        $.ajax({
          url: 'index.php?namespace=admin&controller=product_images&action=destroyProductImage&id=' + $(this).data('id'),
          type: 'DELETE',
          datatType: 'JSON',
          success: function (result) {
            result = JSON.parse(result);
            if (result.status == 'success') {
              $('#product-images .images').html(result.data);
              $().toastmessage('showSuccessToast', result.message);
            } else {
              $().toastmessage('showErrorToast', result.message);
            }
          }
        });
      }
    })
  });
</script>
