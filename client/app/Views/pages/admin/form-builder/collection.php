<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.css">
<link rel="stylesheet" href="<?= base_url(UI['vendors'])?>/lightgallery/css/lightgallery.css" />
<script defer="defer" src="<?= base_url(UI['vendors'])?>/lightgallery/js/lightgallery-all.min.js"></script>
<script defer src="<?= base_url(UI['main']);?>/js/light-gallery.js"></script>
<script defer src="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.js"></script>
<script defer type="text/javascript" src="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.min.js"></script>
<style>
    .pad {height: 300px;width: 400px;display: block;}
    .sign {display: none;}
    #form_data ul {display:flex;flex-wrap: wrap;padding:0;}
    #form_data ul li {width: 33.333%;display: block;}
    .lg-on .modal {z-index:0;}
    .sub_info {position: absolute;right: 30px;top: 40px;}
</style>
<?php 
    // debug($_SERVER);
    $role = user_data('Title')[1];
    $form_id = $form['id'];

    $exp = ($role == 'admin') 
        ? base_url("/$role/form-builder/collect/$form_id")
        : current_url()."/collect/";
    $exp .= "?export=true"
?>
<style>
    .img-sm {width:30px;height:30px;}
</style>

<div class="actions text-right">
    <?php if (@$_GET['tool']): ?>
        <?php if($role !== 'salespeople' ):?>
            <a href="<?= base_url() .'/form/'. form($form['id'])."?src=".base64_encode(current_url()."?tool=true");?>" class="btn btn-primary">Add New</a>
        <?php endif;?>
        <?php if($role !== "admin"): ?>
        <?php endif;?>
        <a href="<?= $exp?>" class="btn btn-success btn-exp">Export</a>
        <?php if($role == 'admin'): ?>
            <a href="<?= base_url()."/$role/form-builder/m/".$form_id ?>" class="btn btn-warning">Edit Form</a>
        <?php endif;?>
    <?php endif;?>
</div>

<?= card('start');?>
<div class="lightgallery">
    <div id="CollectionGrid" data-form-id="<?= $form['id'];?>" class="ag-theme-alpine my-grid"></div>
</div>
<?= card('end');?>

<script defer src="<?= base_url(UI['theme']);?>/sign.js"></script>
<script defer src="<?=base_url(UI['main']);?>/ag-grid/collection.js"></script>
<?= modal(['entry','lg']);?><div id="form_data"></div><?= modal(); ?>

<script>
window.addEventListener ? window.addEventListener("load",script,false) : window.attachEvent && window.attachEvent("onload",script);
function script() {
    setTimeout(entries, 2000);
    function entries() {
        $('.entry').on('click', function() {
            let form_data = $('#form_data');
            form_data.html('<div class="text-center"><i class="fas fa-spin fa-sync"></i> Loading...</div>');
            let url = $(this).attr('href');
            $.get(url,function(res) {

                let subBy = `<div class="sub_info">Submitted by: <strong>${res.form[1]}</strong> on ${window.app.localTime(res.form[2],"lll")}</div>`,
                    view = `<h3>${res.form[0]}</h3>${subBy}<hr><ul>`,
                    p1 = "",p2 = "";
                for(x of res.data) {
                    x[1] = (x[1].includes('public_uploads/')) 
                        ? `<a class='light-item' data-src='${window.app.public+'/'+x[1]}' href='${window.app.public+'/'+x[1]}'><img onerror="this.src='https://placehold.co/600x600?text=Not+Found'" src="${window.app.public+'/'+x[1]}" class="img-fluid"></a>`
                        : x[1];
                    if(!x[1].includes('data:image/') && !x[1].includes('"lines":') && !x[1].includes("public_uploads/")) {
                        p1 += `<li><strong>${x[0]}</strong><p>${x[1]}</p></li>`;
                    } else {
                        p2 += `<div class="col-md-4">
                            <strong>${x[0]}</strong>
                            ${(x[1].includes('"lines":') || x[1].includes('data:image/')) ? `<span class="sign">${x[[1]]}</span><div class="pad"></div>`: x[1]}
                        </div>`;
                    }
                }
                view += p1;
                view += '</ul><div class="row lightgallery">';
                form_data.html(view+p2+"</div>");
                window.draw_sign();
                window.lightGallery();
            })
        })
    }
}    
</script>