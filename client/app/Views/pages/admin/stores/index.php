<?php 
    $role = user_data('Title')[1];
?>
<style>
    .img-sm {width:30px;height:30px;}
</style>
<div class="actions">
    <?php if($role !== 'inventory' && $role !== 'it'):?>
        <a href="<?= current_url();?>/new" class="btn btn-primary">Add New</a>
    <?php endif;?>
    <?php if(@$_GET['status'] == 'false') :?>
            <a href="<?= base_url(user_data('Title')[1].'/stores?status=true');?>" class="btn btn-outline-primary">Enabled Stores</a>
        <?php else: ?>
            <a href="<?= base_url(user_data('Title')[1].'/stores?status=false');?>" class="btn btn-outline-primary">Disabled Stores</a>
    <?php endif; ?>
    <?php if ($role !== 'inventory' && $role !== 'it'): ?>
        <a href="#import" data-toggle="modal" class="btn btn-primary">Import Stores</a>
    <?php endif; ?>
</div>
<?= card('start');?>
<div id="strGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>


<?= modal(['import']);?>
<div class="modal-body">
    <form action="<?= base_url(user_data('Title')[1]);?>/stores/import" method="post" enctype="multipart/form-data">
        <h4 class="mb-3">Upload Stores CSV File</h4>
        <div class="text-right mb-2">
            <a href="<?= base_url($role."/stores?export=format")?>">Import Format</a>
        </div>
        <?= form_file(['store','Stores CSV File','.csv'],true);?>
        <div class="mt-3 float-right">
            <button type="submit" class="btn btn-success btn-imp ml-2">Import</button>
        </div>
    </form>
</div>
<?= modal();?>

<script defer src="<?=base_url(UI['main']);?>/ag-grid/stores.js"></script>

<script>
    window.addEventListener?window.addEventListener('load',script,false):window.attachEvent && window.attachEvent('onload',script);
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
                    console.log(res);
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