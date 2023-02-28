<?php
$isReg = 'Register';
$pro = $cpDet['pro'];
$proid = '';
$paidamt = '';
$fisid = '';
$remark = '';
$ispaid = '';
$paiddate = '';
$pid = '';
if($isEdit){
    // var_dump( $allData);exit;
    $isReg = 'Edit';
    $pid = $allData['pid'];
    $proid = $allData['proid'];
    $paidamt = $allData['paidamt'];
    $fisid = $allData['fisid'];
    $remark = $allData['remarks'];
    // $ispaid = $allData['allData'];
    $paiddate = $allData['paiddate'];
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
$ccidd = crmEncryptUrlParameter('cid=' . crmDecryptWithParameter($_GET['q'])[0]['cid'].'&pid='.$pid);
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Pay Details</h5>
        <div class="offset-md-2">
            <form id="payDetForm" action="<?= base_url('crm/insertPayDet') ?>" method="post" class="">

                <input type="hidden" name="hider" id="hider" value="<?= $ccidd ?>">

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="prod_id" class="col-md-3 col-sm-3 col-xs-12">Product<span class="required">*</span> </label>
                        <select name="prod_id" id="prod_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($pro as $key => $value) { ?>
                                <option <?= $proid == $value->PId ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="paid_amt" class="col-md-3 col-sm-3 col-xs-12">Paid Amount<span class="required">*</span> </label>
                        <input id="paid_amt" type="number" step="0.01" name="paid_amt" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $paidamt ?>" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="fiscal_id" class="col-md-3 col-sm-3 col-xs-12">Fiscal Year<span class="required">*</span> </label>
                        <select name="fiscal_id" id="fiscal_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($pro as $key => $value) { ?>
                                <option <?= $fisid == $value->PId ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="remarks" class="col-md-3 col-sm-3 col-xs-12">Remarks </label>
                        <textarea name="remarks" id="remarks" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $remark ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="ispaid" class="col-md-3 col-sm-3 col-xs-12">Is Paid </label>
                        <input type="checkbox" name="ispaid" id="ispaid" />
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="paid_date" class="col-md-3 col-sm-3 col-xs-12">Paid Date </label>
                        <input id="paid_date" type="text" name="paid_date" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $paiddate ?>">
                    </div>
                </div>

                <button type="submit" id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
            </form>
        </div>
    </div>
</div>