<?php $rep_name = $page['title']['Title'];?> 
<?= modal(['upload']);?>
<form action="<?= current_url();?>/upload" method="post" enctype="multipart/form-data">
    <h3>Upload <?= $rep_name; ?> Report</h3>
    <?= form_file(['report',"CSV Upload for $rep_name",'.csv']);?>
    <?= form_input(['date','Report Date', 'date',date('Y-m-d')]);?>
    <button class="upl-btn btn btn-primary">Upload</button>
</form>
<?= modal();?>