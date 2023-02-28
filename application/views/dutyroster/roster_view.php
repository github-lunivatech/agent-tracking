<?php
$startEdit = false;
$saveText = 'Save';
$depar = $depart;
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<form action="<?= base_url('roster/roster_view') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <select name="jobId" id="jobId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($depar as $key => $value) { ?>
                    <option <?= set_select('jobId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->DepartmentName ?></option>
                <?php } ?>
            </select>
        </div>
        <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
            <input type="hidden" readonly name="from" id="from" class="form-control" value="<?= set_value('from') ?>">
        <!-- </div> -->
        <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
            <input type="hidden" readonly name="to" id="to" class="form-control" value="<?= set_value('to') ?>">
        <!-- </div> -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <select type="text" name="week_sel" id="week_sel" class="form-control" required>
                <option value="">Select</option>
                <?php foreach ($week as $key => $value) { ?>
                    <option <?= set_select('week_sel', $value->Id) ?> value="<?= $value->Id ?>"><?= $value->title ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary btn-sm">Search</button>
    </div>
</form>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">View Duty Roster</h5>
        <button id="print_roster" class="btn btn-light mb-2">Print</button>
        <div class="table-responsive duty_roster_table">
                <table class="table table-hover duty_roster">
                    <thead>
                        <th>Name</th>
                        <th>Department</th>
                        <th class="0_Name">Sun<br /><span></span></th>
                        <th class="1_Name">Mon<br /><span></span></th>
                        <th class="2_Name">Tue<br /><span></span></th>
                        <th class="3_Name">Wed<br /><span></span></th>
                        <th class="4_Name">Thu<br /><span></span></th>
                        <th class="5_Name">Fri<br /><span></span></th>
                        <th class="6_Name">Sat<br /><span></span></th>
                    </thead>
                    <tbody>
                        <!-- <?php foreach ($roster as $key => $value) { ?>
                            <tr>
                                <td><?= $value->EmployeeName ?></td>
                                <td><?= $value->Department ?></td>
                                <td><?= explode('T', $value->DutyDate)[0] ?></td>
                                <td><?= $value->Duty_Shift ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?> -->
                    </tbody>
                </table>
        </div>
    </div>
</div>