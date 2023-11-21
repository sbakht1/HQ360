<?php 
    $rep_name = $page['title']['Title'];
    $act_url = current_url().'/upload';
?>
<?= modal(['upload']);?>
<form action="<?= $act_url; ?>" method="post" enctype="multipart/form-data">
    <h3>Upload <?= $rep_name; ?> Report</h3>
    <div class="text-right mb-2">
        <a href="<?= $act_url."?export=opusx";?>">Upload Format</a>
    </div>
    <?= form_file(['opusx',"CSV Upload for Opusx Data",'.csv']);?>
    <div class="text-right mb-2">
        <a href="<?= $act_url."?export=cognito";?>">Upload Format</a>
    </div>
    <?= form_file(['cognito',"CSV Upload for Cognito Forms",'.csv']);?>
    <?= form_input(['date','Date of Deposit', 'date',date('Y-m-d')]);?>
    <button class="upl-btn btn btn-primary">Upload</button>
</form>
<?= modal();?>