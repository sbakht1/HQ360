let x = setInterval(() => {
    $(".sc-btn").unbind();
    $(".sc-btn").on('click', function () {
        let stage = $('#stage');
        stage.html('loading...');
        $.get($(this).data('src')).then(function(res) {
            window.app.aggrid = '';
            let card = scorecard(res);  
            stage.html(card);
        });
    });
}, 100);

function scorecard(res) {
    let matrics = res.detail,
        heads = ['Sales Metrics','Goal','MTD','Trend','Trending % to Goal','Metric Value','Earned'];
    let table = `<table class="table table-striped table-bordered mt-3"><thead><tr>`;
    for( let h of heads ) table += `<th>${h}</th>`;

    console.log(matrics,matrics.upgrades_metric_value_e4);


    if (typeof matrics.non_ppv_points_earned_f2 == 'undefined') matrics.non_ppv_points_earned_f2 = matrics.non_ppv_points_erned_f2
    if (typeof matrics.upgrades_metric_value_e4 == 'undefined') matrics.upgrades_metric_value_e4 = matrics.upgrade_metric_value_e4
    if (typeof matrics['upgrades_%_to_goal_d4'] == 'undefined') matrics['upgrades_%_to_goal_d4'] = matrics['upgrade_%_to_goal_d4']
    if (typeof matrics.protection_metric_value_e5 == 'undefined') matrics.protection_metric_value_e5 = matrics['protection_+_htp_metric_value_e5']
    if (typeof matrics.accessory_goal_a3 == 'undefined') matrics.accessory_goal_a3 = matrics.acc_gp_goal_a3

    table += `</thead><tbody>`;
        tr = `<tr>`;
            tr +=`<th>Post Paid Voice</th>`;
            tr +=`<td>${window.app.float(matrics.ppv_goal_a1)}</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_mtd_b1)}</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_trend_c1)}</td>`;
            tr +=`<td>${(window.app.float(matrics['ppv_%_to_goal_d1'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_metric_value_e1)}</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_points_earned_f1,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Non-PPV</th>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_goal_a2)}</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_mtd_b2)}</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_trend_c2)}</td>`;
            tr +=`<td>${(window.app.float(matrics['non_ppv_%_to_goal_d2'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_metric_value_e2)}</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_points_earned_f2,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Accessories</th>`;
            tr +=`<td>${int(window.app.float(matrics.accessory_goal_a3,2)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${int(window.app.float(matrics.accessories_mtd_b3,2)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${int(window.app.float(matrics.accessory_trend_c3)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${(window.app.float(matrics['accessories_%_to_goal_d3'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.accessories_metric_value_e3)}</td>`;
            tr +=`<td>${window.app.float(matrics.accessory_points_earned_f3,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Upgrades</th>`;
            tr +=`<td>${window.app.float(matrics.upgrade_goal_a4)}</td>`;
            tr +=`<td>${window.app.float(matrics.upgrade_mtd_b4)}</td>`;
            tr +=`<td>${window.app.float(matrics.upgrade_trend_c4)}</td>`;
            tr +=`<td>${(window.app.float(matrics['upgrades_%_to_goal_d4'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.upgrades_metric_value_e4)}</td>`;
            tr +=`<td>${window.app.float(matrics.upgrade_points_earned_f4,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Protection</th>`;
            tr +=`<td>${int(window.app.float(matrics.protection_goal_a5,2)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${int(window.app.float(matrics.protection_mtd_b5,2)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${int(window.app.float(matrics.protection_trend_c5)).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2})}</td>`;
            tr +=`<td>${(window.app.float(matrics['protection_%_to_goal_d5'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.protection_metric_value_e5)}</td>`;
            tr +=`<td>${window.app.float(matrics.protection_points_earned_f5,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Expert</th>`;
            tr +=`<td>${window.app.float(matrics.expert_goal_a6)}</td>`;
            tr +=`<td>${window.app.float(matrics.expert_mtd_b6)}</td>`;
            tr +=`<td>${window.app.float(matrics.expert_trend_c6)}</td>`;
            tr +=`<td>${(window.app.float(matrics['expert_%_to_goal_d6'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.expert_metric_value_e6)}</td>`;
            tr +=`<td>${window.app.float(matrics.expert_points_earned_f6,2)}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Quality</th>`;
            tr +=`<td>${window.app.float(matrics.quality_goal_a7)}%</td>`;
            tr +=`<td>${window.app.float(matrics.quality_score_mtd_b7)}%</td>`;
            tr +=`<td>${window.app.float(matrics.quality_trend_c7)}%</td>`;
            tr +=`<td>${(window.app.float(matrics['quality_%_to_goal_d7'],2)*100).toFixed(2)}%</td>`;
            tr +=`<td>${window.app.float(matrics.quality_metric_value_e7)}</td>`;
            tr +=`<td>${window.app.float(matrics.quality_points_earned_f7,2)}</td>`;
        tr += `</tr>`;
    table += tr;
    table += `</tbody></table>`;

    return `<div class="row">
        <div class="col-md-6">

            <div class="d-flex">
                <div class="img">
                    <img id="img_pre" src="${window.app.url}/public/uploads/${res.info[2]}" class="img-lg rounded-circle mb-2">
                </div>
                <div class="text ml-4 d-flex items-center">
                    <div>
                        <strong>${moment(res.yyyymm).format('MMMM YYYY')} Scorecard</strong>
                        <h4><span>${res.info[0]}</span></h4>
                        <p>${res.info[1]}</p>
                    </div>
                </div>
            </div>  
        </div>
        <div class="col-md-3">
            <div class="card shadow bg-primary text-light">
                <div class="card-body text-center">
                    <strong>Gross Profit</strong>
                    <h4>${parseInt(res.gp).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow bg-primary text-light">
                <div class="card-body text-center">
                    <strong>Scorecard Total</strong>
                    <h4>${(window.app.float(res.scorecard,2)*100).toFixed(0)}%</h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">${table}</div>
    </div>`;
}

$('#month,#year').on('change', function() {
    let value = $(this).val(),
        url = new URL(window.location.href),
        name = $(this).attr('name');
    if (name === 'month')
        url.searchParams.set('month',moment(value).format('YYYYMM'));
    else 
        url.searchParams.set('year',value);

    window.open(url.toString(),'_self');
});

function int(txt) {
    if($.trim(txt) === "") txt = "0";
    return parseInt(txt);
}