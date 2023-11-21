let x = setInterval(() => {
    $(".sc-btn").unbind();
    $(".sc-btn").on('click', function () {
        let stage = $('#stage');
        $("#stage").css({"max-height": "71vh", "overflow-y": "scroll","overflow-x":"hidden", "::-webkit-scrollbar":"5px"});
        stage.html('loading...');
        $.get($(this).data('src')).then(function(res) {
            window.app.aggrid = '';
            stage.html(scorecard(res));
        });
    });
}, 100);

const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];

const d = new Date();
let CurrMonth = d.getMonth();

function scorecard(res) {
    console.log(res);
    var baseUrl = location.protocol + "//" + location.host, currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");
    let connections="";
    let Connections_str = ""
    if(res.connections.length >0){
        let arr = JSON.parse((res.connections[0].info));
        connections += `<div class="row" style="margin-top:10px;"><div class="col-12 text-center" style="padding:10px !important; background-color:#0f3c7a; color:#fff;">Connection Meeting for `+  getCurrMonth((Number(res.month)-1)) + " " + d.getFullYear() +`</div><div class="col-6 text-right" style="padding:10px;">Connection Date: `+ res.connections[0]['date'] +` </div><div class="col-6 text-left" style="padding:10px;">Report Entered By: `+ res.connections[0]['submit_by'] +`</div><div style="background-color:#F5A623;padding:10px;" class="col-6 text-center"><b>STRENGTHS</b></div><div style="background-color:#F5A623;padding:10px;" class="col-6 text-center"><b>OPPORTUNITIES</b></div>`;
        connections += `<div class="col-6"><ol><li>${arr[0][1]}</li><li>${arr[1][1]}</li><li>${arr[2][1]}</li></ol></div>`;
        connections += `<div class="col-6"><ol><li>${arr[3][1]}</li><li>${arr[4][1]}</li><li>${arr[5][1]}</li></ol> </div>`;
        connections += `<div class="col-12" style="padding:10px 20px; background-color:#0f3c7a; color:#fff;"><b>${arr[6][0]}</b></div>`;
        connections += `<div class="col-12" style="padding:10px; background-color:#fff">${arr[6][1]}</div>`;
        connections += `<div class="col-12" style="padding:10px 20px; background-color:#0f3c7a; color:#fff;"><b>Action Plan</b></div>`;
        connections += `<div class="col-12" style="padding:10px; background-color:#fff">`;
        connections += `<div style="margin-top:15px;"><b>${arr[7][0]}</b><br>${arr[7][1]}</div>`;     //Specific behaviors
        connections += `<div style="margin-top:15px;"><b>${arr[8][0]}</b><br>${arr[8][1]}</div>`;     //How will the behaviors or actions
        connections += `<div style="margin-top:15px;"><b>${arr[9][0]}</b><br>${arr[9][1]}</div>`;     //What is the desired 
        connections += `<br><br><b>Schedule Follow-up Dates:</b><br>${arr[10][1]}<br>${arr[11][1]}`;  //Schedule Follow-up Dates:
        connections += `</div>`;
        connections += `</div>`;
    }else{
        connections = "";
        connections += `<div class="text-center" style="margin:8px !important; padding-top:15px !important; padding-bottom:15px !important; background-color:#e8eff4">No Connections for ` + getCurrMonth( (Number(res.month)-1)) + " " + d.getFullYear() + `</div>`
    }


    let Obstable="";
    if((res.observations.length>0)){
        let arr = JSON.parse((res.observations[0].detail));
        let d = new Date(res.observations[0].date); 
        let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
        let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);

    let Observations = res.observations ;//json_decode(res.observations),
    obsheads = ['Date of Observation','AT&T Score','TWE Score'];   

    Obstable = `<table class="table table-striped table-bordered mt-0"><thead><tr>`;
        for( let h of obsheads ) Obstable += `<th class="text-center">${h}</th>`;
            Obstable += `</thead><tbody>`;
                trs = `<tr>`;
                trs +=`<th class="text-center">${`${da}-${mo}-${ye}`}</th>`;
                trs +=`<td class="text-center bg-${arr['atntScore'][3]}"> ${arr['atntScore'][0] + " Of " + arr['atntScore'][1] + " ( " + arr['atntScore'][2] + " )"}</td>`;
                trs +=`<td class="text-center bg-${arr['tweScore'][3]}" > ${arr['tweScore'][0] + " Of " + arr['tweScore'][1] + " ( " + arr['tweScore'][2] + " )"}</td>`;
                trs += `</tr>`;
            Obstable += trs;
            Obstable += `</tbody></table>`;
    }else{
        Obstable = "";
        Obstable += `<div class="text-center" style="margin:8px !important; padding-top:15px !important; padding-bottom:15px !important; background-color:#e8eff4">No Observations for ` + getCurrMonth((Number(res.month)-1)) + " " + d.getFullYear() + `</div>`
    }
    

