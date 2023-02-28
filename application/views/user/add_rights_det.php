<?php
$isReg = 'Save';

$rightList = $content;

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Rights Details</h5>
        <div class="offset-md-2">
            <form id="addRightsDetForm" action="<?= base_url('user/add_user_details') ?>" method="post" class="">

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <input type="hidden" name="roid" id="roid">
                        <label for="user_right" class="col-md-3 col-sm-3 col-xs-12">User Right<span class="required">*</span> </label>
                        <input type="text" name="user_right" id="user_right" value="" class="form-control col-md-6 col-sm-6 col-xs-12">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="right_description" class="col-md-3 col-sm-3 col-xs-12">Right Description</label>
                        <textarea name="right_description" id="right_description" class="form-control col-md-6 col-sm-6 col-xs-12"></textarea>
                    </div>
                </div>

                <button type="reset" id="resetter" class="mt-2 mr-2 btn btn-light pull-right">Reset</button>
                <button type="submit" id="saver" class="mt-2 mr-2 btn btn-primary pull-right"><?= $isReg ?></button>

            </form>

        </div>
    </div>
</div>

<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">View / Edit Right Details</h5>
    </div>
    <div class="">
        <table class="table table-hover table-bordered viewMaxTestEdit">
            <thead>
                <th>SN</th>
                <th>User Right</th>
                <th>Right Description</th>
                <th>Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>