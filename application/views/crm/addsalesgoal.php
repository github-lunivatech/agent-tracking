<?php
$saveName = 'Add';

$pfrom = '';
$pto = '';
$proid = '';
$ptar = '';
$pstat = '';
$prem = '';
$isactive = true;

if ($content) {
    $saveName = 'Edit';
    $pfrom = $content['DateFrom'];
    $pto = $content['DateTo'];
    $proid = $content['ProjectId'];
    $ptar = $content['TargetGoal'];
    $pstat = $content['GoalStatus'];
    $prem = $content['Remarks'];
    $isactive = $content['IsActive'];
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
        <h5 class="card-title"><?= $saveName ?> Sales Goal</h5>

        <div class="offset-md-2">
            <form id="productForm" action="<?= base_url('crm/salesGoal') ?>" method="post" class="">
                <div class="form-row form-inline">

                    <?php if ($saveName == 'Edit') { ?>
                        <input type="hidden" name="hider" id="hider" value="<?= crmEncryptUrlParameter('GId=' . $content['GId']) ?>">
                    <?php } ?>

                    <div class="col-md-12 form-group mb-3">
                        <label for="date_from" class="col-md-3 col-sm-3 col-xs-12">Date From </label>
                        <input id="date_from" type="text" name="date_from" class="form-control col-md-5 col-sm-6 col-xs-12 datepicker" value="<?= $pfrom ?>">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="date_to" class="col-md-3 col-sm-3 col-xs-12">Date To </label>
                        <input id="date_to" type="text" name="date_to" class="form-control col-md-5 col-sm-6 col-xs-12 datepicker" value="<?= $pto ?>">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="project_id" class="col-md-3 col-sm-3 col-xs-12">Project </label>
                        <select name="project_id" id="project_id" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($projectDet as $key => $value) { ?>
                                <option <?= $value->PId == $proid ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="target_goal" class="col-md-3 col-sm-3 col-xs-12">Target Goal </label>
                        <input id="target_goal" type="number" name="target_goal" class="form-control col-md-5 col-sm-6 col-xs-12" value="<?= $ptar ?>">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="goal_status" class="col-md-3 col-sm-3 col-xs-12">Goal Status<span class="required">*</span> </label>
                        <select name="goal_status" id="goal_status" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($gGoals as $key => $value) {
                                if ($value->IsActive) { ?>
                                    <option <?= $pstat == $value->GId ? 'selected' : '' ?> value="<?= $value->GId ?>"><?= $value->GoalStatus ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="product_code" class="col-md-3 col-sm-3 col-xs-12">Remarks </label>
                        <textarea name="remarks" id="remarks" class="form-control col-md-5 col-sm-6 col-xs-12"><?= $prem ?></textarea>
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="is_active" class="col-md-3 col-sm-3 col-xs-12">Is Active </label>
                        <input id="is_active" type="checkbox" name="is_active" <?= $isactive == true ? 'checked' : '' ?>>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary btn-sm pull-right"><?= $saveName ?></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>