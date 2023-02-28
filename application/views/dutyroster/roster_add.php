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
<form action="<?= base_url('roster/roster_add') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <select name="jobId" id="jobId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($depar as $key => $value) { ?>
                    <option <?= set_select('jobId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->DepartmentName ?></option>
                <?php } ?>
            </select>
        </div>
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
<p>Note:- This is used for inserting only. Please go to <a href="<?= base_url('roster/roster_view') ?>">this</a> for viewing full data</p>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Duty Roster</h5>
        <div class="table-responsive">
            <form id="rosterForm" action="<?= base_url('roster/insertRoster') ?>" method="post" class="">
                <table class="table table-hover">
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
                        <!-- <th>Action</th> -->
                    </thead>
                    <tbody>
                        <?php foreach ($roster as $key => $value) { 
                            $a = $key;
                            ?>
                            <tr class="row_<?= $a ?>">
                                <td>
                                    <?= $value->EmployeeName ?>
                                    <input type="hidden" name="exD[]" value="<?= crmEncryptUrlParameter('eid='.$value->EId) ?>">
                                </td>
                                <td><?= $value->Department ?></td>
                                <?php
                                for ($i=0; $i < 7; $i++) { ?>
                                    <td>
                                        <select name="shiftSel[]" class="<?= $i.'_day' ?>" data-row="row_<?= $a ?>">
                                            <option value="">Select</option>
                                            <?php foreach ($shift as $key => $value) { ?>
                                                <option value="<?= $value->DId ?>"><?= $value->Dutyshift ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                <?php } ?>
                                <!-- <td>
                                    <button class="btn btn-success btn-sm">Save</button>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>