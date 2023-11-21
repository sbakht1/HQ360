<?php
$current = [];
$index = 0;
foreach ( $hubs as $i=>$x ) {
    $x['content'] = $hubs[$i]['content'] = json_decode($x['content']);
    if ($x['id'] == @$_GET['category']) {
        $current = $x;
        $index = $i;
    }
    if ($x['content'][0] == 'Quick Links') unset($hubs[$i]);
}
?>

<style>
    .hide {display: none;}
    .actions {margin-top:-20px;}
    #item .icon {max-width:100px;}
    #item .icon img {max-width:100%;}
    .cat {margin-top:-56px;}
    .btn-del {position: absolute;right: 20px;top: -20px;}
</style>
<div class="actions">
    <?php if ($current['content'][0] != 'Quick Links'): ?>
    <form action="<?= base_url(user_data("Title")[1].'/hubs');?>" method="get">
        <select class="select2" name="category">
            <?php foreach($hubs as $x) :?>
                <option <?= ($_GET['category'] == $x['id']) ? 'selected':'';?> value="<?= $x['id'];?>"><?= $x['content'][0];?></option>
            <?php endforeach;?>
        </select>
    </form>
        <?php if ( @$_GET['category']):?>
            <a href="#panel" data-toggle="modal" class="panel-modal btn btn-primary">Create Panel</a>
            <a href="#hub" data-toggle="modal" class="btn btn-primary">Create Hub</a>
            <a href="#del_" data-type="hub" data-id="<?=$current['id'];?>" data-toggle="modal" class="btn btn-danger">Delete Hub</a>
        <?php endif; ?>
    <?php else: ?>
        <?php if ( @$_GET['category']):?>
            <a href="#panel" data-toggle="modal" class="panel-modal btn btn-primary">Create Panel</a>   
        <?php endif; ?>
    <?php endif ;?>
</div>

<h3 class="cat" id="cat_<?=$current['id']?>"><?= @$current['content'][0];?></h3>
        <p><?= @$current['content'][1];?></p>

        <div class="row">
            <?php if (@$panel):?>
            <?php foreach($panel as $p): $p['content'] = json_decode($p['content']); ?>
                <div class="col-md-4 my-3">
                    <span class="hide" id="panel_<?= $p['id'];?>"><?= json_encode($p);?></span>
                    <?= card('start');?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon mr-2">
                                <button href="#panel" data-panel="#panel_<?= $p['id']; ?>" data-toggle="modal" type="button" class="panel-modal btn btn-primary btn-rounded btn-icon">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button href="#del_" data-id="<?= $p['id']; ?>" data-type="panel" data-toggle="modal" type="button" class="panel-modal btn-del btn btn-danger btn-rounded btn-icon">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            <div class="content">
                                <strong><?= $p['content'][0];?></strong>
                            </div>
                        </div>
                        <hr>
                        <?= ($p['content'][1] !== '') ? '<p><small>'.$p['content'][1].'</small></p>':''; ?>

                        <ul class="link-items">
                            <?php foreach($p['items'] as $x) : $item = json_decode($x['content']);?>
                                <li>
                                    <a href="<?= $item[1];?>" target="_blank">
                                        <?php if (@$item[2]) :?>
                                            <span style="background-image:url(<?= base_url(UI['upload'].'/'.$item[2]);?>)" class="img-sm d-inline-block bg-contain rounded-circle icon"></span>
                                        <?php endif;?>
                                        <span class="title"><?= $item[0]?></span>
                                    </a>
                                    <div class="item-actions">
                                        <a href="#item" data-toggle="modal" data-panel-id="<?=$x['panel'];?>" data-item-id="<?= $x['id'];?>" class="icon text-warning edit-item"><i class="fa-solid fa-pencil"></i></a>
                                        <a href="#del" data-item-id="<?= $x['id'];?>" data-toggle="modal" class="icon text-danger del-btn"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        
                        <hr>
                        <a href="#item" data-toggle="modal" class="btn btn-link add-item" data-panel-id="<?= $p['id'];?>">Add Item</a>
                    <?= card('end');?>
                </div>
            <?php endforeach;?>
            <?php endif; ?>
        </div>


<?= modal(['hub']);?>
    <form action="<?= base_url("/".user_data('Title')[1]."/hubs/create");?>" method="post" id="create_hub">
        <input type="hidden" value="category" name="type">
        <input type="hidden" value="" name="id">
        <?= form_input(['title','Title','text','']);?>
        <?= form_input(['description','Description','textarea/5','']);?>
        <button class="btn btn-primary">Create</button>
    </form>
<?= modal();?>

<?= modal(['panel']);?>
    <form action="#" method="post" id="create_panel">
        <input type="hidden" value="<?= @$_GET['category'];?>" name="category">
        <input type="hidden" value="panel" name="type">
        <input type="hidden" value="" name="id">
        <?= form_input(['title','Title','text','']);?>
        <?= form_input(['description','Description','textarea/5','']);?>
        <button class="btn btn-primary btn-sub">Create</button>
    </form>
<?= modal();?>

