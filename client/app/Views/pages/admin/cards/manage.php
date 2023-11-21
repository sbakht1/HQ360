<style>
    .sample {border-radius:10px;opacity:.95}
    #print {background-color:#000;border-radius:11px;}
    .card-container {position:relative;box-shadow:0 30px 90px -46px #0005;max-width:750px;margin:auto;}
    .card-content {position:absolute;top:80px;left:50px;width: 350px;}
    .card-content h3 {color:#ed772d;}
    .card-content div {margin-bottom:25px}
</style>
<?php 
    $info = (@$card) ? json_decode($card['data'],true): [];
?>
            <div class="row">
                <div class="col-md-6">
                    <?= card('start');?>
            <form method="post" id="emp_card">
                <input type="hidden" name="employee" value="<?= (@$card['employee']) ? $card['employee'] : profile('EmployeeID');?>">
                <?= form_input(['title','Full Name', 'text', (@$info['title'])?$info['title']:profile('Employee_Name')]);?>
                <?= form_input(['department','Department/Title', 'text',(@$info['department'])?$info['department']:profile('Title')]);?>
                <?= form_input(['phone','Office Number', 'tel',(@$info['phone'])?$info['phone']:profile('Work_Number')]);?>
                <?= form_input(['email','Email Address', 'email',(@$info['email'])?$info['email']:profile('Email')]);?>
                <?= form_input(['personal','Personal Code', 'text',(@$info['personal'])?$info['personal']:""]);?>
                <?= form_input(['note','Note', 'textarea/5',(@$info['note'])?$info['note']:""]);?>
                <button class="btn btn-primary">Submit</button>
            </form>
            <?= card('end');?>
        </div>
        <div class="col-md-6">
            <div class="card-container d-none" id="print">
                <img src="<?= base_url(UI['img']."/card-sample.png");?>" class="img-fluid sample">
                <div class="card-content">
                    <div class="card-title">
                        <h3 data-model="title"></h3>
                        <strong data-model="department"></strong>
                    </div>
                    <div class="card-contacts">
                        <h3 data-model="phone"></h3>
                        <strong data-model="email"></strong>
                    </div>
                    <div class="card-address">
                        <p>509 North Main Street <br>Manahawkin, NJ 08050</p>
                    </div>
                </div>
            </div>
            <a href="<?= current_url(); ?>?print=1" class="print btn btn-primary mt-4 ml-3">Print</a>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    window.addEventListener 
        ? window.addEventListener('load',script,false)
        : window.attachEvent && window.attachEvent('onload',script);

    function script() {
        $('.print').on('click', function(e) {
            e.preventDefault();
            var element = document.getElementById('print');
            var opt = {
                margin:       [0.5,0.5],
                filename:     '<?=$info['title']."-".$info['department']."-".date('Y-m-d');?>.pdf',
                image:        { type: 'jpeg', quality: 100 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: [9,5], orientation: 'landscape' }
            };
            html2pdf().set(opt).from(element).save();
        })
        $('input').each(model);
        $('input').on('keyup', model);
        $('.card-container').removeClass('d-none');
        function model() {
            let id = $(this).attr('id'),
                val = $(this).val();
            if ($(`[data-model="${id}"]`).length > 0) $(`[data-model="${id}"]`).html(val);
        }
        $('#emp_card').submit(function(e) {
            e.preventDefault();
            let data = $(this).serializeArray();
            $.post(window.location.href,data,function(res) {
                if ( res.msg ) window.app.flash(res.type,res.msg);
                setTimeout(() => {
                    if ( res.id !== "") window.open(window.location.href+"/"+res.id,'_self');
                }, 1000);
            })
        });
    }
</script>