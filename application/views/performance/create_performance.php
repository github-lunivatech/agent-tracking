<?php
$depar = $depart;
?>
<form action="<?= base_url('performance/create_performance') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="">Department</label>
            <select name="jobId" id="jobId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($depar as $key => $value) { ?>
                    <option <?= set_select('jobId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->DepartmentName ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">From Date</label>
            <input type="text" name="from" id="from" class="form-control allDateRange" value="<?= set_value('from') ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for="">To Date</label>
            <input type="text" name="to" id="to" class="form-control allDateRange" value="<?= set_value('to') ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <label for=""></label>
            <button class="btn btn-primary btn-sm mt-4">Search</button>
        </div>
    </div>
</form>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Give Performance</h5>
        <?php if($emp_list): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Name</th>
                    <?php foreach ($rev_ti as $k => $v) {
                        if ($v->IsActive) : ?>
                            <th><?= $v->TitleMetrics ?></th>
                    <?php endif;
                    } ?>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach ($emp_list as $key => $value) {
                        $row = $key;
                    ?>
                        <tr class="row_<?= $row ?>">
                            <td>
                                <?= $value->EmployeeName ?>
                                <input type="hidden" name="empId[]" value="<?= crmEncryptUrlParameter('eid='.$value->EId) ?>">
                            </td>
                            <?php foreach ($rev_ti as $k => $v) {
                                if ($v->IsActive) : ?>
                                    <td>
                                        <input type="number" name="give_point[]" max="<?= $v->MaxPoint ?>" min="0">
                                        <input type="hidden" name="revTi[]" value="<?= crmEncryptUrlParameter('rid='.$v->RId) ?>">
                                    </td>
                            <?php endif;
                            } ?>
                            <td>
                                <button class="btn btn-success btn-sm give_rev_btn" data-row="row_<?= $row ?>">Give Review</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>