<div class="card-columns">
    <?php foreach($reports as $item): ?>
    <div class="card p-3">
        <h4 class="my-3"><?= $item->title;?></h4>
        <table class="table">
            <tr><th>Report Title</th><th>Last Uploaded</th></tr>
                <?php foreach($item->reports as $li):?>
                <?php 
                    $repDate = "";
                    $link =  "";
                    if (isset($li->table)) {
                        $repDate = isset(last_report($li->table)->date) ? last_report($li->table)->date: '';
                        $link = "?date=$repDate";
                    }
                    ?>
                <tr>
                    <td><a class="text-dark" href="<?= base_url("/".user_data('Title')[1]."/reports/$li->link$link");?>"><?=$li->title;?></a></td>
                    <td><a href="<?= base_url("/".user_data('Title')[1]."/reports/$li->link$link");?>"><?= (isset($li->table)) ? "<span class='text-danger moment' data-form='ll' data-time='".$repDate."'></span>" : ""; ?></a></td>
                </tr>
                <?php endforeach;?>
        </table>
    </div>
    <?php endforeach; ?>
</div>