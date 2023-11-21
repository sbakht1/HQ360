
<?php 
$role = user_data('Title')[1];

?>

<style>
label[for="img"] {position:relative;overflow:hidden}
.upload-icon {display:flex;position:absolute;opacity:0;top:-10%;bottom:0;left:0;right:0;align-items:center;justify-content:center;font-size:24px;background-color:rgb(15 60 122 / 0.8);border-radius:50%;color:#fff;transition:.5s ease 0s;cursor:pointer;}
label:hover .upload-icon {top:0;opacity:1;}
img#img_pre {padding:0;margin:0!important}
.img-lg {background-size:cover;background-position:center;background-color:#eee;background-repeat:no-repeat;display: inline-block;}
</style>
<?php if ( !isset($employee) ): include_once('new.php');?>

<?php else : ?>

<form method="post" id="new_emp">

<div class="row">

<div class="col-md-4">
    <?= card('start');?>
    <div class="d-flex align-items-center">
        <div class="mr-3">
        <div>
            <label for="img">
                <span id="img_pre" style="background-image:url(<?= base_url(UI['upload'].'/'.@$employee['meta']['image']).'?'.time();?>)" class="img-lg rounded-circle"></span>
                <?php if($role !== 'inventory' && $role !== 'it'): ?>
                <span class="upload-icon">
                    <i class="fa-solid fa-pencil"></i>
                </span>
                <?php endif;?>
            </label>
            <?php if($role !== 'inventory'): ?>
                <input type="file" name="image" accept="image/*" style="display:none" id="img">
            <?php endif;?>
        </div>
        </div>
        <div class="text">
            <h4><span><?= @$employee['Employee_Name'];?></span></h4>
            <p><?= @$employee['Title'];?></p>
        </div>
    </div>

    <table class="table">
        <tr><th>Email</th><td><small><?= @$employee['Email'];?></small></td></tr>
        <tr><th>Username</th><td><?= @$employee['Username'];?></td></tr>
        <tr><th>Employee ID</th><td><?= @$employee['EmployeeID'];?></td></tr>
        <tr><th>UID</th><td><?= (@$employee['UID'] == "") ? "NOT FOUND":@$employee['UID'];?></td></tr>
        <tr><th>Sisense Group</th><td><?= (@$employee['SisenseGroup'] == "") ? "NOT FOUND":@$employee['SisenseGroup'];?></td></tr>
        <tr><th>Bell South UID</th><td><?= (@$employee['BellSouthUID'] == "") ? "NOT FOUND":@$employee['BellSouthUID'];?></td></tr>
        <tr><th>ADP File Number</th><td><?= (@$employee['ADPFileNumber'] == "") ? "NOT FOUND":@$employee['ADPFileNumber'];?></td></tr>
    </table>
    <?= card('end');?>
</div>
<div class="col-md-8">
    <?= card('start');?>

    <div class="row">
                <?php if ( @$employee['Email'] ): ?>
                <?php endif;?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Account Status</label>
                        <?= checkbox(['Account_Disabled', 'Disabled', (@$employee['Account_Disabled']=='TRUE')?'checked':''],'TRUE');?>
                    </div>
                </div>
                <div class="col-md-3"><?= form_input(['First_Name','First Name*','text',@$employee['First_Name']] );?></div>
                <div class="col-md-3"><?= form_input(['Last_Name','Last Name*','text',@$employee['Last_Name']]);?></div>
                <div class="col-md-3"><?= form_input(['Employee_Name','Employee Name*','text',@$employee['Employee_Name']]);?></div>
                <div class="col-md-3"><?= select(['Title','Title',ROLES,@$employee['Title']]);?></div>
                <div class="col-md-3"><?= form_input(['Home_Number','Home Number','text',@$employee['Home_Number']]);?></div>
                <div class="col-md-3"><?= form_input(['Work_Number','Work Number','text',@$employee['Work_Number']]);?></div>
                <div class="col-md-3"><?= form_input(['Cellular_Number','Cellular Number','text',@$employee['Cellular_Number']]);?></div>
                <div class="col-md-3"><?= form_input(['StartDate','Start Date','date',date_form(@$employee['StartDate'])]);?></div>
                <div class="col-md-3"><?= form_input(['TerminationDate','Termination Date','date',date_form(@$employee['TerminationDate'])]);?></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stores">Default Location</label>
                        <select id="stores" data-selected="<?= @$employee['DefaultLocation']; ?>" class="stores" name="DefaultLocation"><option></option></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="employees">Supervisor</label>
                        <select id="employees" data-selected="<?= @$employee['SupervisorID']; ?>" class="emps" name="SupervisorID"><option></option></select>
                    </div>
                </div>
            </div>
            <?php if ($role !== 'inventory'&& $role !== 'it'):?>
                <button class="subBtn btn btn-primary">Update</button>
            <?php endif;?>
    <?= card('end');?>
</div>
</div>
</form>
<?php endif;?>
<script defer src="<?= base_url(UI["js"]);?>/employee.js"></script>
<script>

window.addEventListener?window.addEventListener('load',script,false):window.attachEvent && window.attachEvent('onload',script);


function script() {

    <?php if(@$employee['TerminationDate'] === ""): ?>
        $('#TerminationDate').val("");
    <?php endif;?>

    $("#btn_submit").on("click", function (e) {
        let req = $('.required [name]'),
        imp = {},
            validation = true;
        req.each(function (e) {
            imp[$(this).attr('name')] = $(this).val();
        });

        let email = {name:"Email",value:imp.Email},
        user =  {name:'Username',value:imp.Username};
        $.post(window.app.url+'/check/employee',email, function(em) {
        $('.tmp_err').remove();
            if ( em === 'false' ) $('#Email').after(err('This Email already Exist.'));
            $.post(window.app.url+'/check/employee',user, function(us) {
                if ( us === 'false' ) $('#Username').after(err('This Username is already Exist.'));
                if (em=='true' && us=='true') {
                    $('.subBtn').removeAttr('disabled');
                    $("#new_emp").submit();
                } else {
                    
                    $('.subBtn').attr('disabled','disabled');
                    return false;
                }
            });
        });
    });


    $('span[id*="error_"]').each(function() { $(this).remove();});
    let form = $('#new_emp'),
        required = form.find('.text-danger');
        required.each(function() {
        $(this).parent().parent().addClass('required');
        $(this).parent().parent().append(err(''));
    })

$('.required [name]').on('blur', function () {
    var val = $(this).val();
    if ( $.trim(val) == "") {
        $(this).parent().find('.tmp_err').html('This field is required.');
    } else {
        $(this).parent().find('.tmp_err').html('');
    }
    (!validate())
        ? $('.subBtn').attr('disabled','disabled')
        : $('.subBtn').removeAttr('disabled');
});

    $(`[name="confirm_password"]`).on('blur', function() {
        let pass = $('[name="password"]').val();
        //$('.tmp_err').remove();
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
    req.each(function (e) {
        imp[$(this).attr('name')] = $(this).val();
        var val = $(this).val();
        if ( $.trim(val) == "") { validation = false; }
    });


    // if (validation) {
    //     let email = {name:"Email",value:imp.Email},
    //      user =  {name:'Username',value:imp.Username};

    //      $.post(window.app.url+'/check/employee',email, function(em) {
    //         $('.tmp_err').remove();
    //             if ( em === 'false' ) $('#Email').after(err('This Email already Exist.'));
    //             $.post(window.app.url+'/check/employee',user, function(us) {
    //                 if ( us === 'false' ) $('#Username').after(err('This Username is already Exist.'));
    //                 if (em=='true' && us=='true') {
    //                     $('.subBtn').removeAttr('disabled');
    //                 } else {
    //                     $('.subBtn').attr('disabled','disabled');
    //                 }
    //             });
    //         });
    // }


    return validation;
}


<?php if ($role !== 'inventory' && $role !== 'it'): ?>
let img = document.getElementById('img')
img.onchange = evt => {
    const [file] = img.files
    if (file) {
        document.getElementById('img_pre').src = URL.createObjectURL(file);
        var formData = new FormData();
        formData.append('img', $('#img')[0].files[0]);
        formData.append('name', '<?= @$employee['EmployeeID'];?>');
    
        $.ajax({
            url : window.app.url+'/'+window.app.role+'/employees/upload',
            type : 'POST',
            data : formData,
            processData: false,
            contentType: false,
            success : function(data) {
                if (data.success) window.app.flash("success",data.message);
            }
        });
    }
}
<?php else : ?>
    $('input,textarea,select').attr('disabled','disabled');
    let x = setInterval(function(){
    if ($('.select2-hidden-accessible').length > 0) {
        $('.select2-hidden-accessible').select2("enable", false);
        clearInterval(x);
    }
}, 1000);
<?php endif;?>
}
</script>