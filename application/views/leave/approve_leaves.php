<?php
$edi = $this->uri->segment(2) == 'editLeave';
$saveData = 'Request';
$hasUrl = false;
$leaveStat = 0;
$leaveShow = 'Pending';
if ($edi) {
    $saveData = 'Edit';
    $urlParam = crmDecryptUrlParameter()[0];
    $hasUrl = true;
    if ($urlParam['lst'] == 'Approved') {
        $leaveStat = 1;
    } elseif ($urlParam['lst'] == 'Reject') {
        $leaveStat = 2;
    } elseif ($urlParam['lst'] == 'Cancel') {
        $leaveStat = 3;
    }
    $leaveShow = $urlParam['lst'];
}
?>
<style>
    .cla {
        pointer-events: none;
        display: none;
    }
    .header_decider {
        background: none;
        <?php 
            if ($urlParam['lst'] == 'Approved') {
                echo 'background: #3ac47d;color: #fff;';
            } elseif ($urlParam['lst'] == 'Reject') {
                echo 'background: #d92550;color: #fff;';
            } elseif ($urlParam['lst'] == 'Cancel') {
                echo 'background: #d92550;color: #fff;';
            }
        ?>
    }
    .card-body input,.card-body select,.card-body textarea{
        color: inherit;
        <?php 
        if($leaveStat != 0){
            echo 'pointer-events: none;';
        }    
        ?>
    }
</style>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Leave <?= $leaveShow ?></div>
            <div class="card-body">

                <div class="offset-md-2">
                    <?php if ($leaveStat == 0) : ?>
                        <form id="leaveForm" action="<?= base_url('leave/leaveApplicationByEmp') ?>" method="POST">
                            <?php if ($edi) { ?>
                                <input type="hidden" class="cla" name="ent_date" value="<?php echo $hasUrl ? $urlParam['en'] : '' ?>" readonly>
                                <input type="hidden" class="cla" name="laid" value="<?php echo $hasUrl ? $urlParam['laid'] : '' ?>" readonly>
                                <input type="hidden" class="cla" name="eid" value="<?php echo $hasUrl ? $urlParam['eid'] : '' ?>" readonly>
                            <?php } ?>
                        <?php endif; ?>
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="leave_type" class="col-md-3 col-sm-3 col-xs-12">Leave Type<span class="required">*</span> </label>
                                <select name="leave_type" id="leave_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php foreach ($content['head'] as $value) {
                                        if ($value->IsActive) {
                                            $issel = '';
                                            if ($hasUrl) {
                                                if ($urlParam['lh'] == $value->LeaveHead) {
                                                    $issel = 'selected';
                                                }
                                            }
                                            printf('<option %s value="%s" data-desc="%s">%s</option>', $issel, $value->LhId, $value->LeaveDescription, $value->LeaveHead);
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="leave_period" class="col-md-3 col-sm-3 col-xs-12">Leave period<span class="required">*</span> </label>
                                <select name="leave_period" id="leave_period" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php foreach ($content['type'] as $value) {
                                        if ($value->IsActive) {
                                            $isda = '';
                                            if ($hasUrl) {
                                                if ($urlParam['lt'] == $value->LeaveType) {
                                                    $isda = 'selected';
                                                }
                                            }
                                            printf('<option %s value="%s" data-desc="%s">%s</option>', $isda, $value->LtId, $value->LeaveDescription, $value->LeaveType);
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="startDate" class="col-md-3 col-sm-3 col-xs-12">Leave Start Date<span class="required">*</span> </label>
                                <input id="startDate" type="text" name="startDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $hasUrl ? $urlParam['sd'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="endDate" class="col-md-3 col-sm-3 col-xs-12">Leave End Date<span class="required">*</span> </label>
                                <input id="endDate" type="text" name="endDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $hasUrl ? $urlParam['ed'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <?php if (!$edi) { ?>
                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="leave_approve" class="col-md-3 col-sm-3 col-xs-12">Leave Approve<span class="required">*</span> </label>
                                    <select name="leave_approve" id="leave_approve" class="form-control col-md-6 col-sm-6 col-xs-12">
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Reject</option>
                                        <option value="3">Cancel</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="reason" class="col-md-3 col-sm-3 col-xs-12">Reason<span class="required">*</span> </label>
                                <textarea name="reason" id="reason" class="form-control col-md-6 col-sm-6 col-xs-12"><?php echo $hasUrl ? $urlParam['rem'] : '' ?></textarea>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 form-group mb-3">
                                <label for="leave_attachment" class="col-md-3 col-sm-3 col-xs-12">Attachment</label>
                                <div class="file-upload col-md-6 col-sm-6 col-xs-12">
                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" name="leave_attachment" id="leave_attachment" type='file' onchange="readURL(this);" accept="" />
                                        <div class="drag-text">
                                            <h3>
                                                Drag or Select to upload Attachments<br />
                                                <i class="pe-7s-cloud-upload"></i>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <!-- <embed class="file-upload-image" src="" type=""> -->
                                        <!-- <img class="file-upload-image" src="#" alt="attachment" /> -->
                                        <div class="image-title"></div>
                                        <div class="image-title-wrap">
                                            <button type="button" id="remove_image_button" class="btn btn-danger mt-3">Remove Attachment</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($leaveStat == 0) : ?>
                            <button class="mt-2 ml-1 btn btn-primary pull-right"><?= $saveData; ?></button>
                            <?php
                            if ($edi) {
                                echo ' <button class="mt-2 btn btn-danger pull-right" id="cancel_req">Cancel Request</button> ';
                            }
                            ?>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>