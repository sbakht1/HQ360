<?php
$date = (@$_GET['date']) ? '?date='.$_GET['date']."&" : '?';
?>

<ul class="nav nav-pills nav-pills-primary" id="pills-tab-custom" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ( !str_inc($_SERVER['QUERY_STRING'],'type=summary') ) ? 'active':'bg-white' ;?>" href="<?=base_url(user_data('Title')[1].'/reports/product-note')."?date=".$_GET['date'];?>">Main</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (str_inc($_SERVER['QUERY_STRING'],'type=summary')) ? 'active':'bg-white' ;?>" href="<?=base_url(user_data('Title')[1].'/reports/product-note')."?date=".$_GET['date'];?>&type=summary">Summary</a>
    </li>
</ul>

<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>