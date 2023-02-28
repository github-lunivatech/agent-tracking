<?php
$empDet = $allData['empDet'];
$comDet = $allData['comDet'];
$depDet = $allData['depDet'];
$desDet = $allData['desDet'];
$empYList = $allData['empYList'];
$empLList = $allData['empLList'];
$dataList = $allData['dataList'];
$isEdit = $allData['isEdit'];
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Level Salary</div>
            <div class="card-body">

                <div class="offset-md-2">
                    <form id="leaveForm" action="<?= base_url('employeeLevel/insertUpdateEmployeeLevelYearWiseSalaryLookUps') ?>" method="POST">
                        <?php if ($allData['isEdit']) { ?>
                            <input type="hidden" name="lid" id="lid" value="<?= $allData['yid'] ?>">
                        <?php } ?>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="departmentid" class="col-md-3 col-sm-3 col-xs-12">Department<span class="required">*</span> </label>
                                <select name="departmentid" id="departmentid" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $selectedDep = $isEdit ? $dataList->DepartmentId : '';
                                    foreach ($depDet as $value) {
                                        $selected = $value->DId == $selectedDep ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selected, $value->DId, $value->DepartmentName);
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="designationid" class="col-md-3 col-sm-3 col-xs-12">Designation<span class="required">*</span> </label>
                                <select name="designationid" id="designationid" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $selectedDep = $isEdit ? $dataList->DesignationId : '';
                                    foreach ($desDet as $value) {
                                        $selected = $value->DId == $selectedDep ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selected, $value->DId, $value->Designation);
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="levelid" class="col-md-3 col-sm-3 col-xs-12">Level<span class="required">*</span> </label>
                                <select name="levelid" id="levelid" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $selectedDep = $isEdit ? $dataList->LevelId : '';
                                    foreach ($empLList as $value) {
                                        $selected = $value->LId == $selectedDep ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selected, $value->LId, $value->LevelCode . '(' . $value->EmployeeLevel . ')');
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="yearid" class="col-md-3 col-sm-3 col-xs-12">Year<span class="required">*</span> </label>
                                <select name="yearid" id="yearid" class="form-control col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $selectedDep = $isEdit ? $dataList->YearId : '';
                                    foreach ($empYList as $value) {
                                        $selected = $value->YId == $selectedDep ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selected, $value->YId, $value->EmployeeYear);
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="basicsalary" class="col-md-3 col-sm-3 col-xs-12">Basic Salary<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="basicsalary" id="basicsalary" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->BasicSalary : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="festivalbonus" class="col-md-3 col-sm-3 col-xs-12">Festival Bonus<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="festivalbonus" id="festivalbonus" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->FestivalBonus : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="allowance" class="col-md-3 col-sm-3 col-xs-12">Allowance<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="allowance" id="allowance" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->Allowance : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="others" class="col-md-3 col-sm-3 col-xs-12">Others<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="others" id="others" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->Others : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="providentfund" class="col-md-3 col-sm-3 col-xs-12">Provident Fund<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="providentfund" id="providentfund" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->ProvidentFund : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="citizeninvestment" class="col-md-3 col-sm-3 col-xs-12">Citizen Investment<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="citizeninvestment" id="citizeninvestment" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->CitizenInvestmentTrust : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="insurance" class="col-md-3 col-sm-3 col-xs-12">Insurance<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="insurance" id="insurance" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->Insurane : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="ssf" class="col-md-3 col-sm-3 col-xs-12">SSF<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="ssf" id="ssf" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->SSF : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="otherfund" class="col-md-3 col-sm-3 col-xs-12">Other Fund<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="otherfund" id="otherfund" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->OtherFund : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="nightovertime" class="col-md-3 col-sm-3 col-xs-12">Night Over Time<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="nightovertime" id="nightovertime" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->NightOverTime : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="normalovertime" class="col-md-3 col-sm-3 col-xs-12">Normal Over Time<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="normalovertime" id="normalovertime" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->NormalOverTime : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="tds" class="col-md-3 col-sm-3 col-xs-12">TDS<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="tds" id="tds" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->TDS : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="totalPayable" class="col-md-3 col-sm-3 col-xs-12">Total Payable<span class="required">*</span> </label>
                                <input type="number" step="0.01" name="totalPayable" id="totalPayable" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isEdit ? $dataList->TotalPayable : '' ?>">
                            </div>
                        </div>

                        <div class="form-row form-inline">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">Is Active</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="isactive" class="custom-control-input" id="isactive" <?= $allData['isEdit'] ? ($dataList->IsActive == true ? 'checked' : '') : 'checked' ?>>
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