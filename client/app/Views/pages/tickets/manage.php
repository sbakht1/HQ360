<?php
    $dep = 'inventory';
    if (@$_GET['department']) $dep = $_GET['department'];

    foreach($form as $i => $x) if ( isset($x->constant)) $form[$i]->value = constant($form[$i]->constant);
?>
<style>
    .div[class*="col"]:empty, .hide {display:none;}
</style>
<form action="" method="post" id="ticket" enctype="multipart/form-data">
    <?php include "department/$dep.php"; ?>
    <button class="btn btn-primary mt-3">Submit</button>
</form>

<script>
    window.addEventListener ? 
    window.addEventListener("load",script,false) : 
    window.attachEvent && window.attachEvent("onload",script);

function script() {
    let form = <?= json_encode($form);?>,
          rel = [];
    let form_data = $('#form_data'),
        related = $('#related');
    form.map(function (item,i) {
        form_data.append(input(item,false,i));
    });

    window.app.stores();
    $('.select2:not(.emps,.stores)').select2({placeholder:"Select"});

    $('select').on('change', function () {
        let sel = $(this),
            fn = [sel.attr('name'),sel.val()];
        apply_related(sel,fn,'');
    })

    function check_related() {
        $('.related-field select').on('change', function() {
            let sel = $(this),
                fn = [sel.attr('name'),sel.val()];
            apply_related(sel,fn,sel.parent().parent().data('rf'));
        })

        $('#last-day-worked').on('change', function() {
            $('#hire-date').attr('max', this.value);
            $('#termination-date').attr('max', this.value);
        })
    }

    function apply_related(sel,fn,index) {
        if ( index === "" ) {
            for (r of rel) {
                for ( f of r.relation) {
                    if (f.field[0] == sel.attr('name')) {
                        $(`[data-rel]`).each(function (i) { $(this).html(''); });
                        break;
                    }
                }
            }
        } else {
            $(`[data-rel="${index}"]`).each(function (i) { $(this).html(''); });
        }
        form.map(function (item,i) {
            if ( typeof item.relation == "undefined") return
            item.relation.map(function (x) {
                if ( x.field[0] == fn[0] && x.field[1] == fn[1] ) {
                    if ( typeof x.options == 'object') item.value = x.options;
                    $(`.rf-${i}`).attr(`data-rel`,index).html(input(item,true,i));
                    if (item.type == 'select') {
                        window.app.stores();
                        window.app.employees();
                        $(`.rf-${i} select:not(.select2-hidden-accessible,.stores,.emps)`).select2({placeholder: `Select ${item.title}`});
                    }
                }
            })
        })
        check_related();
    }

    $('#ticket').submit(function(e) {
        e.preventDefault();
        console.log($(this).serializeArray())
        $('#ticket button').attr('disabled','disabled');
        let form = {},
            send = true;
        $('.err').remove();
        $('#ticket [name]').each(function() {
            let name  = $(this).attr('name'),
                val   = $(this).val(),
                req   = $(this).parent().hasClass('required');
            form[name]  = val;
            if ( $.trim(val) == "" && req) {
                send = false;
                $(`[name="${name}"]`).parent().append('<span class="err text-danger">This Field is required.</span>');
            }
        });

        if (send) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                success:function (res) { 
                    if (res.success == true) window.open(window.app.url+'/tickets','_self'); 
                }
            });
        }
        $('#ticket button').removeAttr('disabled');
    });
    
    function input(f,related,i) {
        let inp = (!related) ? `<div class="col-md-12">` : '',
            required = (typeof f.validate !== 'undefined') ? f.validate.required:false;
        if ( typeof f.relation !== 'undefined' && !related){ 
            inp += `<div class="related-field rf-${i}" data-rf="${i}"></div>`;
            rel.push(f);
        } else {
            inp += `        
                <div class="form-group ${(required)?'required':''}">
                    <label for="${f.name}">${f.title} ${(required)?'<span class="text-danger">*</span>':''}</label>
                    ${field(f)}
                </div>
            `;
        }
        inp += (!related)?'</div>':'';

        return inp;
            
        }
    
        
    function field(data) {
        let input_field = "",
            placeholder = (typeof data.placeholder == "undefined") ? "" : data.placeholder,
            store_selector = (data.name=='store')?'stores':'';
            classes = (typeof data.class !== 'undefined')? data.class.join(' '):'';
            multiple = (typeof data.multiple !== 'undefined') ? 'multiple': '';
        if (data.type == "select") {
            input_field += `<select ${multiple} name="${data.name}" class="select2 ${store_selector+classes}" data-selected="${(window.app.store != null) ? window.app.store.StoreID : "" }">`;
            input_field += `<option></option>`;
    
            if ( typeof data.value == 'object' ) {
                data.value.map(function (opt) {
                    input_field += `<option value="${opt}">${opt}</option>`;
                });
            }
            input_field += "</select>";
        } else if ( data.type.includes('textarea')) {
            let rows = data.type.split('/')[1];
            input_field += `<textarea placeholder="${placeholder}" rows="${rows}" name="${data.name}" id="${data.name}" class="form-control">${data.value}</textarea>`;
        } else {
            input_field += `<input placeholder="${placeholder}" type="${data.type}" id="${data.name}" name="${data.name}" class="form-control" ${(data.accept)?"accept="+data.accept:""}>`;
        }
    
        return input_field;
    }
}



</script>