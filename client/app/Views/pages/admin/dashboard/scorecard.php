<?php 
    use App\Models\Scorecard;
    $sc = new Scorecard();
    $scores = $sc->my();
    $scores['detail'] = @$scs = json_decode($scores['detail']);
    $x = 0;
    $role = user_data('Title')[1];

    //debug($scores);
?>
<style>
    .ops .card {cursor: pointer;}
    .gauge {margin-top:-50px;min-height:160px;}
</style>
<?php
    $sc = [
        'sales' => [
            ["Post Paid Voice",@$scores['ppv_%_to_goal_d1']],
            ["Non-PPV",@$scores['non_ppv_%_to_goal_d2']],
            ["Accessories",@$scores['accessories_%_to_goal_d3']],
            [],
            ["Protection",@$scores['protection_%_to_goal_d5']],
            ["Expert",@$scores['expert_%_to_goal_d6']],
            ["Quality",@$scores['quality_%_to_goal_d7']]
        ]
    ];
    switch ($role) {
        case 'admin': 
            $sc['sales'][3] = ["Upgrades",@$scores['upgrade_%_to_goal_d4']];
            break;
        case 'district-team-leader':
            $sc['sales'][3] = ['Miscellaneous', @$scores['misc_%_to_goal_d4']];
            break;
        default:
            $sc['sales'][3] = ['Upgrades', @$scores['upgrades_%_to_goal_d4']];
            break;
    }
    $colors=["bg-primary text-light","bg-warning","bg-success","bg-info","bg-danger"];
    $clrs = ["#FF5E6D","#F5A623","#04B76B"];


    // debug($sc['sales']);
?>

<section class="mt-4">
    <h2>Sales</h2>
    <hr>
    <div class="row">
        <?php foreach($sc['sales'] as $i => $v): 
            $x++;
            if ($i>4)$i=0;
            if (empty($v[1])) $v[1]=0; 
        ?>
            <div class="col-3 mb-4 text-center">
                <?= card('start');?>
                    <div id="g<?=$x?>" class="gauge" data-number="<?= @round(($v[1]*100),0);?>"></div>
                    <strong><?= $v[0];?></strong>
                <?= card('end');?>
            </div>
        <?php endforeach;?>        
    </div>
</section>

<section class="mt-4">
    <h2>Operations</h2>
    <hr>
    <div class="row ops">
        <?php foreach(ops() as $i => $v): ?>
            <div class="col <?= ($i==0 && $v[1] !== 0) ? "ple" : "ops-$i";?>">
                <?= card('start',$colors[$i]);?>
                    <h3 class="display-3"><i class="fa-solid fa-layer-group"></i> <?= round($v[1],2);?></h3>
                    <strong><?= $v[0];?></strong>
                <?= card('end');?>
            </div>
        <?php endforeach; ?>        
    </div>
    <div class="row">
        <div class="col-md-3"></div>
    </div>
</section>
<script>

window.addEventListener 
    ? window.addEventListener('load',script,false) 
    : window.attachEvent && window.attachEvent('onload',script);
function script() {
    let {url,role} = window.app;
    <?php if($role == 'admin' || $role = BASE['hr']) :?>
        $('.ple').on('click', function() {
            window.open(url+'/compliance','_self');
        })
    <?php else: ?>
        $('.ple').on('click', function() {$('#pleComliance').modal('show');})
    <?php endif;?>
    $('.ops-1').on('click', function() { window.open(url+'/tickets','_self')});
    $('.ops-2').on('click', function() { window.open(url+'/'+role+'/observations','_self')});
    $('.ops-3').on('click', function() { window.open(url+'/'+role+'/connections','_self')});
    
    let g = [],
        n = [],
        zero = false;
       
        refresh();

    function refresh() {
        zero = !zero;
        for ( x in g ) {
            up_num = (zero) ? 0 : n[x];
            g[x].refresh(up_num);
        }
    }
        $('.gauge').each(function() {
            let id = $(this).attr('id'),
                num = $(this).data('number');
            n.push(num);
            g.push(new JustGage({
                id: id,value:num,min:0,max:200,symbol: "%",pointer:true,gaugeWidthScale:0.3,
                customSectors: [
                    {color:"<?= $clrs[0]; ?>",lo:0,hi:50},
                    {color:"<?= $clrs[1]; ?>",lo:50,hi:100},
                    {color:"<?= $clrs[2]; ?>",lo:100,hi:200}
                ],
                counter: true,
            }));
        })
}
</script>