<?php define('VIEW_LAYOUT_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR) ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title id="maintitle">Agent Tracking | <?= $page['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->

    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
    <link rel="shortcut icon" href="<?= base_url('assets/bootstrap/dist/css/bootstrap.min.css') ?>">

    <?php if (isset($page['styles'])) foreach ($page['styles'] as $stylePath) printf('<link rel="stylesheet" href="%s">', base_url($stylePath)); ?>

    <script type="text/javascript">
        const BASE_URL = '<?= base_url() ?>';
    </script>
</head>

<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header fixed-footer">
        <?php include_once('layouts/header/header.php') ?>
        <div class="app-main" id="app-main">
            <script>
                (function() {
                    var dashboard_e = document.getElementById('app-main')

                    var loaderElem = document.createElement('div');
                    loaderElem.id = 'reportLoading_';
                    var loaderGif = document.createElement('img');
                    loaderGif.style.marginTop = ((window.innerHeight / 2) - 72) + 'px';
                    loaderGif.src = BASE_URL + 'assets/images/loading.gif';

                    loaderElem.append(loaderGif);
                    window.ecrm = {
                        loaderElement: loaderElem
                    };
                    dashboard_e.prepend(loaderElem);
                    window.addEventListener('load', function() {
                        loaderElem.remove();
                    })
                })()
            </script>
            <?php include_once('layouts/sidebar/sidebar.php') ?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php
                    if (isset($settingBundle)) {
                        foreach ($settingBundle as $settingName => $settingFlag) {
                            if ($settingFlag === true || $settingFlag === false)
                                printf('<input type="hidden" name="%s" id="%s" value="%d">', $settingName, $settingName, $settingFlag);
                            else if (is_array($settingFlag))
                                printf('');
                            else
                                printf('<input type="hidden" name="%s" id="%s" value="%s">', $settingName, $settingName, $settingFlag);
                        }
                    }
                    ?>

                    <?php
                    $pageTemplateFile = $page['template'] . '.php';
                    // echo '<pre>';print_r($pageTemplateFile);die;
                    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $pageTemplateFile)) {
                        include_once($pageTemplateFile);
                    } else {
                        include_once('errors/pages/template-not-found.php');
                    }
                    ?>
                </div>
                <?php include_once('layouts/footer/footer.php') ?>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>

    <script type="text/javascript" src="<?= base_url('assets/metismenu/dist/metisMenu.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/daterangepicker-master/moment.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>

    <?php if (isset($page['scripts'])) foreach ($page['scripts'] as $scriptPath) printf('<script type="text/javascript" src="%s"></script> <br>', base_url($scriptPath)); ?>
    <script type="text/javascript" src="<?= base_url('assets/js/live_notification.js') ?>"></script>
    <?php if ($this->uri->segment(2) == 'leaveManage') : ?>
        <!-- Modal only on leave management -->
        <!-- View own leave modal -->
        <div class="modal fade" id="view_own_leave" tabindex="-1" role="dialog" aria-labelledby="view_own_leaveLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view_own_leaveLabel">Leave Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="badge badge-success">Number of leaves requested (<span class="lDays">0</span>)</label>

                        <table class="table-bordered" width="100%">
                            <thead>
                                <th>Leave Date</th>
                                <th>Leave Period</th>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div class="leave_stat_rem">

                        </div>

                        <div class="leave_view_attachment">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- View own leave modal -->

        <!-- change pending status of leave modal -->
        <div class="modal fade" id="view_pend_leave" tabindex="-1" role="dialog" aria-labelledby="view_pend_leaveLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view_pend_leaveLabel">Change Leave Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="changePendLeaveStat" method="post">
                        <div class="modal-body">
                            <div class="form-row">
                                <div id="ema">

                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Leave Status</label>
                                        <select name="pend_stat" id="pend_stat" class="form-control">
                                            <?php
                                            if (isset($content['leaveStat'])) {
                                                foreach ($content['leaveStat'] as $value) {
                                                    printf('<option value="%s">%s</option>', $value->leaveId, $value->leaveStat);
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Leave Change Remarks</label>
                                        <textarea name="leave_changerem" id="leave_changerem" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="change_leave_stat">Change Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- change pending status of leave modal -->
        <!-- Modal only on leave management -->
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'emprofile') : ?>
        <!-- Modal only on employee profile -->
        <!-- education modal -->
        <div class="modal fade" id="educationModal" tabindex="-1" role="dialog" aria-labelledby="educationModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="educationModalLabel">Education Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="educationForm" method="post" action="<?= base_url('employee/insertUpdateEducationDetail') ?>">
                        <div class="modal-body">
                            <div class="form-row form-inline">
                                <input type="hidden" name="ee" id="ee" value="<?= $_GET['q'] ?>" readonly>
                                <input type="hidden" name="ef" id="ef" readonly>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">Occupation <span class="required">*</span> </label>
                                    <input id="qualification" type="text" name="qualification" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Occupation" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="institution" class="col-md-4 col-sm-4 col-xs-12">Institution <span class="required">*</span> </label>
                                    <input id="institution" type="text" name="institution" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Institution" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Start Date <span class="required">*</span> </label>
                                    <input id="eduStartDate" type="text" name="eduStartDate" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Start Date" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduCompleteDate" class="col-md-4 col-sm-4 col-xs-12">Completion Date <span class="required">*</span> </label>
                                    <input id="eduCompleteDate" type="text" name="eduCompleteDate" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Completion Date" required>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveEduBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- education modal -->

         <!-- Address modal -->
         <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="educationModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="educationModalLabel">Address Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="educationForm" method="post" action="<?= base_url('employee/InsertUpdatePersonalEmployeeAddressDetails') ?>">
                        <div class="modal-body">
                        <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Address Type<span class="required">*</span> </label>
                                    <select  id="AddressType" name="AddressType" class="form-control col-md-7 col-sm-7 col-xs-12" required> 
                                        <option value="">Select Address Type</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="temporary">Temporary</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <input type="hidden" name="ee" id="ee" value="<?= $_GET['q'] ?>" readonly>
                                <input type="hidden" name="ef" id="ef" >
                                <input type="hidden" name="CountryId" id="CountryId" value="1" readonly>

                                
                                <div class="col-md-12 form-group mb-3">
                                    <label for="qualification" class="col-md-4 col-sm-4 col-xs-12">State <span class="required">*</span> </label>
                                    <select id="StateId" name="StateId" class="form-control col-md-7 col-sm-7 col-xs-12"  onchange="changestate()"> 
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
                                    <label for="eduStartDate" class="col-md-4 col-sm-4 col-xs-12">Municipality/VDC  </label>
                                    <select  id="VDCMunId" name="VDCMunId" class="form-control col-md-7 col-sm-7 col-xs-12" > 

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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveEduBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Address modal -->
        <!-- experience modal -->
        <div class="modal fade" id="experienceModal" tabindex="-1" role="dialog" aria-labelledby="experienceModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="experienceModalLabel">Experience Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="experienceForm" method="post" action="<?= base_url('employee/insertUpdateExperience') ?>">
                        <div class="modal-body">

                            <div class="form-row form-inline">
                                <input type="hidden" name="exe" id="exe" value="<?= $_GET['q'] ?>" readonly>
                                <input type="hidden" name="exf" id="exf" readonly>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="skills" class="col-md-4 col-sm-4 col-xs-12">Skills <span class="required">*</span> </label>
                                    <input id="skills" type="text" name="skills" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Skills" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="experiences" class="col-md-4 col-sm-4 col-xs-12">Experiences <span class="required">*</span> </label>
                                    <input id="experiences" type="text" name="experiences" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Experiences" required>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveExpBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- experience modal -->
        <!-- reference modal -->
        <div class="modal fade" id="refModal" tabindex="-1" role="dialog" aria-labelledby="refModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refModalLabel">References Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="refForm" method="post" action="<?= base_url('employee/insertUpdateReferenceCon') ?>">
                        <div class="modal-body">

                            <div class="form-row form-inline">
                                <input type="hidden" name="ece" id="ece" value="<?= $_GET['q'] ?>" readonly>
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

                        </div>


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

                           
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveRefBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal reference -->
        <?php
        $comDet = $content['comDet'];
        $depDet = $content['depDet'];
        $desDet = $content['desDet'];
        $spDet = $content['spDet'];
        $emYL = $content['emYL'];
        $emLL = $content['emLL'];
        ?>
        <!-- modal job -->
        <div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <?php ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobModalLabel">Job Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="jobForm" method="post" action="<?= base_url('employee/insertUpdateEmployeeDes') ?>">
                        <div class="modal-body">

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
                            <?php if ($content) { }
                            $bas = $content['allDet']['bas'];
    
                        // var_dump($bas);exit;?>
                            <div class="form-row form-inline" id="customerCodeId" style="display:none">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="customerId" class="col-md-4 col-sm-4 col-xs-12">Customer Code <span class="required">*</span> </label>
                                    <input name="position" id="position" class="form-control col-md-7 col-sm-7 col-xs-12" value="<?= $bas[0]->EmpCode?>">     
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
                                    <select name="supervisorId" id="supervisorId" class="form-control col-md-7 col-sm-7 col-xs-12" required>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveJobBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal job -->
        <!-- modal documents -->
        <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Document Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="documentForm" method="post" action="<?= base_url('employee/insertUpdateEmployeeDocument') ?>">
                        <div class="modal-body">

                            <div class="form-row form-inline">
                                <input type="hidden" name="edo" id="edo" value="<?= $_GET['q'] ?>" readonly>
                                <input type="hidden" name="did" id="did" value="" readonly>
                                <!-- <input type="hidden" name="exf" id="exf" readonly> -->
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="doc_name" class="col-md-4 col-sm-4 col-xs-12">Document Name <span class="required">*</span> </label>
                                    <input id="doc_name" type="text" name="doc_name" class="form-control col-md-7 col-sm-7 col-xs-12" value="" placeholder="Document Name" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="doc_type" class="col-md-4 col-sm-4 col-xs-12">Document Type <span class="required">*</span> </label>
                                    <select name="doc_type" id="doc_type" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <option value="Citizenship">Citizenship</option>
                                        <option value="Certificate">Certificate</option>
                                        <option value="Certificate">Liscense</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="document_attachment" class="col-md-4 col-sm-4 col-xs-12">Document</label>
                                    <div class="file-upload col-md-7 col-sm-7 col-xs-12">
                                        <div class="image-upload-wrap">
                                            <input class="file-upload-input" name="document_attachment" id="document_attachment" type='file' onchange="readURL(this);" accept="image/jpeg, image/x-png, image/gif" />
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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveDocBtn">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal documents -->
        <!-- modal bank details -->
        <div class="modal fade" id="bankModal" tabindex="-1" role="dialog" aria-labelledby="bankModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bankModalLabel">Bank Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="bankDetailForm" method="post" action="<?= base_url('employee/insertUpdateBankDetails') ?>">
                        <div class="modal-body">
                            <input type="hidden" name="ebi" id="ebi" value="<?= $_GET['q'] ?>" readonly>
                            <input type="hidden" name="bbi" id="bbi" value="" readonly>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="bank_name" class="col-md-4 col-sm-4 col-xs-12">Bank Name <span class="required">*</span> </label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control col-md-7 col-sm-7 col-xs-12" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="bank_branch" class="col-md-4 col-sm-4 col-xs-12">Bank Branch </label>
                                    <input type="text" name="bank_branch" id="bank_branch" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="bank_account_no" class="col-md-4 col-sm-4 col-xs-12">Account No <span class="required">*</span> </label>
                                    <input type="text" name="bank_account_no" id="bank_account_no" class="form-control col-md-7 col-sm-7 col-xs-12" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="bank_isactive" class="col-md-4 col-sm-4 col-xs-12">Is Active <span class="required">*</span> </label>
                                    <input type="checkbox" name="bank_isactive" id="bank_isactive">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBankBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal bank details -->
        <!-- modal bank details -->
        <div class="modal fade" id="salModal" tabindex="-1" role="dialog" aria-labelledby="salModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="salModalLabel">Salary Lookup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="salaryDetailForm" method="post" action="<?= base_url('employee/insertUpdateSalaryLookup') ?>">
                        <div class="modal-body">
                            <input type="hidden" name="sbi" id="sbi" value="<?= $_GET['q'] ?>" readonly>
                            <input type="hidden" name="ssbi" id="ssbi" value="" readonly>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="marital_stat" class="col-md-4 col-sm-4 col-xs-12">Marital Status <span class="required">*</span> </label>
                                    <input type="radio" class="ml-3 mr-2" name="marital_stat" value="1" checked> Unmarried
                                    <input type="radio" class="ml-3 mr-2" name="marital_stat" value="2"> Married
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="basic_salary" class="col-md-4 col-sm-4 col-xs-12">Basic Salary <span class="required">*</span> </label>
                                    <input type="number" name="basic_salary" id="basic_salary" class="form-control col-md-7 col-sm-7 col-xs-12" required>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="festival_bonus" class="col-md-4 col-sm-4 col-xs-12">Festival Bonus </label>
                                    <input type="number" name="festival_bonus" id="festival_bonus" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="allowance" class="col-md-4 col-sm-4 col-xs-12">Allowance </label>
                                    <input type="number" name="allowance" id="allowance" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="others" class="col-md-4 col-sm-4 col-xs-12">Others </label>
                                    <input type="number" name="others" id="others" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="provident_fund" class="col-md-4 col-sm-4 col-xs-12">Provident Fund </label>
                                    <input type="number" name="provident_fund" id="provident_fund" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="citizen_investment" class="col-md-4 col-sm-4 col-xs-12">Citizen Investment Trust </label>
                                    <input type="number" name="citizen_investment" id="citizen_investment" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="insurance" class="col-md-4 col-sm-4 col-xs-12">Insurance </label>
                                    <input type="number" name="insurance" id="insurance" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="other_fund" class="col-md-4 col-sm-4 col-xs-12">Other Fund </label>
                                    <input type="number" name="other_fund" id="other_fund" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="tds" class="col-md-4 col-sm-4 col-xs-12">TDS </label>
                                    <input type="number" name="tds" id="tds" class="form-control col-md-7 col-sm-7 col-xs-12" step="0.01">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="total_payable" class="col-md-4 col-sm-4 col-xs-12">Total Payable </label>
                                    <input type="number" name="total_payable" id="total_payable" class="form-control col-md-7 col-sm-7 col-xs-12" step="0.01" tabindex='-1'>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="sal_isactive" class="col-md-4 col-sm-4 col-xs-12">Is Active <span class="required">*</span> </label>
                                    <input type="checkbox" name="sal_isactive" id="sal_isactive" checked tabindex='-1'>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveSalBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal bank details -->
        <!-- Modal only on employee profile -->
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'leaveGroup') : ?>
        <!-- modal only on leave group -->
        <!-- modal leave group -->
        <div class="modal fade" id="leaveGroupModal" tabindex="-1" role="dialog" aria-labelledby="leaveGroupModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leaveGroupModalLabel">Leave Group Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="leaveGroupForm" method="post" action="<?= base_url('leave/insertUpdateLeaveGroup') ?>">
                        <div class="modal-body">

                            <div class="form-row form-inline">
                                <input type="hidden" name="eeff" id="eeff">
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="leave_group" class="col-md-4 col-sm-4 col-xs-12">Leave Group<span class="required">*</span> </label>
                                    <select name="leave_group" id="leave_group" class="form-control col-md-7 col-sm-7 col-xs-12">
                                        <?php foreach ($content['lGroup'] as $value) {
                                            printf('<option value="%s">%s</option>', $value->GId, $value->LeaveGroup);
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="start_period" class="col-md-4 col-sm-4 col-xs-12">Start Period<span class="required">*</span> </label>
                                    <input id="start_period" type="text" name="start_period" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="end_period" class="col-md-4 col-sm-4 col-xs-12">End Period<span class="required">*</span> </label>
                                    <input id="end_period" type="text" name="end_period" class="form-control col-md-7 col-sm-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="isactive" class="col-md-4 col-sm-4 col-xs-12">IsActive<span class="required">*</span> </label>
                                    <fieldset class="position-relative form-group">
                                        <div class="position-relative form-check">
                                            <label class="form-check-label mr-3">
                                                <input type="radio" name="isactive" value="1" class="form-check-input" checked> Active
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveGroup">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal leave group -->
        <!-- modal only on leave group -->
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'appointmentTab') : ?>
        <!-- modal edit time -->
        <div class="modal fade" id="editTimeModal" tabindex="-1" role="dialog" aria-labelledby="editTimeModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTimeModalLabel">Edit Outgoing Time</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="editTimeForm" method="post" action="<?= base_url('visitor/updateOutTime') ?>">
                        <div class="modal-body">

                            <input type="hidden" name="ai" id="ai">

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="intime" class="col-md-4 col-sm-4 col-xs-12">In Time</label>
                                    <label for="intime" class="col-md-7 col-sm-7 col-xs-12 intimelabel" style="justify-content: left;">--:--:--</label>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="outtime" class="col-md-4 col-sm-4 col-xs-12">Outgoing Time<span class="required">*</span> </label>
                                    <input id="outtime" type="text" name="outtime" class="form-control col-md-7 col-sm-7 col-xs-12" required>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="editTime">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal edit time -->
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'viewAppForAd') : ?>
        <!-- modal for admin view with accept and cancel -->
        <div class="modal fade" id="editAppModal" tabindex="-1" role="dialog" aria-labelledby="editAppModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAppModalLabel"><?= $header['visitor'] . ' ' . $header['introduce'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="editAppForm" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="app_headers"><?= $header['name'] ?></span>: <span class="app_namer"></span>
                                </div>
                                <div class="col-md-12">
                                    <span class="app_headers"><?= $header['address'] ?></span>: <span class="app_addresser"></span>
                                </div>
                                <div class="col-md-12">
                                    <span class="app_headers"><?= $header['subject'] ?></span>: <span class="app_remarker"></span>
                                </div>
                                <div class="col-md-6">
                                    <span class="app_headers"><?= $header['date'] ?></span>: <span class="app_dater"></span>
                                </div>
                                <div class="col-md-6">
                                    <span class="app_headers"><?= $header['time'] ?></span>: <span class="app_timer"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="editAppAc"><?= $header['accept'] ?></button>
                            <button type="button" class="btn btn-danger" id="canAppAc" data-ai=""><?= $header['cancel'] ?></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $header['close'] ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal for admin view with accept and cancel -->
    <?php endif; ?>

    <?php if ($this->session->flashdata('show_notice')) : ?>
        <div class="modal fade" id="noticeAppModal" tabindex="-1" role="dialog" aria-labelledby="noticeAppModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noticeAppModalLabel">Notice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="noticeModaller">
                                <thead>
                                    <th>Notice Title</th>
                                    <th>Notice Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $header['close'] ?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $.ajax({
                url: BASE_URL + 'notice/ajaxNotice',
                method: 'post',
                dataType: 'json',
                data: ''
            }).done(function(res) {
                let tbla = '';
                if (res.length != 0) {
                    res.forEach(element => {
                        tbla += '<tr><td>' + element.NoticeTitle + '</td><td>' + element.NoticeDescription + '</td><td>' + element.NoticeStartDate.split('T')[0] + '</td><td>' + element.NoticeEndDate.split('T')[0] + '</td></tr>'
                    });
                    $('#noticeModaller tbody').html(tbla)
                    $('#noticeAppModal').modal('show');
                }
            }).fail(function(res) {
                console.log('server error');
            })
        </script>
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'viewProfile') :
        $emDet = $content['emDet'];
        $uStat = $content['uStat'];
        $projDet = $content['projDet'];
        $cStat = $content['cStat'];
        $mList = $content['mList'];
        $csfToken = $content['csfToken'];
    ?>
        <div class="modal fade" id="socialMediaModal" tabindex="-1" role="dialog" aria-labelledby="socialMediaModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="socialMediaModalLabel">Social Media</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="socler" action="<?= base_url('crm/addSocialMedia') ?>" method="post">
                        <div class="modal-body">

                            <input type="hidden" name="cust_id" id="cust_id" value="<?= $_GET['q'] ?>">

                            <input type="hidden" name="cust_hider" id="cust_hider" value="">

                            <input type="hidden" name="csftoken" id="csftoken" value="<?= $csfToken ?>" readonly>

                            <div class="form-row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Social Media Type</label>
                                        <select name="media_id" id="media_id" class="form-control">
                                            <?php foreach ($mList as $key => $value) { ?>
                                                <option value="<?= $value->SId ?>"><?= $value->SocialMediaName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Social Media Link</label>
                                        <input type="text" name="media_link" id="media_link" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Contact Person</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="socler" action="<?= base_url('crm/addContactPerson') ?>" method="post">
                        <div class="modal-body">

                            <input type="hidden" name="concust_id" id="concust_id" value="<?= $_GET['q'] ?>" readonly>

                            <input type="hidden" name="concust_hider" id="concust_hider" value="">

                            <div class="form-row">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Contact Person Name</label>
                                        <input type="text" name="cont_per_name" id="cont_per_name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Contact Person Number</label>
                                        <input type="text" name="cont_per_num" id="cont_per_num" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Contact Person Email</label>
                                        <input type="email" name="cont_per_email" id="cont_per_email" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Contact Person Designation</label>
                                        <input type="text" name="cont_per_des" id="cont_per_des" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Is Active</label> <br />
                                        <input type="checkbox" name="isactive" id="isactive" checked>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeModalLabel">Employee Assign</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="socler" action="<?= base_url('crm/addCustomerAssign') ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="assigncust_id" id="assigncust_id" value="<?= $_GET['q'] ?>">
                            <input type="hidden" name="csf" value="">
                            <div class="form-row">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">User</label>
                                        <select name="cust_userid" id="cust_userid" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($emDet as $key => $value) { ?>
                                                <option value="<?= $value->EId ?>"><?= $value->EmployeeName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">User Status</label>
                                        <select name="cust_user_stat" id="cust_user_stat" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($uStat as $key => $value) { ?>
                                                <option value="<?= $value->EId ?>"><?= $value->UserStatus ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Remarks</label>
                                        <textarea name="cust_remarks" id="cust_remarks" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Is Active</label> <br />
                                        <input type="checkbox" name="isactive" id="isactive" checked>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="productLeadModal" tabindex="-1" role="dialog" aria-labelledby="productLeadModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productLeadModalLabel">Product Lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="<?= base_url('crm/addProductLead') ?>" method="post">
                        <div class="modal-body">

                            <div class="form-row">

                                <input type="hidden" name="prodd_id" id="prodd_id" value="<?= $_GET['q'] ?>">
                                <input type="hidden" name="csff" id="csff" value="">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Project</label>
                                        <select name="pro_project_id" id="pro_project_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($projDet as $key => $value) { ?>
                                                <option value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Lead Status</label>
                                        <select name="pro_lead_stat" id="pro_lead_stat" class="form-control">
                                            <?php foreach ($cStat as $key => $value) { ?>
                                                <option value="<?= $value->CId ?>"><?= $value->CustomerStatus ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Amount</label>
                                        <input type="number" name="pro_amount" id="pro_amount" class="form-control" min="0" step="0.01">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Probability</label>
                                        <input type="text" name="pro_proba" id="pro_proba" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Lead Closed Date</label>
                                        <input type="text" name="pro_lead_close_date" id="pro_lead_close_date" class="form-control datepicker" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Attachments Link</label>
                                        <input type="file" name="document_attachment">
                                        <!-- <input type="text" name="pro_attach_link" id="pro_attach_link" class="form-control"> -->
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Remarks</label>
                                        <textarea name="pro_remarks" id="pro_remarks" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->uri->segment(2) == 'viewTracks' || $this->uri->segment(2) == 'complainProfile') : ?>
        <div class="modal fade" id="add_comment" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form id="complainForm" action="<?= base_url('complain/ajaxUpdateComplainStatus') ?>" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="comp_stat_id" id="comp_stat_id">

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="comp_stat_comment">Complain Status<span class="required">*</span> </label>
                                    <select name="comp_stat_comment" id="comp_stat_comment" class="form-control col-md-12 col-sm-6 col-xs-12">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($reqType as $key => $value) {
                                            printf('<option value="%d">%s</option>', $value->Id, $value->title);
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="remarks_comment">Remarks </label>
                                    <textarea name="remarks_comment" id="remarks_comment" class="form-control col-md-12 col-sm-6 col-xs-12"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="post" class="btn btn-primary">Post</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- here see see -->
    <!-- <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Before Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- here see see -->
    <?php if ($this->uri->segment(2) == 'emp_type') : ?>
        
    <?php endif;?>

    <?php if ($this->uri->segment(2) == 'expense_head') : ?>
        
    <?php endif;?>
</body>

</html>