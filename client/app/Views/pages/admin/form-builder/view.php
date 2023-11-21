<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.css">
<link rel="stylesheet" href="<?= base_url(UI['vendors'])?>/lightgallery/css/lightgallery.css" />
<script defer="defer" src="<?= base_url(UI['vendors'])?>/lightgallery/js/lightgallery-all.min.js"></script>
<script defer src="<?= base_url(UI['main']);?>/js/light-gallery.js"></script>
<script defer src="<?= base_url(UI['vendors']);?>/jquery-ui/jquery-ui.min.js"></script>
<script defer type="text/javascript" src="<?= base_url(UI['vendors']);?>/jquery-signature/jquery-signature.min.js"></script>
<style>
    .light-item img {max-width:200px}
    .pad {height: 300px;width: 300px;display: block;}
    .sign {display: none;}
    .field {margin-bottom: 20px;border-bottom: 1px solid #ddd;padding-bottom: 20px;}
    .que {color:#e3a856;font-weight: bold;margin-bottom: 10px;}
</style>
<div class="row">

    <div class="col-md-6">
        <?= card('start');?>
            <?php foreach($collection['data'] as $i => $c) : ?>
                <?php if (!is_date($c[1]) && !str_contains($c[1],'public_uploads/')): ?>
                    <div class="field" id="<?= $i; ?>">
                        <div class="que"><?= $c[0];?></div>
                        <?php if ( strpos($i, '_exp') !== false): ?>
                            <span class="sign"><?= $c[1];?></span>
                            <div class="pad"></div>
                        <?php else : ?>
                            <div class="ans">
                                <?php
                                    if (strpos($c[0],'/stores') !== false) {
                                        $c[1] = _find(['stores','StoreID',$c[1],'StoreName']);
                                    }
                                    if (strpos($c[0],'/employees') !== false) {
                                        $c[1] = _find(['employees','EmployeeID',$c[1],'Employee_Name']);
                                    }
                                ?>
                                <?= $c[1];?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?= card('end');?>
    </div>
            <div class="col-md-6 d-none" id="lightgallery">
                <?= card('start');?>
                <?php foreach($collection['data'] as $c) : ?>
                    <?php if (is_date($c[1]) || str_contains($c[1],'public_uploads/')): ?>
                        <div class="field">
                            <div class="que"><?= $c[0];?></div>
                            <?php 
                            if ( is_date($c[1])) {
                                echo "<div class='ans'><span class='moment' data-time='$c[1]' data-form='ll'></span></div>";
                            } else {
                                $url = base_url(UI['upload'].'/'.$c[1]);
                                echo "<p><a class='light-item' data-src='$url' href='$url'><img src='$url' /></a></p>";
                            }
                            ?>
                        </div>
                    <?php endif; ?>

<?php endforeach;?>
<?= card('end');?>

</div>

</div>

<script defer src="<?= base_url(UI['theme']);?>/sign.js"></script>
<script>
    window.addEventListener 
      ? window.addEventListener('load',script,false)
      : window.attachEvent && window.attachEvent("onload",script);
    function script() {
        ($.trim($('#lightgallery .card-body').html()) == "") 
            ? $('#lightgallery').remove()
            : $('#lightgallery').removeClass('d-none');
    }
</script>