<form action="<?= base_url('crm/viewsalesgoal') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <select name="customerId" id="customerId" class="form-control">
                <option value="0">All</option>
                <?php
                $isSel = set_value('customerId');
                foreach ($pDet as $key => $value) { ?>
                    <option <?= $value->PId == $isSel ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary">Load</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">View Sales Goal Details</div>
            <div class="card-body">
                <div class="">
                <!-- table-responsive -->
                    <table class="table table-bordered table-hover crmdata" id="viewCustDet">
                        <thead>
                            <th>SN</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Project</th>
                            <th>Target Goal</th>
                            <th>Goal Status</th>
                            <th>Is Active</th>
                            <th>Remarks</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            <?php $sn = 1;
                            foreach ($content as $key => $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= explode('T', $value->DateFrom)[0] ?></td>
                                    <td><?= explode('T', $value->DateTo)[0] ?></td>
                                    <td><?= $value->ProjectName ?></td>
                                    <td><?= $value->TargetGoal ?></td>
                                    <td><?= $value->GoalStatus ?></td>
                                    <td><?= $value->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td><?= $value->Remarks ?></td>
                                    <td><?php $allData = 'GId=' . $value->GId .
                                            '&DateFrom=' . $value->DateFrom .
                                            '&DateTo=' . $value->DateTo .
                                            '&ProjectId=' . $value->ProjectId .
                                            '&TargetGoal=' . $value->TargetGoal .
                                            '&GoalStatus=' . $value->GoalStatusId .
                                            '&IsActive=' . $value->IsActive .
                                            '&Remarks=' . $value->Remarks ?>
                                        <a href="<?= base_url('crm/addsalesgoal?q=') . crmEncryptUrlParameter($allData) ?>" class="btn btn-success btn-sm">Edit</a>
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