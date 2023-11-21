<?php 
    $role = user_data('Title')[1];
    $month = (@$_GET['month']) ? $_GET['month'] : date('Ym');
    $type = (@$_GET['type']) ? $_GET['type'] : "employee";
    $dis_month = substr($month,0,4).'-'.substr($month,4,6);
?>
<style>
    .actions .form-group {margin:0;display:inline-block}
    .actions .form-group label {display:none;}
</style>
<script>
    window.app.score = '/<?= user_data('Title')[1];?>/scorecards/find_data?month=<?= $month;?>&type=<?= $type;?>';
</script>
<div id="myGrid" style="height: 100%;" class="ag-theme-balham"></div>
<script defer src="<?=base_url(UI['main']);?>/ag-grid/infinite.js"></script>