<?php 
    $cat = array_unique(array_column($articles,'category'));
    $data=[];
    foreach($cat as $c) {
        $items = [
            'title' => $c,
            'data' => []
        ];
        foreach($articles as $a) if ($a->category === $c) $items['data'][] = $a;
        $data[] = $items;
    }
?>
<style>
.card .icon {color:var(--warning);border-radius:50px;font-size:24px;margin-right:15px}
.card h6 {margin:0;font-weight:600;font-size:16px;color:#333;}
.card p {color:#888}
.card h4 {display: flex;justify-content:space-between;align-items:center;}
</style>

<div class="card-columns">
    <?php foreach($data as $item): ?>
        <div class="card">
            <div class="card-body">
                <h4><?= $item['title'];?> <span class="badge badge-danger badge-pill"><?= sizeof($item['data']);?> Articles</span></h4>
                <hr />
                <?php foreach($item['data'] as $i): ?>
                    <a class="d-flex align-items-center" href="<?= current_url()."/$i->id";?>">
                        <div><div class="icon"><i class="fas fa-book mx-0"></i></div></div>
                        <div><h6><?=$i->title;?></h6></div>
                    </a>
                    <div class="dropdown-divider"></div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endforeach; ?>
</div>