<style>
    .news-bg {height:300px;background-size:100% auto;background-position:center;background-repeat:no-repeat;background-color:#eee;}
    .news h3 {font-size: 20px;min-height: 50px;display: flex;align-items: center;}
    .news .card-text {min-height:110px;line-height:26px;color:#555}
</style>
<section class="mt-4">
<h2>News</h2>
<hr>
<?php 
    $db = db_connect();
    $news = $db->table('news as n');
    $news->select('n.*,e.Employee_Name');
    $news->join('employees as e','n.author = e.EmployeeID');
    $data = $news->orderBy('n.id','DESC')->get(4)->getResultArray();
?>
<div class="row news">
    <?php foreach($data as $n) : ?>
        <div class="col">
        <div class="card">
            <div class="news-bg" style="background-image:url(<?= base_url(UI['upload']).'/'.$n['media'];?>);"></div>
            <div class="card-body">
                <h3><?= $n['title'];?></h3>
                <p class="my-3"><i class="fa-solid fa-user text-danger"></i> <?=$n['Employee_Name'];?> | <i class="fa-solid fa-calendar-days text-danger"></i> <span class="moment" data-time="<?=$n['created'];?>" data-form="ll"></span></p>
                <p class="card-text"><?= excerpt($n['content'],25);?></p>
                <a href="<?= base_url('/news/'.$n['id']);?>" class="btn btn-primary">Learn More</a>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
</div>
</section>