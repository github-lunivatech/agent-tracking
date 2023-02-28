<?php
$depar = $allData['depar'];
$desDet = $allData['desDet'];
$empYList = $allData['empYList'];
$empLList = $allData['empLList'];
$dataList = $allData['dataList'];
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<form action="<?= base_url('employeelevel/empLevelSalaryList') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label for="departId">Department</label>
            <select name="departId" id="departId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($depar as $key => $value) { ?>
                    <option <?= set_select('departId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->DepartmentName ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <label for="levelid">Level</label>
            <select name="levelid" id="levelid" class="form-control">
                <option value="">Select</option>
                <?php foreach ($empLList as $key => $value) { ?>
                    <option <?= set_select('levelid', $value->LId) ?> value="<?= $value->LId ?>"><?= $value->LevelCode ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <label for="yearId">Year</label>
            <select name="yearId" id="yearId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($empYList as $key => $value) { ?>
                    <option <?= set_select('yearId', $value->YId) ?> value="<?= $value->YId ?>"><?= $value->EmployeeYear ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <label for="designation">Designation</label>
            <select name="designation" id="designation" class="form-control">
                <option value="">Select</option>
                <?php foreach ($desDet as $key => $value) { ?>
                    <option <?= set_select('designation', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->Designation ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <label for=""></label>
            <button class="btn btn-primary btn-sm mt-4">Search</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Salary Level List</div>
            <div class="card-body">
            <a href="<?= base_url('employeelevel/empLevelSalaryListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Level Salary</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>LId</th>
                            <th>Basic Salary</th>
                            <th>Entry Date</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($dataList as $value) { ?>
                                <tr>
                                    <td><?= $value->LId ?></td>
                                    <td><?= $value->BasicSalary ?></td>
                                    <td><?= explode('T', $value->EntryDate)[0] . '<br>' . $value->NepaliDate ?></td>
                                    <td><?= $value->IsActive == true ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td>
                                        <a href="<?= base_url('employeelevel/empLevelSalaryListAdd?q=' . crmEncryptUrlParameter(
                                                        'lid=' . $value->LId .
                                                            '&DepartmentId=' . $value->DepartmentId .
                                                            '&DesignationId=' . $value->DesignationId .
                                                            '&LevelId=' . $value->LevelId .
                                                            '&YearId=' . $value->YearId
                                                    )) ?>" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>