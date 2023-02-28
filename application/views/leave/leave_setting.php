<?php
$isReg = 'Register';
$lGroup = $leaveTypes['lGroup'];
$lHead = $leaveTypes['lHead'];
$llType = $leaveTypes['llType'];

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Leave Settings</h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('leave/insertedSet') ?>" method="post" class="">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="leave_type" class="col-md-3 col-sm-3 col-xs-12">Leave Type<span class="required">*</span> </label>
                        <select name="leave_type" id="leave_type" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <?php foreach ($llType as $key => $value) {
                                // LtId 
                            ?>
                                <option value="<?= $value->LeaveType ?>"><?= $value->LeaveType ?></option>
                            <?php } ?>
                        </select>
                        <!-- <input id="leave_type" type="text" name="leave_type" class="form-control col-md-6 col-sm-6 col-xs-12" value="" required> -->
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="leave_count" class="col-md-3 col-sm-3 col-xs-12">Leave Count<span class="required">*</span> </label>
                        <input id="leave_count" type="number" name="leave_count" class="form-control col-md-6 col-sm-6 col-xs-12" value="" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="leave_group" class="col-md-3 col-sm-3 col-xs-12">Leave Group<span class="required">*</span> </label>
                        <select name="leave_group" id="leave_group" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <?php foreach ($lGroup as $key => $value) { ?>
                                <option value="<?= $value->GId ?>"><?= $value->LeaveGroup ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="leave_head" class="col-md-3 col-sm-3 col-xs-12">Leave Head<span class="required">*</span> </label>
                        <select name="leave_head" id="leave_head" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <?php foreach ($lHead as $key => $value) { ?>
                                <option value="<?= $value->LhId ?>"><?= $value->LeaveHead ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <button type="submit" id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
            </form>
        </div>
    </div>
</div>