<?= modal(['item']);?>
    <form action="#" method="post" id="create_item" enctype="multipart/form-data">
        <input type="hidden" value="<?= @$_GET['category'];?>" name="category">
        <input type="hidden" value="" name="panel">
        <input type="hidden" value="item" name="type">
        <input type="hidden" value="" name="id">
        <?= form_input(['title','Title','text','']);?>
        <?= form_input(['link','Link','text','']);?>
        <?= form_file(['icon','Icon','image/*']);?>
        <button class="btn btn-primary btn-sub">Add Item</button>
    </form>
<?= modal();?>

<?= modal(['del']);?>
<form action="#" class="text-center" id="del_form">
    <div class="swal-icon swal-icon--warning">
        <span class="swal-icon--warning__body">
        <span class="swal-icon--warning__dot"></span></span>
    </div>
    <div class="swal-title" style="">Are you sure?</div>
    <div class="swal-text" style="">You won't be able to revert this!</div>
    <input type="hidden" name="id">
    <input type="hidden" name="type" value="delete">
    <hr>
    <div class="text-right">
        <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary">Delete</button>
    </div>
</form>
<?= modal();?>


<?= modal(['del_']);?>
<form action="<?= base_url();?>/admin/hubs/delete" class="text-center" id="del__form">
    <div class="swal-icon swal-icon--warning">
        <span class="swal-icon--warning__body">
        <span class="swal-icon--warning__dot"></span></span>
    </div>
    <div class="swal-title" style="">Are you sure?</div>
    <div class="swal-text" style="">You won't be able to revert this!</div>
    <input type="hidden" name="id">
    <input type="hidden" name="type" value="">
    <hr>
    <div class="text-right">
        <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary">Delete</button>
    </div>
</form>
<?= modal();?>

<script>
    window.addEventListener ? window.addEventListener("load",script,false) : window.attachEvent && window.attachEvent("onload",script);
function script() {

    $('.actions form select').on('change', function () {
        $('.actions form').submit();
    })

    $('[href="#del_"]').on('click', function() {
        let id = $(this).data('id'),
            type = $(this).data('type');
        $('#del__form [name="id"]').val(id);
        $('#del__form [name="type"]').val(type);
    })

    let form_url = '<?= base_url('/'.user_data('Title')[1].'/hubs/create');?>';
    $('#create_hub,#create_panel,#create_item,#del_form').submit(function (e) {
        e.preventDefault();
        let form = new FormData(this),
            title = $(this).find('#title'),
            form_id = $(this).attr('id');
        if($.trim(title.val()) == "" && form_id !== 'del_form') {
            $('#tit_err').remove();
            title.after('<span id="tit_err" class="text-danger">This field is required.</span>');
        } else {
            process_form(form_url, form);
        }
    })
    $('#del__form').submit(function(e){
        e.preventDefault();
        let form = new FormData(this),
            acti = $(this).attr('action');
        process_form(acti,form);
    })
    
    function process_form(url,data) {
        $.ajax({
            url:url,
            data: data,
            type:'post',
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                if ( res.success && res.type !== "hub" ) {
                    window.location.reload();
                } else {
                    window.open(window.location.href.split('?')[0],'_self');
                }
            },
            fail: function (err) { console.log(err);}
        })
    }

    $('.panel-modal').on('click', function() {
        let panel = {id:'',content:['',''],submit:'Create'},
            panel_id = $(this).data('panel');
        if (typeof panel_id === 'string') {
            panel = JSON.parse($(panel_id).html());
            panel.submit = 'Update';
        }
        $('#create_panel [name="id"]').val(panel.id);
        $('#create_panel [name="title"]').val(panel.content[0]);
        $('#create_panel [name="description"]').val(panel.content[1]);
        $('#create_panel .btn-sub').html(panel.submit);
    });


    $('.add-item,.edit-item').on('click', function() {
        $('#item .icon').remove();
        let pid = $(this).data('panel-id'),
            id = $(this).data('item-id'),
            panel = JSON.parse($(`#panel_${pid}`).html()).items,
            item = {
                content: ['',''],
                id:""
            };
        panel.map(function(x) {
            if (x.id==id) {
                x.content = JSON.parse(x.content);
                item = x;
            }
        });
        if ( item.content.length > 2 ) {
            $('#item [name="link"]').after(`<div class="icon"><span class="close remove" data-id="${id}">&times;</span><img src="${window.app.public}/${item.content[2]}" /></div>`);
            icon_remover();
        }
        $('#item [name="id"]').val(item.id);
        $('#item [name="panel"]').val(pid);
        $('#item [name="title"]').val(item.content[0]);
        $('#item [name="link"]').val(item.content[1]);
    });

    $('.del-btn').on('click', function() {
        let id = $(this).data('item-id');
        $('#del_form [name="id"]').val(id);
    })

    function icon_remover() {
        $('#item .icon .remove').on('click', function () {
            let id = $(this).data('id');
            $.post(window.app.url+'/'+window.app.role+'/hubs/remove_icon', {id:id},function(res) {
                $(`[data-item-id="${id}"]`).parent().parent().find('.icon').remove();
                $('#item .icon').remove();
            })
        })
    }

}
</script>
