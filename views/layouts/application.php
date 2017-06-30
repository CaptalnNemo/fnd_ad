<DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="views/assets/images/icon-logo.png">

    <title><?= display_title(@$title) ?></title>

    <link rel="stylesheet" href="views/assets/stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/font-awesome.min.css">
    <link rel="stylesheet" href="views/assets/stylesheets/slider.css">
    <link rel="stylesheet" href="views/assets/stylesheets/animate.css">
    <link rel="stylesheet" href="views/assets/stylesheets/jquery.toastmessage.css">
    <link rel="stylesheet" href="views/assets/stylesheets/custom-user.css">


    <script src="views/assets/javascripts/jquery-2.2.3.min.js"></script>
    <script src="views/assets/javascripts/bootstrap.min.js"></script>
    <script src="views/assets/javascripts/slider.min.js"></script>
    <script src="views/assets/javascripts/jquery.number.min.js"></script>
    <script src="views/assets/javascripts/wow.min.js"></script>
    <script src="views/assets/javascripts/jquery.toastmessage.js"></script>
    <script src="views/assets/javascripts/custom.js"></script>
  </head>
  <body>
  <?php include_once('views/layouts/header.php') ?>
  <div class="content-container col-md-12 col-sm-12 col-xs-12">
    <?php include_once('views/shareds/message.php') ?>
    <?= @$content ?>
  </div>
  <?php include_once('views/layouts/footer.php') ?>
  </body>
  </html>
