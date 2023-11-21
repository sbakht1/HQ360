
<ul class="nav nav-pills nav-pills-primary" id="pills-tab-custom" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?= ( !str_inc($_SERVER['QUERY_STRING'],'type=summary') ) ? 'active':'bg-white' ;?>" href="<?=base_url(user_data('Title')[1].'/reports/obsolete')."?date=".$_GET['date'];?>">Main</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (str_inc($_SERVER['QUERY_STRING'],'type=summary')) ? 'active':'bg-white' ;?>" href="<?=base_url(user_data('Title')[1].'/reports/obsolete')."?date=".$_GET['date'];?>&type=summary">Summary</a>
    </li>
</ul>


<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>

<script defer src="<?= base_url(UI['main']);?>/ag-grid/reports/obsolete.js"></script>
<script defer src="<?= base_url(UI['main']);?>/ag-grid/GroupRowInnerRenderer.js"></script>