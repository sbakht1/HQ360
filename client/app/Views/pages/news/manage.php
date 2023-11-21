<link rel="stylesheet" href="<?= base_url(UI['main']); ?>/vendors/summernote/dist/summernote-bs4.css"/>
<style>
    .news-media {height: 250px;background-size: contain;background-repeat: no-repeat;width:300px;margin:0 30px;}
    .news-date {text-transform:uppercase;text-align:center;line-height:24px;font-weight:500;}
    .news-date .date {font-weight:900;font-size:30px;}

    .news-content .meta {margin-bottom:10px;color:#ed772d;font-weight: 600;}
    .meta .sep {color: #999;}
    .news-content .content {margin-bottom:10px}
</style>
<div class="news-content">
    <div class="row">
        <div class="col-md-8">
            <?= card('start');?>
            <h2><?= $news['title'];?></h2>
            <p class="my-3"><i class="fa-solid fa-user text-danger"></i> <?=$news['author']['Employee_Name'];?> | <i class="fa-solid fa-calendar-days text-danger"></i> <span class="moment" data-time="<?=$news['created'];?>" data-form="ll"></span></p>
            <div class="content">
                <?= $news['content'];?>
            </div>

            <?= card('end');?>
        </div>
        <div class="col-md-4">
            <?php if ($news['media'] != ""):?>
            <?= card('start');?>
            <div style="max-width:800px">
                <img class="img-fluid" src="<?= base_url(UI['upload'].'/'.$news['media']); ?>">
            </div>
            <?= card('end');?>
            <?php endif; ?>
        </div>
    </div>
</div>

