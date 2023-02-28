<?php
$startEdit = false;
$saveText = 'Save';
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    .app-main__outer {
        width: 100%;
    }
</style>
<form action="<?= base_url('performance/viewPerformance') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="jobId" id="jobId" class="form-control" value="<?= set_value('jobId') ?>" placeholder="Employee Id" required>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="from" id="from" class="form-control" value="<?= set_value('from') ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="to" id="to" class="form-control" value="<?= set_value('to') ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm">Search</button>
        </div>
    </div>
</form>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">View Review</h5>
        <?php if ($retData != 0) {
            echo '<span class="badge badge-success">Average Review: ' . $retData . '</span>';
        } ?>
        <div class="table-responsive mt-3">
            <table class="table table-hover" id="reviewTbl">
                <thead>
                    <th>Employee Name</th>
                    <?php 
                    $fullPoint = 0;
                    $passPoint = 0;
                    foreach ($rev_ti as $key => $value) { 
                        $fullPoint += $value->MaxPoint;
                        $passPoint += $value->PassPoint;
                        ?>
                        <th><?= $value->TitleMetrics ?></th>
                    <?php } ?>
                    <th>Total Point</th>
                    <?php if ($settingBundle['disclose_review']) : ?>
                        <th>Review Given By</th>
                    <?php endif; ?>

                    <th>Review Date From</th>
                    <th>Review Date To</th>
                </thead>
                <tbody>
                    
                    <?php
                    $thisCount = count($rev_ti);
                    $thisEmp = count($perRev);
                    $allCount = 0;
                    foreach ($perRev as $key => $value) { ?>
                        <tr>
                            <td><?= $value->Employee ?></td>
                            <?php
                            $thisVal = 0;
                            foreach ($rev_ti as $k => $v) { ?>
                                <?php
                                $title = $v->TitleMetrics;
                                if (isset($value->$title)) {
                                    $thes = $value->$title;
                                    $thisVal += $thes;
                                    if ($thes != null) {
                                        echo '<td>' . $value->$title . '</td>';
                                    } else {
                                        echo '<td>0</td>';
                                    }
                                } else {
                                    echo '<td>0</td>';
                                }
                                ?>
                            <?php } 
                            $allCount += $thisVal;
                            ?>
                            <td><?= $thisVal ?></td>
                            <?php if ($settingBundle['disclose_review']) : ?>
                                <td><?= $value->Reviewer ?></td>
                            <?php endif; ?>
                            <td>
                                <?php echo explode('T', $value->ReviewDateFrom)[0] ?>
                            </td>
                            <td>
                                <?php echo explode('T', $value->ReviewDateTo)[0] ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php 
                    if($allCount != 0 && $thisEmp != 0){
                        $Average = $allCount / $thisEmp; 
                        echo '<span class="badge badge-success mb-3">Full Score: '.$fullPoint.'</span>'; 
                        echo '<span class="badge badge-info ml-3">Pass Score: '.$passPoint.'</span>';
                        echo '<span class="badge badge-warning ml-3">Average Review Score: '.$Average.'</span>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>