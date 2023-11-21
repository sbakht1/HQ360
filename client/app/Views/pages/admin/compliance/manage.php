<style>
    .table td {word-break:break-word;}
</style>
<div class="row">
    <div class="col-md-3">
        <?= card('start');?>

        <div class="text-center">
            <div class="mr-3">
                <div class="image">
                    <img src="<?= base_url(UI['upload'].'/'.@$emp_info['image']);?>" class="img-lg rounded-circle mb-2" alt="profile image">
                </div>
            </div>
            <div class="text">
                <h4><span><?= @$emp_info['Employee_Name'];?></span></h4>
                <p><?= @$emp_info['Title'];?></p>
            </div>
        </div>
        <div>
            <div>
                <b>Market</b><br>
                <span><?= @$courses[0]['market'];?></span>
            </div>
            <hr>
            <div>
                <b>Store</b><br>
                <span><?= @$courses[0]['location'];?></span>
            </div>
            <hr>
            <div>
                <b>AT&T UID</b><br>
                <span><?= @$courses[0]['attuid'];?></span>
            </div>
            <hr>
            <div>
                <b>Employee ID</b><br>
                <span><?= @$emp_info['EmployeeID'];?></span>
            </div>
            <hr>
            <div>
                <b>Username</b><br>
                <span><?= @$emp_info['Username'];?></span>
            </div>
            <hr>
            <div>
                <b>Employee Email</b><br>
                <span><?= @$emp_info['Email'];?></span>
            </div>
            <hr>
            <div>
                <b>Account Status</b><br>
                <span><?= (strtolower($emp_info['Account_Disabled']) == 'false') ?"Active":"Disable";;?></span>
            </div>
        </div>
        <?= card('end');?>
    </div>
    <div class="col-md-9">
        <?= card('start');?>
        <?php if (sizeof($courses) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Code</th>
                        <th>Course Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($courses as $c) :?>
                        <tr>
                            <td><?= $c['training_section'];?></td>
                            <td><?= $c['course_code'];?></td>
                            <td><?= $c['course_name'];?></td>
                            <td><?= $c['course_status'];?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php else: ?>
                <strong>You have no course to complete!</strong>
            <?php endif;?>
        <?= card('end');?>
    </div>
</div>
