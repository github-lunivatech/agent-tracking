<?php
if ($content) {
    $bas = $content['allDet']['bas'];
    // var_dump($bas);exit;
    $edu = $content['allDet']['edu'];
    $exp = $content['allDet']['exp'];
    $des = $content['allDet']['des'];
    $ref = $content['allDet']['ref'];
    $doc = $content['allDet']['doc'];
    $bank = $content['allDet']['bank'];
    $sal = $content['allDet']['sal'];
    $addr = $content['allDet']['add'];
    // var_dump($addr);exit;

    $currentDepartment = '';
    $currentDesignation = '';
    $currentLevel = '';
    $currentYear = '';

    foreach ($des as $value) {
        if($value[10] == true){
            $currentDepartment = $value[3];
            $currentDesignation = $value[4];
            $currentYear = $value[12];
            $currentLevel = $value[13];
            break;
        }
    }
}

                                      //  var_dump($edu);exit;
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-primary col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
.personal_details{
    color: black;
    font-size: x-large;
}

.code{
    border:  4px solid #bbb
}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#bas" class="nav-link active">Details</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#add" class="nav-link">Address</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#edu" class="nav-link">Occupation</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#exp" class="nav-link">Experience</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#con" class="nav-link">Nominee</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#doc" class="nav-link">Documents</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#bak" class="nav-link">Bank Details</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#sal" class="nav-link">Salary Lookup</a></li>
        </ul>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane active" id="bas" role="tabpanel">
                        <h2 class="card-title">Employee Profile</h2>
                        <input type="hidden" name="allValDa" id="allValDa" value="<?= $currentDepartment.'|'.$currentDesignation.'|'.$currentLevel.'|'.$currentYear ?>">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <?php
                                            if ($bas[0]->EmpImage != '') { ?>
                                                <img src="<?= $bas[0]->EmpImage ?>" alt="" class="img-rounded img-responsive profile_img" />
                                            <?php } else { ?>
                                                <img src="<?= base_url('assets/images/unk.png') ?>" alt="" class="img-rounded img-responsive profile_img" />
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-6 col-md-8 emp_name">
                                            <h4 class="em_name mt-4 personal_details"><?php if ($bas) echo $bas[0]->EmployeeName ?></h4>
                                            <?php if ($bas) { ?>
                                                <div class="minor-details">
                                                    <label for=""><i class="pe-7s-phone"></i>
                                                        <?= $bas[0]->EmployeeMobileNumber ?></label> <br />
                                                    <label for=""><i class="pe-7s-mail"></i>
                                                        <?= $bas[0]->EmployeeEmailId ?></label>
                                                </div>
                                            <?php } ?>

                                            <?php
                                            $regPer = in_array("register employee", $permissions);
                                            $isSameId = $this->session->userdata('loggedInEmpId') == $bas[0]->EId;
                                            if ($regPer || $isSameId) { ?>
                                                <div>
                                                    <a href="<?= base_url('employee/em_edit?q=') . crmEncryptUrlParameter('eid=' . $bas[0]->EId) ?>" class="btn btn-success"><i class="metismenu-icon pe-7s-pen"></i> Edit Info</a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <table class="table table-bordered mt-4 code">
                                    
                                    <tr>
                                        <th>Employee Code</th>
                                        <td><?php if($bas[0]->EmpCode !=0 ||$bas[0]->EmpCode !=null ){
                                            echo $bas[0]->EmpCode;
                                        }else{
                                            echo $bas[0]->EId;
                                        }  ?></td>
                                    </tr>
                                    <tr>
                                        <th>Employee Id</th>
                                        <td><?= $bas[0]->EId ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a data-toggle="tab" href="#bas_info" class="nav-link active">Basic Info</a></li>
                                </ul>

                                <div class="tab-pane active" id="bas_info" role="tabpanel">
                                    <!-- <table class="table"> -->
                                    <h5 class="personal_details">Personal Details</h5>
                                    <div class="divider"></div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Date of Birth</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo explode('T', $bas[0]->NepaliDOB)[0] ?></label>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Gender</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeGender ?></label>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Nationality</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeNationality ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Registered Date</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo explode('T', $bas[0]->RegisterDate)[0] ?></label>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Ethinicity</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeEthinicity ?></label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <h5 class="personal_details">Contact Information</h5>
                                    <div class="divider"></div>
                                    <div class="row">
                                        <!-- <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeAddress ?></label>
                                        </div> -->
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Id No</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeIdentificationNumber ?></label>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Id Type</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeIdentificationType ?></label>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Contact Number</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $bas[0]->EmployeeMobileNumber ?></label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <h5 class="personal_details">Post</h5>
                                    <?php //if ($this->session->userdata('loggedInRole') == 'Admin' || $this->session->userdata('loggedInRole') == 'Manager') : ?>
                                        <button class="btn btn-primary btn-sm add_new_job mb-1">Add New</button>
                                    <?php //endif; ?>
                                    <?php //var_dump($des);exit;?>
                                    <div class="divider"></div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Customer Code</th>
                                                    <th>Chief Marketing Officer</th>
                                                    <th>Marketing Officer</th>
                                                    <?php //if ($this->session->userdata('loggedInRole') == 'Admin' || $this->session->userdata('loggedInRole') == 'Manager') : ?>
                                                        <th class="all"></th>
                                                    <?php //endif; ?>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                
                                                    foreach ($des as $key => $value) { ?>
                                                        <tr>
                                                            <td><?= $value['dep_name'] ?></td>
                                                            <td><?= $value['des_name'] ?></td>
                                                            <td><?= $value[5] ?></td>
                                                            <td><?= $value['sup_name'] ?></td>
                                                            <td>
                                                                <?php  
                                                            /*if($value['rep_name'] == 0 && $value['sup_name'] !='' )
                                                            {
                                                                 echo $value['sup_name'];
                                                            }elseif( $value['rep_name'] !='') {
                                                               
                                                                
                                                            }
                                                            else{
                                                                echo $value['rep_name'];
                                                            }*/
                                                            echo $value['rep_name'];
                                                            ?>
                                                            </td>
                                                            <th>
                                                                <?php //if ($this->session->userdata('loggedInRole') == 'Admin' || $this->session->userdata('loggedInRole') == 'Manager') : ?>
                                                                    <button class="btn btn-info btn-sm designation_edit" data-json='<?php echo json_encode($value) ?>'>Edit</button>
                                                                <?php //endif; ?>
                                                            </th>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="edu" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12  table-responsive">
                                <button class="btn btn-primary btn-sm mb-3 add_new_edu">Add New</button>

                                <table class="table table-bordered" id="eduTbl">
                                    <thead>
                                        <th>Qualification</th>
                                        <th>Institution</th>
                                        <th>Start Date</th>
                                        <th>Completion Date</th>
                                        <th class="all"></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // var_dump($edu);exit;
                                        foreach ($edu as $value) { ?>
                                            <tr>
                                                <td><?= $value[2] ?></td>
                                                <td><?= $value[3] ?></td>
                                                <td><?php echo explode('T', $value[4])[0] ?></td>
                                                <td><?php echo explode('T', $value[5])[0] ?></td>
                                                <td><button class="btn btn-info btn-sm edit_edu" data-json='<?php echo json_encode($value) ?>'>Edit</button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="add" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12  table-responsive">
                                <button class="btn btn-primary btn-sm mb-3 add_new_addre">Add New</button>

                                <table class="table table-bordered" id="eduTbl">
                                    <thead>
                                        <th>Address Type</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Municipality/VDC</th>
                                        <th>Local Address</th>
                                        
                                        <th class="all"></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($addr as $value) { ?>
                                            <tr>
                                            <td><?= ucfirst($value[1]) ?></td>
                                                <td><?= $value[10] ?></td>
                                                <td><?= $value[11] ?></td>
                                                <td><?php echo  $value[12] ?></td>
                                                <td><?php echo  $value[7] ?></td>
                                                <!-- <td><?php echo explode('T', $value[5])[0] ?></td> -->
                                                <td><button class="btn btn-info btn-sm edit_addre" data-json='<?php echo json_encode($value) ?>'>Edit</button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane table-responsive" id="exp" role="tabpanel">
                        <button class="btn btn-primary btn-sm mb-3 add_new_exp">Add New</button>

                        <table class="table table-bordered" id="expTbl">
                            <thead>
                                <th>Skills</th>
                                <th>Experiences</th>
                                <th class="all"></th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($exp as $value) { ?>
                                    <tr>
                                        <td><?= $value[2] ?></td>
                                        <td><?= $value[3] ?></td>
                                        <td><button class="btn btn-info btn-sm edit_exp" data-json='<?php echo json_encode($value) ?>'>Edit</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane table-responsive" id="con" role="tabpanel">
                        <button class="btn btn-primary btn-sm mb-3 add_new_ref">Add New</button>

                        <table class="table table-bordered" id="refTbl">
                            <thead>
                                <th>Reference Name</th>
                                <th>Relationship</th>
                                <th>Designation</th>
                                <th>Mobile Phone</th>
                                <th>Home Phone</th>
                                <th>Office Phone</th>
                                <th class="all"></th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ref as $value) { ?>
                                    <tr>
                                        <td><?= $value[2] ?></td>
                                        <td><?= $value[3] ?></td>
                                        <td><?= $value[7] ?></td>
                                        <td><?= $value[5] ?></td>
                                        <td><?= $value[4] ?></td>
                                        <td><?= $value[6] ?></td>
                                        <td><button class="btn btn-info btn-sm edit_ref" data-json='<?php echo json_encode($value) ?>'>Edit</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane table-responsive" id="doc" role="tabpanel">
                        <button class="btn btn-primary btn-sm mb-3 upload_doc">Upload Document</button>

                        <table class="table table-bordered" id="documentTbl">
                            <thead>
                                <th>Document Name</th>
                                <th>Document Type</th>
                                <th class="all">Attachment</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($doc as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value->DocumentName ?></td>
                                        <td><?= $value->DocumentType ?></td>
                                        <td><a href="<?= $value->DocumentPath ?>" target="_blank">View Document</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="bak" role="tabpanel">
                        <button class="btn btn-primary btn-sm mb-3 add_new_bak">Add New Details</button>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tblBank">
                                <thead>
                                    <th>Bank Name</th>
                                    <th>Bank Branch</th>
                                    <th>Account No.</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($bank as $key => $value) { ?>
                                        <tr>
                                            <td><?= $value[2] ?></td>
                                            <td><?= $value[3] ?></td>
                                            <td><?= $value[4] ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm edit_bankdet" data-json='<?php echo json_encode($value); ?>'>Edit</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="sal" role="tabpanel">
                        <?php if (in_array("show salary", $permissions) && in_array("add/edit", $permissions)) { ?>
                            <button class="btn btn-primary btn-sm mb-3 add_new_sal">Add New Salary Lookup</button>
                            <p>Note:- Keep only one salary active</p>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tblSal">
                                <thead>
                                    <th>Basic Salary</th>
                                    <th>Festival Bonus</th>
                                    <th>Allowance</th>
                                    <th>Others</th>
                                    <th>Provident Fund</th>
                                    <th>Citizen Investment Trust</th>
                                    <th>Insurance</th>
                                    <th>Other Fund</th>
                                    <th>TDS</th>
                                    <th>Total Payable</th>
                                    <th>Is Active</th>
                                    <?php if (in_array("show salary", $permissions) && in_array("add/edit", $permissions)) { ?>
                                        <th>Action</th>
                                    <?php } ?>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($sal as $key => $value) { ?>
                                        <tr>
                                            <td><?= $value[3] ?></td>
                                            <td><?= $value[4] ?></td>
                                            <td><?= $value[5] ?></td>
                                            <td><?= $value[6] ?></td>
                                            <td><?= $value[7] ?></td>
                                            <td><?= $value[8] ?></td>
                                            <td><?= $value[9] ?></td>
                                            <td><?= $value[10] ?></td>
                                            <td><?= $value[11] ?></td>
                                            <td><?= $value[12] ?></td>
                                            <td><?= $value[15] == true ? 'Active' : 'Inactive' ?></td>
                                            <?php if (in_array("show salary", $permissions) && in_array("add/edit", $permissions)) { ?>
                                                <td>
                                                    <button class="btn btn-primary btn-sm edit_saldet" data-json='<?php echo json_encode($value); ?>'>Edit</button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>