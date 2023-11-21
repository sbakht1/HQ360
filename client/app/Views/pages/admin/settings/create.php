<div class="mb-4">
    <a href="<?= base_url('/admin/settings');?>" class="btn btn-outline-primary">Go Back</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <?= form_input(['name','Name','text',@$set['name']]); ?>
                    <?= form_input(['info','Info','text',@$set['info']]); ?>
                    <?= form_input(['content','Content','textarea/10',@$set['content']]); ?>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>