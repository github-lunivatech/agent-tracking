<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Add public holidays</h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('holiday/insertPublicHoliday') ?>" method="post" class="">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="fiscal_year" class="col-md-3 col-sm-3 col-xs-12">Fiscal Year<span class="required">*</span> </label>
                        <input id="fiscal_year" type="text" name="fiscal_year" class="form-control col-md-5 col-sm-6 col-xs-12" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="holiday_date" class="col-md-3 col-sm-3 col-xs-12">Holiday Date<span class="required">*</span> </label>
                        <input id="holiday_date" type="text" name="holiday_date" class="form-control col-md-5 col-sm-6 col-xs-12" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Holiday Remarks<span class="required">*</span> </label>
                        <textarea name="holiday_remarks" id="holiday_remarks" class="form-control col-md-5 col-sm-6 col-xs-12"></textarea>
                    </div>
                </div>

                <!-- <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3"> -->
                        <button class="btn btn-primary btn-sm pull-right">Save</button>
                    <!-- </div>
                </div> -->
            </form>
        </div>
    </div>
</div>