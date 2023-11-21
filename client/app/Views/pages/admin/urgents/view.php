<?php 
$start = (@$message['start']) ? date('Y-m-d',$message['start']):"";
$end = (@$message['end']) ? date('Y-m-d',$message['end']):"";
?>
<link rel="stylesheet" href="<?= base_url(UI['main']); ?>/vendors/summernote/dist/summernote-bs4.css"/>
<style>
    .status {flex:1}
</style>
<form method="post" id="urg_form" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-7">
        <?=card('start');?>        
                <input id="id" type="hidden" name="id" value="<?= $id; ?>">
                <?= form_input(['title','Title *','text',@$message['title']]); ?>
                <textarea name="message" class="summernote"><?= @$message['message'];?></textarea>
                <div class="d-flex align-items-center">
                    
                    <div class="status ml-3">
                        </div>
                        <div class="status ml-3">
                        
                    </div>
                </div>
                <?=card('end');?>        
            </div>
            <div class="col-md-5">
                <?= card('start'); ?>
                <div class="d-flex align-items-center">
                    <div class="status">
                        <?= select2(['limit','Time Limit',['No Time Limit','Limited'],@$message['limit']]);?>
                    </div>
                    <div class="status ml-2">
                        <?= select2(['status','Status',['Publish','Draft'],@$message['status']]);?>
                    </div>
                </div>
                <div class="limits d-none">
                    <div class="d-flex align-items-center">
                        <div class="status"><?= form_input(['start','Start','date',$start]);?></div>
                        <div class="status ml-2"><?= form_input(['end','End','date',$end]);?></div>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary">SUBMIT</button>
                <?= card('end'); ?>
            </div>
        </form>
</div>
<script>
    window.addEventListener
        ? window.addEventListener('load',script,false)
        : window.attachEvent && window.attachEvent('onload',script);
    function script() {
        let limited = $('#limit').val(),
            rules = {
                title: { required: true, minlength: 5},
                message: { required: true, minlength: 20},
                start: {required:true},
                end: {required:true}
            };
        limit(limited);
        $('#limit').on('change', function() { limit($(this).val()) });
        function limit(val) {
            limited = val;
            if ( val == 'Limited' ) {
                $('.limits').removeClass('d-none');
            } else {
                $('.limits').addClass('d-none');
            }
        }
        $('#urg_form').validate({rules: rules})
    }
</script>