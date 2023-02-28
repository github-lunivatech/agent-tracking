<form action="" id="searchEmp" method="POST">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="from" id="from" class="form-control" placeholder="From" value="<?= set_value('from') ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="to" id="to" class="form-control" placeholder="To" value="<?= set_value('to') ?>">
        </div>
        <button class="btn btn-primary btn-sm">Search</button>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mt-3 mb-3 card">
            <div class="card-header">View Vacancy Details</div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover" id="vacTbl">
                        <thead>
                            <th>Job Title</th>
                            <th>Openings</th>
                            <th>Job Type</th>
                            <th>Job Heading</th>
                            <th>Job Description</th>
                            <th>Job Qualification</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->JobTitleId ?></td>
                                    <td><?= $value->Openings ?></td>
                                    <td><?= $value->JobType ?></td>
                                    <td><?= $value->JobHeading ?></td>
                                    <td><?= $value->JobDescription ?></td>
                                    <td><?= $value->JobQualification ?></td>
                                    <td><?= explode('T', $value->Deadline)[0] ?></td>
                                    <td><button class="btn btn-info btn-sm">Edit</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>