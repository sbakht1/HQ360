<?php 
    $month = (@$_GET['month']) ? $_GET['month']:date('Y-m');
    $role = user_data('Title')[1];
    // debug([page_url(),$_SERVER]);
?>

<style>
    .actions label {display:none;}
    .actions .form-group {margin:0;}
</style>
<div class="actions text-right">
    <form id="monthForm" action="<?= current_url();?>">
        <?= form_input(['month','Month','month',$month]);?>
    </form>
    <?php if($role == 'admin'): ?>
    <a href="<?= base_url(user_data('Title')[1]);?>/connections/new" class="btn btn-primary">Add New</a>
    <a href="<?= str_replace('connections','connections/find',page_url("export=true")) ?>" class="btn btn-success">Export</a>
    <a href="<?= current_url()."/form" ?>" class="btn btn-warning">Edit Form</a>
    <?php endif;?>
</div>
<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>
<script defer src="<?= base_url(UI['main']);?>/ag-grid/connections.js"></script>