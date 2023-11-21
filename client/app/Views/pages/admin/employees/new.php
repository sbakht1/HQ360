<form action="" method="post" id="new_emp">
<div class="row">
    <div class="col-md-6">
        <?= card('start');?>
            <h2>Basic Information</h2>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= form_input(['First_Name','First Name*','text','']);?></div>
                <div class="col-md-6"><?= form_input(['Last_Name','Last Name*','text','']);?></div>
                <div class="col-md-6"><?= form_input(['Employee_Name','Employee Name*','text','']);?></div>
                <div class="col-md-6"><?= select2(['Title','Title*',ROLES,'']);?></div>
            </div>
        <?= card('end');?>
    </div>
    <div class="col-md-6">
        <?= card('start');?>
            <h2>Contact Information</h2>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= form_input(['Email','Employee Email*','email','']);?></div>
                <div class="col-md-6"><?= form_input(['Home_Number','Home Number','tel','']);?></div>
                <div class="col-md-6"><?= form_input(['Work_Number','Work Number*','tel','']);?></div>
                <div class="col-md-6"><?= form_input(['Cellular_Number','Cellular Number*','tel','']);?></div>
            </div>
        <?= card('end');?>
    </div>

    <div class="col-md-6 mt-4">
        <?= card('start');?>
            <h2>Employement Information</h2>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= form_input(['StartDate','Start Date*','date','']);?></div>
                <div class="col-md-6"><?= selection(['DefaultLocation','Default Location*','stores','']);?></div>
                <div class="col-md-6"><?= selection(['SupervisorID','Supervisor','emps','']);?></div>
                <div class="col-md-6"><?= form_input(['UID','UID','text','']);?></div>
                <div class="col-md-4"><?= form_input(['SisenseGroup','SisenseGroup','text','']);?></div>
                <div class="col-md-4"><?= form_input(['BellSouthUID','BellSouthUID','text','']);?></div>
                <div class="col-md-4"><?= form_input(['ADPFileNumber','ADPFileNumber','text','']);?></div>
            </div>
        <?= card('end');?>
    </div>

    <div class="col-md-3 mt-4">
        <?= card('start');?>
            <h2>Login Information</h2>
            <hr>
            <div class="row">
                <div class="col-md-12"><?= form_input(['Username','Username*','text','']);?></div>
                <div class="col-md-12"><?= form_input(['password','Password*','password','']);?></div>
                <div class="col-md-12"><?= form_input(['confirm_password','Confirm Password*','password','']);?></div>
            </div>
        <?= card('end');?>
    </div>
</div>
<input type="button" id="btn_submit" disabled="disabled"  value="Save Employee" class="subBtn btn btn-primary btn-lg mt-4"/>
<!-- <button disabled="disabled" id="btn_submit" class="subBtn btn btn-primary btn-lg mt-4">Save Employee</button> -->
</form>
<!-- 
<script>
    window.addEventListener ? 
    window.addEventListener("load",script,false) : 
    window.attachEvent && window.attachEvent("onload",script);
function script() {
    let form = $('#new_emp'),
        required = form.find('.text-danger');
    required.each(function() {
       // $(this).parent().parent().addClass('required');
    })

    $('.required [name]').on('blur', function () {
        var val = $(this).val();
        if ( $.trim(val) == "") {
            $('.subBtn').attr('disabled','disabled');
        } else {
            //$(ids).text('');
            validate();
        }
    });

    $(`[name="confirm_password"]`).on('keyup', function() {
        let pass = $('[name="password"]').val();
        $('.tmp_err').remove();
        if ( pass != $(this).val() ) {
            $('.subBtn').attr('disabled','disabled');
            $(this).after(err('Password did not match.'));
        } else {
            validate();
        }
    })

    function err(msg) { return `<span class="tmp_err text-danger">${msg}</span>`;}
    function validate() {
        let req = $('.required [name]'),
            imp = {},
            validation = true;
        $('.tmp_err').remove();
        req.each(function (e) {
            imp[$(this).attr('name')] = $(this).val();
            var val = $(this).val();
            if ( $.trim(val) == "") { validation = false; }
        });

        if (validation) {
            let email = {name:"Email",value:imp.Email},
                user = {name:'Username',value:imp.Username};
            $.post(window.app.url+'/check/employee',email, function(em) {
                if ( em === 'false' ) $('#Email').after(err('This Email already Exist.'));
                $.post(window.app.url+'/check/employee',user, function(us) {
                    if ( us === 'false' ) $('#Username').after(err('This Username is already Exist.'));
                    if (em=='true' && us=='true') {
                        $('.subBtn').removeAttr('disabled');
                    } else {
                        $('.subBtn').attr('disabled','disabled');
                    }
                })
            })
        }
    }
}
</script> -->