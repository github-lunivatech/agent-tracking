<?php 
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Leave Request</div>
            <div class="card-body">

                <div class="offset-md-2">
                    <form id="leaveForm" action="<?= base_url('leave/leaveApplicationByEmp') ?>" method="POST">
                        <input type="hidden" name="eeid" id="eeid" value="<?php echo crmEncryptUrlParameter('eid='.$this->session->userdata('loggedInEmpId')) ?>">
                        <input type="hidden" name="did" id="did" value="">
                        <div id="ema">

                        </div>
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="leave_type" class="col-md-3 col-sm-3 col-xs-12">Leave Type<span class="required">*</span> </label>
                                <select name="leave_type" id="leave_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php foreach ($content['headEx'] as $value) {
                                        // if ($value->IsActive) {
                                            printf('<option value="%s" data-ava="%s">%s</option>', $value->LeaveHeadId, $value->Available, $value->LeaveType);
                                        // }
                                    } ?>
                                </select>
                                <small class="ava_show">Available Days: <span class="ava_day"></span> </small>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="leave_period" class="col-md-3 col-sm-3 col-xs-12">Leave period<span class="required">*</span> </label>
                                <select name="leave_period" id="leave_period" class="form-control col-md-6 col-sm-6 col-xs-12">
                                <?php foreach ($content['type'] as $value) {
                                        if ($value->IsActive) {
                                            printf('<option value="%s" data-desc="%s">%s</option>', $value->LtId, $value->LeaveDescription, $value->LeaveType);
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="startDate" class="col-md-3 col-sm-3 col-xs-12">Leave Start Date<span class="required">*</span> </label>
                                <input id="startDate" type="text" name="startDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="endDate" class="col-md-3 col-sm-3 col-xs-12">Leave End Date<span class="required">*</span> </label>
                                <input id="endDate" type="text" name="endDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="reason" class="col-md-3 col-sm-3 col-xs-12">Reason</label>
                                <textarea name="reason" id="reason" class="form-control col-md-6 col-sm-6 col-xs-12"></textarea>
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

                        <button class="mt-2 btn btn-primary pull-right" id="leReq">Request</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>