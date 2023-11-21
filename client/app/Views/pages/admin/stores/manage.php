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
<section class="single-store">
<div class="row">
    <div class="col-md-4">
        <?= card('start');?>
        <form method="post"  enctype="multipart/form-data">
        <div class="d-flex">
            <div class="img">
                <label for="img">
                    <span id="img_pre" style="background-image:url(<?= base_url(UI['upload'].'/'.$store['image']).'?'.time();?>)" class="img-lg rounded-circle"></span>
                    <?php if($role !== 'inventory' && $role !== 'it'): ?>
                    <span class="upload-icon">
                        <i class="fa-solid fa-pencil"></i>
                    </span>
                    <?php endif;?>
                </label>
                <?php if($role !== 'inventory' && $role !== 'it'): ?>
                <input type="file" name="image" accept="image/*" style="display:none" id="img">
                <?php endif;?>
            </div>
            <div class="text ml-4 d-flex items-center">
                <div>
                    <h4><span><?= $store['StoreName'];?></span></h4>
                    <p><?= $store['Address'];?></p>
                </div>
            </div>
        </div>
        <table class="table store-info">
            <tr>
                <th>Store Status</th>
                <td><?= checkbox(['Enabled', 'Enabled', (@$store['Enabled']=='TRUE')?'checked':''],'TRUE');?></td>
            </tr>
            <tr>
                <th>Store Name</th>
                <td><input type="text" name="StoreName" value="<?= $store['StoreName'];?>"></td>
            </tr>
            <tr><th>Address</th><td><textarea name="Address" rows="3"><?=$store['Address']?></textarea></td></tr>
            <tr><th>IP Address</th><td><input name="IPAddress" type="text" value="<?=$store['IPAddress']?>" /></td></tr>
            <tr><th>Long Name</th><td><textarea name="LongName" rows="3"><?=$store['LongName']?></textarea></td></tr>
            <tr><th>City</th><td><input name="City" type="text" value="<?=$store['City']?>" /></td></tr>
            <tr><th>Zip</th><td><input name="Zip" type="text" value="<?=$store['Zip']?>" /></td></tr>
            <tr><th>Plaza Name</th><td><input name="PlazaName" type="text" value="<?=$store['PlazaName']?>" /></td></tr>
            <tr>
                <th>Store Team Leader</th>
                <td>
                    <select data-selected="<?= (gettype($store['ManagerID']) == 'array') ? $store['ManagerID']['EmployeeID']:""; ?>" class="emps" name="ManagerID"><option></option></select>
                </td>
            </tr>
            <tr>
                <th>District Team Leader</th>
                <td>
                    <select data-selected="<?= (gettype($store['DMID']) == 'array') ? $store['DMID']['EmployeeID']:""; ?>" class="emps" name="DMID"><option></option></select>
                </td>
            </tr>
            <tr>
                <th>Regional Team Leader</th>
                <td>
                    <select data-selected="<?= (gettype($store['RMID']) == 'array') ? $store['RMID']['EmployeeID']:""; ?>" class="emps" name="RMID"><option></option></select>
                </td>
            </tr>
            <tr><th>Opus ID</th><td><?=$store['OpusId']?></td></tr>
            <tr><th>Notification Phone</th><td><input name="SystemNotificationPhoneNumber" type="text" value="<?=$store['SystemNotificationPhoneNumber']?>" /></td></tr>
            <?php if ($role !== 'inventory' && $role !== 'it'):?>
            <tr><td colspan="2">
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </td></tr>
            <?php endif;?>
        
        </table>
        </form>
        <?= card('end');?>
    </div>

    <div class="col-md-8 store-imployees">
        <?= card('start');?>
        <h2 class="mb-4"><?= $store['StoreName'];?> Employees</h2>
        <hr>
        <div class="row">
            <?php foreach($store['employees']['Enabled'] as $emp): ?>
            <div class="col-md-4 mb-4">
                <a class="d-flex" href="<?=base_url('admin/employees/'.$emp->id);?>">
                    <div class="img">
                        <img src="<?= base_url(UI['upload'].'/'.$emp->image);?>" class="img-lg rounded-circle mb-2" alt="profile image">
                    </div>
                    <div class="text ml-3 d-flex align-items-center">
                        <div>
                            <h5><?= $emp->Employee_Name;?></h5>
                            <p><?= $emp->Title;?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach;?>
        </div>
        <?= card('end');?>        
    </div>
</div>
</section>

<script>
window.addEventListener?window.addEventListener('load',script,false):window.attachEvent && window.attachEvent('onload',script);
function script() {
    <?php if ($role === 'inventory' || $role === 'it'): ?>
        let x = setInterval(function(){
        if ($('.select2-hidden-accessible').length > 0) {
            $('.select2-hidden-accessible').select2("enable", false);
            clearInterval(x);
        }
        }, 1000);
        $('input,textarea').attr('disabled','disabled');
        <?php else: ?>
            let img = document.getElementById('img')
            img.onchange = evt => {
                const [file] = img.files
                if (file) {
                    document.getElementById('img_pre').src = URL.createObjectURL(file)
                }
            }
    <?php endif;?>
}

</script>