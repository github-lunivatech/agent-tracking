<?php
$isReg = 'Register';
$cus = $cpDet['cus'];
$pro = $cpDet['pro'];
$emp = $cpDet['emp'];
$allDa = $cpDet['allDa'];
$ctyp = $cpDet['ctyp'];
$pTy = $cpDet['pTy'];
$comType = $cpDet['comType'];

$ccode = '';
$cus_id = '';
$pro_id = '';
$ctype = '';
$cdet = '';
$cby = '';
$cdate = '';
$cstat = '';
$ccid = '';
if ($allDa) {
    $isReg = 'Edit';
    $ccid = $allDa['CId'];
    $ccode = $allDa['ComplainCode'];
    $cus_id = $allDa['CustomerId'];
    $pro_id = $allDa['ProductId'];
    $ctype = $allDa['ComplainType'];
    $cdet = $allDa['ComplainDetails'];
    $cby = $allDa['ComplainBy'];
    $cdate = explode('T', $allDa['ComplainDate'])[0];
    $cstat = $allDa['ComplainStatus'];
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Complain</h5>
        <div class="offset-md-2">
            <form id="addComplainForm" action="<?= base_url('complain/insertComplaint') ?>" method="post" class="">

                <?php if ($isReg == 'Edit') { ?>
                    <input type="hidden" name="hider" id="hider" value="<?= crmEncryptUrlParameter('cid=' . $ccid) ?>">
                <?php } ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_code" class="col-md-3 col-sm-3 col-xs-12">Complain Code<span class="required">*</span> </label>
                        <input id="comp_code" type="text" name="comp_code" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $ccode ?>" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_id" class="col-md-3 col-sm-3 col-xs-12">Customer<span class="required">*</span> </label>
                        <select name="cust_id" id="cust_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($cus as $key => $value) { ?>
                                <option <?= $cus_id == $value->CId ? 'selected' : '' ?> value="<?= $value->CId ?>"><?= $value->CustomerName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="prod_id" class="col-md-3 col-sm-3 col-xs-12">Product<span class="required">*</span> </label>
                        <select name="prod_id" id="prod_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($pro as $key => $value) { ?>
                                <option <?= $pro_id == $value->PId ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_type" class="col-md-3 col-sm-3 col-xs-12">Complain Type<span class="required">*</span> </label>
                        <select name="comp_type" id="comp_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($comType as $key => $value) { ?>
                                <option <?= $ctype == $value->CId ? 'selected' : '' ?> value="<?= $value->CId ?>"><?= $value->ComplainTitle ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_det" class="col-md-3 col-sm-3 col-xs-12">Complain Details<span class="required">*</span> </label>
                        <textarea name="comp_det" id="comp_det" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $cdet ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_by" class="col-md-3 col-sm-3 col-xs-12">Complain By<span class="required">*</span> </label>
                        <input type="text" name="comp_by" id="comp_by" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cby ?>">
                        <!-- <select name="comp_by" id="comp_by">
                            <option value="">Select</option>
                            <?php foreach ($emp as $key => $value) { ?>
                                <option <?= $cby == $value->EId ? 'selected' : '' ?> value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                            <?php } ?>
                        </select> -->
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_date" class="col-md-3 col-sm-3 col-xs-12">Complain Date<span class="required">*</span> </label>
                        <input id="comp_date" type="text" name="comp_date" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cdate ?>" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_stat" class="col-md-3 col-sm-3 col-xs-12">Complain Status<span class="required">*</span> </label>
                        <select name="comp_stat" id="comp_stat" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            foreach ($ctyp as $key => $value) {
                                $cStatt = $cstat == $value->RId ? 'selected' : '';
                                printf('<option %s value="%d">%s</option>', $cStatt, $value->RId, $value->RequestType);
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="proi_type" class="col-md-3 col-sm-3 col-xs-12">Priority Type<span class="required">*</span> </label>
                        <select name="proi_type" id="proi_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            foreach ($pTy as $key => $value) {
                                $cStatt = $cstat == $value->PId ? 'selected' : '';
                                printf('<option %s value="%d">%s</option>', $cStatt, $value->PId, $value->PriorityDetails);
                            } ?>
                        </select>
                    </div>
                </div>

                <button type="submit" id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
            </form>
        </div>
    </div>
</div>