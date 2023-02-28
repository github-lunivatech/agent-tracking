<?php
$eid = '';
$emCode = '';
$fullname = '';
$address = '';
$dob = '';
$NepaliDOB='';
$nationality = '';
$gender = '';
$ethic = '';
$mobno = '';
$cono = '';
$email = '';
$idno = '';
$idtype = '';
$regdate = '';
$isactive = '';
$image = '';
$image2 = '';
$isReg = 'Submit';
if ($content) {
    $content = $content[0];
    $eid = $content->EId;
    $fullname = $content->EmployeeName;
    $emCode = $content->EmpCode;
    $NepaliDOB = $content->NepaliDOB;
    $address = $content->EmployeeAddress;
    $exdob = explode('T',$content->EmployeeDOB);
    $dob = $exdob[0];
    $nationality = $content->EmployeeNationality;
    $gender = $content->EmployeeGender;
    $ethic = $content->EmployeeEthinicity;
    $mobno = $content->EmployeeMobileNumber;
    $cono = $content->EmployeeContactNumber;
    $email = $content->EmployeeEmailId;
    $idno = $content->EmployeeIdentificationNumber;
    $idtype = $content->EmployeeIdentificationType;
    $regdate = $content->RegisterDate;
    $isactive = $content->IsActive;
    $image = $content->EmpImage;
    if($image != ''){
        $image2 = $content->EmpImage2;
    }
    $isReg = 'Edit';
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    <?php if($image2 != ''){ ?>
        .file-upload-content {
            display: block;
        }
        .image-upload-wrap {
            display: none;
        }
        /* .emp_dob{
            margin-left: -182px;
        } */
    <?php } ?>
    .tabs-wrap {
	margin-top: 40px;
}
.tab-content .tab-pane {
	padding: 20px 0;
}

.nav-item .nav-link {
    font-weight: normal;
    color: #0014ff;
}

.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.nav-link {
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease, color 0.3s ease;
    cursor: pointer;
}
.btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}

