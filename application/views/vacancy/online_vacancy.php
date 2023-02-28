<?php
$startEdit = false;
$jobTitle = $job_title;
$saveText = 'Apply';
if ($content != []) {
    $startEdit = true;
    $saveText = 'Update';
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Apply</h5>
        <div class="offset-md-2">
            <form id="applyVacancy" action="<?= base_url('vacancy/applyVacancy') ?>" method="post" class="">

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="applicant_name" class="col-md-3 col-sm-3 col-xs-12">Applicant Name</label>
                        <input type="text" name="applicant_name" id="applicant_name" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Applicant Name" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_id" class="col-md-3 col-sm-3 col-xs-12">Apply For</label>
                        <select name="job_id" id="job_id" class="form-control col-md-5 col-sm-6 col-xs-12" required>
                            <option value="">Select</option>
                            <?php foreach ($jobTitle as $key => $value) { ?>
                                <option value="<?= $value->DId ?>"><?= $value->Designation ?></option>
                            <?php } ?>     
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="app_address" class="col-md-3 col-sm-3 col-xs-12">Applicant Address</label>
                        <input type="text" name="app_address" id="app_address" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Applicant Address" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="app_conno" class="col-md-3 col-sm-3 col-xs-12">Applicant Contact No</label>
                        <input type="text" name="app_conno" id="app_conno" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Applicant contact no" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="app_email" class="col-md-3 col-sm-3 col-xs-12">Applicant Email</label>
                        <input type="email" name="app_email" id="app_email" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Applicant Email">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="app_qualification" class="col-md-3 col-sm-3 col-xs-12">Applicant Qualification</label>
                        <input type="text" name="app_qualification" id="app_qualification" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Application Qualification" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="applicant_image" class="col-md-3 col-sm-3 col-xs-12">Applicant Image</label>
                        <input type="file" name="applicant_image" id="applicant_image">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="applicant_cv" class="col-md-3 col-sm-3 col-xs-12">CV</label>
                        <input type="file" name="applicant_cv" id="applicant_cv">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="applicant_cover" class="col-md-3 col-sm-3 col-xs-12">Cover Letter</label>
                        <input type="file" name="applicant_cover" id="applicant_cover">
                    </div>
                </div>

                <button class="btn btn-primary btn-sm pull-right saver_bu"><?= $saveText ?></button>
            </form>
        </div>
    </div>
</div>