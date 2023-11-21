<?php $rep_name = $page['title']['Title'];?> 
<?= modal(['upload']);?>
<form action="<?= current_url();?>/upload" method="post" enctype="multipart/form-data">
    <h3>Upload <?= $rep_name; ?> Report</h3>
    <?= form_file(['hyla',"CSV Upload for HYLA Compliance",'.csv']);?>
    <?= form_file(['discrepancy',"CSV Upload for Discrepancy Report",'.csv']);?>
    <?= form_file(['trade-in',"CSV Upload for Trade-in Summary Dashboard",'.csv']);?>
    <?= form_input(['date','Report Date', 'date',date('Y-m-d')]);?>
    <button class="upl-btn btn btn-primary">Upload</button>
</form>
<?= modal();?>