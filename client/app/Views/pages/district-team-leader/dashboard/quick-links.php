<div class="row">
            <?php if (@$panel):?>
            <?php foreach($panel as $p): $p['content'] = json_decode($p['content']); ?>
                <div class="col-md-4 my-3">
                    <?= card('start');?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="content">
                                <strong><?= $p['content'][0];?></strong>
                            </div>
                        </div>
                        <hr>
                        <?= ($p['content'][1] !== '') ? '<p><small>'.$p['content'][1].'</small></p>':''; ?>

                        <ul class="link-items">
                            <?php foreach($p['items'] as $x) : $item = json_decode($x['content']);?>
                                <li>
                                    <a href="<?= $item[1];?>" target="_blank">
                                        <?php if (@$item[2]) :?>
                                            <span style="background-image:url(<?= base_url(UI['upload'].'/'.$item[2]);?>)" class="img-sm d-inline-block bg-contain rounded-circle icon"></span>
                                        <?php endif;?>
                                        <span class="title"><?= $item[0]?></span>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        
                        <hr>
                    <?= card('end');?>
                </div>
            <?php endforeach;?>
            <?php endif; ?>
        </div>