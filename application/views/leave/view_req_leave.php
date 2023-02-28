<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">View All Leaves</div>
            <div class="card-body">

                <div class="clearfix"></div>
                <table class="table table-bordered" id="empLeaveTable">
                    <thead>
                        <th>Id</th>
                        <th>Leave Head</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remarks</th>
                        <th>Leave Status</th>
                        <th>Approved Date</th>
                        <th class="all">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($content as $key => $value) {
                                // var_dump($value);
                                $leaveStatus = $value->LeaveStatus;
                                $bcolor = 'secondary';
                                if($leaveStatus == 'Pending'){
                                    $bcolor = 'warning';
                                }elseif ($leaveStatus == 'Approved') {
                                    $bcolor = 'success';
                                }elseif ($leaveStatus == 'Reject') {
                                    $bcolor = 'info';
                                }elseif ($leaveStatus == 'Cancel') {
                                    $bcolor = 'danger';
                                }
                                $lLabel = '<label class="badge badge-'.$bcolor.'">'.$leaveStatus.'</label>';

                                $stEx = explode('T',$value->StartDate)[0];
                                $enEx = explode('T',$value->EndDate)[0];
                                $apEx = explode('T',$value->ApprovedDate)[0];
                                
                                $allEnc = 'laid='.$value->LAId.
                                '&eid='.$value->EmployeeId.
                                '&ls='.$value->LeaveSettingId.
                                '&lti='.$value->LeaveTypeId.
                                '&sd='.$stEx.
                                '&ed='.$enEx.
                                '&en='.$value->EntryDate.
                                '&rem='.$value->Remarks.
                                '&lst='.$value->LeaveStatus.
                                '&ab='.$value->ApprovedBy.
                                '&ad='.$value->ApprovedDate.
                                '&af='.$value->AttachementFile.
                                '&lh='.$value->LeaveHead.
                                '&lt='.$value->LeaveType;

                                $encl = base_url('leave/editLeave?q=').crmEncryptUrlParameter($allEnc);
                                printf('<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td><a class="btn btn-primary" href="%s">Edit</a></td>
                                </tr>',
                                $value->LAId,
                                $value->LeaveHead,
                                $value->LeaveType,
                                $stEx,
                                $enEx,
                                $value->Remarks,
                                $lLabel,
                                $apEx,
                                $encl
                            );
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>