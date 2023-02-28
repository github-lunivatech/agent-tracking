<?php
$isReg = 'Assign';

$emp = $cpDet['emp'];
$allDa = $cpDet['allDa'];
$ctyp = $cpDet['ctyp'];
$isEdit = $cpDet['isEdit'];

$cstat = '';
$ccid = '';

if($isEdit)
    $isReg = 'Edit';
    
if ($allDa) {    
    $ccid = $allDa['CId'];
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
        <h5 class="card-title">Complain Track</h5>
        <div class="offset-md-2">
            <form id="addComplainForm" action="<?= base_url('complain/insertComplainTrackRecord') ?>" method="post" class="">

                <?php if ($isReg == 'Edit') { ?>
                    <input type="hidden" name="hider" id="hider" value="<?= crmEncryptUrlParameter('cid=' . $ccid) ?>">
                <?php } ?>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="complain_id" class="col-md-3 col-sm-3 col-xs-12">Complain<span class="required">*</span> </label>
                        <input type="text" name="complain_id" id="complain_id" value="<?= $ccid ?>" class="form-control col-md-6 col-sm-6 col-xs-12" readonly>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_id" class="col-md-3 col-sm-3 col-xs-12">Employee Name<span class="required">*</span> </label>
                        <select name="emp_id" id="emp_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <?php foreach ($emp as $key => $value) { ?>
                                <option value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="comp_stat" class="col-md-3 col-sm-3 col-xs-12">Complain Status<span class="required">*</span> </label>
                        <select name="comp_stat" id="comp_stat" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            foreach ($ctyp as $key => $value) {
                                $cStatt = $cstat == $value->Id ? 'selected' : '';
                                printf('<option %s value="%d">%s</option>', $cStatt, $value->Id, $value->title);
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_rem" class="col-md-3 col-sm-3 col-xs-12">Employee Remarks </label>
                        <textarea name="emp_rem" id="emp_rem" class="form-control col-md-6 col-sm-6 col-xs-12"></textarea>
                    </div>
                </div>

                <button type="submit" id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
            </form>
        </div>
    </div>
</div>