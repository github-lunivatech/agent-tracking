<?php
$jobTitle = $job_title;
?>
<form action="" id="searchApp" method="POST">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <select name="jobId" id="jobId" class="form-control" >
                <option value="">Select</option>
                <?php foreach ($jobTitle as $key => $value) { ?>
                    <option <?= set_select('jobId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->Designation ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary btn-sm">Search</button>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mt-3 mb-3 card">
            <div class="card-header">View Vacancy Application Details</div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover" id="vacTbl">
                        <thead>
                            <!-- <th>Job Id</th> -->
                            <th>Applicant Name</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Qualification</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $key => $value) { ?>
                                <tr>
                                    <!-- <td><?= $value->JobId ?></td> -->
                                    <td><?= $value->ApplicantName ?></td>
                                    <td><?= $value->ApplicantAddress ?></td>
                                    <td><?= $value->ApplicantContactNumber ?></td>
                                    <td><?= $value->ApplicantEmailId ?></td>
                                    <td><?= $value->ApplicantQualification ?></td>
                                    <td><?= $value->ApplicantStatus ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm mt-1">Edit</button>
                                        <button class="btn btn-warning btn-sm mt-1">View Documents</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>