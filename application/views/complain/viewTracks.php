<style>
    .inTab,
    .app-main__outer {
        width: 100%;
    }

    .select2-selection.select2-selection--single {
        height: 35px;
    }

    .patientTypeContainer {
        display: flex;
        column-gap: 5%;
    }
</style>
<form action="" id="searchEmp" method="POST">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">From Date</label>
            <input type="text" name="fromDate" id="fromDate" class="form-control" value="<?= set_value('fromDate') ?>" />
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">To Date</label>
            <input type="text" name="toDate" id="toDate" class="form-control" value="<?= set_value('toDate') ?>" />
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">Filter Type</label>
            <?php $cuss = set_value('custId') ?>
            <select name="custId" id="custId" class="form-control" required>
                <option value="">Select</option>
                <option <?= $cuss == 'complainid' ? 'selected' : '' ?> value="complainid">Complain</option>
                <option <?= $cuss == 'employee' ? 'selected' : '' ?> value="employee">Employee</option>
                <option <?= $cuss == 'status' ? 'selected' : '' ?> value="status">Status</option>
                <option <?= $cuss == 'customer' ? 'selected' : '' ?> value="customer">Customer</option>
                <option <?= $cuss == 'projectname' ? 'selected' : '' ?> value="projectname">ProjectName</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">Filter Name</label>
            <select name="ider" id="ider" class="form-control">
            </select>
            <input type="hidden" name="huders" id="huders" value="<?= set_value('ider') ?>" />
            <input type="hidden" name="filName" id="filName" value="<?= set_value('filName') ?>" />
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm search_btn">Search</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" id="doMore">
        <div class="main-card mb-3 card">
            <div class="card-header">View Track</div>
            <div class="card-body">
                <div class="patientTypeContainer">
                    <div>
                        <label for="tblAllPatientTypesFilter" style="float: left;margin-right: 0.5em;">Priority:</label>
                        <select class="" id="tblAllPatientTypesFilter">
                            <option value="">All</option>
                            <!-- <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option> -->
                        </select>
                    </div>
                    <div>
                        <label for="tblStatFilter" style="float: left;margin-right: 0.5em;">Status:</label>
                        <select class="" id="tblStatFilter">
                        </select>
                    </div>
                </div>
                <?php if ($content) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="salEmpTbl">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Employee Name</th>
                                    <th>Priority</th>
                                    <th>Complain Date</th>
                                    <th>Status</th>
                                    <th class="all">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value->CustomerName ?></td>
                                        <td><?= $value->ProductName ?></td>
                                        <td><?= $value->EmployeeName ?></td>
                                        <td><?php
                                            $pri = strtolower($value->PriorityDetails);
                                            $prilab = 'warning';
                                            if ($pri == 'high') {
                                                $prilab = 'danger';
                                            } elseif ($pri == 'medium') {
                                                $prilab = 'primary';
                                            }
                                            echo '<span class="badge badge-' . $prilab . '">' . $pri . '</span>';
                                            ?></td>
                                        <td><?= explode('T', $value->ComplainDate)[0] ?></td>
                                        <td><?php
                                            $pri = strtolower($value->ChangeStatus);
                                            $prilab = 'warning';
                                            if ($pri == 'closed') {
                                                $prilab = 'danger';
                                            } elseif ($pri == 'ongoing') {
                                                $prilab = 'primary';
                                            }
                                            echo '<span class="badge badge-' . $prilab . '">' . $pri . '</span>'; ?></td>
                                        <td>
                                            <a href="<?= base_url('complain/complainProfile?q=') . crmEncryptUrlParameter('CId=' . $value->ComplainId . '&CustomerId=' . $value->CustomerId . '&fromDate=' . $value->ComplainDate) ?>" class="btn btn-secondary btn-sm mt-1">View Profile</a>
                                            <?php if ($value->EmployeeId != null) { ?>
                                                <button data-stid="<?php echo crmEncryptUrlParameter('cid=' . $value->ComplainId) ?>" data-stat="<?= $value->ComplainStatus ?>" data-rem="<?= $value->EmployeeRemarks ?>" class="btn btn-success btn-sm mt-1 add_com">Update Status</button>
                                            <?php } else {
                                                echo '<a href="' . base_url('complain/add_complain_track?q=') . crmEncryptUrlParameter('CId=' . $value->ComplainId . '&ComplainStatus=' . $value->ComplainStatus) . '" class="btn btn-primary btn-sm mt-1">Assign Employee</a>';
                                            } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>