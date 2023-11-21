<?php 
    $rep_name = $page['title']['Title'];
    $act_url = str_replace('view','upload',current_url());
?>
<?= modal(['upload']);?>
<form action="<?= $act_url; ?>" method="post" enctype="multipart/form-data">
    <h3>Upload <?= $rep_name; ?> Report</h3>
    <?= form_file(['upload',"CSV Upload for $rep_name",'.csv']);?>
    <?= form_input(['date','Report Date', 'date',date('Y-m-d')]);?>
    <button class="upl-btn btn btn-primary">Upload</button>
</form>
<?= modal();?>