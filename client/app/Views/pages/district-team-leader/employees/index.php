<style>
    .img-sm {width:30px;height:30px;}
</style>
<?= card('start');?>
<div id="EmpGrid" class="my-grid ag-theme-alpine"></div>
<?= card('end');?>
<script>
    window.employee = {
        url:'/district-team-leader/employees/find',
        single: '/district-team-leader/employees/'
    };
</script>
<script defer src="<?=base_url(UI['main']);?>/ag-grid/employees.js"></script>