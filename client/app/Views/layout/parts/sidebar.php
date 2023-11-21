<?php
$user_data = session()->get('user_data');
$role = user_data('Title')[1];
// print_r($user_data['EmployeeID']);
if (@$user_data) {
  $base = base_url();
} else {
  header('Location:'.base_url('/login'));
}
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="profile-image">
                <img src="<?= profile('image'); ?>" alt="image"/>
              </div>
              <div class="profile-name">
                <p class="designation">
                  </p>
                  <p class="name"><?= ucwords(profile('Employee_Name'));?></p>
                  <p class="designation">
                  <?= str_replace('-',' ', ucwords(profile('Title'))); ?><br>
                  <?php if( $role === 'district-team-leader') :?>District: <?= user_store('DistrictName'); ?><br><?php endif;?>
                  <?php if($role === 'salespeople' || $role === BASE['stl']) :?>
                    Store: <?= user_store('StoreName'); ?>
                  <?php endif;?>
                </p>
              </div>
            </div>
          </li>
          <?php foreach($page['sidebar'] as $i => $item) :?>
            <li class="nav-item">
              <a class="nav-link" <?php if(isset($item->sub)): ?> data-toggle="collapse" href="#sb<?= $i;?>" aria-expanded="false" aria-controls="sb<?= $i;?>" <?php else :?> href="<?= $base.$item->link;?>"<?php endif; ?>>
                <?= str_replace("'>"," menu-icon'>",$item->icon); ?><span class="menu-title"><?= $item->title; ?></span>
                <?= (isset($item->sub)) ? '<i class="menu-arrow"></i>':'';?>
              </a>
              <?php if (isset($item->sub)): ?>
                <div class="collapse" id="sb<?= $i;?>">
                <ul class="nav flex-column sub-menu">
                  <?php foreach($item->sub as $sb): ?>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= $base.$sb->link;?>"><?= $sb->title; ?></a>
                    </li>
                  <?php endforeach;?>
                </ul>
              </div>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>
<div class="main-panel">
    <div class="content-wrapper">
    
        <div class="page-header" style="justify-content:space-between !important">
          <h3 class="page-title float-left"><?=$page['title']['Title'];?></h3>

          <?php if($page['title']['subMenu']!=''){ ?>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page" style="font-size:16px;"><a href="<?php echo base_url();?>">Dashboard</a></li>
                  <li class="breadcrumb-item" style="font-size:16px;"><a href="<?=base_url() ."/". $page['title']['subMenuPath'] ?>"><?=$page['title']['subMenu']?></a></li>
                  <li class="breadcrumb-item active" aria-current="page" style="font-size:16px;">
                  <?=$page['title']['Title'];?>
                  </li>
                </ol>
              </nav>
            <?php } ?>
        </div>
        <?php if (@$_SESSION['success']) : ?>
          <div data-flash="<?= $_SESSION['success'] ?>" data-type="success"></div>
        <?php endif; ?>
        <?php if (@$_SESSION['error']) : ?>
          <div data-flash="<?= $_SESSION['error'] ?>" data-type="error"></div>
        <?php endif; ?>