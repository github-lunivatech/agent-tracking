<?php
$eid = 0;
$shown = true;
$isSaved = 'Save';
$btnColor = 'primary';
if (isset($_GET['q'])) {
    $eid = crmDecryptUrlParameter()[0]['eid'];
}

if ($content) {
    $bas = $content['allDet']['bas'];
    $edu = $content['allDet']['edu'];
    $exp = $content['allDet']['exp'];
    $des = $content['allDet']['des'];
    $ref = $content['allDet']['ref'];
    $doc = $content['allDet']['doc'];
}

$comDet = $content['comDet'];
$depDet = $content['depDet'];
$desDet = $content['desDet'];
$spDet = $content['spDet'];
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-primary col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#bas" class="nav-link active">Basic Info</a></li>
            <?php if ($shown) : ?>
                <li class="nav-item"><a data-toggle="tab" href="#edu" class="nav-link">Education</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#exp" class="nav-link">Experience</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#des" class="nav-link">Designation</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#con" class="nav-link">Contact</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#doc" class="nav-link">Documents</a></li>
            <?php endif; ?>
        </ul>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane active" id="bas" role="tabpanel">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive profile_img" />
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <h4 class="em_name"><?php if ($bas) echo $bas[0]->EmployeeName ?></h4>
                                            <?php if ($bas) { ?>
                                                <div class="minor-details">
                                                    <label for="">(<?= $bas[0]->EmpCode ?>)</label> <br />
                                                    <!-- <label for=""><i class="pe-7s-date"></i> <?= $bas[0]->EmployeeGender ?></label> <br /> -->
                                                    <label for=""><i class="pe-7s-phone"></i> <?= $bas[0]->EmployeeMobileNumber ?></label> <br />
                                                    <!-- <label for="">
                                                    <i class="<?php echo $bas[0]->IsActive ? 'pe-7s-id' : 'pe-7s-delete-user' ?>"></i> <?php echo $bas[0]->IsActive ? 'Active' : 'Inactive' ?>
                                                </label> <br /> -->
                                                    <label for=""><i class="pe-7s-compass"></i> <?= $bas[0]->EmployeeAddress ?></label> <br />
                                                    <label for=""><i class="pe-7s-mail"></i> <?= $bas[0]->EmployeeEmailId ?></label>
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <a href="<?= base_url('employee/em_edit?q=') . crmEncryptUrlParameter('eid=' . $eid) ?>" class="btn btn-success"><i class="metismenu-icon pe-7s-pen"></i> Edit Info</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="edu" role="tabpanel">
                        <h2 class="card-title">Education Detail</h2>
                        <form action="<?= base_url('employee/insertUpdateEducationDetail') ?>" method="POST">
                            <div class="offset-md-2">
                                <input type="hidden" value="<?php if ($edu) {
                                                                echo $edu[0]->EdId;
                                                            } ?>" name="edid">
                                <input type="hidden" value="<?php if ($eid) {
                                                                echo $eid;
                                                            } ?>" name="eid">
                                <input type="hidden" value="<?php if ($edu) {
                                                                echo $edu[0]->EntryDate;
                                                            } ?>" name="ent_date">
                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="qualification" class="col-md-3 col-sm-3 col-xs-12">Qualification <span class="required">*</span> </label>
                                        <input id="qualification" type="text" name="qualification" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($edu) {
                                                                                                                                                                echo $edu[0]->Qualification;
                                                                                                                                                            } ?>" placeholder="Qualification" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="institution" class="col-md-3 col-sm-3 col-xs-12">Institution <span class="required">*</span> </label>
                                        <input id="institution" type="text" name="institution" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($edu) {
                                                                                                                                                            echo $edu[0]->Institution;
                                                                                                                                                        } ?>" placeholder="Institution" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="startDate" class="col-md-3 col-sm-3 col-xs-12">Start Date <span class="required">*</span> </label>
                                        <input id="startDate" type="text" name="startDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($edu) {
                                                                                                                                                        echo explode('T', $edu[0]->StartDate)[0];
                                                                                                                                                    } ?>" placeholder="Start Date" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="completeDate" class="col-md-3 col-sm-3 col-xs-12">Completion Date <span class="required">*</span> </label>
                                        <input id="completeDate" type="text" name="completeDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($edu) {
                                                                                                                                                                echo explode('T', $edu[0]->CompletionDate)[0];
                                                                                                                                                            } ?>" placeholder="Completion Date" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-<?= $btnColor ?> pull-right"><?= $isSaved ?></button>
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane" id="exp" role="tabpanel">
                        <h2 class="card-title">Experience Details</h2>
                        <form action="<?= base_url('employee/insertUpdateExperience') ?>" method="POST">
                            <input type="hidden" value="<?php if ($exp) {
                                                            echo $exp[0]->ExpId;
                                                        } ?>" name="expid">
                            <input type="hidden" value="<?php if ($eid) {
                                                            echo $eid;
                                                        } ?>" name="eid">
                            <input type="hidden" value="<?php if ($exp) {
                                                            echo $exp[0]->EntryDate;
                                                        } ?>" name="ent_date">

                            <div class="offset-md-2">

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="skills" class="col-md-3 col-sm-3 col-xs-12">Skills <span class="required">*</span> </label>
                                        <input id="skills" type="text" name="skills" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($exp) {
                                                                                                                                                    echo $exp[0]->Skills;
                                                                                                                                                } ?>" placeholder="Skills" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="experiences" class="col-md-3 col-sm-3 col-xs-12">Experiences <span class="required">*</span> </label>
                                        <input id="experiences" type="text" name="experiences" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($exp) {
                                                                                                                                                            echo $exp[0]->Experiences;
                                                                                                                                                        } ?>" placeholder="Experiences" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-<?= $btnColor ?> pull-right"><?= $isSaved ?></button>

                            </div>

                        </form>

                    </div>

                    <div class="tab-pane" id="des" role="tabpanel">
                        <h2 class="card-title">Designation Details</h2>
                        <form action="<?= base_url('employee/insertUpdateEmployeeDes') ?>" method="POST">
                            <input type="hidden" value="<?php if ($des) {
                                                            echo $des[0]->EdId;
                                                        } ?>" name="edid">
                            <input type="hidden" value="<?php if ($eid) {
                                                            echo $eid;
                                                        } ?>" name="eid">
                            <input type="hidden" value="<?php if ($des) {
                                                            echo $des[0]->EntryDate;
                                                        } ?>" name="ent_date">

                            <div class="offset-md-2">
                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="companyId" class="col-md-3 col-sm-3 col-xs-12">company <span class="required">*</span> </label>
                                        <select name="companyId" id="companyId" class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <?php foreach ($comDet as $value) {
                                                printf('<option value="%s">%s</option>', $value->CId, $value->CompanyName);
                                            } ?>
                                        </select>
                                        <!-- <?php if ($des) {
                                                    echo $des[0]->CompanyId;
                                                } ?> -->
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="departmentId" class="col-md-3 col-sm-3 col-xs-12">department <span class="required">*</span> </label>
                                        <select name="departmentId" id="departmentId" class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <?php foreach ($depDet as $value) {
                                                printf('<option value="%s">%s</option>', $value->DId, $value->DepartmentName);
                                            } ?>
                                        </select>
                                        <!-- <?php if ($des) {
                                                    echo $des[0]->DepartmentId;
                                                } ?> -->
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="designationId" class="col-md-3 col-sm-3 col-xs-12">designation <span class="required">*</span> </label>
                                        <select name="designationId" id="designationId" class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <?php foreach ($desDet as $value) {
                                                printf('<option value="%s">%s</option>', $value->DId, $value->Designation);
                                            } ?>
                                        </select>
                                        <!-- <?php if ($des) {
                                                    echo $des[0]->DesignationId;
                                                } ?> -->
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="position" class="col-md-3 col-sm-3 col-xs-12">position <span class="required">*</span> </label>
                                        <input id="position" type="text" name="position" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($des) {
                                                                                                                                                        echo $des[0]->Position;
                                                                                                                                                    } ?>" placeholder="position" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="supervisorId" class="col-md-3 col-sm-3 col-xs-12">supervisor <span class="required">*</span> </label>
                                        <select name="supervisorId" id="supervisorId" class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <option value="">Select Supervisor</option>
                                            <?php foreach ($spDet as $key => $value) {
                                                if ($value->IsActive) {
                                                    $isselected = '';
                                                    if ($des) {
                                                        if($des[0]->SupervisorId == $value->EId){
                                                            $isselected = 'selected';
                                                        }
                                                    }
                                                    printf('<option %s value="%s">%s</option>', $isselected, $value->EId, $value->EmployeeName);
                                                }
                                            } ?>
                                        </select>
                                        <!-- <input id="supervisorId" type="text" name="supervisorId"  value="" placeholder="supervisor" required> -->
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="reportingManager" class="col-md-3 col-sm-3 col-xs-12">reportingManager <span class="required">*</span> </label>
                                        <select name="reportingManager" id="reportingManager" class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <option value="">Select Reporting Manager</option>
                                            <?php foreach ($spDet as $key => $value) {
                                                if ($value->IsActive) {
                                                    $ismanagerselected = '';
                                                    if ($des) {
                                                        if($des[0]->ReportingManager == $value->EId){
                                                            $ismanagerselected = 'selected';
                                                        }
                                                    }
                                                    printf('<option %s value="%s">%s</option>',$ismanagerselected, $value->EId, $value->EmployeeName);
                                                }
                                            } ?>
                                        </select>
                                        <!-- <input id="reportingManager" type="text" name="reportingManager"  value="" placeholder="reportingManager" required> -->
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="basicSalary" class="col-md-3 col-sm-3 col-xs-12">basicSalary <span class="required">*</span> </label>
                                        <input id="basicSalary" type="text" name="basicSalary" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($des) {
                                                                                                                                                            echo $des[0]->BasicSalary;
                                                                                                                                                        } ?>" placeholder="basicSalary" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">IsActive<span class="required">*</span> </label>
                                        <fieldset class="position-relative form-group">
                                            <div class="position-relative form-check">
                                                <label class="form-check-label mr-3">
                                                    <input <?php if ($des) {
                                                                echo $des[0]->IsActive == true ? 'checked' : '';
                                                            } ?> type="radio" name="isactive" value="1" class="form-check-input"> Active
                                                </label>
                                            </div>
                                            <div class="position-relative form-check">
                                                <label class="form-check-label mr-3">
                                                    <input <?php if ($des) {
                                                                echo $des[0]->IsActive == false ? 'checked' : '';
                                                            } ?> type="radio" name="isactive" value="0" class="form-check-input"> Inactive
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-<?= $btnColor ?> pull-right"><?= $isSaved ?></button>

                            </div>
                        </form>

                    </div>

                    <div class="tab-pane" id="con" role="tabpanel">
                        <h2 class="card-title">Refrence Contacts</h2>
                        <form action="<?= base_url('employee/insertUpdateReferenceCon') ?>" method="POST">
                            <input type="hidden" value="<?php if ($ref) {
                                                            echo $ref[0]->RId;
                                                        } ?>" name="rid">
                            <input type="hidden" value="<?php if ($eid) {
                                                            echo $eid;
                                                        } ?>" name="eid">
                            <input type="hidden" value="<?php if ($ref) {
                                                            echo $ref[0]->EntryDate;
                                                        } ?>" name="ent_date">
                            <div class="offset-md-2">
                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="rname" class="col-md-3 col-sm-3 col-xs-12">Reference Name <span class="required">*</span> </label>
                                        <input id="rname" type="text" name="rname" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                echo $ref[0]->RName;
                                                                                                                                            } ?>" placeholder="Reference Name" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="relation" class="col-md-3 col-sm-3 col-xs-12">relationship <span class="required">*</span> </label>
                                        <input id="relation" type="text" name="relation" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                        echo $ref[0]->RelationShip;
                                                                                                                                                    } ?>" placeholder="relationship" required>
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="homePhone" class="col-md-3 col-sm-3 col-xs-12">Home Phone </label>
                                        <input id="homePhone" type="text" name="homePhone" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                        echo $ref[0]->HomePhone;
                                                                                                                                                    } ?>" placeholder="Home Phone" pattern="^\d+$" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="mobilePhone" class="col-md-3 col-sm-3 col-xs-12">Mobile Phone <span class="required">*</span> </label>
                                        <input id="mobilePhone" type="text" name="mobilePhone" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                            echo $ref[0]->MobilePhone;
                                                                                                                                                        } ?>" placeholder="Mobile Phone" required pattern="^\d+$" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="officePhone" class="col-md-3 col-sm-3 col-xs-12">Office Phone </label>
                                        <input id="officePhone" type="text" name="officePhone" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                            echo $ref[0]->OfficePhone;
                                                                                                                                                        } ?>" placeholder="Office Phone" pattern="^\d+$" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="Designation" class="col-md-3 col-sm-3 col-xs-12">Designation <span class="required">*</span> </label>
                                        <input id="Designation" type="text" name="Designation" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($ref) {
                                                                                                                                                            echo $ref[0]->Designation;
                                                                                                                                                        } ?>" placeholder="Designation" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-<?= $btnColor ?> pull-right"><?= $isSaved ?></button>
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane" id="doc" role="tabpanel">
                        <h2 class="card-title">Documents</h2>
                        <form id="doc_upload" action="<?= base_url('employee/insertUpdateEmployeeDocument') ?>" method="POST">
                            <input type="hidden" value="<?php if ($doc) {
                                                            echo $doc[0]->DId;
                                                        } ?>" name="did">
                            <input type="hidden" value="<?php if ($eid) {
                                                            echo $eid;
                                                        } ?>" name="eid">
                            <input type="hidden" value="<?php if ($doc) {
                                                            echo $doc[0]->EntryDate;
                                                        } ?>" name="ent_date">
                            <div class="offset-md-2">

                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="doc_name" class="col-md-3 col-sm-3 col-xs-12">Document Name <span class="required">*</span> </label>
                                        <input id="doc_name" type="text" name="doc_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php if ($doc) {
                                                                                                                                                        echo $ref[0]->RName;
                                                                                                                                                    } ?>" placeholder="Document Name" required>
                                    </div>
                                </div>


                                <div class="form-row form-inline">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="doc_up" class="col-md-3 col-sm-3 col-xs-12">Document</label>
                                        <div class="file-upload col-md-6 col-sm-6 col-xs-12">
                                            <div class="image-upload-wrap">
                                                <input class="file-upload-input" name="doc_up" id="doc_up" type='file' onchange="readURL(this);" accept="image/jpeg, image/x-png, image/gif" />
                                                <div class="drag-text">
                                                    <h3>
                                                        Drag or Select to upload Document<br />
                                                        <i class="pe-7s-cloud-upload"></i>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="file-upload-content">
                                                <img class="file-upload-image" src="#" alt="image" />
                                                <div class="image-title-wrap">
                                                    <button type="button" id="remove_image_button" class="btn btn-danger mt-3">Remove Document</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="mt-2 btn btn-primary pull-right">Upload</button>

                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>