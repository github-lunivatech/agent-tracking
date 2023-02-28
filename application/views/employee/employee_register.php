<!-- <head>
  <meta charset="UTF-8">
  <title> Old book Stories</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head> -->
<?php
$url="";
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

$aid0="";
$stateId0="";
$DistrictId0="";
$VDCMunId0="";
$LocalAddress1="";
$DistrictId1="";
$VDCMunId1="";
$LocalAddress0="";
$aid1="";
$stateId1="";
$LocalAddress1="";
if(isset($_GET['q'])){
    $url=crmDecryptUrlParameter()[0]['eid'];
if(isset($address1)){
    if(isset($address1[0])){
    
    $aid0=$address1[0]->AId;
    $stateId0=$address1[0]->StateId;
    $DistrictId0=$address1[0]->DistrictId;
    $VDCMunId0=$address1[0]->VDCMunId;
    $LocalAddress0=$address1[0]->LocalAddress;
// var_dump($stateId0);
    }
    if(isset($address1[1])){
    $aid1=$address1[1]->AId;
    $stateId1=$address1[1]->StateId;
    $DistrictId1=$address1[1]->DistrictId;
    $VDCMunId1=$address1[1]->VDCMunId;
    $LocalAddress1=$address1[1]->LocalAddress;
    // var_dump($stateId1);exit;
    }
}
}
    $rid='';
    $eid='';
    $rName='';
    $RelationShip='';
    $HomePhone='';
    $MobilePhone='';
    $OfficePhone='';
    $Designation='';
    // var_dump($nominee);exit;