if(res.type!="district"){
    if(res.connections.length >0 || res.observations.length>0){
        Connections_str = `<div class="row">
            <div class="col-3 text-left" style="margin-top:20px"><a href="#" onclick="getPrevMonth()" style="text-decoration:none; font-size:12px;"><< Prev Month</a></div>
            <div class="col-6 text-center"><img src='${ baseUrl}/public/ui/images/logo-twe.png' style="width:120px"/></div>
            <div class="col-3 text-right" style="margin-top:20px"> <a href="#" onclick="getNextMonth()" style="text-decoration:none; font-size:12px;">Next Month >></a></div>
            <div class="col-12 text-center" style="padding:10px !important; background-color:#0f3c7a; color:#fff;">Wireless Specialist Observation for `+  getCurrMonth((Number(res.month)-1)) + " " + d.getFullYear() +`</div>
            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">${Obstable}</div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding-top:1px">${connections}</div>
        </div>`;
    }else {
        Connections_str = `<div class="col-12 text-center" style="padding:10px !important; background-color:#0f3c7a; color:#fff;"> Wireless Specialist - No Observation for Selected Month</div>`;
    }
}



    let matrics = res.detail,
        heads = ['Sales Metrics','Goal','MTD','Trend','Trending % to Goal','Metric Value','Earned'];            
    let table = `<table class="table table-striped table-bordered mt-3"><thead><tr>`;
    for( let h of heads ) table += `<th>${h}</th>`;

    table += `</thead><tbody>`;
        tr = `<tr>`;
            tr +=`<th>Post Paid Voice</th>`;
            tr +=`<td>${window.app.float(matrics.ppv_goal_a1.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_mtd_b1.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float((matrics.ppv_trend_c1.replace(',', '')) ? matrics.ppv_trend_c1.replace(',', ''):0)}</td>`;
            tr +=`<td>${(window.app.float(matrics['ppv_%_to_goal_d1'].replace(',', '')*100))}%</td>`;
            tr +=`<td>${window.app.float(matrics.ppv_metric_value_e1.replace(',', ''))}</td>`;
            //${window.app.float(matrics.ppv_points_earned_f1.replace(',', ''))}
            tr +=`<td>${(matrics.ppv_points_earned_f1!="")?parseFloat(matrics.ppv_points_earned_f1.replace(',', '')).toFixed(2) :"0"} </td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Non-PPV</th>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_goal_a2.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_mtd_b2.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float((matrics.non_ppv_trend_c2.replace(',', ''))?matrics.non_ppv_trend_c2.replace(',', ''):0)}</td>`;
            tr +=`<td>${(window.app.float(matrics['non_ppv_%_to_goal_d2'].replace(',', '')*100))}%</td>`;
            tr +=`<td>${window.app.float(matrics.non_ppv_metric_value_e2.replace(',', ''))}</td>`;
            //${window.app.float((res.type==='employee') ? matrics.non_ppv_points_erned_f2.replace(',', '') : matrics.non_ppv_points_earned_f2.replace(',', ''))}
            tr +=`<td>${(res.type==='employee') ? ((matrics.non_ppv_points_erned_f2!="") ?parseFloat(matrics.non_ppv_points_erned_f2.replace(',', '')).toFixed(2):"0") : ((matrics.non_ppv_points_earned_f2!="") ? parseFloat(matrics.non_ppv_points_earned_f2.replace(',', '')).toFixed(2):"0")}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Accessories</th>`;
            tr +=`<td>${int((res.type==='employee') ? matrics.accessory_goal_a3.replace(',', '') : (res.type=="district") ? matrics.acc_gp_goal_a3.replace(',', ''):matrics.acc_gp_goal_a3.replace(',', '')).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${int(matrics.accessories_mtd_b3.replace(',', '')).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${int((matrics.accessory_trend_c3.replace(',', ''))?matrics.accessory_trend_c3.replace(',', ''):0).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${(window.app.float(matrics['accessories_%_to_goal_d3']*100))}%</td>`;
            tr +=`<td>${window.app.float(matrics.accessories_metric_value_e3)}</td>`;
            //${window.app.float(matrics.accessory_points_earned_f3)}
            tr +=`<td>${(matrics.accessory_points_earned_f3!="")?(parseFloat(matrics.accessory_points_earned_f3.replace(',', '')).toFixed(2)):"0"}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Upgrades</th>`;
            tr +=`<td>${window.app.float((res.type=="district") ? matrics.misc_goal_a4 : matrics.upgrade_goal_a4)}</td>`;  //misc_goal_a4
            tr +=`<td>${window.app.float((res.type=="district") ? matrics.misc_mtd_b4 : matrics.upgrade_mtd_b4)}</td>`;    //misc_mtd_b4
            tr +=`<td>${window.app.float((res.type=="district") ? ((matrics.misc_trend_c4)?matrics.misc_trend_c4.replace(',', ''):0) : ((matrics.upgrade_trend_c4)?matrics.upgrade_trend_c4.replace(',', ''):0))}</td>`;    //misc_trend_c4
            tr +=`<td>${(res.type==='employee') ? (window.app.float(matrics['upgrades_%_to_goal_d4']*100)) :  (res.type=="district") ? (window.app.float(matrics['misc_%_to_goal_d4']*100)) : (window.app.float(matrics['upgrade_%_to_goal_d4']*100))}%</td>`; //misc_%_to_goal_d4
            tr +=`<td>${(window.app.float((res.type==='employee') ? matrics.upgrades_metric_value_e4 : (res.type=="district") ? matrics.misc_metric_value_e4 :  matrics.upgrade_metric_value_e4))}</td>`;  //upgrades_metric_value_e4 //misc_metric_value_e4
            
            //${window.app.float((res.type=="district") ? matrics.misc_points_earned_f4 : matrics.upgrade_points_earned_f4)}
            tr +=`<td>${(res.type=="district") ? ((matrics.misc_points_earned_f4!="")?parseFloat(matrics.misc_points_earned_f4.replace(',', '')).toFixed(2):"0") : ((matrics.upgrade_points_earned_f4!="")?parseFloat(matrics.upgrade_points_earned_f4.replace(',', '')).toFixed(2):"0") }</td>`;  //misc_points_earned_f4
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Protection</th>`;
            tr +=`<td>${int(matrics.protection_goal_a5.replace(',', '')).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${int(matrics.protection_mtd_b5.replace(',', '')).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${int((matrics.protection_trend_c5.replace(',', '')) ? matrics.protection_trend_c5.replace(',', ''):0).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</td>`;
            tr +=`<td>${(window.app.float(matrics['protection_%_to_goal_d5']*100))}%</td>`;
            tr +=`<td>${window.app.float( (res.type==='employee') ? matrics['protection_metric_value_e5'] : matrics['protection_+_htp_metric_value_e5'])}</td>`;
            //${window.app.float(matrics.protection_points_earned_f5)}
            tr +=`<td>${(matrics.protection_points_earned_f5!="")?parseFloat(matrics.protection_points_earned_f5.replace(',', '')).toFixed(2):"0"}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Expert</th>`;
            tr +=`<td>${window.app.float(matrics.expert_goal_a6.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float(matrics.expert_mtd_b6.replace(',', ''))}</td>`;
            tr +=`<td>${window.app.float((matrics.expert_trend_c6.replace(',', '')) ? matrics.expert_trend_c6.replace(',', ''):0)}</td>`;
            tr +=`<td>${(window.app.float(matrics['expert_%_to_goal_d6']*100))}%</td>`;
            tr +=`<td>${window.app.float(matrics.expert_metric_value_e6.replace(',', ''))}</td>`;
            //${window.app.float(matrics.expert_points_earned_f6.replace(',', ''))}
            tr +=`<td>${(matrics.expert_points_earned_f6!="")?parseFloat(matrics.expert_points_earned_f6.replace(',', '')).toFixed(2):"0"}</td>`;
        tr += `</tr>`;
        tr += `<tr>`;
            tr +=`<th>Quality</th>`;
            tr +=`<td>${window.app.float(matrics.quality_goal_a7.replace(',', ''))}%</td>`;
            tr +=`<td>${window.app.float(matrics.quality_score_mtd_b7.replace(',', ''))}%</td>`;
            tr +=`<td>${window.app.float((matrics.quality_trend_c7.replace(',', '')) ? matrics.quality_trend_c7.replace(',', ''):0)}%</td>`;
            tr +=`<td>${(window.app.float(matrics['quality_%_to_goal_d7']*100))}%</td>`;
            tr +=`<td>${(matrics.quality_metric_value_e7!="")?window.app.float(matrics.quality_metric_value_e7.replace(',', '')):"0"}</td>`;

            //${window.app.float(matrics.quality_points_earned_f7.replace(',', ''))} 
            tr +=`<td>${parseFloat(matrics.quality_points_earned_f7.replace(',', '')).toFixed(2)}</td>`;
        tr += `</tr>`;
    table += tr;
    table += `</tbody></table>`;

   

    return `<div class="row">
        <div class="col-md-6">
            <div class="d-flex">
                <div class="img">
                    <img id="img_pre" src="${window.app.url}/public/uploads/${(res.info[2])}" class="img-lg rounded-circle mb-2">
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
                    <h4>${parseInt(res.gp.replace(',','')).toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:0})}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow bg-primary text-light">
                <div class="card-body text-center">
                    <strong>Scorecard Total</strong>
                    <h4>${(window.app.float(res.scorecard.replace(',',''),2)*100).toFixed(0)}%</h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">${table}</div>
    </div>
        ${Connections_str}
     `;

}



function getCurrMonth(monthId){
    return monthNames[monthId];
}
function getPrevMonth()
{
    if(CurrMonth>=0){
        CurrMonth--;
        $('#monthName').html(getCurrMonth(CurrMonth) + " " +  d.getFullYear());
    }
}

function getNextMonth()
{
    if(CurrMonth <12){
        CurrMonth++;
        $('#monthName').html(getCurrMonth(CurrMonth) + " " +  d.getFullYear());
    }
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