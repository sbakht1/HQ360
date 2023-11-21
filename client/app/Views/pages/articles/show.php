<style>
    .article-body img {max-width:100%;}
</style>
<div class="row">
    <div class="col-md-8">
        <?= card('start');?>
            <h2 class="article-title"><?= $article['title'];?></h2>
            <hr>
            <div class="article-body">
                <?= $article['content'];?>
            </div>
        <?= card('end');?>
    </div>
</div>