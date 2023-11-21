<?php 
    $role = user_data('Title')[1];
    $form = settings('observation_question',true);
?>
<style>
    .score {display:flex;justify-content:center;align-items: center;}
    .title-area {border-right:1px solid #999;padding-right:10px;margin-right:10px}
    .score p {margin: 0;}
    .q-container {cursor: pointer;}
    .q-container:hover {opacity: .3;}
    .edit .act, #del_form .btn-danger {position:absolute;right:15px;top:15px;cursor: pointer;}
    .edit .edit {right:50px}
</style>
<?php 
    if (@session()->getFlashdata('item_')) { $item_ = session()->getFlashdata('item_');}

?>
<div class="observation">
<?php if ($role !== 'inventory' && $role !== 'it'):?>
<?php else: ?>
    <div>
<?php endif;?>
<div class="row">
    <div class="col-md-8">
        <?= card('start') ?>
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-field required">
                            <div class="form-group">
                                <label for="store">Store</label>
                                <select class="select2" name="store" id="stores" data-selected="<?= @$item_['store']?>"><option></option></select>
                                <?= isErr('store', 'This');?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-field required">
                            <div class="form-group">
                                <label for="employee">Employee</label>
                                <select class="emps" name="employee" id="employees" data-selected="<?= @$item_['employee']?>"><option></option></select>
                                <?= isErr('employee', 'This');?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-field nice-select required">
                            <?= select2(['interaction_type','Interaction Type',["","Sale","Service","Role Play"],@$item_['interaction_type']]) ?>
                            <?= isErr('interaction_type', 'This');?>
                        </div>
                    </div>
                </div>
        <?= card('end') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3 class="my-4">5 Key Behaviors</h3>
        <?= card('start') ?>
        <div id="behavior"></div>        
        <?= card('end') ?>
    </div>
    <div class="col-md-6">
        <h3 class="my-4">Retail Sales Process</h3>
        <?= card('start') ?>
        <div id="sales"></div>        
        <?= card('end') ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-4 atnt-score-box">
        <?= card('start'); ?>
            <div class="score">
                <div class="title-area">
                    <h4>AT&T Score</h4>
                    <p>Based on above responses</p>
                </div>
                <div class="score-area" id="atntScore">
                    <h4 class="score"></h4>
                    <p class="remarks"></p>
                </div>
            </div>
            <?= card('end'); ?>
        </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3 class="my-4">The TWE Way</h3>
        <?= card('start') ?>
        <div id="twe_way"></div>
        <?= card('end') ?>
    </div>
    <div class="col-md-6">
        <h3 class="my-4">DIRECT Feedback</h3>
        <?= card('start') ?>
        <div class="row">
    <?php foreach($form['inputs'] as $ind => $f): $info = base64_encode(json_encode([$ind,$f])); ?>
    <?php 
        $act = "<span class='text-warning act edit'><i class='fas fa-pencil edit-elm' data-info='$info'></i></span><span class='text-danger act'><i class='fas fa-trash-alt del-elm' data-del='$ind'></i></span>";
    ?>
    <?php if(count($f) == 1): ?>
        <div class="col-md-12 py-3 edit">
                <?=$act?>
                <?= $f[0];?>
            </div>
        <?php else: ?>
            <div class="col-md-12 py-3 edit">
            <?=$act?>
            <?= form_input(array_merge(["f-$ind"],$f));?>
        </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<a href="#fields" data-toggle="modal" class="btn btn-primary">Add Field</a>
            <?= card('end') ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4 atnt-score-box">
            <?= card('start'); ?>
            <div class="score">
                <div class="title-area">
                    <h4>TWE Score</h4>
                    <p>Based on above responses</p>
                </div>
                <div class="score-area" id="tweScore">
                    <h4 class="text-danger score"></h4>
                    <p class="remarks"></p>
                </div>
            </div>
            <?= card('end'); ?>
        </div>
    </div>
    <textarea name="detail" id="detail" style="display:none"><?= @$item_['detail'];?></textarea>
    <?php if ($role !== 'inventory' && $role !== 'it'):?>
    <?php else: ?>
        <div>
    <?php endif;?>
    </div>

    <?= modal(["quest"]);?>
    <form method="post" id="del_form">
        <input type="hidden" id="delete" name="delete" value="">
        <input type="hidden" id="del_type" name="del_type" value="">
        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
    </form>
    <form method="post" id="q_form">
        <input type="hidden" name="index" id="index">
        <input type="hidden" name="type" id="type">
        <?= form_input(["question","Question","textarea/5",""]);?>
        <?= form_input(["opts","Options","number",0]);?>
        <div class="row" id="options"></div>
        <button class="btn btn-primary">Submit</button>
    </form>
    <?= modal();?>

    <?= modal(['fields']);?>
    <form method="post" id="input_form">
        <input type="hidden" name="i" value="">
        <input type="hidden" name="type" value="inputs">
        <div class="mb-3">
            <select name="type_input" id="input_type" class="select2">
                <option value="text">Single Line Input</option>
                <option value="textarea/5">Paragraph input</option>
                <option value="date">Date input</option>
                <option value="message">Text without input</option>
            </select>
        </div>
        <?= form_input(['title','Label/Description','textarea/3',""]); ?>
        <button class="btn btn-primary">Save</button>
    </form>
    <?= modal('end');?>

<script defer src="<?= base_url(UI["js"]);?>/observations.js"></script>


<script>
    window.addEventListener ? window.addEventListener('load',script):
    window.attachEvent && window.attachEvent('onload',script);

    function script() {
        let b = $('#behavior'),
            s = $('#sales'),
            t = $('#twe_way');

        let interv = setInterval(function() {
            
            if($('#behavior .q-container').length != 0) {
                clearInterval(interv);

                b.append(mk_btn('Add Question','behavior'));
                s.append(mk_btn('Add Question','sales'));
                t.append(mk_btn('Add Question','twe_way'));
                manage_inputs();
                q_form();
                del_form();
                $('#behavior .q-container').each(function() {
                    $(this).attr({
                        'data-toggle':"modal", 
                        'data-target':"#quest",
                        'data-key':'behavior'})
                })
        
                $('#sales .q-container').each(function() {
                    $(this).attr({
                        'data-toggle':"modal", 
                        'data-target':"#quest",
                        'data-key':'sales'})
                })
        
                $('#twe_way .q-container').each(function() {
                    $(this).attr({
                        'data-toggle':"modal", 
                        'data-target':"#quest",
                        'data-key':'twe_way'})
                })
            


            $('.q-container').on('click',function() {
                let opts = $(this).find('.opts .form-check'),
                    options = opts.length,
                    index = $(this).data('index'),
                    type = $(this).data('key'),
                    ques = $(this).find('.ques').html();
                $('#del_form').show();
                $('#index,#delete').val(index);
                $('#question').val(ques);
                $('#type,#del_type').val(type);
                $('#opts').val(options);
                $('#options').html('');
                opts.each(function(i) {
                    let arr = [i+1,$.trim($(this).text()),parseInt($(this).find('input').val())];
                    $('#options').append(mk_ques(arr));
                })
            })
            }

        }, 100);

    

        function del_form() {
            $('#del_form').submit(function(e) {
                e.preventDefault();
                let type = $("#del_type").val(),
                    indx = parseInt($('#delete').val());
                window.obs_form[type].splice(indx,1);
                console.log(window.obs_form[type],indx);
                $.post(window.location.href,{data:window.obs_form},function(res) {
                    if(res.success) window.location.reload();
                })
            })
        }


        function q_form() {
            $('#q_form #opts').attr('min',0);
            $('#q_form .form-control').on('change', function() { $(this).next('.err-msg').remove(); });
            $('[data-key]').on('click', function() {
                let type = $(this).data('key');
                $('#q_form #index,#del_form #delete,#del_form #del_type, #question').val("");
                $('#opts').val(0).trigger('change');
                $('#type').val(type);
            })
            $('#q_form').submit(function(e) {
                e.preventDefault();
                $(this).find('.err-msg').remove();
                let send = true;
                let inputs = $('#q_form .form-control');
                inputs.each(function(i) {
                    let v = $(this).val();
                    console.log(v);
                    if($.trim(v) === "" ) {
                        send = false;
                        $(this).after(`<span class="text-danger err-msg">This must be filled.</span>`); 
                    } else if(parseInt(v) < 2 && $(this).attr('name') == 'opts') {
                        send = false;
                        $(this).after(`<span class="text-danger err-msg">There must be at least 2 options.</span>`); 
                    }
                })
                if(send) {
                    let opts = {};
                    $('[name="key"]').each(function(i) {
                        let name = $(this).val(),
                            int = parseInt($('[name="val"]').eq(i).val());
                        opts[name] = int;
                    })
    
                    let all_num = Object.values(opts),
                        st = Math.min(...all_num),
                        en = Math.max(...all_num);
    
                    let data = {question: $('#question').val(),options:opts,value:[st,en]},
                        indx = $('#index').val();
                    if($.trim(indx) == '') {
                        window.obs_form[$('#type').val()].push(data);
                    } else {
                        window.obs_form[$('#type').val()][parseInt(indx)] = data;
                    }
                    $.post(window.location.href,{data:window.obs_form},function(res) {
                        if(res.success) window.location.reload();
                    })
                }

            })
        }

        function manage_inputs() {
            $('#opts').on('change', function() {
                let inputs = $(this).val();
                $('#options').html('');
                for (let i = 0; i < inputs; i++) $('#options').append(mk_ques([i+1,"",""]));
            })
        }

        function mk_ques(arr) {
            return `
            <div class="col-md-8">
                <input class="form-control my-2" name="key" placeholder="Option ${arr[0]}" value="${arr[1]}" />
            </div>
            <div class="col-md-4">
                <input class="form-control my-2" type="number" min="0" name="val" placeholder="Marks" value="${arr[2]}" />
            </div>
            <div class="col-md-12"><hr></div>
            `;
        }

        function mk_btn(text,id) {
            return `<button data-toggle="modal" data-target="#quest" data-key="${id}" class="btn btn-primary">${text}</button>`;
        }

        // input fields
        $('.del-elm').on('click', function() {
            let del = $(this).data('del');
            // console.log(del,$(this).attr('data-del'));
            // return false;
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                confirmButtonText: 'Great ',
                buttons: {
                    cancel: {text: "Cancel",value: false,visible: true,className: "btn btn-danger",closeModal: true},
                    confirm: { text: "OK",value: true,visible: true,className: "btn btn-primary",closeModal: true}
                }
            }).then(function(confirm) {
                
                if (confirm) {
                    window.obs_form['inputs'].splice(parseInt(del),1);
                    $.post(window.location.href,{data:window.obs_form},function(res) {
                        if(res.success) window.location.reload();
                    })
                }
            })
        })


        let modal = '#fields';
        $('.edit-elm,.add').on('click',function() {
            let add=$(this).hasClass('add'),
                i = $('[name="i"]');
                console.log(add);
            if(add) {
                i.val("");
                $(`#input_type`).val("text").trigger('change');
            } else {
                let info = JSON.parse(atob($(this).data('info'))),
                    label = info[1];
                    console.log(label);
                i.val(info[0]);
                $('[name="title"]').val(label[0]);
                if(info[1].length == 1) {
                    $(`#input_type`).val("message").trigger('change');
                } else {
                    $(`#input_type`).val(label[1]).trigger('change');
                }
            }
            $(modal).modal('show');
        })

        $('[href="#fields"]').on('click',function() {
            let add = $(this).hasClass('btn');
            $('#input_form')[0].reset();
            $('#input_form [name="type_input"]').trigger('change');
            $('#input_form [name="i"]').val('');
        })

        $('#input_form #title').on('change', function() {
            $('#input_form .err-msg').remove();
        })

        $('#input_form').submit(function(e) {
            e.preventDefault();
            let send = true,
                title = $('#input_form #title'),
                t = $('#input_form [name="type"]').val(),
                it = $('#input_form [name="type_input"]').val(),
                i = $('#input_form [name="i"]').val();
                    
            if($.trim(title.val()) === "") {
                send = false;
                title.after(`<span class="text-danger err-msg">This must be filled.</span>`); 
            }

            if(send) {
                if(i !== "") {
                    window.obs_form[t][parseInt(i)][0] = title.val();
                    window.obs_form[t][parseInt(i)][1] = it;
                } else {
                    window.obs_form[t].push([title.val(),it,""]);
                    $('#input_form')[0].reset();
                    $('#input_form [name="type_input"]').trigger('change');
                    $('#input_form [name="i"]').val('');
                }
                $.post(window.location.href,{data:window.obs_form},function(res) {
                    if(res.success) window.location.reload();
                })
            }
        })
    }
</script>