if(isset($_GET['q'])){
if($nominee){
    $url=crmDecryptUrlParameter()[0]['eid'];
    $nominee=$nominee[0];
    $rid=$nominee->RId;
    $eid=$nominee->EId;
    $rName=$nominee->RName;
    $RelationShip=$nominee->RelationShip;
    $HomePhone=$nominee->HomePhone;
    $MobilePhone=$nominee->MobilePhone;
    $OfficePhone=$nominee->OfficePhone;
    $Designation=$nominee->Designation;
    // Designation
}
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>

<!-- <input type="hidden" id="eid" value=""> -->
<input type="hidden" name="eid" class="hidden_eid">




<ul class="nav nav-tabs" id="myTab" role="tablist">
<li class="nav-item">
  <a class="nav-link active" id="pane-customer-details" data-toggle="tab" href="#customer-details-tab" role="tab" aria-controls="customer-details-tab" aria-selected="true">Customer Details</a>
</li>
<li class="nav-item">
  <a class="nav-link" id="pane-address-details" data-toggle="tab" href="#address-details-tab" role="tab" aria-controls="address-details-tab" aria-selected="false" onclick="goNextTab('address-details','address-details',this);">Customer Address</a>
</li>
<li class="nav-item">
  <a class="nav-link" id="pane-nominee-details" data-toggle="tab" href="#nominee-details-tab" role="tab" aria-controls="nominee-details-tab" aria-selected="false" onclick="goNextTab('address-details','nominee-details',this);">Nominee</a>
</li>
</ul>
<div class="tab-content" id="myTabContent">
<div class="b fade show active" id="customer-details-tab" role="tabpanel" aria-labelledby="customer-details-tab-lb">
  <!-- <form id="form-1" method="post" action="<?php echo base_url('registration/namemail')?>" enctype="multipart/form-data"> -->
     <div class="offset-md-2">
         <form id="customer-details" action="<?= base_url('employee/insertUpdateEmployeePersonalDetails') ?>" method="post" class="" nonvalidate>
               <input type="hidden" id="eid" name="eid" value=" <?php echo $url; ?>">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Customer Code<span class="required">*</span> </label>
                        <input id="emp_code" type="text" name="emp_code" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $emCode ?>" placeholder="Customer Code" ><div id="message" style="margin-left: 12px; color:red"></div> <span style="margin-left: 87px">Note:Please provide code only if customer code is being registered</span>
                        
                    </div>
                    
                </div>
                    <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_full_name" class="col-md-3 col-sm-3 col-xs-12">Full Name <span class="required">*</span> </label>
                        <input id="emp_full_name" type="text" name="emp_full_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $fullname ?>" placeholder="Full Name" required>
                    </div>
                </div>
              

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
                                <option <?php //echo $value->EthName == $ethic ? 'selected' : '' ?> value="<?//= $value->EthName ?>"><?//= $value->EthName ?></option>
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
                                $selc = $idtype == $value->Id ? 'selected' : '';
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
    <input type="submit" class="nexttab btn btn-primary"style="margin-left:406px;color: white;" value="Next">

        </div>
  </form>
</div>
<div class="tab-pane fade hide" id="address-details-tab" role="tabpanel" aria-labelledby="address-details-tab-lb">
<form id="address-details" method="POST" action="<?php echo base_url('employee/InsertUpdatePersonalEmployeeAddressDetailscustomerreg')?>">      

                
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
                                <?php  if(isset($_GET['q'])){?>
                                 <input type="hidden" name="aid0" id="aid" value="<?php if($aid0 != '') echo $aid0?>"  readonly>

                                <input type="hidden" name="aid1" id="ef" value="<?php if($aid1 != '') echo $aid1?>">
                                <input type="hidden" name="districtId0" id="districtId0" value="<?php if($DistrictId0 != '') echo $DistrictId0?>" readonly>

                                 <input type="hidden" name="districtId11" id="districtId11" value="<?php if($DistrictId1 != '') echo $DistrictId1 ?>" readonly>

                                 <input type="hidden" name="VDCMunId0" id="VDCMunId0" value="<?php if($VDCMunId0 != '') echo $VDCMunId0?>" readonly>

                                 <input type="hidden" name="VDCMunId11" id="VDCMunId11" value="<?php if($VDCMunId1 != '') echo $VDCMunId1 ?>" readonly>
                               <input type="hidden" id="eid" name="eid" value="<?php if($url != '') echo $url?>">
                                 <?php }else{?>
                                     <input type="hidden" name="eid" class="hidden_eid">
                                     <input type="hidden" name="aid0" id="aid0" value=""  readonly>
                                     <input type="hidden" name="aid1" id="aid1" value=""  readonly>

                               <?php  } ?>

                                <input type="hidden" name="ee" id="ee"  readonly>
                                <input type="hidden" name="ef" id="ef" >
                                <input type="hidden" name="CountryId" id="CountryId" value="1" readonly>
                                <input type="hidden" name="AddressType" id="" value="Permanent" readonly>
                                <input type="hidden" name="AddressType1" id="" value="Temporary" readonly>

                                <?php  if(isset($_GET['q'])){?>
                                            <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">State <span class="required">*</span> </label>
                                    <select id="StateId" name="StateId" class="form-control col-md-7 col-sm-7 col-xs-12"  onchange="changestate1()"> 
                                 <?php foreach ($states as $key => $value) {
                                        $selc = $stateId0 == $value->Id ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selc, $value->Id,$value->Name);
                            } ?>
                                    </select>
                                </div>
                            </div> 
                                <?php }else{?>
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
                            <?php }?>
                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="institution" class="col-md-4 col-sm-4 col-xs-12">District<span class="required">*</span> </label>
                                    <select id="DistrictId" name="DistrictId" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Municipality/VDC  </label>
                                    <select  id="VDCMunId" name="VDCMunId" class="form-control col-md-7 col-sm-7 col-xs-12" > 

                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Local Address <span class="required">*</span> </label>
                                    <input id="LocalAddress" type="text" name="LocalAddress" class="form-control col-md-7 col-sm-7 col-xs-12"  placeholder="Enter Local Address"  value="<?= $LocalAddress0?>"required>
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
                                
                                <?php  if(isset($_GET['q'])){?>
                                   <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">State <span class="required">*</span> </label>
                                    <select id="StateId1" name="StateId1" class="form-control col-md-7 col-sm-7 col-xs-12"  onchange="changestate2()"> 
                                      <?php foreach ($states as $key => $value) {
                                        $selc = $stateId1 == $value->Id ? 'selected' : '';
                                        printf('<option %s value="%s">%s</option>', $selc, $value->Id,$value->Name);
                            } ?>
                                    </select>
                                </div>
                            </div>
                               
                            <?php }else{?>
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
                            <?php }?>
                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="institution" class="col-md-4 col-sm-4 col-xs-12">District<span class="required">*</span> </label>
                                    <select id="DistrictId1" name="DistrictId1" class="form-control col-md-7 col-sm-7 col-xs-12" required> 

                                    </select>
                                
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Municipality/VDC  </label>
                                    <select  id="VDCMunId1" name="VDCMunId1" class="form-control col-md-7 col-sm-7 col-xs-12" > 

                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Local Address <span class="required">*</span> </label>
                                    <input id="LocalAddress1" type="text" name="LocalAddress1" class="form-control col-md-7 col-sm-7 col-xs-12"  placeholder="Enter Local Address"  value="<?= $LocalAddress1?>" required>
                                </div>
                            </div>

                            <div class="form-row form-inline" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Postal Code <span class="required">*</span> </label>
                                    <input id="PostalCode1" type="hidden" name="postalCode1" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Enter Postal Code" required>
                                </div>
                            </div>
    <!-- <input type="submit" class="nexttab btn btn-primary"style="color: white;" value="Next"> -->
    <button class="prevtab btn btn-primary" style="margin-left:456px;color: white;" onclick= "goNextTab('address-details-tab','customer-details-tab');">Prev</button>
    <!-- <button class="nexttab btn btn-primary" style="color: white;" >Next</button> -->
     <input type="submit" class="nexttab btn btn-primary"style="color: white;" value="Next">

  </form>
