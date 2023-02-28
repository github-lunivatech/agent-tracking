<?php
$startEdit = false;
$saveText = 'Save';
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Create Lookup</h5>
        <div class="offset-md-2">
            <form id="lookupForm" action="<?= base_url('performance/createLookup') ?>" method="post" class="">

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="title" class="col-md-3 col-sm-3 col-xs-12">Metrics Title</label>
                        <input type="text" name="title" id="title" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Metrics title">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="met_desc" class="col-md-3 col-sm-3 col-xs-12">Metrics Description</label>
                        <input type="text" name="met_desc" id="met_desc" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Metrics description">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="max_point" class="col-md-3 col-sm-3 col-xs-12">Max Point</label>
                        <input type="number" name="max_point" id="max_point" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Max point">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="pass_point" class="col-md-3 col-sm-3 col-xs-12">Pass Point</label>
                        <input type="number" name="pass_point" id="pass_point" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Pass point">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="is_active" class="col-md-3 col-sm-3 col-xs-12">Is Active</label>
                        <input type="checkbox" name="is_active" id="is_active" <?= $startEdit ? ($content['IsActive'] != '' ? 'checked' : '') : 'checked' ?>>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm pull-right"><?= $saveText ?></button>
            </form>
        </div>
    </div>
</div>