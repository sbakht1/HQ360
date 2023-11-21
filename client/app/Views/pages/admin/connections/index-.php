<?php $role = user_data('Title')[1]?>
<?php if($role !== "inventory" && $role !== 'it'):?>
<div class="actions text-right">
    <a href="<?= base_url(user_data('Title')[1].'/connections/new');?>" class="btn btn-primary">Add New</a>
    <?php if($role == 'admin'): ?>
        <a href="<?= base_url(user_data('Title')[1].'/connections/form');?>" class="btn btn-outline-primary">Edit Form</a>
    <?php endif;?>
</div>
<?php endif;?>
<div class="card">
    <div class="card-body">

    <table class="table">
    <thead>
        <th>Date</th>
        <th>Store</th>
        <th>Employee</th>
        <th>Submitted By</th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($connections as $x): ?>
            <tr>
                <td><span class="moment" data-time="<?= $x->date;?>" data-form="ll"></span></td>
                <td><?= $x->store;?></td>
                <td><?= $x->employee;?></td>
                <td><?= $x->submit_by;?></td>
                <td>
                    <a href="<?= base_url(user_data('Title')[1].'/connections/'.$x->id);?>" class="badge badge-warning badge-pill">View More</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>