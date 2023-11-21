<?php if ( !isset($employee) ): include_once('new.php');?>
    
<?php else : ?>

    <form method="post">

<div class="row">
    <div class="col-md-4">
        <?= card('start');?>
        <div class="d-flex align-items-center">
            <div class="mr-3">
                <div class="image">
                    <img src="<?= base_url(UI['upload'].'/'.@$employee['meta']['image']);?>" class="img-lg rounded-circle mb-2" alt="profile image">
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
                    <div class="col-md-3"><?= form_input(['First_Name','First Name','text',@$employee['First_Name']]);?></div>
                    <div class="col-md-3"><?= form_input(['Last_Name','Last Name','text',@$employee['Last_Name']]);?></div>
                    <div class="col-md-3"><?= form_input(['Employee_Name','Employee Name','text',@$employee['Employee_Name']]);?></div>
                    <div class="col-md-3"><?= select(['Title','Title',ROLES,@$employee['Title']]);?></div>
                    <div class="col-md-3"><?= form_input(['Home_Number','Home Number','text',@$employee['Home_Number']]);?></div>
                    <div class="col-md-3"><?= form_input(['Work_Number','Work Number','text',@$employee['Work_Number']]);?></div>
                    <div class="col-md-3"><?= form_input(['Cellular_Number','Cellular Number','text',@$employee['Cellular_Number']]);?></div>
                    <div class="col-md-3"><?= form_input(['StartDate','Start Date','date',date_form(@$employee['StartDate'])]);?></div>
                    <div class="col-md-3"><?= form_input(['TerminationDate','Start Date','date',date_form(@$employee['TerminationDate'])]);?></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stores">Default Location</label>
                            <select id="stores" data-selected="<?= @$employee['DefaultLocation']; ?>" class="select2" name="DefaultLocation"><option></option></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="employees">Supervisor</label>
                            <select id="employees" data-selected="<?= @$employee['SupervisorID']; ?>" class="select2 emps" name="SupervisorID"><option></option></select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Update</button>
        <?= card('end');?>
    </div>
</div>
</form>
<?php endif;?>
<script defer src="<?= base_url(UI["js"]);?>/employee.js"></script>