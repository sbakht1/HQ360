<div class="row">
    <div class="col-md-4">
    <form class="modal-content" method="post" action="<?= base_url('admin/stores/import');?>" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-3">Upload Employees CSV File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?= form_file(['stores','Store CSV File','.csv']);?>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Import</button>
    </div>
</form>

    </div>
</div>