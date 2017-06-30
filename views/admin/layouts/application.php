<DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="views/assets/images/icon.ico">

    <title><?= display_title(@$title) ?></title>

    <link rel="stylesheet" href="views/assets/stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/font-awesome.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/AdminLTE.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/skin-blue.css">
    <link rel="stylesheet" href="views/assets/stylesheets/datatables.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/jquery.toastmessage.css">
    <link rel="stylesheet" href="views/assets/stylesheets/custom-admin.css">

    <script src="views/assets/javascripts/jquery-2.2.3.min.js"></script>
    <script src="views/assets/javascripts/bootstrap.min.js"></script>
    <script src="views/assets/javascripts/app.min.js"></script>
    <script src="views/assets/javascripts/datatables.min.js"></script>
    <script src="views/assets/javascripts/jquery.number.min.js"></script>
    <script src="views/assets/javascripts/jquery.toastmessage.js"></script>
    <script src="views/assets/javascripts/highcharts.js"></script>
    <script src="views/assets/javascripts/custom.js"></script>
  </head>
  <body class="skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include_once('views/admin/layouts/header.php') ?>
    <?php include_once('views/admin/layouts/sidebar.php') ?>
    <div class="content-wrapper">
      <?php include_once('views/shareds/message.php') ?>
      <?= @$content ?>
    </div>
    <?php include_once('views/admin/layouts/footer.php') ?>
  </div>
  <body>
  <html>
