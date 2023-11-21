<?php
$arc_url = str_replace('/department','',current_url())."/view/";
$role = user_data('Title')[1];
?>
<div class="card">
    <div class="card-body">
        <h4 class="my-3"><?= $report->title;?></h4>
        <table class="table">
            <tr><th>Report Title</th><th>Last Uploaded</th><th></th></tr>
                <?php foreach($report->reports as $li):?>
                <?php 
                    $repDate = "";
                    $link =  "";
                    $arc = false;
                    $table = (@$li->table) ? $li->table:"";
                    if (isset($li->table)) {
                        if ( gettype($li->table) == 'array' && $li->table[0] == 'doors' ) {
                            $arc = true;
                            $table = $li->table;
                        }
                        $last_report = isset(last_report($table)->date) ? last_report($table): '';
                        $link = (strpos($li->link,'?') !== false) ? "&" : "?";
                        $link .= "date=".@$last_report->date;
                    }
                    ?>
                <tr>
                    <td><a class="text-dark" href="<?= ($report->title != "Doors Report") ? base_url("/".$role."/reports/$li->link$link"):"#";?>"><?=$li->title;?></a></td>
                    <td>
                        <a href="<?=  ($report->title != "Doors Report") ? base_url("/".$role."/reports/$li->link$link"):"#";?>"><?= (isset($li->table)) ? "<span class='text-danger moment upload-next' data-form='ll' data-time='".@$last_report->date."'></span>" : ""; ?></a>
                    </td>
                    <td>
                        <?php if ($arc): ?>
                            <?php 
                                $filename = $li->title.'-'.@$last_report->date;
                                $dl = base_url('uploads/'.@$last_report->file);
                                $extra_dl =  "download='$filename'";
                                if($role === BASE['dtl'] || $role === BASE['stl']) {
                                    $dl = base_url('/'.$role.'/reports/').str_replace('view','dl',$li->link);
                                    $dl .= "?date=".@$last_report->date."&filename=".$filename;
                                    $extra_dl =  "";
                                }
                            ?>
                            <a href="<?= $dl; ?>" <?= $extra_dl;?> class="btn btn-primary dl">Download Last Updated</a>
                            <a href="<?= $arc_url.$li->table[2]; ?>" class="btn btn-outline-primary arch">Archive</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
<script>
    window.addEventListener
        ? window.addEventListener('load',script,false)
        : window.attachEvent && window.attachEvent('onload',script);
    
    function script() {
        <?php if ($role !== 'admin'): ?>

        $('.dl').on('click', function(e) {
            e.preventDefault();
            window.open($(this).attr('href'));
        });
        <?php endif;?>
        <?php if($role == 'admin'): ?>
        $('.upload-next').each(function() {
            let url = window.location.href;
            if(!url.includes('/doors')) {
                let link = $(this).parent().attr('href');
                link += (link.includes('?')) ? "&upload=true": "?upload=true";
                $(this).parent().after(`<a class="btn btn-success float-right" href="${link}">Upload</a>`);
            }
        })
        let arc = $('.arch');
        if(arc.length > 0) {
            arc.each(function() {
                let link = $(this).attr('href');
                link += (link.includes('?')) ? "&upload=true": "?upload=true";
                $(this).after(`<a class="btn btn-success float-right" href="${link}">Upload</a>`);
            })
        }
        <?php endif;?>
    }

</script>