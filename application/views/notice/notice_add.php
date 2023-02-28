<?php
$startEdit = false;
$saveText = 'Save';
if ($content != []) {
    $startEdit = true;
    $saveText = 'Update';
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
        <h5 class="card-title"><?= $startEdit ? 'Edit' : 'Add' ?> Notice</h5>
        <div class="offset-md-2">
            <form id="noticeForm" action="<?= base_url('notice/insertNotice') ?>" method="post" class="">

                <?php if($startEdit): ?>
                <div class="form-row form-inline">
                    <input type="hidden" name="exD" value="<?php echo crmEncryptUrlParameter('nid='.$content['NId'].'&EntryDate='.$content['EntryDate']) ?>">
                </div>
                <?php endif; ?>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_title" class="col-md-3 col-sm-3 col-xs-12">Notice Title<span class="required">*</span> </label>
                        <input id="notice_title" type="text" name="notice_title" class="form-control col-md-5 col-sm-6 col-xs-12" required value="<?= $startEdit ? $content['NoticeTitle'] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_startdate" class="col-md-3 col-sm-3 col-xs-12">Notice Start Date<span class="required">*</span> </label>
                        <input id="notice_startdate" type="text" name="notice_startdate" class="form-control col-md-5 col-sm-6 col-xs-12" autocomplete="off" required value="<?= $startEdit ? explode('T', $content['NoticeStartDate'])[0] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_enddate" class="col-md-3 col-sm-3 col-xs-12">Notice End Date<span class="required">*</span> </label>
                        <input id="notice_enddate" type="text" name="notice_enddate" class="form-control col-md-5 col-sm-6 col-xs-12" autocomplete="off" required value="<?= $startEdit ? explode('T', $content['NoticeEndDate'])[0] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_description" class="col-md-3 col-sm-3 col-xs-12">Notice Description<span class="required">*</span> </label>
                        <textarea name="notice_description" id="notice_description" class="form-control col-md-5 col-sm-6 col-xs-12"><?= $startEdit ? $content['NoticeDescription'] : '' ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="notice_description" class="col-md-3 col-sm-3 col-xs-12">Notice Is Active<span class="required">*</span> </label>
                        <input type="checkbox" name="is_active" id="is_active" <?= $startEdit ? ($content['IsActive'] != '' ? 'checked' : '') : 'checked' ?>>
                    </div>
                </div>

                <!-- <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3"> -->
                <button class="btn btn-primary btn-sm pull-right"><?= $saveText ?></button>
                <!-- </div>
                </div> -->
            </form>
        </div>
    </div>
</div>