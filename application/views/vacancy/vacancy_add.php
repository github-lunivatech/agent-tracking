<?php
$jobT = $job_type;
$jobTitle = $job_title;
$startEdit = false;
$saveText = 'Save';
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
        <h5 class="card-title">Add Notice</h5>
        <div class="offset-md-2">
            <form id="noticeForm" action="<?= base_url('vacancy/insertVacancy') ?>" method="post" class="">

                <?php if ($startEdit) : ?>
                    <div class="form-row form-inline">
                        <input type="hidden" name="exD" value="<?php echo crmEncryptUrlParameter('nid=' . $content['NId'] . '&EntryDate=' . $content['EntryDate']) ?>">
                    </div>
                <?php endif; ?>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_titleid" class="col-md-3 col-sm-3 col-xs-12">Job Title<span class="required">*</span> </label>
                        <select name="job_titleid" id="job_titleid" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($jobTitle as $key => $value) { ?>
                                <option value="<?= $value->DId ?>"><?= $value->Designation ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="openings" class="col-md-3 col-sm-3 col-xs-12">Openings</label>
                        <input type="number" name="openings" id="openings" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Openings">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_type" class="col-md-3 col-sm-3 col-xs-12">Job Type</label>
                        <select name="job_type" id="job_type" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($jobT as $key => $value) { ?>
                                <option value="<?= $value->Id ?>"><?= $value->title ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_heading" class="col-md-3 col-sm-3 col-xs-12">Job Heading</label>
                        <input type="text" name="job_heading" id="job_heading" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Job Headings">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_description" class="col-md-3 col-sm-3 col-xs-12">Job Description</label>
                        <textarea name="job_description" id="job_description" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Job Description"></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="job_qualification" class="col-md-3 col-sm-3 col-xs-12">Job Qualification</label>
                        <input type="text" name="job_qualification" id="job_qualification" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Job Qualification">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="expect_salary" class="col-md-3 col-sm-3 col-xs-12">Expected Salary</label>
                        <input type="number" name="expect_salary" id="expect_salary" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Expected Salary">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="deadline" class="col-md-3 col-sm-3 col-xs-12">Deadline</label>
                        <input type="text" name="deadline" id="deadline" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="Deadline">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_description" class="col-md-3 col-sm-3 col-xs-12">Is Active</label>
                        <input type="checkbox" name="is_active" id="is_active" <?= $startEdit ? ($content['IsActive'] != '' ? 'checked' : '') : 'checked' ?>>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm pull-right"><?= $saveText ?></button>
            </form>
        </div>
    </div>
</div>