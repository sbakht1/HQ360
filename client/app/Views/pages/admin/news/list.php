<style>
    .news-media {height: 250px;background-size: 100%;background-repeat: no-repeat;width:300px;margin:0 30px;    background-color: #eee;
    background-position: center;}
    .news-date {text-transform:uppercase;text-align:center;line-height:24px;font-weight:500;}
    .news-date .date {font-weight:900;font-size:30px;}

    .news-content .meta {margin-bottom:10px;color:#ed772d}
    .news-content .content {margin-bottom:10px}
    .news-card {margin-bottom: 20px;}
    .news-card h2 {font-size:20px;line-height:30px;min-height:50px;display:flex;align-items:center;}
</style>
<script>
    window.news = <?= json_encode($news['data']); ?>;
</script>
<div class="row">
    <?php foreach($news['data'] as $i=>$x):  if ($x['media'] == "") $x['media'] = "news/0.png";?>
    
<div class="news-card col-md-6">
    <?= card('start'); ?>
    <div class="d-flex list-item">
        <div class="news-date">
            <span class="moment month" data-form="MMM" data-time="<?= $x['created'];?>"></span><br>
            <span class="moment date" data-form="DD" data-time="<?= $x['created'];?>"></span><br>
            <span class="moment year" data-form="YYYY" data-time="<?= $x['created'];?>"></span>
        </div>
        <div>
            <div class="news-media" style="background-image:url(<?= base_url(UI['upload']).'/'.$x['media'];?>"></div>
        </div>
        <div>
            <div class="news-content">
                <h2><?= $x['title'];?></h2>
                <div class="meta">
                    <span>Posted by: <?= $x['Employee_Name'];?></span>
                </div>
                <div class="content">
                    <?= excerpt($x['content'],25);?>
                </div>
                <a href="<?= current_url()."/".$x['id'];?>" class="btn btn-primary">Learn more</a>
                <a href="#news_modal" data-toggle="modal" data-i="<?=$i;?>" class="btn btn-outline-primary">Edit</a>
            </div>
        </div>
    </div>
    <?= card('end'); ?>
</div>
<?php endforeach; ?>
</div>
<?= $news['links']; ?>
