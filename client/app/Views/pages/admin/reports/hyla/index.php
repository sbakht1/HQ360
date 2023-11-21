<?php 
    include dirname(__FILE__).'/../report-header.php';
    include 'list.php';
    include 'popup.php';
?>
<script defer src="<?= base_url(UI['main']);?>/ag-grid/reports/<?=$slug;?>.js"></script>