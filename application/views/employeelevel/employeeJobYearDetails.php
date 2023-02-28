<?php $empDet = $allData['empDet'] ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Year</div>
            <div class="card-body">

                <div class="offset-md-2">
                    <form id="leaveForm" action="<?= base_url('employeeLevel/insertUpdateEmployeeJobYearDetail') ?>" method="POST">
                        <?php if ($allData['isEdit']) { ?>
                            <input type="hidden" name="yid" id="yid" value="<?= $allData['yid'] ?>">
                        <?php } ?>
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="empYear" class="col-md-3 col-sm-3 col-xs-12">Employee Year<span class="required">*</span> </label>
                                <input type="text" name="empYear" id="empYear" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $allData['isEdit'] ? $empDet->EmployeeYear : '' ?>" required>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">Is Active</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="isactive" class="custom-control-input" id="isactive" <?= $allData['isEdit'] ? ($empDet->IsActive == true ? 'checked' : '') : '' ?>>
                                    <label class="custom-control-label" for="isactive"></label>
                                </div>
                            </div>
                        </div>

                        <button class="mt-2 ml-1 btn btn-primary pull-right autoSubmit">Submit</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>