<?php 
    $role = user_data('Title')[1];
    $form = ($action == 'new') ? settings('observation_question',true) : json_decode($item_['detail'],true);
?>
<style>
    .score {display:flex;justify-content:center;align-items: center;}
    .title-area {border-right:1px solid #999;padding-right:10px;margin-right:10px}
    .score p {margin: 0;}
</style>
<?php 
    if (@session()->getFlashdata('item_')) { $item_ = session()->getFlashdata('item_');}

?>
<div class="observation">
<?php if ($role !== 'inventory' && $role !== 'it'):?>
<form method="post" enctype="multipart/form-data">
<?php else: ?>
    <div>
<?php endif;?>
<div class="row">
    <div class="col-md-8">
        <?= card('start') ?>
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-field required">
                            <div class="form-group">
                                <label for="store">Store</label>
                                <select class="select2" name="store" id="stores" data-selected="<?= @$item_['store']?>"><option></option></select>
                                <?= isErr('store', 'This');?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-field required">
                            <div class="form-group">
                                <label for="employee">Employee</label>
                                <select class="emps" name="employee" id="employees" data-selected="<?= @$item_['employee']?>"><option></option></select>
                                <?= isErr('employee', 'This');?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-field nice-select required">
                            <?= select2(['interaction_type','Interaction Type',["","Sale","Service","Role Play"],@$item_['interaction_type']]) ?>
                            <?= isErr('interaction_type', 'This');?>
                        </div>
                    </div>
                </div>
        <?= card('end') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3 class="my-4">5 Key Behaviors</h3>
        <?= card('start') ?>
        <div id="behavior"></div>        
        <?= card('end') ?>
    </div>
    <div class="col-md-6">
        <h3 class="my-4">Retail Sales Process</h3>
        <?= card('start') ?>
        <div id="sales"></div>        
        <?= card('end') ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-4 atnt-score-box">
        <?= card('start'); ?>
            <div class="score">
                <div class="title-area">
                    <h4>AT&T Score</h4>
                    <p>Based on above responses</p>
                </div>
                <div class="score-area" id="atntScore">
                    <h4 class="score"></h4>
                    <p class="remarks"></p>
                </div>
            </div>
            <?= card('end'); ?>
        </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3 class="my-4">The TWE Way</h3>
        <?= card('start') ?>
        <div id="twe_way"></div>
        <?= card('end') ?>
    </div>
    <div class="col-md-6">
        <h3 class="my-4">DIRECT Feedback</h3>
        <?= card('start') ?>
        <div class="row inputs">
        <?php foreach($form['inputs'] as $i => $f): ?>
            <?php if(count($f) == 1):?>
                <div class="col-md-12 my-2">
                    <?= $f[0]; ?>
                </div>
            <?php else : ?>
                <div class="col-md-12 my-2">
                    <?= form_input(array_merge(['f-'.$i],$f)); ?>
                </div>
            <?php endif;?>
        <?php endforeach;?>
        </div>
        <?= card('end') ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4 atnt-score-box">
            <?= card('start'); ?>
            <div class="score">
                <div class="title-area">
                    <h4>TWE Score</h4>
                    <p>Based on above responses</p>
                </div>
                <div class="score-area" id="tweScore">
                    <h4 class="text-danger score"></h4>
                    <p class="remarks"></p>
                </div>
            </div>
            <?= card('end'); ?>
        </div>
    </div>
    <textarea name="detail" id="detail" style="display:none"><?= @$item_['detail'];?></textarea>
    <?php if ($role !== 'inventory' && $role !== 'it' && $role !== 'salespeople'):?>
    <div class="mt-4">
        <button class="btn btn-primary btn-lg save-btn">Save</button>
    </div>
    </form>
    <?php else: ?>
        <div>
    <?php endif;?>
    </div>

<script defer src="<?= base_url(UI["js"]);?>/observations.js"></script>
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