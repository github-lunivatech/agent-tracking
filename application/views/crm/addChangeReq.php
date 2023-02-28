<?php
$isReg = 'Register';
$emDet = $content['emDet'];
$reqType = $content['reqType'];
$chgStat = $content['chgStat'];
$isData = $content['isData'];
$pDet = $content['pDet'];

if ($isData) {
    $isReg = 'Edit';
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    #total_tent_time,
    #total_tent_cost {
        pointer-events: none;
    }
</style>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Customer Change Request</h5>
        <div class="offset-md-2">
            <form id="customerChangeForm" action="<?= base_url('crm/addCustomerChange') ?>" method="post" class="">

                <input type="hidden" name="customer_id" id="customer_id" value="<?= $_GET['q'] ?>">
                <?php if ($isData) { ?>
                    <input type="hidden" name="hider" id="hider" value="<?= crmEncryptUrlParameter('ccid=' . $isData->CId . '&ent_date=' . $isData->EntryDate) ?>">
                <?php } ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="change_number" class="col-md-3 col-sm-3 col-xs-12">Change Number<span class="required">*</span> </label>
                        <input id="change_number" type="text" name="change_number" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->ChangeNumber : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="project_id" class="col-md-3 col-sm-3 col-xs-12">Project </label>
                        <select name="project_id" id="project_id" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->ProjectId : '';
                            foreach ($pDet as $key => $value) { ?>
                                <option <?= $value->PId == $isSel ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="requested_by" class="col-md-3 col-sm-3 col-xs-12">Requested By</label>
                        <select name="requested_by" id="requested_by" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->RequestedBy : '';
                            foreach ($emDet as $key => $value) { ?>
                                <option <?= $value->EId == $isSel ? 'selected' : '' ?> value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="presented_to" class="col-md-3 col-sm-3 col-xs-12">Presented To </label>
                        <select name="presented_to" id="presented_to" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->PresentedTo : '';
                            foreach ($emDet as $key => $value) { ?>
                                <option <?= $value->EId == $isSel ? 'selected' : '' ?> value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="request_date" class="col-md-3 col-sm-3 col-xs-12">Requested Date</label>
                        <input id="request_date" type="text" name="request_date" class="form-control col-md-6 col-sm-6 col-xs-12 all_date_pick" value="<?= $isData ? explode('T', $isData->RequestDate)[0] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="request_type" class="col-md-3 col-sm-3 col-xs-12">Requested Type</label>
                        <select name="request_type" id="request_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->RequestType : '';
                            foreach ($reqType as $key => $value) { ?>
                                <option <?= $value->RId == $isSel ? 'selected' : '' ?> value="<?= $value->RId ?>"><?= $value->RequestType ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="change_stat" class="col-md-3 col-sm-3 col-xs-12">Change Status</label>
                        <select name="change_stat" id="change_stat" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->ChangeStatus : '';
                            foreach ($chgStat as $key => $value) { ?>
                                <option <?= $isSel == $value->CSId ? 'selected' : '' ?> value="<?= $value->CSId ?>"><?= $value->ChangeStatus ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="change_name" class="col-md-3 col-sm-3 col-xs-12">Change Name</label>
                        <input id="change_name" type="text" name="change_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->ChangeName : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="change_desc" class="col-md-3 col-sm-3 col-xs-12">Change Description</label>
                        <textarea name="change_desc" id="change_desc" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $isData ? $isData->ChangeDescription : '' ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="reason_change" class="col-md-3 col-sm-3 col-xs-12">Reason For Change</label>
                        <textarea name="reason_change" id="reason_change" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $isData ? $isData->ResonForChange : '' ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="effect_on_org" class="col-md-3 col-sm-3 col-xs-12">Effect On Organization</label>
                        <textarea name="effect_on_org" id="effect_on_org" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $isData ? $isData->EffectOnOrgnization : '' ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="effect_on_sch" class="col-md-3 col-sm-3 col-xs-12">Effect on schedule</label>
                        <textarea name="effect_on_sch" id="effect_on_sch" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $isData ? $isData->EffectOnSchedule : '' ?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="analysis_time" class="col-md-3 col-sm-3 col-xs-12">Analysis Time</label>
                        <input id="analysis_time" type="number" name="analysis_time" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->AnalysisTime : '' ?>" min="0">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="analysis_cost" class="col-md-3 col-sm-3 col-xs-12">Analysis Cost</label>
                        <input id="analysis_cost" type="number" min="0" step="0.01" name="analysis_cost" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->AnalysisCost : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="design_time" class="col-md-3 col-sm-3 col-xs-12">Design Time</label>
                        <input id="design_time" type="number" name="design_time" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->DesignTime : '' ?>" min="0">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="design_cost" class="col-md-3 col-sm-3 col-xs-12">Design Cost</label>
                        <input id="design_cost" type="number" min="0" step="0.01" name="design_cost" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->DesignCost : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="develop_time" class="col-md-3 col-sm-3 col-xs-12">Develop Time</label>
                        <input id="develop_time" type="number" name="develop_time" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->DevelopmentTime : '' ?>" min="0">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="develop_cost" class="col-md-3 col-sm-3 col-xs-12">Develop Cost</label>
                        <input id="develop_cost" type="number" min="0" step="0.01" name="develop_cost" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->DevelopmentCost : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="test_time" class="col-md-3 col-sm-3 col-xs-12">Testing Time</label>
                        <input id="test_time" type="number" name="test_time" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->TestingTime : '' ?>" min="0">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="test_cost" class="col-md-3 col-sm-3 col-xs-12">Testing Cost</label>
                        <input id="test_cost" type="number" min="0" step="0.01" name="test_cost" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->TestingCost : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="total_tent_time" class="col-md-3 col-sm-3 col-xs-12">Total Tentative Time</label>
                        <input id="total_tent_time" type="number" name="total_tent_time" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->TotalTentativeTime : '' ?>" readonly tabindex="-1" min="0">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="total_tent_cost" class="col-md-3 col-sm-3 col-xs-12">Total Tentative Cost</label>
                        <input id="total_tent_cost" type="number" min="0" step="0.01" name="total_tent_cost" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $isData ? $isData->TotalTentativeCost : '' ?>" readonly tabindex="-1">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="tent_date_sub" class="col-md-3 col-sm-3 col-xs-12">Tentative Submission</label>
                        <input id="tent_date_sub" type="text" name="tent_date_sub" class="form-control col-md-6 col-sm-6 col-xs-12 all_date_pick" value="<?= $isData ? explode('T', $isData->TentativeDateOfSubmission)[0] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="project_man" class="col-md-3 col-sm-3 col-xs-12">Project Manager</label>
                        <select name="project_man" id="project_man" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php
                            $isSel = $isData ? $isData->ProjectManger : '';
                            foreach ($emDet as $key => $value) { ?>
                                <option <?= $isSel == $value->EId ? 'selected' : '' ?> value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="complete_date" class="col-md-3 col-sm-3 col-xs-12">Completion Date</label>
                        <input id="complete_date" type="text" name="complete_date" class="form-control col-md-6 col-sm-6 col-xs-12 all_date_pick" value="<?= $isData ? explode('T', $isData->CompletedDate)[0] : '' ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="note" class="col-md-3 col-sm-3 col-xs-12">Note</label>
                        <textarea name="note" id="note" class="form-control col-md-6 col-sm-6 col-xs-12"><?= $isData ? $isData->Note : '' ?></textarea>
                    </div>
                </div>

                <button id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>

            </form>
        </div>
    </div>
</div>