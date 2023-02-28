<?php
$isReg = 'Register';
$cname = '';
$cstate = '';
$cdis = '';
$cmun = '';
$cward = '';
$caddr = '';
$ccont = '';
$cema = '';
$cweb = '';
$ctype = '';
$cstat = '';
$cact = true;
$crem = '';

if ($content) {
    $content = $content[0];
    //var_dump($content);
    $isReg = 'Edit';
    $cname = $content->CustomerName;
    $cstate = $content->CustomerStateId;
    $cdis = $content->CustomerDistrictId;
    $cmun = $content->CustomerMunicipilityId;
    $cward = $content->CustomerWardNo;
    $caddr = $content->CustomerAddress;
    $ccont = $content->CustomerContactNumber;
    $cema = $content->CustomerEmailId;
    $cweb = $content->CustomerWebSite;
    $ctype = $content->CustomerTypeId;
    $cstat = $content->CustomerStatus;
    $cact = $content->IsActive;
    $crem = $content->Remarks;
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Customer Details <?= $isReg ?></h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('crm/insertCustomerDetails') ?>" method="post" class="">

                <?php if ($isReg == 'Edit') { ?>
                    <input type="hidden" name="hider" id="hider" value="<?php echo crmEncryptUrlParameter('cid=' . $content->CId . '&ent_date=' . $content->EntryDate) ?>" readonly required>
                <?php } ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_name" class="col-md-3 col-sm-3 col-xs-12">Customer Name<span class="required">*</span> </label>
                        <input id="cust_name" type="text" name="cust_name" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cname ?>" placeholder="Customer Name">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_state" class="col-md-3 col-sm-3 col-xs-12">Customer State </label>
                        <select name="cust_state" id="cust_state" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($cState as $key => $value) { ?>
                                <option value="<?= $value->Id ?>" <?= $cstate == $value->Id ? 'selected' : '' ?>><?= $value->Name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_district" class="col-md-3 col-sm-3 col-xs-12">Customer District </label>
                        <select name="cust_district" id="cust_district" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                        </select>
                        <input type="hidden" name="cdis" id="cdis" value="<?= $cdis ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_municipality" class="col-md-3 col-sm-3 col-xs-12">Customer Municipality </label>
                        <select name="cust_municipality" id="cust_municipality" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                        </select>
                        <input type="hidden" name="cmun" id="cmun" value="<?= $cmun ?>">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_ward" class="col-md-3 col-sm-3 col-xs-12">Customer Ward No. </label>
                        <input id="cust_ward" type="text" name="cust_ward" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cward ?>" placeholder="Ward No">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_address" class="col-md-3 col-sm-3 col-xs-12">Customer Address </label>
                        <input id="cust_address" type="text" name="cust_address" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $caddr ?>" placeholder="Address">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_contact" class="col-md-3 col-sm-3 col-xs-12">Customer Contact No. </label>
                        <input id="cust_contact" type="text" name="cust_contact" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $ccont ?>" minlength="7" maxlength="10" placeholder="XXXXXXXXXX">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_email" class="col-md-3 col-sm-3 col-xs-12">Customer Email </label>
                        <input id="cust_email" type="email" name="cust_email" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cema ?>" placeholder="abc@example.com">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_website" class="col-md-3 col-sm-3 col-xs-12">Customer Website </label>
                        <input id="cust_website" type="text" name="cust_website" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $cweb ?>" placeholder="www.example.com">
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_type" class="col-md-3 col-sm-3 col-xs-12">Customer Type </label>
                        <select name="cust_type" id="cust_type" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($cTypes as $key => $value) { ?>
                                    <option value="<?= $value->CId ?>" <?= $ctype == $value->CId ? 'selected' : '' ?>><?= $value->CustomerType ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="cust_stat" class="col-md-3 col-sm-3 col-xs-12">Customer Status </label>
                        <select name="cust_stat" id="cust_stat" class="form-control col-md-6 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($cStats as $key => $value) {
                                if ($value->IsActive == true) { ?>
                                    <option value="<?= $value->CId ?>" <?= $cstat == $value->CId ? 'selected' : '' ?>><?= $value->CustomerStatus ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">Is Active </label>
                        <input id="isactive" type="checkbox" name="isactive" <?= $cact ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="remarks" class="col-md-3 col-sm-3 col-xs-12">Remarks </label>
                        <textarea name="remarks" id="remarks" class="form-control col-md-6 col-sm-6 col-xs-12" placeholder="Remarks"><?= $crem ?></textarea>
                    </div>
                </div>

                <button type="submit" id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>

            </form>
        </div>
    </div>
</div>