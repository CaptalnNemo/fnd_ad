<?php
if (isset($_SESSION['form_errors'])) {
  ?>
  <div class="form-errors">
    <ul>
      <?php foreach ($_SESSION['form_errors'] as $error) { ?>
        <li><?= $error ?></li>
      <?php } ?>
    </ul>
  </div>
  <?php
  unset($_SESSION['form_errors']);
}
?>
