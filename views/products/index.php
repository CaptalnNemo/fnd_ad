<div class="lst-product col-md-9 col-sm-9 col-xs-12" id="product">
  <div class="detail-cat col-md-12 col-xs-12 col-sm-12">
    <h4 class="title-lst txt-drink">
      <i class="fa fa-hand-o-right" aria-hidden="true"></i>
      Danh sách sản phẩm <?= @$_GET['k'] ? 'cho từ khoá "' . $_GET['k'] . '"' : '' ?>
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
            <h4 class="price-item"><?= number_format($product->price, 0, ",", ".") ?> VND</h4>
            <a href="<?= get_route('products', 'showProduct', null, array('id' => $product->id)) ?>"
               class="btn btn-success btn-add-cart">Mua ngay</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<div class="side-bar col-md-3 col-sm-3 col-xs-12">
  <div class="category col-md-12 col-sm-12 xs-hidden part-sidebar">
    <div class="title-cat sub-title-sidebar">
      <h5>Danh mục sản phẩm</h5>
    </div>
    <div class="lst-cat">
      <ul>
        <?php foreach ($categories as $subCategory) {
          if ($subCategory->parent_id > 0) continue;
          ?>
          <li>
            <a data-toggle="collapse" href="#subcategories-<?= $subCategory->id ?>">
              <i class="fa fa-chevron-right" aria-hidden="true"></i> <?= $subCategory->name ?>
            </a>
          </li>
          <ul id="subcategories-<?= $subCategory->id ?>" class="collapse">
            <?php foreach ($categories as $_subCategory) {
              if ($subCategory->id != $_subCategory->parent_id) continue;
              ?>
              <li>
                <a href="<?= get_route('categories', 'showCategory', null, array('id' => $_subCategory->id)) ?>">
                  <i class="fa fa-chevron-right" aria-hidden="true"></i> <?= $_subCategory->name ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
