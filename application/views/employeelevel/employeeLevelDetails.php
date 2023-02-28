<?php $empDet = $allData['empDet'] ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Level</div>
            <div class="card-body">

                <div class="offset-md-2">
                    <form id="leaveForm" action="<?= base_url('employeeLevel/insertUpdateEmployeeLevels') ?>" method="POST">
                        <?php if ($allData['isEdit']) { ?>
                            <input type="hidden" name="lid" id="lid" value="<?= $allData['yid'] ?>">
                        <?php } ?>
                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="levelCode" class="col-md-3 col-sm-3 col-xs-12">Level Code<span class="required">*</span> </label>
                                <input type="text" name="levelCode" id="levelCode" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $allData['isEdit'] ? $empDet->LevelCode : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="employeeLevel" class="col-md-3 col-sm-3 col-xs-12">Employee Level<span class="required">*</span> </label>
                                <input type="text" name="employeeLevel" id="employeeLevel" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $allData['isEdit'] ? $empDet->EmployeeLevel : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">Is Active</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="isactive" class="custom-control-input" id="isactive" <?= $allData['isEdit'] ? ($empDet->IsActive == true ? 'checked' : '') : 'checked' ?>>
                                    <label class="custom-control-label" for="isactive"></label>
                                </div>
                            </div>
                        </div>

                        <button class="mt-2 ml-1 btn btn-primary pull-right">Submit</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>