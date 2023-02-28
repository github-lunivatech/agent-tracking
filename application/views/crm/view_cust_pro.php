<?php
$customerContent = $content['customerDet'];
$customerSocial = $content['customerSocial'];
$customerContact = $content['customerContact'];
$customerAssigned = $content['customerAssigned'];
$customerChange = $content['customerChange'];
$customerLead = $content['customerLead'];
$reqType = $content['reqType'];
$payDet = $content['payDet'];
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}

$ccidd = crmEncryptUrlParameter('cid=' . crmDecryptWithParameter($_GET['q'])[0]['cid']);
?>
<style>
    .nav-tabs {
        margin-bottom: unset;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#details" class="nav-link active">Details</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#social" class="nav-link">Social Media</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#contact" class="nav-link">Contact Person</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#employee" class="nav-link">Employee Assign</a></li>

            <?php if (strtolower($customerContent[0]->CustomerCurrentStatus) == 'converted') : ?>
                <li class="nav-item"><a data-toggle="tab" href="#change" class="nav-link">Change Request</a></li>
            <?php endif; ?>
            <li class="nav-item"><a data-toggle="tab" href="#product_leader" class="nav-link">Product Lead</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#pay_det" class="nav-link">Payment Details</a></li>
        </ul>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="details" role="tabpanel">
                        <h2 class="card-title">Customer Profile</h2>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <img src="<?= base_url('assets/images/unk.png') ?>" alt="" class="img-rounded img-responsive profile_img" />
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <h4 class="em_name mt-4"><?php if ($customerContent) echo $customerContent[0]->CustomerName ?></h4>
                                            <?php if ($customerContent) { ?>
                                                <div class="minor-details">
                                                    <label for=""><i class="pe-7s-phone"></i>
                                                        <?= $customerContent[0]->CustomerContactNumber ?></label> <br />
                                                    <label for=""><i class="pe-7s-mail"></i>
                                                        <?= $customerContent[0]->CustomerEmailId ?></label> <br />
                                                    <label for=""><i class="pe-7s-global"></i>
                                                        <a href="http://<?= $customerContent[0]->CustomerWebSite ?>" target="_blank" rel="noopener noreferrer"><?= $customerContent[0]->CustomerWebSite ?></a></label>
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <a href="<?= base_url('crm/add_det?q=') . crmEncryptUrlParameter('cid=' . $customerContent[0]->CId) ?>" class="btn btn-success"><i class="metismenu-icon pe-7s-pen"></i> Edit Info</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <table class="table table-bordered mt-4">
                                    <tr>
                                        <th>Customer Id</th>
                                        <td><?= $customerContent[0]->CId ?></td>
                                    </tr>
                                    <tr>
                                        <th>Is Active</th>
                                        <td><?= $customerContent[0]->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
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
                                    <h5>Personal Details</h5>
                                    <div class="divider"></div>

                                    <div class="row">

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Customer Type</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo $customerContent[0]->CustomerType ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Customer Status</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo $customerContent[0]->CustomerCurrentStatus ?></label>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Entry Date</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo explode('T', $customerContent[0]->EntryDate)[0] ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Remarks</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?php echo $customerContent[0]->Remarks ?></label>
                                        </div>
                                    </div>

                                    <div class="divider"></div>

                                    <h5>Contact Information</h5>
                                    <div class="divider"></div>
                                    <div class="row">

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>State</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->State ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>District</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->District ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Municipality</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->Municipility ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Ward No</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->CustomerWardNo ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->CustomerAddress ?></label>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-6">
                                            <strong>Contact Number</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-6">
                                            <label><?= $customerContent[0]->CustomerContactNumber ?></label>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="social" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <button class="btn btn-primary btn-sm mb-3 add_new_social">Add New</button>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="socialTbl">
                                        <thead>
                                            <th>Media Type</th>
                                            <th>Media Link</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerSocial as $key => $value) {
                                                $linkDet = strpos($value->SocialMediaLink, '://') !== false ? $value->SocialMediaLink : 'http://' . $value->SocialMediaLink;
                                            ?>
                                                <tr>
                                                    <td><?= $value->SocialMedia ?></td>
                                                    <td><a href="<?= $linkDet ?>" target="_blank" rel="noopener noreferrer">Click Here</a></td>
                                                    <?php //$value->SocialMediaLink 
                                                    ?>
                                                    <td><button class="btn btn-success btn-sm edit_media" data-show='{"0": "<?= $value->SocialMediaTypeId ?>", "1": "<?= $value->SocialMediaLink ?>"}' data-ext="<?= crmEncryptUrlParameter('CSId=' . $value->CSId . '&ent_date=' . $value->EntryDate) ?>">Edit</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="contact" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <button class="btn btn-primary btn-sm mb-3 add_new_contact">Add New</button>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="contactTbl">
                                        <thead>
                                            <th>Contact Person Name</th>
                                            <th>Contact Person Number</th>
                                            <th>Contact Person Email</th>
                                            <th>Contact Person Designation</th>
                                            <th>Is Active</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerContact as $key => $value) { ?>
                                                <tr>
                                                    <td><?= $value->ContactPersonName ?></td>
                                                    <td><?= $value->ContactPersonNumber ?></td>
                                                    <td><?= $value->ContactpersonEmail ?></td>
                                                    <td><?= $value->ContactPersonDesignation ?></td>
                                                    <td><?= $value->IsActive == true ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                                    <td><button class="btn btn-success btn-sm edit_contacter" data-show='{"0": "<?= $value->ContactPersonName ?>", "1": "<?= $value->ContactPersonNumber ?>", "2": "<?= $value->ContactpersonEmail ?>", "3": "<?= $value->ContactPersonDesignation ?>", "4": "<?= $value->IsActive ?>"}' data-ext="<?= crmEncryptUrlParameter('CPId=' . $value->CPId . '&ent_date=' . $value->EntryDate) ?>">Edit</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="employee" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <button class="btn btn-primary btn-sm mb-3 add_new_employee">Add New</button>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="employeeTbl">
                                        <thead>
                                            <th>User</th>
                                            <th>User Status</th>
                                            <th>Remarks</th>
                                            <th>Is Active</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerAssigned as $key => $value) { ?>
                                                <tr>
                                                    <td><?= $value->AssignedEmployee ?></td>
                                                    <td><?= $value->EmployeeStatus ?></td>
                                                    <td><?= $value->Remarks ?></td>
                                                    <td><?= $value->IsActive == true ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                                    <td><button class="btn btn-success btn-sm edit_employeer" data-show='{"0": "<?= $value->UserId ?>", "1": "<?= $value->UsertStatus ?>", "2": "<?= $value->Remarks ?>", "3": "<?= $value->IsActive ?>"}' data-ext="<?= crmEncryptUrlParameter('CAId=' . $value->CAId . '&ent_date=' . $value->EntryDate) ?>">Edit</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php if (strtolower($customerContent[0]->CustomerCurrentStatus) == 'converted') : ?>
                        <div class="tab-pane" id="change" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <a href="<?= base_url('crm/addChangeReq?q=') . $ccidd ?>" class="btn btn-primary btn-sm mb-3">Add New </a>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="changeTbl">
                                            <thead>
                                                <th>Change Number</th>
                                                <th>Change Name</th>
                                                <th>Change Description</th>
                                                <th>Change Reason</th>
                                                <th>Requested Type</th>
                                                <th>Change Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($customerChange as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= $value->ChangeNumber ?></td>
                                                        <td><?= $value->ChangeName ?></td>
                                                        <td><?= $value->ChangeDescription ?></td>
                                                        <td><?= $value->ResonForChange ?></td>
                                                        <td><?php
                                                            foreach ($reqType['reqType'] as $k => $v) {
                                                                echo $v->Id == $value->RequestType ? $v->title : '';
                                                            }
                                                            ?></td>
                                                        <td><?php
                                                            foreach ($reqType['chgStat'] as $k => $v) {
                                                                echo $v->Id == $value->ChangeStatus ? $v->title : '';
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <a class="btn btn-success mt-1" href="<?= base_url('crm/addChangeReq?e=1&q=') . crmEncryptUrlParameter('cid=' . $value->CustomerId . '&key=' . $key) ?>" target="_blank" rel="noopener noreferrer">Edit</a>
                                                            <!-- <button class="btn btn-warning mt-1 send_email_btn">Email</button> -->
                                                            <a class="btn btn-light mt-1" href="<?= base_url('crm/printChange?q=') . crmEncryptUrlParameter('cid=' . $value->CustomerId . '&key=' . $key) ?>" target="_blank" rel="noopener noreferrer">Print</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="tab-pane" id="product_leader" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <button class="btn btn-primary btn-sm mb-3 add_new_plt">Add New</button>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="productLeadtbl">
                                        <thead>
                                            <th>Project</th>
                                            <th>Lead Status</th>
                                            <th>Amount</th>
                                            <th>Probability</th>
                                            <th>Remarks</th>
                                            <th>Attachments Link</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerLead as $key => $value) { ?>
                                                <tr>
                                                    <td><?= $value->ProjectName ?></td>
                                                    <td><?= $value->LeadStatus ?></td>
                                                    <td><?= $value->Amount ?></td>
                                                    <td><?= $value->Probability ?></td>
                                                    <td><?= $value->Remarks ?></td>
                                                    <td><a href="<?= $value->AttachmentsLink ?>" target="_blank" rel="noopener noreferrer"><?= $value->AttachmentsLink ?></a></td>
                                                    <td><button class="btn btn-success btn-sm edit_plt" data-show='{"0": "<?= $value->ProjectId ?>", "1": "<?= $value->LeadStatusId ?>", "2": "<?= $value->Amount ?>", "3": "<?= $value->Probability ?>", "4": "<?= $value->Remarks ?>", "5": "<?= $value->LeadClosedDate ?>", "6": "<?= $value->AttachmentsLink ?>"}' data-ext="<?= crmEncryptUrlParameter('LId=' . $value->LId) ?>">Edit</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="pay_det" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <a href="<?= base_url('crm/payDetails?q=') . $ccidd ?>" class="btn btn-primary btn-sm mb-3 add_new_pay_det">Add New</a>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="payDetTbl">
                                        <thead>
                                            <th>Product</th>
                                            <th>Paid Amount</th>
                                            <th>Paid Date</th>
                                            <th>Fiscal Year</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($payDet as $key => $value) {
                                                $tUrl = crmEncryptUrlParameter(
                                                    'pid=' . $value->PId .
                                                        '&cid=' . $value->CustomerId .
                                                        '&proid=' . $value->ProductId .
                                                        '&paidamt=' . $value->PaidAmount .
                                                        '&paiddate=' . $value->PaidDate .
                                                        '&fisid=' . $value->FiscalYearId .
                                                        '&remarks=' . $value->Remarks
                                                ); ?>
                                                <tr>
                                                    <td><?= $value->ProductId ?></td>
                                                    <td><?= $value->PaidAmount ?></td>
                                                    <td><?= explode('T', $value->PaidDate)[0] ?></td>
                                                    <td><?= $value->FiscalYearId ?></td>
                                                    <td><?= $value->Remarks ?></td>
                                                    <td><a href="<?= base_url('crm/payDetails?q=') . $tUrl ?>" class="btn btn-success btn-sm mt-1">Edit</a> </td>
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
    </div>
</div>