<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">View All Employees Leaves</div>
            <div class="card-body">

                <form id="viewAllForm" method="post">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="eid" class="">Reporting Id</label>
                                <input id="eid" type="text" name="eid" class="form-control" value="<?php set_value('eid') ?>">
                            </div>
                        </div>
                    </div>

                    <button class="mt-2 mb-3 btn btn-primary">Load Leaves</button>
                </form>

                <div class="clearfix"></div>
                <table class="table table-bordered">
                    <thead>
                        <th>Employee Id</th>
                        <th>Employee Name</th>
                        <th>Leave Status</th>
                        <th>Leave Head</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remarks</th>
                        <th class="all">Options</th>
                    </thead>
                    <tbody>
                        <?php foreach ($content as $key => $value) {
                            $encId = base_url('leave/approveLeave?q=').crmEncryptUrlParameter('eid='.$value->EmployeeId);
                            printf(
                                '<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td><a href="%s" class="btn btn-primary" target="_blank">View</a></td>
                                </tr>',$value->EmployeeId,
                                $value->EmployeeName,
                                $value->LeaveStatus,
                                $value->LeaveHead,
                                $value->LeaveType,
                                explode('T',$value->StartDate)[0],
                                explode('T',$value->EndDate)[0],
                                $value->Remarks,
                                $encId
                            );
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>