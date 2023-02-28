<?php
//var_dump($content);exit;
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
            <div class="card-header">View All Employees</div>
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

                    <button class="mt-2 mb-3 btn btn-primary">Load Employees</button>
                </form> -->
                <?php //var_dump($content);exit;?>
                <div class="clearfix"></div>
                <table class="table table-bordered table-hover" id="empTable">
                    <thead>
                        <th>Id</th>
                        <th>Customer Code</th>
                        <th>Designation</th>
                        <th>Name</th>
                        <th>Phone no</th>
                        <th class="all">Action</th>
                        <th>Registered Date</th>
                         <th>IsActive</th>
                    </thead>
                    <tbody>
                        <?php foreach ($content as $key => $value) {
                            $encId = crmEncryptUrlParameter('eid=' . $value->EId);
                            $createLog = '';
                            if($value->Designation=="Customer"){
                                $color="#7fb17f";
                            }elseif($value->Designation=="Marketing Officer"){
                                $color="#b39c71";
                            }
                            elseif($value->Designation=="Chief Marketing Officer"){
                                $color="#cfcf94";
                            }
                            else{
                                $color='';
                            }


                            $customer_code=$value->EmpCode;
                            $Designation=$value->Designation;
                            $date=new DateTime($value->RegisterDate);
                            $date1=$date->format('Y-m-d');
                            $createLeaveGroup = '';
                            if ($value->LoginId == null && in_array("create login", $permissions))
                                $createLog = '<a href="' . base_url('login/create_login?q=') . $encId . '" class="btn btn-success btn-sm mt-1" target="_blank">Create Login</a>';
                            if (in_array("leave settings", $permissions))
                                $createLeaveGroup = '<a href="' . base_url('leave/leaveGroup?q=') . $encId . '&from=a" class="btn btn-info btn-sm mt-1" target="_blank" style="margin:-2px">Edit Leave Group</a>';

                            $isactive = $value->IsActive;
                            $isactives = '<label class="badge badge-success">Active</label>';
                            if (!$isactive)
                                $isactives = '<label class="badge badge-danger">Inactive</label>';
                            $src = base_url('assets/images/user.png');
                            //needs checking for image src
                            if ($value->EmpImage != null)
                                $src = $value->EmpImage;
                            $serow = '<div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        <img width="40" class="rounded-circle opacity-7" 
                                        src="' . $src . '" 
                                        alt="" loading="lazy">
                                    </div>
                                </div>
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading">' . $value->EmployeeName . '</div>
                                </div>
                            </div>
                        </div>';
                            printf(
                                '<tr>
                                <td>%s</td>
                                <td width="10px">%s</td>
                                <td style="background-color:'.$color.'">%s</td>
                                <td>%s</td>
                                
                                <td>%s</td>
                                <td>
                                <a href="' . base_url('employee/emprofile?q=') . '%s" class="btn btn-primary btn-sm mt-1" target="_blank">View</a>
                                %s
                                %s
                                </td>
                                <td>%s</td>
                                <td>%s</td>
                                </tr>',
                                $value->EId,
                                $customer_code,
                                $Designation,
                                $serow,
                                $value->EmployeeMobileNumber,
                                $encId,
                                $createLog,
                                $createLeaveGroup,
                                $date1,
                                $isactives
                            );
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>