.btn {
    display: inline-block;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>

<div class="container tabs-wrap">
  <!-- <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-item active" >
      <a href="#billing1" aria-controls="billing" role="tab" data-toggle="tab" aria-expanded="true" class="nav-link active">Customer Details</a>
    </li>
    <li  role="presentation" class="nav-item" >
      <a href="#shipping1" aria-controls="shipping" role="tab" data-toggle="tab" aria-expanded="false" class="nav-link">Customer Address</a>
    </li>
    <li  role="presentation" class="nav-item ">
      <a href="#review1" aria-controls="review" role="tab" data-toggle="tab" aria-expanded="false" class="nav-link ">Nominee</a>
    </li>
  </ul> -->

  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#billing1" role="tab" aria-controls="home" aria-selected="true">Customer Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#shipping1" role="tab" aria-controls="profile" aria-selected="false">Customer Address</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#review1" role="tab" aria-controls="contact" aria-selected="false">Nominee</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Post</a>
  </li>
</ul>

<div class="tab-content">

  <div role="tabpanel" class="tab-pane active" id="billing1">

  
  <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('employee/insertUpdateEmployeePersonalDetails') ?>" method="post" class="" nonvalidate>
                <input type="hidden" id="eid" name="eid" value="<?php if($eid != '') echo crmEncryptUrlParameter('eid='.$eid); ?>">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Customer Code<span class="required">*</span> </label>
                        <input id="emp_code" type="text" name="emp_code" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $emCode ?>" placeholder="Customer Code" > <span style="margin-left: 87px">Note:Please provide code only if customer code is being registered</span>
                    </div>
                </div>

                <?php if($fullname == ''): ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_first_name" class="col-md-3 col-sm-3 col-xs-12">First Name<span class="required">*</span> </label>
                        <input id="emp_first_name" type="text" name="emp_first_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="First Name" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_middle_name" class="col-md-3 col-sm-3 col-xs-12">Middle Name </label>
                        <input id="emp_middle_name" type="text" name="emp_middle_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="Middle Name">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_last_name" class="col-md-3 col-sm-3 col-xs-12">Last Name <span class="required">*</span> </label>
                        <input id="emp_last_name" type="text" name="emp_last_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="Last Name" required>
                    </div>
                </div>
                <?php else: ?>
                    <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_full_name" class="col-md-3 col-sm-3 col-xs-12">Full Name <span class="required">*</span> </label>
                        <input id="emp_full_name" type="text" name="emp_full_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $fullname ?>" placeholder="Full Name" required>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_dob" class="col-md-3 col-sm-3 col-xs-12">Date of Birth<span class="required">*</span> </label>
                        <input id="emp_dob" type="text" name="emp_dob" class="form-control col-md-6 col-sm-6 col-xs-12 emp_dob" value="<?= $dob ?>" placeholder="dd/mm/yyyy " required>
                        <?php //include('aafromdate.php') ?>
                        <?php //if (isset($settingBundle['shownepfromto']) && $settingBundle['shownepfromto']) { ?>
                        <!-- <style>
                            #emp_dob{
                                display: none;
                            }
                            #nepaliFrom {
                                background-color: unset;
                            }
                        </style> -->
                        <!-- <input type="checkbox" name="show_nepaliCheck" id="show_nepaliCheck"> English -->
                    <?php //}else{ ?>
                        <!-- <style>
                            #nepaliFrom{
                                display: none;
                            }
                        </style> -->
                    <?php //} ?> 
                    </div>
                    <?php //if (isset($settingBundle['shownepfromto']) && $settingBundle['shownepfromto']) { ?>
                    <input type="hidden" class="form-control col-md-6 col-sm-6 col-xs-12 " id="nepaliDateForm" name="EntryNepaliDate" value="<?php echo set_value('nepaliFrom'); ?>" required autocomplete="off">

                        
                  
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_gender" class="col-md-3 col-sm-3 col-xs-12">Gender<span class="required">*</span> </label>
                        <fieldset class="position-relative form-group">
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input <?= $gender == 'Male' || $gender == '' ? 'checked' : '' ?> type="radio" name="emp_gender" value="Male" class="form-check-input"> Male
                                </label>
                            </div>
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input <?= $gender == 'Female' ? 'checked' : '' ?> type="radio" name="emp_gender" value="Female" class="form-check-input"> Female
                                </label>
                            </div>
                            <div class="position-relative form-check">
                                <label class="form-check-label">
                                    <input <?= $gender == 'Other' ? 'checked' : '' ?> type="radio" name="emp_gender" value="Other" class="form-check-input"> Other
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="form-row form-inline" style="display:none">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_nationality" class="col-md-3 col-sm-3 col-xs-12">Nationality<span class="required">*</span> </label>
                        <input id="emp_nationality" type="hidden" name="emp_nationality" class="form-control col-md-6 col-sm-6 col-xs-12" value="Nepali" placeholder="Nationality" required>
                    </div>
                </div>

                <div class="form-row form-inline" style="display:none">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_ethinicity" class="col-md-3 col-sm-3 col-xs-12">Ethinicity<span class="required">*</span> </label>
                        <select name="emp_ethinicity" id="emp_ethinicity" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="others" selected="selected">Others</option>
                            <?php //foreach ($ethinic as $key => $value) { ?>
                                <option <?php //echo $value->EthName == $ethic ? 'selected' : '' ?> value="<?= $value->EthName ?>"><?= $value->EthName ?></option>
                            <?php //} ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_idtype" class="col-md-3 col-sm-3 col-xs-12">Identification Type<span class="required">*</span> </label>
                        <select name="emp_idtype" id="emp_idtype" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <option value="">Select</option>
                            <?php foreach ($ide as $key => $value) {
                                $selc = $idtype == $value->title ? 'selected' : '';
                                printf('<option %s value="%s">%s</option>', $selc, $value->title,$value->title);
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_idno" class="col-md-3 col-sm-3 col-xs-12">Identification No<span class="required">*</span> </label>
                        <input id="emp_idno" type="text" name="emp_idno" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $idno ?>" placeholder="Identification No" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">IsActive<span class="required">*</span> </label>
                        <fieldset class="position-relative form-group">
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input <?php 
                                        if($isactive != ''):
                                            echo $isactive == '1' ? 'checked' : '' ;
                                        else:
                                            echo 'checked';
                                        endif;
                                    ?> type="radio" name="isactive" value="1" class="form-check-input"> Active
                                </label>
                            </div>
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input <?= $isactive == '0' ? 'checked' : '' ?> type="radio" name="isactive" value="0" class="form-check-input"> Inactive
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_mobileno" class="col-md-3 col-sm-3 col-xs-12">Mobile No.<span class="required">*</span> </label>
                        <input id="emp_mobileno" type="text" name="emp_mobileno" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $mobno ?>" placeholder="Mobile No" required pattern="[1-9]{1}[0-9]{9}" minlength="10" maxlength="10">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_contactno" class="col-md-3 col-sm-3 col-xs-12">Contact No.</label>
                        <input id="emp_contactno" type="text" name="emp_contactno" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cono ?>" placeholder="Contact No" pattern="^\d+$" maxlength="10">
                    </div>
                </div>

                <!-- <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_address" class="col-md-3 col-sm-3 col-xs-12">State<span class="required">*</span> </label>
                        <select id="state" type="text" name="state" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <option value="">Select State </option>
                            <?php foreach ($states->GetStates as $state) {
                                // var_dump($state);exit;
                                printf('<option value="%d">%s</option>',$state->Id,$state->Name);
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="district" class="col-md-3 col-sm-3 col-xs-12">District<span class="required">*</span> </label>
                        <select id="district" type="text" name="district" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <option value="">Select District </option>

                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="municipality" class="col-md-3 col-sm-3 col-xs-12">Municipality<span class="required">*</span> </label>
                        <select id="municipality" type="text" name="municipality" class="form-control col-md-6 col-sm-6 col-xs-12" required>
                            <option value="">Select Municipality </option>

                        </select>
                    </div>
                </div> -->

                <!-- <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_address" class="col-md-3 col-sm-3 col-xs-12">Permanent Address<span class="required">*</span> </label>
                        <input id="emp_address" type="text" name="emp_address" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $address ?>" placeholder="Address" required>
                    </div>
                </div> -->

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_email" class="col-md-3 col-sm-3 col-xs-12">Email</label>
                        <input name="emp_email" id="emp_email" placeholder="example@example.com" type="email" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $email ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_image" class="col-md-3 col-sm-3 col-xs-12">Photo</label>
                        <div class="file-upload col-md-6 col-sm-6 col-xs-12">
                            <div class="image-upload-wrap">
                                <input class="file-upload-input" name="emp_image" id="emp_image" type='file' onchange="readURL(this);" accept="image/jpeg, image/x-png, image/gif" data-val='<?= $image ?>' />
                                <div class="drag-text">
                                    <h3>
                                        Drag or Select to upload Image<br />
                                        <i class="pe-7s-cloud-upload"></i>
                                    </h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="<?php if($image2 != ''){
                                    echo $image2;
                                }else{
                                    echo '#';
                                }  ?>" alt="image" />
                                <div class="image-title-wrap">
                                    <button type="button" id="remove_image_button" class="btn btn-danger mt-3">Remove Image</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        <!-- <a class="btn btn-primary continue" style="margin-left:517px;color: white;">Continue</a> -->
        <!-- <button class="mt-2 btn btn-primary ontinue" style="margin-left: 515px;"type="button" >Continue</button> -->
        <!--  -->
        <!-- <button class="prevtab btn btn-success">Prev</button> -->
        <button class="nexttab btn btn-primary" style="margin-left:517px;color: white;">Next</button>
    </div>


  <div role="tabpanel" class="tab-pane" id="shipping1">
               
                        <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Address Type<span class="required">*</span> </label>
                                    <select  id="AddressType" name="AddressType" class="form-control col-md-7 col-sm-7 col-xs-12" required readonly disabled> 
                                        <option value="">Select Address Type</option>
                                        <option value="Permanent" selected>Permanent</option>
                                        <option value="temporary">Temporary</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <input type="hidden" name="ee" id="ee"  readonly>
                                <input type="hidden" name="ef" id="ef" >
                                <input type="hidden" name="CountryId" id="CountryId" value="1" readonly>
                                <input type="hidden" name="AddressType" id="" value="Permanent" readonly>
                                <input type="hidden" name="AddressType1" id="" value="Temporary" readonly>

                                
                                <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">State <span class="required">*</span> </label>
                                    <select id="StateId" name="StateId" class="form-control col-md-7 col-sm-7 col-xs-12"  onchange="changestate1()"> 
                                   <option value="">Select State</option>
                                   <?php foreach ($states->GetStates as $state) {
                                          printf('<option value="%d">%s</option>',$state->Id,$state->Name);
                                    } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="institution" class="col-md-4 col-sm-4 col-xs-12">District<span class="required">*</span> </label>
                                    <select id="DistrictId" name="DistrictId" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Municipality/VDC <span class="required">*</span> </label>
                                    <select  id="VDCMunId" name="VDCMunId" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Local Address <span class="required">*</span> </label>
                                    <input id="LocalAddress" type="text" name="LocalAddress" class="form-control col-md-7 col-sm-7 col-xs-12"  placeholder="Enter Local Address" required>
                                </div>
                            </div>

                            <div class="form-row form-inline" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Postal Code <span class="required">*</span> </label>
                                    <input id="PostalCode" type="hidden" name="postalCode" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Enter Postal Code" required>
                                </div>
                            </div>

                            <div class="divider">Temporary Address</div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Address Type<span class="required">*</span> </label>
                                    <select  id="AddressType1" name="AddressType1" class="form-control col-md-7 col-sm-7 col-xs-12" required readonly disabled> 
                                        <option value="">Select Address Type</option>
                                        <option value="Permanent" >Permanent</option>
                                        <option value="temporary" selected>Temporary</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <input type="hidden" name="ee" id="ee"  readonly>
                                <input type="hidden" name="ef" id="ef" >
                                <input type="hidden" name="CountryId1" id="CountryId1" value="1" readonly>
                                
                                
                                <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">State <span class="required">*</span> </label>
                                    <select id="StateId1" name="StateId1" class="form-control col-md-7 col-sm-7 col-xs-12"  onchange="changestate2()"> 
                                   <option value="">Select State</option>
                                   <?php foreach ($states->GetStates as $state) {
                                          printf('<option value="%d">%s</option>',$state->Id,$state->Name);
                                    } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="institution" class="col-md-4 col-sm-4 col-xs-12">District<span class="required">*</span> </label>
                                    <select id="DistrictId1" name="DistrictId1" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Municipality/VDC <span class="required">*</span> </label>
                                    <select  id="VDCMunId1" name="VDCMunId1" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Local Address <span class="required">*</span> </label>
                                    <input id="LocalAddress1" type="text" name="LocalAddress1" class="form-control col-md-7 col-sm-7 col-xs-12"  placeholder="Enter Local Address" required>
                                </div>
                            </div>

                            <div class="form-row form-inline" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Postal Code <span class="required">*</span> </label>
                                    <input id="PostalCode1" type="hidden" name="postalCode1" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Enter Postal Code" required>
                                </div>
                            </div>

             <!-- <a class="btn btn-primary back" style="margin-left:456px;color: white;">Back</a>  
             <a class="btn btn-primary continue" style="color: white;">Continue</a>   -->
          
    <!-- <button class="btn btn-primary back" style="margin-left: 456px;">Go Back</button>
    <button class="btn btn-primary continue">Continue</button> -->

    <button class="prevtab btn btn-primary" style="margin-left:456px;color: white;">Prev</button>
    <button class="nexttab btn btn-primary"style="color: white;" >Next</button>
  </div>

  <div role="tabpanel" class="tab-pane" id="review1">
                        <div class="form-row form-inline">
                                <input type="hidden" name="ece" id="ece" readonly>
                                <input type="hidden" name="ecf" id="ecf" readonly>
                            </div>
                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="Designation" class="col-md-4 col-sm-4 col-xs-12">Designation <span class="required">*</span> </label>
                                    <select name="Designation" class="form-control col-md-7 col-sm-7 col-xs-12" id="Designation"
                                                onchange="if(this.options[this.selectedIndex].value=='customOption'){
                                                    toggleField(this,this.nextSibling);
                                                    this.selectedIndex='0';
                                                }">
                                                    <option></option>
                                                    <option value="customOption">[Type a custom value]</option>
                                                    <option value="Guardian">Guardian</option>
                                                    <option value="Nominee">Nominee</option>
                                                    <option value="Verifier">Verifier</option>
                                                    <option value="Others">Others</option>
                                                    <!-- <option value="customOption">Safari</option> -->
                                                </select><input name="Designation" class="form-control col-md-7 col-sm-7 col-xs-12"style="display:none;" disabled="disabled" 
                                                    onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
                                        
                                </div>
                            </div> 
                                <script>
                                            function toggleField(hideObj,showObj){
                                            hideObj.disabled=true;        
                                            hideObj.style.display='none';
                                            showObj.disabled=false;   
                                            showObj.style.display='inline';
                                            showObj.focus();
                                            }
                                </script>

                        


                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="rname" class="col-md-4 col-sm-4 col-xs-12">Reference Name <span class="required">*</span> </label>
                                    <input id="rname" type="text" name="rname" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Reference Name" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="relation" class="col-md-4 col-sm-4 col-xs-12">Relationship <span class="required">*</span> </label>
                                    <select name="relation" class="form-control col-md-7 col-sm-7 col-xs-12" id="relation"
                                                onchange="if(this.options[this.selectedIndex].value=='customOption'){
                                                    toggleField(this,this.nextSibling);
                                                    this.selectedIndex='0';
                                                }">
                                                    <option></option>
                                                    <option value="customOption">[Type a custom value]</option>
                                                    <option value="GrandFather">GrandFather</option>
                                                    <option value="GrandMother">GrandMother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Son">Son</option>
                                                    <option value="Daughter">Daughter</option>
                                                    <option value="Wife">Wife</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <!-- <option value="customOption">Safari</option> -->
                                                </select><input name="relation" class="form-control col-md-7 col-sm-7 col-xs-12"style="display:none;" disabled="disabled" 
                                                    onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
                                        
                                
                                            <script>
                                                        function toggleField(hideObj,showObj){
                                                        hideObj.disabled=true;        
                                                        hideObj.style.display='none';
                                                        showObj.disabled=false;   
                                                        showObj.style.display='inline';
                                                        showObj.focus();
                                                        }
                                            </script>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="homePhone" class="col-md-4 col-sm-4 col-xs-12">Home Phone </label>
                                    <input id="homePhone" type="text" name="homePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Home Phone" pattern="^\d+$" maxlength="10">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="mobilePhone" class="col-md-4 col-sm-4 col-xs-12">Mobile Phone <span class="required">*</span> </label>
                                    <input id="mobilePhone" type="text" name="mobilePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Mobile Phone" required pattern="^\d+$" maxlength="10">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="officePhone" class="col-md-4 col-sm-4 col-xs-12">Office Phone </label>
                                    <input id="officePhone" type="text" name="officePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Office Phone" pattern="^\d+$" maxlength="10">
                                </div>
                            </div>

        <button class="prevtab btn btn-primary" style="margin-left: 343px;color: white;">Prev</button>
        <!-- <button class="nexttab btn btn-success">Next</button> -->
     <!-- <a class="btn btn-primary back" style="margin-left: 343px;color: white;">Back</a>              -->
    <!-- <button class="mt-2 btn btn-primary back" style="float:left;margin-left: 343px;">Go Back</button> -->
    <button id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
    </form>
