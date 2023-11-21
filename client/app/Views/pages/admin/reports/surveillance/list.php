<?php if(strpos($_SERVER['PATH_INFO'],'conversion') !== false): ?>
<ul class="nav nav-pills nav-pills-primary" id="pills-tab-custom" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ( !str_inc($_SERVER['QUERY_STRING'],'get=store') ) ? 'active':'bg-white' ;?>" href="<?=base_url($_SERVER['PATH_INFO'])."?date=".$_GET['date'];?>">Employees</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (str_inc($_SERVER['QUERY_STRING'],'get=store')) ? 'active':'bg-white' ;?>" href="<?=base_url($_SERVER['PATH_INFO'])."?date=".$_GET['date'];?>&get=store">Stores</a>
    </li>
</ul>
<?php endif;?>

<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>