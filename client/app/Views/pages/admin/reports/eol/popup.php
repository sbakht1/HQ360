<?php
    $upload_link = current_url()."/upload";

?>
<?= modal(['upload']);?>
<form action="<?= $upload_link;?>" method="post" enctype="multipart/form-data">
    <h3>Upload EOL Report</h3>
    <div class="text-right mb-2">
        <a href="<?= $upload_link."?export=format";?>">Upload Format</a>
    </div>
    <?= form_file(['report','Upload EOL CSV','.csv']);?>
    <?= form_input(['date','Report Date', 'date',date('Y-m-d')]);?>
    <button class="upl-btn btn btn-primary">Upload</button>
</form>
<?= modal();?>