</div>
<div  role="tabpanel" class="tab-pane" id="post1">
<div class="form-row form-inline">
                                <input type="hidden" name="eje" id="eje" value="<?= $_GET['q'] ?>" readonly>
                                <input type="hidden" name="ejf" id="ejf" readonly>
                            </div>

<!-- 
                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="companyId" class="col-md-4 col-sm-4 col-xs-12">Company <span class="required">*</span> </label>
                                    <select name="companyId" id="companyId" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <?php //foreach ($comDet as $value) {
                                          //  printf('<option value="%s">%s</option>', $value->CId, $value->CompanyName);
                                       // } ?>
                                    </select>
                                </div>
                            </div> -->

                            
                            <input id="companyId" type="hidden" name="companyId" value="1">
                            <input id="levelDetails" type="hidden" name="levelDetails" value="1" >
                            <input id="yearDetails" type="hidden" name="yearDetails" value="1">
                            <input id="departmentId" type="hidden" name="departmentId" value="1">
                            <input id="basicSalary" type="hidden" name="basicSalary" value="1">



                            <!-- <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="departmentId" class="col-md-4 col-sm-4 col-xs-12">Department <span class="required">*</span> </label>
                                    <select name="departmentId" id="departmentId" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <?php //foreach ($depDet as $value) {
                                         //  printf('<option value="%s">%s</option>', $value->DId, $value->DepartmentName);
                                      //  } ?>
                                    </select>
                                </div>
                            </div> -->


                            
                            <!-- <input id="departmentId" type="hidden" name="departmentId" value="1"  -->


                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="designationId" class="col-md-4 col-sm-4 col-xs-12">Designation <span class="required">*</span> </label>
                                    <select name="designationId" id="designationId" class="form-control col-md-7 col-sm-7 col-xs-12 designationlist" onchange="changevalue()">
                                        <?php foreach ($desDet as $value) {
                                         printf('<option value="%s">%s</option>', $value->DId, $value->Designation);
                                      } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="position" class="col-md-4 col-sm-4 col-xs-12">Position <span class="required">*</span> </label>
                                </div>
                            </div> -->
                            <input id="position" type="hidden" name="position" value="detail" placeholder="position" required>

                            <div class="form-row form-inline" id="customerCodeId" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="customerId" class="col-md-4 col-sm-4 col-xs-12">Customer Code <span class="required">*</span> </label>
                                    <input name="position" id="position" class="form-control col-md-7 col-sm-7 col-xs-12">     
                                </div>
                            </div>

                            <div class="form-row form-inline" id="agent" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="reportingManager" class="col-md-4 col-sm-4 col-xs-12">Marketing Officer<span class="required">*</span> </label>
                                    <select name="reportingManager" id="reportingManager" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <option value="">Select Marketing Officer</option>
                                        <?php //foreach ($spDet as $key => $value) {
                                            //if ($value->IsActive) {
                                             //   printf('<option value="%s">%s</option>', $value->EId, $value->EmployeeName);
                                        //  }
                                    //   } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-row form-inline" id="sagent" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="supervisorId" class="col-md-4 col-sm-4 col-xs-12">Chief Marketing Officer <span class="required">*</span> </label>
                                    <select name="supervisorId" id="supervisorId" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <option value="">Select Chief Marketing Officer</option>

                                        <?php 
                                            
                                        /*foreach ($spDet as $key => $value) {
                                            if ($value->IsActive) {
                                                printf('<option value="%s">%s</option>', $value->EId, $value->EmployeeName);
                                            }
                                       } */ ?>
                                    </select>
                                </div>
                            </div>

                            

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="levelDetails" class="col-md-4 col-sm-4 col-xs-12">Level<span class="required">*</span> </label>
                                    <select name="levelDetails" id="levelDetails" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <!-- <option value="">Select Level</option> -->
                                        <?php foreach ($emLL as $key => $value) {
                                            if ($value->IsActive) {
                                              printf('<option value="%s">%s</option>', $value->LId, $value->EmployeeLevel);
                                           }
                                      } ?>
                                    </select>
                                </div>
                            </div>

                            


                            <!-- <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="yearDetails" class="col-md-4 col-sm-4 col-xs-12">Year<span class="required">*</span> </label>
                                    <select name="yearDetails" id="yearDetails" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <option value="">Select Year</option>
                                        <?php //foreach ($emYL as $key => $value) {
                                           // if ($value->IsActive) {
                                           //  printf('<option value="%s">%s</option>', $value->YId, $value->EmployeeYear);
                                          //  }
                                       // } ?>
                                    </select>
                                </div>
                            </div> -->

                            <!-- <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="basicSalary" class="col-md-4 col-sm-4 col-xs-12">Basic Salary <span class="required">*</span> </label>
                                    <input id="basicSalary" type="number" name="basicSalary" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="basicSalary" required min="0">
                                </div>
                            </div> -->

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="isactive" class="col-md-4 col-sm-4 col-xs-12">IsActive<span class="required">*</span> </label>
                                    <fieldset class="position-relative form-group">
                                        <div class="position-relative form-check">
                                            <label class="form-check-label mr-3">
                                                <input type="radio" name="isactive" value="1" class="form-check-input"> Active
                                            </label>
                                        </div>
                                        <div class="position-relative form-check">
                                            <label class="form-check-label mr-3">
                                                <input type="radio" name="isactive" value="0" class="form-check-input"> Inactive
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
</div>

</div>
<div id="push"></div>
        
