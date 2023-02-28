<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Leave Lookup</div>
            <div class="card-body">

                <!-- <form id="viewAllForm" method="post">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="fromDate" class="">From Date</label>
                                <input id="fromDate" type="text" name="fromDate" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <label for="toDate" class="">To Date</label>
                                <input id="toDate" type="text" name="toDate" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <button class="mt-2 mb-3 btn btn-primary">Load Employees Leaves</button>
                </form> -->

                <div class="clearfix"></div>
                <table class="table table-bordered table-hover" id="leaveLookupTbl">
                    <thead>
                        <th>Employee Id</th>
                        <th>LeaveType</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Leave Days (remaining)</th>
                    </thead>
                    <tbody>
                        <?php foreach ($content as $key => $value) {
                            // $encId = base_url('employee/emprofile?q=').crmEncryptUrlParameter('eid='.$value->EmployeeId);
                            $exSP = explode('T',$value->PeriodStart)[0];
                            $exEP = explode('T',$value->EndPeriod)[0];
                            printf(
                                '<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                </tr>',$value->EmployeeId,$value->LeaveType,$exSP,$exEP,$value->LeaveCount
                            );
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>