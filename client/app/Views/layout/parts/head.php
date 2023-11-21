<?php 
  if(gettype($page['title']) == 'string') $page['title'] = ['Title' => $page['title'],'subMenu' => '','subMenuPath' => ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=@$page['title']['Title']; ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url(UI['vendors']) ?>/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url(UI['vendors']) ?>/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?= base_url(UI['vendors']) ?>/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  
  <link rel="stylesheet" href="<?= base_url(UI['vendors']) ?>/lightgallery/css/lightgallery.css">
  <link rel="stylesheet" href="<?= base_url(UI['vendors']) ?>/select2/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(UI['main']); ?>/vendors/summernote/dist/summernote-bs4.css"/>
  <link rel="stylesheet" href="<?= base_url(UI['css']) ?>/theme.css">
  <link rel="stylesheet" href="<?= base_url(UI['css']) ?>/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url(UI['main']) ?>/images/favicon.png" />
  <script defer src="<?= base_url(UI['vendors']) ?>/js/vendor.bundle.base.js"></script>
  <script defer src="<?= base_url(UI['vendors']) ?>/js/vendor.bundle.addons.js"></script>
  <?php if (@$_SESSION['user_data']): ?>
    <script defer src="<?= base_url(UI['vendors']); ?>/summernote/dist/summernote-bs4.min.js"></script>
    <script>
      window.app = {
      url:'<?= base_url(); ?>',
      public: '<?=  base_url(UI['upload']);?>',
      employee: <?= json_encode(profile());?>,
      store: <?= json_encode(user_store());?>,
      role: '<?= user_data('Title')[1];?>'
    }
    </script>
  <?php endif; ?>
  <style>
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown {
    position: absolute;
    font-size: 0.9rem;
    margin-top: 0;
    right: 0;
    max-height: 300px  !important;
    left: auto;
    overflow: hidden !important;
    top: 48px;
    padding: 0;
}
    </style>
</head>

<body>
<div class="container-scroller">