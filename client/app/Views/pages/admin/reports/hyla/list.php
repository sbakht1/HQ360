<?php
$date = (@$_GET['date']) ? '?date='.$_GET['date'].'&':'?';
?>
<ul class="nav nav-pills nav-pills-primary" id="pills-tab-custom" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= (strpos($_SERVER['QUERY_STRING'], 'type=') !== false) ? 'bg-white':'active' ;?>" href="<?= current_url().$date;?>">Hyla</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (strpos($_SERVER['QUERY_STRING'], 'type=discrepancy') !== false) ? 'active':'bg-white' ;?>" href="<?= base_url(user_data('Title')[1].'/reports').'/'.$slug.$date.'type=discrepancy';?>">Discrepancy</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (strpos($_SERVER['QUERY_STRING'], 'type=trade-in') !== false) ? 'active':'bg-white' ;?>" href="<?= base_url(user_data('Title')[1].'/reports').'/'.$slug.$date.'type=trade-in';?>">Trade In</a>
    </li>
</ul>
<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>