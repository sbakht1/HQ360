<?php 
    $month = (@$_GET['month']) ? $_GET['month']:date('Y-m');
?>
<style>
    .actions label {display:none;}
    .actions .form-group {margin:0;}
</style>
<div class="actions text-right">
    <form id="monthForm" action="<?= current_url();?>">
        <?= form_input(['month','Month','month',$month]);?>
    </form>
</div>
<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>
<script defer src="<?= base_url(UI['main']);?>/ag-grid/pulse.js"></script>