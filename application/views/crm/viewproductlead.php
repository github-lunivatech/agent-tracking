<form action="<?= base_url('crm/viewprolead') ?>" id="searchApp" method="POST">
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
            <div class="card-header">View Product Lead Details</div>
            <div class="card-body">
                <div class="">
                    <!-- table-responsive -->
                    <table class="table table-bordered crmdata">
                        <thead>
                            <th>Project</th>
                            <th>Lead Status</th>
                            <th>Amount</th>
                            <th>Probability</th>
                            <th>Remarks</th>
                            <th>Attachments Link</th>
                            <!-- <th>Action</th> -->
                        </thead>
                        <tbody>
                            <?php foreach ($content as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->ProjectName ?></td>
                                    <td><?php $badger = 'secondary';
                                        $customerStatt = $value->LeadStatusId;
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
                                        echo '<span class="badge badge-' . $badger . '">' . $value->LeadStatus . '</span>' ?></td>
                                    <td><?= $value->Amount ?></td>
                                    <td><?= $value->Probability ?></td>
                                    <td><?= $value->Remarks ?></td>
                                    <td><a href="<?= $value->AttachmentsLink ?>" target="_blank" rel="noopener noreferrer"><?= $value->AttachmentsLink ?></a></td>
                                    <!-- <td><button class="btn btn-success btn-sm edit_plt" data-show='{"0": "<?= $value->ProjectId ?>", "1": "<?= $value->LeadStatus ?>", "2": "<?= $value->Amount ?>", "3": "<?= $value->Probability ?>", "4": "<?= $value->Remarks ?>", "5": "<?= $value->LeadClosedDate ?>", "6": "<?= $value->AttachmentsLink ?>"}' data-ext="<?= crmEncryptUrlParameter('LId=' . $value->LId) ?>">Edit</button></td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>