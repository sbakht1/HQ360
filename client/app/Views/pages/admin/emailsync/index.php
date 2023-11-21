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
    window.app.score = '/<?= user_data('Title')[1];?>/emailsync/find_data?month=<?= $month;?>&type=<?= $type;?>';
   
</script>
<div class="actions">
    <?= form_input(['month','Month','month',$dis_month]); ?>
    <?php if($role === 'admin') : ?>
       
        <a href="#upload" class="btn btn-primary" data-toggle="modal">Upload Scorecard</a>
    <?php endif;?>
    
    
    <?php if($role == 'admin') : ?>
        <form action="<?= base_url($role);?>/emailsync/SyncEmails"  method="post" enctype="multipart/form-data">
            <button class="btn btn-primary">Email Sync</button>
        </form>
    <?php endif;?>


</div>

<?= card('start');?>
<div id="scoreGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>

<?php if($role == 'admin') : ?>
<?=modal(['upload']);?>
<form action="<?= base_url($role);?>/emailsync/upload" id="uploadCSV" method="post" enctype="multipart/form-data">
    <?= form_file(['file','Upload Scorecard','.csv']);?>
    <button class="btn btn-primary">Upload</button>
</form>
<?=modal();?>
<?php endif;?>


<?= modal(['scorecard','lg']);?>
    <div id="stage"></div>
<?= modal();?>

<script defer src="<?=base_url(UI['main']);?>/ag-grid/emailsync.js"></script>
<script defer src="<?=base_url(UI['theme']);?>/emailsync.js"></script>