</div>

<div class="tab-pane fade hide" id="nominee-details-tab" role="tabpanel" aria-labelledby="nominee-details-tab-lb">
  <form id="form-3" method="POST" action="<?php echo base_url('employee/insertUpdateReferenceCon')?>">
<div class="form-row form-inline">

                        <?php if(isset($_GET['q'])){?>
                            
                           <input type="hidden" name="rid" value="<?php if($rid != '') echo $rid?>">

                             <input type="hidden" id="eid" name="eid" value="<?php if($url != '') echo $url?>">
                        <?php }else{?>
                             <input type="hidden" name="rid" value="">
                              <input type="hidden" name="eid" class="hidden_eid">

                              <?php } ?>   

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
                                                    
                                                    <option value="Guardian" <?php echo ($Designation == 'Guardian') ? 'selected' : ''; ?>>Guardian</option>
                                                    <option value="Nominee" <?php  echo ($Designation == 'Nominee') ? 'selected' : ''; ?>>Nominee</option>
                                                    <option value="Verifier"<?php echo ($Designation == 'Verifier') ? 'selected' : ''; ?> >Verifier</option>
                                                    <option value="Others" <?php echo ($Designation == 'Others') ? 'selected' : ''; ?>>Others</option>
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
                                    <input id="rname" type="text" name="rname" class="form-control col-md-7 col-sm-7 col-xs-12" value="<?= $rName  ?>" placeholder="Reference Name" required>
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
                                                    
                                                    <option value="GrandFather" <?php echo ($RelationShip == 'GrandFather') ? 'selected' : ''; ?> >GrandFather</option>
                                                    <option value="GrandMother" <?php echo ($RelationShip == 'GrandMother') ? 'selected' : ''; ?>>GrandMother</option>
                                                    <option value="Father" <?php echo ($RelationShip == 'Father') ? 'selected' : ''; ?>>Father</option>
                                                    <option value="Son" <?php echo ($RelationShip == 'Son') ? 'selected' : ''; ?>>Son</option>
                                                    <option value="Daughter" <?php echo ($RelationShip == 'Daughter') ? 'selected' : ''; ?>>Daughter</option>
                                                    <option value="Wife" <?php echo ($RelationShip == 'Wife') ? 'selected' : ''; ?>>Wife</option>
                                                    <option value="Brother" <?php echo ($RelationShip == 'Brother') ? 'selected' : ''; ?>>Brother</option>
                                                    <option value="Sister" <?php echo ($RelationShip == 'Sister') ? 'selected' : ''; ?>>Sister</option>
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
                                    <input id="homePhone" type="text" name="homePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="<?= $HomePhone  ?>" placeholder="Home Phone" pattern="^\d+$" maxlength="10">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="mobilePhone" class="col-md-4 col-sm-4 col-xs-12">Mobile Phone <span class="required">*</span> </label>
                                    <input id="mobilePhone" type="text" name="mobilePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="<?= $MobilePhone  ?>"placeholder="Mobile Phone" required pattern="^\d+$" maxlength="10">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="officePhone" class="col-md-4 col-sm-4 col-xs-12">Office Phone </label>
                                    <input id="officePhone" type="text" name="officePhone" class="form-control col-md-7 col-sm-7 col-xs-12" value="<?= $OfficePhone  ?>" placeholder="Office Phone" pattern="^\d+$" maxlength="10">
                                </div>
                            </div>
<button class="prevtab btn btn-primary" style="margin-left: 343px;color: white" onclick="goNextTab('nominee-details-tab','address-details-tab');">Prev</button>
<!-- <button  id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button> -->
<input type="submit" class="nexttab btn btn-primary"style="color: white;" value="Submit">

</form>

</div>
</div>

