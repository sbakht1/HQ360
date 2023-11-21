<div class="mb-4">
<a href="<?= base_url('admin/settings/add');?>" class="btn btn-primary">Add New</a>
</div>
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Info</th><th></th></tr>
                </thead>
                <tbody>
                    <?php foreach($settings as $set) : ?>
                        <tr>
                            <td><?= $set['id']; ?></td>
                            <td><?= $set['name'];?></td>
                            <td><?= $set['info']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/settings/'.$set['id']);?>" class="badge badge-warning badge-pill">Edit</a>
                                <a href="<?= base_url('admin/settings/del/'.$set['id']);?>" class="badge badge-danger badge-pill">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>