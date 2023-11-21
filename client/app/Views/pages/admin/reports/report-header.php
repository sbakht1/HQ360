<?php $role = user_data('Title')[1];?>
<style>
    .actions label {display:none;}
    .actions .form-group {margin-bottom: 0;}
</style>
<div class="actions">
    <form>
        <?php if (strpos(current_url(),'reports/doors/') !== false):?>
            <?= form_input(['date','Month','month', (@$_GET['date'])?$_GET['date']:date('Y-m')]);?>
        <?php else:?>
            <?= form_input(['date','Report Date','date', @$_GET['date']]);?>
        <?php endif; ?>
    </form>
    <?php if ($role == 'admin'): ?>
        <a href="#upload" data-toggle="modal" class="btn btn-primary">Upload Report</a>
    <?php endif;?>
</div>

<script>
    window.addEventListener ? 
    window.addEventListener("load",script,false) : 
    window.attachEvent && window.attachEvent("onload",script);

    function script() {
        $('.upl-btn').on('click', function() {
            $(this).attr('disabled','disabled');
            $(this).after('<span class="ml-3 d-inline-block"><i class="fa-solid fa-arrow-rotate-right fa-spin"></i> uploading...</span>');
            $('#upload form').submit();
        });
        $('.actions #date').on('change', function() {
            $('.actions form').submit();
        })
        <?php if(@$_GET['upload']): ?>
        $('#upload').modal('show');
        <?php endif;?>
    }
</script>