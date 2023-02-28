<form action="<?= base_url('crm/view_det') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <select name="customerId" id="customerId" class="form-control">
                <option value="0">All</option>
                <?php
                $nowVal = set_value('customerId');
                foreach ($CustId as $key => $value) {
                    //if ($value->IsActive) { 
                ?>
                    <option <?= $nowVal == $value->CId ? 'selected' : '' ?> value="<?= $value->CId ?>"><?= $value->CustomerName ?></option>
                <?php //}
                } ?>
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
            <div class="card-header">View Customer Details</div>
            <div class="card-body">

                <div class="">
                    <!-- table-responsive -->
                    <table class="table table-bordered table-hover crmdata" id="viewCustDet">
                        <thead>
                            <th>SN</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Is Active</th>
                            <th>Status</th>
                            <th>Entry Date</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 1;
                            foreach ($content as $key => $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $value->CustomerName ?></td>
                                    <td><?= $value->CustomerAddress ?></td>
                                    <td><?= $value->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td><?php $badger = 'secondary';
                                        $customerStatt = $value->CustomerStatus;
                                        if ($customerStatt == 2) {
                                            $badger = 'info';
                                        } elseif ($customerStatt == 3) {
                                            $badger = 'dark';
                                        } elseif ($customerStatt == 4) {
                                            $badger = 'warning';
                                        } elseif ($customerStatt == 5) {
                                            $badger = 'success';
                                        } elseif ($customerStatt == 6 || $customerStatt == 7) {
                                            $badger = 'danger';
                                        }
                                        echo '<span class="badge badge-' . $badger . '">' . $value->CustomerCurrentStatus . '</span>' ?>
                                    </td>
                                    <td><?= explode('T', $value->EntryDate)[0] ?></td>
                                    <td>
                                        <a href="<?= base_url('crm/viewProfile?q=') . crmEncryptUrlParameter('cid=' . $value->CId) ?>" target="_blank" class="btn btn-primary btn-sm mt-1">View</a>
                                        <?php if (strtolower($value->CustomerCurrentStatus) == 'converted') : ?>
                                            <a href="<?= base_url('crm/addChangeReq?q=') . crmEncryptUrlParameter('cid=' . $value->CId) ?>" target="_blank" class="btn btn-secondary btn-sm mt-1">Add Change Request</a>
                                        <?php endif; ?>
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