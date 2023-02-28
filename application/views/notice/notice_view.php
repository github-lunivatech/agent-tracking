<?php
    $con = $content;
?>
<!-- <form action="" id="searchEmp" method="POST">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee Id">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="from" id="from" class="form-control" placeholder="From">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="to" id="to" class="form-control" placeholder="To">
        </div>
        <button class="btn btn-primary btn-sm">Search</button>
    </div>
</form> -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mt-3 mb-3 card">
            <div class="card-header">View Notice</div>
            <div class="card-body">
                
                <a class="btn btn-info btn-sm add_new_sal mb-3" href="<?= base_url('notice/index') ?>">Add New Notice</a>

                <div class="table-responsive">
                    <table class="table table-hover" id="salEmpTbl">
                        <thead>
                            <th>Notice Title</th>
                            <th style="width: 35%;">Notice Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($con as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->NoticeTitle ?></td>
                                    <td><?= $value->NoticeDescription ?></td>
                                    <td><?php echo explode('T', $value->NoticeStartDate)[0]  ?></td>
                                    <td><?php echo explode('T', $value->NoticeEndDate)[0]  ?></td>
                                    <td>
                                        <?php echo $value->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?>
                                    </td>
                                    <td><a href="<?= base_url('notice?q=').$value->urlPram ?>" class="btn btn-info btn-sm">Edit</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- NId -->