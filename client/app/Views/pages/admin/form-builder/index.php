<style>
    .img-sm {width:30px;height:30px;}
</style>
<div class="actions text-right">
    <a href="<?= current_url();?>/m/new" class="btn btn-primary">Add New</a>
</div>

<?= card('start');?>
<div id="FormGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>



<script defer src="<?=base_url(UI['main']);?>/ag-grid/forms.js"></script>