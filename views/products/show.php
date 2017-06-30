<div class="margin-top-20 col-md-12">
  <div class="col-md-9 col-sm-9 col-xs-12 show-detail-product">
    <div class="detail-img col-md-6 col-sm-6 col-xs-12">
      <div class="slider" id="slider">
        <div class="slItems">
          <?php
          $images = $product->getImages();
          if (count($images) > 1) {
            foreach ($images as $image) { ?>
              <div class="slItem" style="background-image: url('<?= $image->image ?>')"></div>
            <?php }
          } else {
            $image = @$images[0] ? $images[0]->image : 'views/assets/images/no-image.png';
            ?>
            <div class="one-image" style="background-image: url('<?= $image ?>')"></div>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="detail-descrip col-md-6 col-sm-6 col-xs-12">
      <h2 class="detail-name-item"><?= $product->name ?></h2>
      <h3 class="detail-price"><?= number_format($product->price, 0, ",", ".") ?>VND</h3>
      <p id="product_rating"><?= renderRatingStar(floor($product->rating)) ?></p>
      <p class="detail-description-item">
        <?= $product->description ?>
      </p>

      <div class="col-sm-12 addToCart">
        <form class="cart-form col-md-12" method="POST" id="form-add-to-cart" data-product-id="<?= $product->id ?>">
          <div class="quantity">
            <label for="">Số lượng:</label>
            <div class="input-group">
              <input type="number" name="quantity" value="1" min="1" class="quantity-txt form-control" size="4">
              <span class="input-group-btn cart-control">
                <button type="submit" class="btn button-my-cart btn-danger">
                  <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
                </button>
              </span>
            </div>
          </div>
        </form>
      </div>

      <div class="rate-share col-md-12">
        <div class="rating col-md-7">
          <label class="txt-rating">Đánh giá sản phẩm</label>
          <form data-action="<?= $rated_score == 0 ? 'createRating' : 'updateRating' ?>"
                data-product-id="<?= $product->id ?>" id="form_rate">
            <input type="hidden" name="rating_score" value="<?= $rated_score ?>" id="rating_score">
            <span class="lst-star">
              <?php for ($i = 1; $i <= $rated_score; $i++) { ?>
                <i class="fa fa-star rating-star" data-index="<?= $i ?>"></i>
              <?php } ?>
              <?php for ($i = $rated_score + 1; $i <= 5; $i++) { ?>
                <i class="fa fa-star-o rating-star" data-index="<?= $i ?>"></i>
              <?php } ?>
            </span>
          </form>
        </div>
        <a
          href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
          class="btn col-md-5 share-fb btn-info" target="_blank">
          <i class="fa fa-facebook" aria-hidden="true"></i> Chia sẻ Facebook
        </a>
      </div>
    </div>

    <div class="cmt col-md-12">
      <div class="region-cmt col-md-8 col-md-offset-2 col-sm-offset-0 col-xs-offset-0 col-sm-12 col-xs-12">
        <div class="pt-title">
          <p class="number-cmt">
            <span class="comment_count"><?= count($comments) ?></span> bình luận </p>
        </div>

        <?php if (logged_in()) { ?>
          <form class="form-none-cmt form-cmt" id="form_comment" method="post" data-product-id="<?= $product->id ?>">
            <div class="form-group">
              <textarea type="text" class="form-control vresize" name="content" id="comment_content"
                        placeholder="Hãy bình luận cho sản phẩm mình thích" required></textarea>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Gửi</button>
            </div>
          </form>
        <?php } else { ?>
          <div class="well text-center">
            Hãy <a href="<?= get_route('sessions', 'newSession') ?>">đăng nhập</a> để có thể gửi bình luận
          </div>
        <?php } ?>

        <div id="comments">
          <?php
          foreach ($comments as $comment) {
            echo renderComment($comment);
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="side-bar col-md-3 col-sm-3 col-xs-12">
    <div class="category col-md-12 col-sm-12 xs-hidden part-sidebar">
      <div class="title-cat sub-title-sidebar">
        <h5>Danh mục sản phẩm</h5>
      </div>
      <div class="lst-cat lst-item-sidebar">
        <ul>
          <?php foreach ($categories as $category) {
            if ($category->parent_id > 0) continue;
            ?>
            <li>
              <a data-toggle="collapse" href="#subcategories-<?= $category->id ?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i> <?= $category->name ?>
              </a>
            </li>
            <ul id="subcategories-<?= $category->id ?>" class="collapse">
              <?php foreach ($categories as $subCategory) {
                if ($subCategory->parent_id != $category->id) continue;
                ?>
                <li>
                  <a href="<?= get_route('categories', 'showCategory', null, array('id' => $subCategory->id)) ?>">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i> <?= $subCategory->name ?>
                  </a>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </ul>
      </div>
    </div>

    <div class="relation-product col-md-12 col-sm-12 xs-hidden part-sidebar">
      <div class="title-cat sub-title-sidebar">
        <h5>Sản phẩm liên quan</h5>
      </div>
      <div class="lst-relation-item col-md-12">
        <ul class="col-md-12">
          <?php foreach ($product->getRelateProducts(5) as $relateProduct) { ?>
            <li class="col-md-12">
              <a href="<?= get_route('products', 'showProduct', null, array('id' => $relateProduct->id)) ?>">
                <div class="clearfix">
                  <img src="<?= getProductFirstImage($relateProduct) ?>"/>
                  <div class="infor-product-sidebar">
                    <h5 class="name-relation-item"><?= $relateProduct->name ?></h5>
                    <h5 class="price-relation-item"><?= number_format($relateProduct->price, 0, ",", ".") ?>VND</h5>
                  </div>
                </div>
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    $('#slider').rbtSlider({
      height: '70%',
      'dots': true,
      'arrows': true,
      'auto': 3
    });
    $('.rating').on('mouseenter', '.rating-star', function () {
      var index = $(this).data('index');
      for (var i = 1; i <= index; i++) {
        $('.rating-star[data-index="' + i + '"]').removeClass('fa-star-o').addClass('fa-star');
      }
      for (var i = index + 1; i <= 5; i++) {
        $('.rating-star[data-index="' + i + '"]').removeClass('fa-star').addClass('fa-star-o');
      }
    });
    $('.rating').on('mouseleave', '.lst-star', function () {
      var selected = parseInt($('#rating_score').val()) || 0;
      for (var i = 1; i <= selected; i++) {
        $('.rating-star[data-index="' + i + '"]').removeClass('fa-star-o').addClass('fa-star');
      }
      for (var i = selected + 1; i <= 5; i++) {
        $('.rating-star[data-index="' + i + '"]').removeClass('fa-star').addClass('fa-star-o');
      }
    });
    $('.rating').on('click', '.rating-star', function () {
      var selected = parseInt($(this).data('index'));
      $('#rating_score').val(selected);
      for (var i = selected + 1; i <= 5; i++) {
        $('.rating-star[data-index="' + i + '"]').removeClass('fa-star').addClass('fa-star-o');
      }
      var action = $(this).closest('form').data('action');
      var product_id = $(this).closest('form').data('product-id');
      $.ajax({
        url: 'index.php?controller=ratings&action=' + action,
        type: 'POST',
        dataType: 'JSON',
        data: {
          score: $('#rating_score').val(),
          product_id: product_id
        },
        success: function (result) {
          if (result.status == 'success') {
            $('#product_rating').html(result.product_rating);
            $().toastmessage('showSuccessToast', result.message);
            if ($('#form_rate').data('action') == 'createRating') {
              $('#form_rate').data('action', 'updateRating');
            }
          } else {
            $().toastmessage('showErrorToast', result.message);
          }
        }
      });
    });
    $('#form-add-to-cart').submit(function (event) {
      event.preventDefault();
      var quantity = parseInt($('.quantity-txt', $(this)).val());
      var product_id = $(this).data('product-id');
      $.ajax({
        url: 'index.php?controller=carts&action=createCart',
        type: 'POST',
        dataType: 'JSON',
        data: {
          quantity: quantity,
          product_id: product_id
        },
        success: function (result) {
          $('.number-product').html(result.total_product);
          $('.title-number-product').prop('title', 'Có ' + result.total_product + ' sản phẩm trong giỏ hàng')
          $().toastmessage('showSuccessToast', 'Đã thêm sản phẩm vào giỏ hàng');
        }
      });
    });
    $('#form_comment').submit(function (event) {
      event.preventDefault();
      var product_id = $(this).data('product-id');
      $.ajax({
        url: 'index.php?controller=comments&action=createComment',
        type: 'POST',
        dataType: 'JSON',
        data: {
          content: $('#comment_content').val(),
          product_id: product_id
        },
        success: function (result) {
          if (result.status == 'success') {
            $().toastmessage('showSuccessToast', result.message);
            $('#comment_content').val('');
            $('#comments').prepend(result.comment);
            $('.comment_count').html(parseInt($('.comment_count').html()) + 1);
          } else {
            $().toastmessage('showErrorToast', result.message);
          }
        }
      });
    });
    $('#comments').on('click', '.remove-comment-btn', function (event) {
      if (confirm('Xác nhận xoá?')) {
        event.preventDefault();
        var $comment = $(this).closest('.comment');
        $.ajax({
          url: 'index.php?controller=comments&action=destroyComment&id=' + $comment.data('comment-id'),
          type: 'DELETE',
          dataType: 'JSON',
          success: function (result) {
            if (result.status == 'success') {
              $().toastmessage('showSuccessToast', result.message);
              $comment.slideUp('slow');
              $('.comment_count').html(parseInt($('.comment_count').html()) - 1);
            } else {
              $().toastmessage('showErrorToast', result.message);
            }
          }
        });
      }
    });
  })
</script>
