<?php
if (isset($_SESSION['message'])) {
  ?>
  <div class="alert alert-<?php echo $_SESSION['message']['class'] ?> message">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $_SESSION['message']['content'] ?>
  </div>
  <?php
  unset($_SESSION['message']);
}
?>
