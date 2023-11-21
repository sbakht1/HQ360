<?php 
    $role = user_data('Title')[1];
    $form = settings('connection-form');
    ?>
<?php
    $ses = session();
    if(@$ses->getFlashdata('item_')) $item_ = $ses->getFlashdata('item_');    
    ?>
<style>
    .eq-cards .card {min-height:260px;}
</style>
<?php if ($role !== 'inventory' && $role !== 'it'): ?>
<form method="post">
<?php endif;?>
<span class="d-none" id="info"><?=@$item_['info'];?></span>
<div class="row">
    <div class="col-md-12">
        <?= card('start'); ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-field required">
                        <div class="form-group">
                            <label for="store">Store<span class="text-danger">*</span></label>
                            <select class="select2" name="store" id="stores" data-selected="<?= @$item_['store']?>"><option></option></select>
                            <?= isErr('store', 'This');?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-field required">
                        <div class="form-group">
                            <label for="store">Employee<span class="text-danger">*</span></label>
                            <select class="emps" name="employee" id="employees" data-selected="<?= @$item_['employee']?>"><option></option></select>
                            <?= isErr('employee', 'This');?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-field">
                        <?= form_input(['month','Month <span class="text-danger">*</span>','month',@$item_['month']]);?>
                        <?= isErr('month', 'This');?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-field">
                        <?= form_input(['date','Date <span class="text-danger">*</span>','date',@$item_['date']]);?>
                        <?= isErr('date', 'This');?>
                    </div>
                </div>
            </div>        
        <?= card('end'); ?>
    </div>

    <?php foreach($form as $i => $f): ?>
        <?php if(count($f) == 1):?>
            <div class="col-md-12 my-2">
                <?= $f[0]; ?>
            </div>
        <?php else : ?>
            <div class="col-md-4 my-2">
                <input type="hidden" name="f<?= $i?>[]" value="<?=$f[0];?>">
                <?php 
                    echo card('start');
                    echo form_input(array_merge(['f'.$i.'[]'],$f));
                    echo card('end');
                ?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<?php if ($role !== 'inventory' && $role !== 'it' && $role !== 'salespeople'): ?>
<div class="mt-4">
    <button class="btn btn-primary btn-lg save-btn">Save</button>
</div>
</form>
<?php endif;?>
<script defer src="<?= base_url(UI["js"]);?>/connections.js"></script>
<script>

window.addEventListener 
    ? window.addEventListener('load',script,false)
    : window.attachEvent && window.attachEvent("onload",script);
function script() {
    $('.save-btn').on('click',function() {
        let t = $(this),
            cls = t.attr('class').split('primary').join('light'),
            txt = t.text();
        t.hide().after(`<span class="${cls}">${txt}</span><div class="mt-4"><i class="fas fa-sync fa-spin"></i> Please wait...</div>`);
    })
<?php if ($role == 'inventory' || $role == 'it' || $role == 'salespeople'): ?>
    $('input,textarea').attr('disabled','disabled');
    $('[data-name="strength"]').remove();
    $('[data-name="opportunity"]').remove();
    let x = setInterval(function(){
        if ($('.select2-hidden-accessible').length > 0) {
            $('.select2-hidden-accessible').select2("enable", false);
            clearInterval(x);
        }
    }, 1000);
<?php endif;?>
}
</script>