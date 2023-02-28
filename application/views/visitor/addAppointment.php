<?php
$gender = '';
$isseen = '';
$isView = $content['isView'];
$allDet = array();
$appType = $content['appType'];
$appStat = $content['appStat'];
$emList = array();
if ($isView) {
    $allDet = $content['allDet'];
    $gender = $allDet['vgen'];
    $isseen = $allDet['isseen'];
}
if (!$isView) {
    $emList = $content['emList'];
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    <?php if ($isView) { ?>input,
    textarea,
    select {
        pointer-events: none;
    }
    <?php } ?>
    .select2-selection.select2-selection--single {
        height: 35px;
    }
    /* .select2.select2-container.select2-container--default {
        width: 100%;
    } */
</style>
<!-- <img src="<?= base_url('assets/nepalitype/keyboardlayout-traditional.jpg') ?>" alt="" style="width:100%"> -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?php echo $page['title'] ?></div>
            <div class="card-body">

                <div class="offset-md-2">
                    <?php if (!$isView) : ?>
                        <form id="leaveForm" action="<?= base_url('visitor/insertUpdateAppointment') ?>" method="POST">
                        <?php endif; ?>
                        <!-- <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_id" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['code'] ?></label>
                                <input type="text" name="visit_id" id="visit_id" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($allDet) {
                                                                                                                                                echo $allDet['vid'];
                                                                                                                                            } ?>" />
                            </div>
                        </div> -->

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_mobno" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['mobile'].' '.$header['no'] ?></label>
                                <input type="text" pattern="^[789]\d{9,9}$" name="visit_mobno" id="visit_mobno" class="form-control col-md-6 col-sm-6 col-xs-12" maxlength="10" minlength="10" value="<?php if ($allDet) {
                                                                                                                                                                                            echo $allDet['vmob'];
                                                                                                                                                                                        } ?>" />
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_name" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['name'] ?><span class="required">*</span> </label>
                                <input type="text" name="visit_name" id="visit_name" class="form-control col-md-6 col-sm-6 col-xs-12 convert-preeti" required value="<?php if ($allDet) {
                                                                                                                                                            echo $allDet['vname'];
                                                                                                                                                        } ?>" />
                                <?php echo form_error('visit_name'); ?>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_address" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['address'] ?><span class="required">*</span> </label>
                                <input type="text" name="visit_address" id="visit_address" class="form-control col-md-6 col-sm-6 col-xs-12 convert-preeti" required value="<?php if ($allDet) {
                                                                                                                                                                echo $allDet['vaddress'];
                                                                                                                                                            } ?>" />
                                <?php echo form_error('visit_address'); ?>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_gender" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['gender'] ?><span class="required">*</span> </label>
                                <fieldset class="position-relative form-group">
                                    <div class="position-relative form-check">
                                        <label class="form-check-label mr-3">
                                            <input <?= $gender == 'Male' || $gender == '' ? 'checked' : '' ?> type="radio" name="visit_gender" value="Male" class="form-check-input" <?php if($isView) echo 'onclick="return false"' ?>> <?php echo $header['male'] ?>
                                        </label>
                                    </div>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label mr-3">
                                            <input <?= $gender == 'Female' ? 'checked' : '' ?> type="radio" name="visit_gender" value="Female" class="form-check-input" <?php if($isView) echo 'onclick="return false"' ?>> <?php echo $header['female'] ?>
                                        </label>
                                    </div>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label">
                                            <input <?= $gender == 'Other' ? 'checked' : '' ?> type="radio" name="visit_gender" value="Other" class="form-check-input" <?php if($isView) echo 'onclick="return false"' ?>> <?php echo $header['other'] ?>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_org" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['organization'] ?></label>
                                <input type="text" name="visit_org" id="visit_org" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($allDet) {
                                                                                                                                                echo $allDet['vorg'];
                                                                                                                                            } ?>" />
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="visit_desg" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['visitor'].' '.$header['designation'] ?></label>
                                <input type="text" name="visit_desg" id="visit_desg" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($allDet) {
                                                                                                                                                    echo $allDet['vdes'];
                                                                                                                                                } ?>" />
                            </div>
                        </div> -->

                        <!-- <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="appoint_with" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['appointment'].' '.$header['with'] ?><span class="required">*</span> </label>
                                <?php if ($isView) : ?>
                                    <input type="text" name="appoint_with" id="appoint_with" class="form-control col-md-6 col-sm-6 col-xs-12" required value="<?php if ($allDet) {
                                                                                                                                                                    echo $allDet['appwith'];
                                                                                                                                                                } ?>" />
                                <?php else : ?>
                                    <select name="appoint_with" id="appoint_with" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                                        <?php foreach ($emList as $key => $value) {
                                            printf('<option value="%s">%s</option>', $value->EmployeeName, $value->EmployeeName);
                                        } ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div> -->

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="appoint_reason" class="col-md-3 col-sm-3 col-xs-12"><?php echo $nep ? $header['subject'] : $header['appointment'].' '.$header['reason'] ?><span class="required">*</span> </label>
                                <textarea name="appoint_reason" id="appoint_reason" class="form-control col-md-6 col-sm-6 col-xs-12 convert-preeti" required><?php if ($allDet) {
                                                                                                                                                    echo $allDet['apprea'];
                                                                                                                                                } ?></textarea>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="noofvisitors" class="col-md-3 col-sm-3 col-xs-12"><?php echo $nep ? $header['visitor'].$header['haru'].$header['of'].' '.$header['number'] : $header['no'].' '.strtolower($header['of']).' '.$header['visitor'] ?></label>
                                <input type="number" name="noofvisitors" id="noofvisitors" class="form-control col-md-6 col-sm-6 col-xs-12" min="1" value="<?php if ($allDet) {
                                                                                                                                                                echo $allDet['novisit'];
                                                                                                                                                            } ?>" />
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="appoint_date" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['appointment'].' '.$header['date'] ?><span class="required">*</span> </label>
                                <input type="text" name="appoint_date" id="appoint_date" class="form-control col-md-6 col-sm-6 col-xs-12" required value="<?php if ($allDet) {
                                                                                                                                                                echo explode('T', $allDet['appdate'])[0];
                                                                                                                                                            } ?>" />
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="intime" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['in'].' '.$header['time'] ?><span class="required">*</span> </label>
                                <input type="text" name="intime" id="intime" class="form-control col-md-6 col-sm-6 col-xs-12" required value="<?php if ($allDet) {
                                                                                                                                                    echo $allDet['intime'];
                                                                                                                                                } ?>" />
                            </div>
                        </div>

                        <?php if ($isView) : ?>
                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="outtime" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['out'].' '.$header['time'] ?></label>
                                    <input type="text" name="outtime" id="outtime" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($allDet) {
                                                                                                                                                echo $allDet['outtime'];
                                                                                                                                            } ?>" />
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="appoint_type" class="col-md-3 col-sm-3 col-xs-12"><?php echo $header['appointment'].' '.$header['type'] ?><span class="required">*</span> </label>
                                <select name="appoint_type" id="appoint_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $ty = 0;
                                    if ($allDet) {
                                        $ty = $allDet['apptype'];
                                    }
                                    foreach ($appType as $key => $value) {
                                        if ($ty == $value->leaveId) {
                                            printf('<option selected value="%s">%s</option>', $value->leaveId, $value->leaveStat);
                                        } else {
                                            printf('<option value="%s">%s</option>', $value->leaveId, $value->leaveStat);
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php if($isView): ?>
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="appoint_status" class="col-md-3 col-sm-3 col-xs-12">Appointment Status<span class="required">*</span> </label>
                                <select name="appoint_status" id="appoint_status" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $ty = 0;
                                    if ($allDet) {
                                        $ty = $allDet['appstat'];
                                    }
                                    foreach ($appStat as $key => $value) {
                                        if ($ty == $value->leaveId) {
                                            printf('<option selected value="%s">%s</option>', $value->leaveId, $value->leaveStat);
                                        } else {
                                            printf('<option value="%s">%s</option>', $value->leaveId, $value->leaveStat);
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="is_seenby" class="col-md-3 col-sm-3 col-xs-12">Is Seen By </label>
                                <fieldset class="position-relative form-group">
                                    <div class="position-relative form-check">
                                        <label class="form-check-label mr-3">
                                            <input <?= $isseen == true ? 'checked' : '' ?> type="radio" name="is_seenby" value="1" class="form-check-input" <?php if($isView) echo 'onclick="return false"' ?>> Yes
                                        </label>
                                    </div>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label mr-3">
                                            <input <?= $isseen == false || $isseen == '' ? 'checked' : '' ?> type="radio" name="is_seenby" value="0" class="form-check-input" <?php if($isView) echo 'onclick="return false"' ?>> No
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <?php endif; ?>

                        <input type="hidden" name="nepalidate" id="nepalidate" value="<?php if ($allDet) {
                                                                                            echo $allDet['nepdate'];
                                                                                        } ?>" />

                        <?php if (!$isView) : ?>
                            <button class="mt-2 btn btn-primary pull-right" id="addApp"><?php echo $nep ? $header['appointment'].' '.$header['add'] : $header['add'].' '.$header['appointment'] ?></button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>