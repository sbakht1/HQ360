<?php 
    $role = user_data('Title')[1];
?>

<style>
    .img-sm {width:30px;height:30px;}
</style>
<div class="actions text-right">
    <?php if ($role !== 'inventory' && $role !== 'it'): ?>
        <a href="<?= current_url();?>/new" class="btn btn-primary">Add New</a>
    <?php endif;?>
    <?php if (@$_GET['status'] == TRUE): ?>
        <a href="<?= current_url();?>" class="btn btn-outline-primary">Enabled Employees</a>
    <?php else : ?>
        <a href="<?= current_url().'?status=true';?>" class="btn btn-outline-primary">Disabled Employees</a>
    <?php endif; ?>
    <?php if ($role !== 'inventory' && $role !== 'it'): ?>
        <a href="#import" data-toggle="modal" class="btn btn-primary">Import Employees</a>
    <?php endif;?>
</div>

<?= card('start');?>
<div id="EmpGrid" class="my-grid ag-theme-alpine"></div>
<?= card('end');?>


<div class="modal fade" id="import">
    <div class="modal-dialog modal-sm">
        <form class="modal-content" method="post" action="<?= base_url($role.'/employees/import');?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">Upload Employees CSV File</h5>
            </div>
            <div class="modal-body">
                <div class="text-right mb-2">
                    <a href="<?= base_url($role."/employees?export=format")?>">Import Format</a>
                </div>
                <?= form_file(['emp','Employee CSV File','.csv'],true);?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-imp">Import</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.employee = {
        url:'/<?= $role;?>/api/employees/aggrid',
        single:'/<?= $role;?>/employees/'
    }
    window.addEventListener
        ?window.addEventListener('load',script,false)
        :window.attachEvent && window.attachEvent('onload',script);
    function script() {
        $('#import form').submit(function(e) {
            e.preventDefault();
            $('#import .loader').remove();
            $(this).find('.btn-imp').attr('disabled','disabled');
            $(this).find('.btn-imp').before(`<span class="loader"><i class="fas fa-spin fa-sync"></i> Please wait...</span>`);
            let form = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if(!res.success) {
                        $('#import .loader').html(`<span class="text-danger">${res.message}</span>`);
                        $('#import .btn-imp').removeAttr('disabled');
                    } else {
                        $('#import .loader').html(`<span class="text-success">${res.message}</span><br>please wait...`);
                        setTimeout(function() {
                            window.location.reload();
                        },3000);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    }
</script>
<script defer src="<?=base_url(UI['main']);?>/ag-grid/employees.js"></script>