<div class="main-content col-md-12 col-sm-12 col-xs-12">
  <div class="slider col-md-12 col-sm-12 hidden-xs">
    <div class="slider" id="slider">
      <div class="slItems">
        <div class="slItem" style="background-image: url('views/assets/images/slider-1.png');"></div>
        <div class="slItem" style="background-image: url('views/assets/images/slider-2.png');"></div>
        <div class="slItem" style="background-image: url('views/assets/images/cream.png');"></div>
        <div class="slItem" style="background-image: url('views/assets/images/chicken-sandwich.png');"></div>
      </div>
    </div>
  </div>

  <div class="welcome col-md-12 col-sm-12 col-xs-12" id="hello">
    <h2 class="wow">FoodnDrink</h2>
    <p>Mắt đẫn đờ, dạ dày rỗng, con tim rối bời chỉ vì không biết ăn gì ở đâu? Đừng lo, vào đây có hết!</p>
  </div>

  <div class="lst-product col-md-9 col-sm-9 col-xs-12" id="product">
    <?php foreach ($categories as $category) {
      $products = $category->getInStockProducts();
      if (empty($products)) continue;
      ?>
      <div class="detail-cat col-md-12 col-xs-12 col-sm-12">
        <h4 class="title-lst txt-drink">
          <i class="fa fa-hand-o-right" aria-hidden="true"></i> <?= $category->name ?>
        </h4>
        <div class="col-sm-12 col-md-12 detail-item">
          <?php foreach ($products as $product) { ?>
            <div class="col-md-3 item">
              <a href="<?= get_route('products', 'showProduct', null, array('id' => $product->id)) ?>">
                <img src="<?= getProductFirstImage($product) ?>" class="img-responsive">
              </a>
              <div class="infor-product col-md-12">
                <a href="<?= get_route('products', 'showProduct', null, array('id' => $product->id)) ?>">
                  <h4 class="name-item" title="<?= $product->name ?>"><?= $product->name ?></h4>
                </a>
                <p><?= renderRatingStar(floor($product->rating)) ?></p>
                <h4 class="price-item"><?= number_format($product->price, 0, ",", ".") ?> VND</h4>
                <a href="<?= get_route('products', 'showProduct', null, array('id' => $product->id)) ?>"
                   class="btn btn-success btn-add-cart">Mua ngay</a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="side-bar col-md-3 col-sm-3 col-xs-12">
    <div class="category col-md-12 col-sm-12 xs-hidden part-sidebar">
      <div class="title-cat sub-title-sidebar">
        <h5>Danh mục sản phẩm</h5>
      </div>
      <div class="lst-cat">
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
  </div>
</div>

<script>
new WOW().init();
  $(function () {
    $('#slider').rbtSlider({
      height: '100vh',
      'dots': true,
      'arrows': true,
      'auto': 3
    });
  });
</script>
