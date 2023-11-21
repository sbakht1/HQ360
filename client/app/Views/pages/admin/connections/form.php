<div class="actions text-right">
    <a href="#fields" class="btn btn-primary add">Add Field</a>
</div>
<?php 
    $connection_form = settings('connection-form');
?>
<style>
    .edit {transition:.5s ease 0;width:100%;cursor:pointer;}
    .edit:hover {background:#0001;}
    .edit .btn {position:absolute;right:15px;opacity:0;top:10px;}
    .edit:hover .btn {opacity:1;}
    .btn-warning {right:70px !important;}
</style>
<?= card('start');?>
<div class="row">
    <?php foreach($connection_form as $ind => $f): $info = base64_encode(json_encode([$ind,$f])); ?>
    <?php 
        $act = "<span class='btn-sm btn btn-warning'><i class='fas fa-pencil edit-elm' data-info='$info'></i></span><span class='btn-sm btn btn-danger'><i class='fas fa-trash-alt del-elm' data-del='$ind'></i></span>";
    ?>
    <?php if(count($f) == 1): ?>
        <div class="col-md-12 py-3 edit">
                <?=$act?>
                <?= $f[0];?>
            </div>
        <?php else: ?>
            <div class="col-md-4 py-3 edit">
            <?=$act?>
            <?= form_input(array_merge(["f-$ind"],$f));?>
        </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<?= card('end'); ?>

<?= modal(['fields']);?>
<form method="post">
    <input type="hidden" name="i" value="">
    <div class="mb-3">
        <select name="type" id="input_type" class="select2">
            <option value="text">Single Line Input</option>
            <option value="textarea/3">Paragraph input</option>
            <option value="date">Date input</option>
            <option value="message">Text without input</option>
        </select>
    </div>
    <?= form_input(['title','Label/Description','textarea/3',""]); ?>
    <button class="btn btn-primary">Save</button>
</form>
<?= modal('end');?>

<script>
    window.addEventListener 
        ? window.addEventListener('load',script)
        : window.attachEvent && window.attachEvent('onload',script);
    function script() {
    
        $('.del-elm').on('click', function() {
            let del = $(this).data('del');
            // console.log(del,$(this).attr('data-del'));
            // return false;
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                confirmButtonText: 'Great ',
                buttons: {
                    cancel: {text: "Cancel",value: false,visible: true,className: "btn btn-danger",closeModal: true},
                    confirm: { text: "OK",value: true,visible: true,className: "btn btn-primary",closeModal: true}
                }
            }).then(function(confirm) {
                if(confirm) window.location.href = window.location.href+"?del="+del;
            })
        })


        let modal = '#fields';
        $('.edit-elm,.add').on('click',function(e) {
            e.preventDefault();
            let add=$(this).hasClass('add'),
                i = $('[name="i"]');
                console.log(add);
            if(add) {
                i.val("");
                $(`#input_type`).val("text").trigger('change');
            } else {
                let info = JSON.parse(atob($(this).data('info'))),
                    label = info[1];
                    console.log(label);
                i.val(info[0]);
                $('[name="title"]').val(label[0]);
                if(info[1].length == 1) {
                    $(`#input_type`).val("message").trigger('change');
                } else {
                    $(`#input_type`).val(label[1]).trigger('change');
                }
            }
            $(modal).modal('show');
        })
    }
</script>