$(document).ready(function() {
    if ($(".summernote").length) {
        $(".summernote").summernote({height: 300,tabsize: 2});
    }
    $('#profile_image').on('change', function() {
        $('#profile_image_form').submit();
    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('.nice-select select').select2();


    // Moment JS
    let mom = $('.moment');
    mom.each(function() {
        let time = $(this).data('time'),
            form = $(this).data('form');
        if (form === 'now') {
            $(this).html(moment(time).fromNow());
        } else {
            if ( time !="" && form != "") $(this).html(moment(time).format(form));
        }
    })

    let user_time = $('.user_time');
    user_time.each(function() {
        let time = $(this).data('time'),
            calc = time_convert(time);
        $(this).html(calc);
    })

// disable input
$('.disable-input').each(function() {
    $(this).find('input').attr('disabled','disabled');
});

// General Select2
if($('.select2').length > 0) $('.select2').select2();

// Select 2 with stores
if ( $('#stores').length == 1 || $('.stores').length > 0) window.app.stores();

// Select 2 with employees
if ($('.emps').length > 0 ) window.app.employees();

// Helpers for select2

// Flash Message
var flash = $('[data-flash]');
if ( flash.length > 0 ) {
    let type = flash.data('type'),
        data = {
            text: flash.data('flash'),
            showHideTransition: 'slide',
            icon: type,
            position: 'top-right'
        }
    switch(type) {
        case 'success':
            data.heading = 'Success';
            data.loaderBg = '#f96868';
        break;
        case 'error':
            data.heading = 'Error';
            data.loaderBg = '#f2a654';
        break;
    }
    $.toast(data);
}

});


function select(item) {return item.title;}
function result(item) {
    if (item.id === item.text) return;
    var $item = $(`<div class="store-option-li">
        <span style="background-image:url(${item.image})" class="mr-2 img rounded-circle"></span>
        <div>
            <strong>${item.title} ${(item.status==='TRUE') ? ' <small>Disabled</small>':''}</strong>
            <span>${item.desc}</span>
        </div>
    </div>`);
    return $item;
}
function map(data,keys,sel) {
    var _data = [{id:0,title:"Select",desc:""}];
    var i = 0;
    for (item of data) {            
        var _item = {
            id:item[keys[0]],
            image:item[keys[1]],
            title:item[keys[2]],
            desc:item[keys[3]],
            text:item[keys[2]],
            status: item[keys[5]]
        };
        if (sel == item[keys[0]]) _item.selected = true;
        _data.push(_item);
        i = i+1;
    }
    return _data;
}

window.app.stores = function () {
    $.get(`${window.app.url}/api/stores`)
        .done(function(res) {
            let select2 = $('#stores,.stores:not(.select2-hidden-accessible),.strs:not(.select2-hidden-accessible)');
            for ( i in res ) res[i].image = `${window.app.public+'/'+res[i].image}`;
    
            var selected = (select2.data('selected') != undefined) ? select2.data('selected') : "",
                data = map(res,['StoreID','image','StoreName','District','City'], selected);
            
            select2.select2({
                placeholder:"Select Store",
                templateResult: result,
                templateSelection: select,
                data:data
            });
        })
}

window.app.employees = function () {
    let select2 = $('.emps:not(.select2-hidden-accessible)'),
        ids = [];
    select2.each(function () {
        let _so = $(this).data('selected');
        if (_so !== "") ids.push(_so);
    });
    let selected_emp = (ids.length > 0) ? ids.join('/'): '';
    $.get(`${window.app.url}/api/employees?select=${selected_emp}`)
     .done(function (emps) {
        for ( i in emps ) emps[i].image = window.app.public+'/'+emps[i].image;

        for ( let x=0; x < select2.length; x++) {
            var selected = select2.eq(x).data('selected'),
                data = map(emps,['EmployeeID','image','Employee_Name','Title','text','Account_Disabled'], selected);
                let setting = {
                    placeholder:"Select Employee",
                    templateResult: result,
                    templateSelection: select,
                    data:data
                };

                select2.eq(x).select2(setting);
        }
    })
}

window.app.flash = function(type,message) {
    let data = {
            text: message,
            showHideTransition: 'slide',
            icon: type,
            position: 'top-right'
        }
    switch(type) {
        case 'success':
            data.heading = 'Success';
            data.loaderBg = '#f96868';
        break;
        case 'error':
            data.heading = 'Error';
            data.loaderBg = '#f2a654';
        break;
    }
    $.toast(data);
}

window.app.time = time_convert;
function time_convert(UTC) {
    let localTime  = moment.utc(UTC).toDate();
    return moment(localTime).calendar();
}

window.app.localTime = function(time,form) {
    let lt = moment(moment.utc(time).toDate());
    switch (form) {
        case 'cal': return lt.calendar();break;
        case 'fn': return lt.fromNow();break;
        default:
            return lt.format(form);
            break;
    }
}

window.app.form_object = function (form) {
    let form_data = $(form).serializeArray(),
        form_obj = {};
    form_data.map(function (item) {form_obj[item.name] = item.value;});
    return form_obj;
}

window.app.float = function(val,dec) {
    if (val=="" || typeof val == "undefined") val = "0";
    // console.log('script.js',typeof val,val);
    val = (typeof val !== "number" && val.includes(',')) ? val.split(',').join('') : val;
    let form = parseFloat(val);
    if(dec==0) {
        return form;
    } else {
        return form.toFixed(dec);
    }
}
