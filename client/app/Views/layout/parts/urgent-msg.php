<style>
    .btn .count {font-size:12px;background-color:var(--primary-color);color:#fff;display: inline-block;min-width:20px;line-height:20px;border-radius:20px;position: absolute;top:-10px;}
</style>
<?php 
    $msg = urgent_messages();
    $count = 0;
    foreach ($msg as $m) {
        if (!meta_data('urgent',$m['id'])) $count++;
        // debug([$m,meta_data('urgent',$m['id'])]);
    }
?>
<li class="nav-item dropdown">
    <a class="btn btn-danger" id="urgentMsg" href="#URGENT" data-toggle="modal">
        <i class="fas fa-circle-exclamation mx-0"></i> 
        Urgent Message
        <?php if($count != 0) :?>
            <span class="count"><?= $count;?></span>
        <?php endif;?>
    </a>
</li>