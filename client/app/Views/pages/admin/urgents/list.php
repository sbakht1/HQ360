<div id="UrgGrid" class="ag-theme-alpine my-grid"></div>
<script defer src="<?= base_url(UI['main']);?>/ag-grid/urgent.js"></script>
<?= modal(['employee_ack','lg']); ?>
<h4 class="mb-3" id="msg_title"></h4>
<table class="table" id="emp"></table>
<?= modal();?>