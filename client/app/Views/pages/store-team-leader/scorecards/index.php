<?php 
    $from = (@$_GET['from']) ? $_GET['from'] : date('Y')."-01";
    $to = (@$_GET['to']) ? $_GET['to'] : date('Y')."-12";
?>
<script>
    window.scorecard = {
        api: '/salespeople/scorecards/find',
    }
</script>
<div class="actions">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="collapse" data-target="#filters">Filter</button>
    <a href="#upload" class="btn btn-primary" data-toggle="modal">Upload Scorecard</a>
</div>

<div class="filters collapse" id="filters">
    <div class="row justify-content-end mb-4">
        <div class="col-md-4">
            <?= card('start');?>
            <form id="filter_form">
            <div class="row">
                <div class="col-md-5"><?= form_input(['from','From','month',$from]);?></div>
                <div class="col-md-5"><?= form_input(['to','To','month',$to]);?></div>
                <div class="col-md-2 d-flex align-items-center"><div><button class="btn btn-primary">Filter</button></div></div>
            </div>
            </form>
            <?= card('end');?>
        </div>
    </div>
</div>

<?= card('start');?>
<div id="scoreGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>

<?= modal(['scorecard','lg']);?>
    <div id="stage"></div>
<?= modal();?>

<script defer src="<?=base_url(UI['main']);?>/ag-grid/scorecard.js"></script>

<script>
window.addEventListener ? 
window.addEventListener("load",script,false) : 
window.attachEvent && window.attachEvent("onload",script);
function script() {
    let x = setInterval(() => {
        if ( window.app.aggrid == 'loaded' ) {
            $(".sc-btn").unbind();
            $(".sc-btn").on('click', function () {
                let stage = $('#stage');
                stage.html('loading...');
                $.get($(this).data('src')).then(function(res) {
                    window.app.aggrid = '';
                    stage.html(scorecard(res));
                    clearInterval(x);
                });
            });
        }
    }, 100);

    function scorecard(res) {
        let matrics = res.meta.meta_value,
            heads = Object.keys(matrics),
            hd = Object.keys(matrics[heads[0]]);
        let meta = `<table class="table table-striped table-bordered mt-3"><thead>`;
        meta += `<tr><th>Sales Metrics</th>`;

        for ( i in heads) meta += `<th>${heads[i]}</th>`;
        
        meta += '</tr></thead><tbody>';

        for (h in hd) {
            meta += '<tr>';
            meta += `<th>${hd[h]}</th>`;
            for ( x in heads ) meta += `<td>${matrics[heads[x]][hd[h]]}</td>`;
            meta += '</tr>';
        }
        
        meta +=   `<tbody><table>`;

        let dates = `<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
            <h6 class="dropdown-header">Visit Dates</h6>
            `;

        for ( let d of res.visit.dates) { dates += `<a class="dropdown-item" href="#">${moment(d).format('Do MMM, ddd')}</a>`;}
        dates += '</div>';
            
        return `
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex">
                    <div class="img">
                        <img id="img_pre" src="${window.app.url}/public/uploads/${res.employee.image}" class="img-lg rounded-circle mb-2">
                    </div>
                    <div class="text ml-4 d-flex items-center">
                        <div>
                            <strong>${moment(res.month).format('MMMM YYYY')} Scorecard</strong>
                            <h4><span>${res.employee.Employee_Name}</span></h4>
                            <p>${res.employee.Title}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow bg-primary text-light">
                    <div class="card-body text-center">
                        <strong>Gross Profit</strong>
                        <h2>$${res.gross_profit}</h2>
                    </div>
                </div>
            </div>
        </div>
        ${meta}
        <div class="row text-white text-center py-3 mt-3">
            <div class="col-md-3">
                <div class="card shadow bg-orange">
                    <div class="card-body">
                        <h4 class="m-0">${res.scorecard_total}%</h4><p class="m-0">Scorecard Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow bg-orange">
                    <div class="card-body">
                        <h4 class="m-0">${res.grade}</h4><p class="m-0">Grade</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow bg-orange">
                    <div class="card-body">
                        <h4 class="m-0">${res.mycsp }</h4><p class="m-0">myCSP</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow bg-orange">
                    <div class="card-body">
                        <h4 class="m-0">${res.visit.count}</h4><p class="m-0">Visit Count</p>
                        ${dates}
                    </div>
                </div>
            </div>
        </div>
        `;
    }    
}
</script>