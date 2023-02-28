<?php
$aData = $content['aData'];
$urlPar = $content['urlPar'];
$filterTable = $content['filterTable'];

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-primary col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#bas" class="nav-link active">Details</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#empTb" class="nav-link">Complain Assigned</a></li>
        </ul>
    </div>
</div>

<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane active" id="bas" role="tabpanel">
                <h2 class="card-title">Complain Details</h2>
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="<?= base_url('assets/images/unk.png') ?>" alt="" class="img-rounded img-responsive profile_img" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <label class="em_name mt-4"> <strong>Customer Name:</strong> <?php echo $aData->CustomerId ?></label>
                                    <div class="minor-details">
                                        <label for=""><strong>Product Name:</strong> <?= $aData->ProductId ?></label> <br />
                                        <label for=""><strong>Complain By:</strong> <?= $aData->ComplainBy ?></label>
                                    </div>
                                    <div>
                                        <?php if (in_array("add complain", $permissions)) { ?>
                                            <a href="<?= base_url('complain/add_complain?q=') . $urlPar ?>" class="btn btn-primary">Edit Complain</a>
                                        <?php }
                                        if (in_array("employee assign", $permissions)) { ?>
                                            <a href="<?= base_url('complain/add_complain_track?q=') . $urlPar ?>" class="btn btn-success">Assign Employee</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <table class="table table-bordered mt-4">
                            <tr>
                                <th>Complain Code</th>
                                <td><?= $aData->ComplainCode ?></td>
                            </tr>
                            <tr>
                                <th>Complain Id</th>
                                <td><?= $aData->CId ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 mt-2">
                        <h5>Complain Status</h5>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-6">
                                <strong>Complain Type</strong>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <label><?= $aData->ComplainType ?></label>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <strong>Complain Status</strong>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <label><?= $aData->ComplainStatus ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-6">
                                <strong>Complain Date</strong>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <label><?= $aData->ComplainDate ?></label>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <strong>Complain Details</strong>
                            </div>
                            <div class="col-md-2 col-sm-6 col-6">
                                <label><?= $aData->ComplainDetails ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 mt-2">
                        <h5>Complain Remarks</h5>
                        <div class="divider"></div>
                        <?php
                        foreach ($filterTable as $key => $value) {
                            $cmDate = '';
                            if ($value->EmployeecommenetDate != null)
                                $cmDate = '(' . explode('T', $value->EmployeecommenetDate)[0] . ')';
                            echo 'Commented By: ' . $value->EmployeeRemarks . $cmDate . ' <div class="divider"></div>';
                        }
                        ?>

                    </div>

                </div>
            </div>

            <div class="tab-pane" id="empTb" role="tabpanel">
                <h2 class="card-title">Complain Assigned</h2>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="salEmpTbl">
                                <thead>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Employee Name</th>
                                    <th>Priority</th>
                                    <th>Complain Date</th>
                                    <th>Status</th>
                                    <th class="all">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($filterTable as $key => $value) { ?>
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
                                            <?php $cmDate = '';
                                            if ($value->EmployeecommenetDate != null)
                                                $cmDate = ' (' . explode('T', $value->EmployeecommenetDate)[0] . ')';
                                            $prevCom = $value->EmployeeRemarks . $cmDate ?>
                                            <td>
                                                <?php if ($value->EmployeeId != null) { ?>
                                                    <button data-stid="<?php echo crmEncryptUrlParameter('cid=' . $value->ComplainId . '&prevCom=' . $prevCom) ?>" data-stat="<?= $value->ComplainStatus ?>" data-rem="<?= $value->EmployeeRemarks ?>" class="btn btn-success btn-sm mt-1 add_com">Update Status</button>
                                                <?php } else {
                                                    echo '<a href="' . base_url('complain/add_complain_track?q=') . $urlPar . '" class="btn btn-success">Assign Employee</a>';
                                                } ?>
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
    </div>
</div>