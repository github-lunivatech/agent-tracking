<?php
$isReg = 'Save';
$newinsert = isset($_GET['n']);
$newLeaveGroup = isset($_GET['from']);
$isEid = isset($_GET['q']);
$eid = 0;
if($isEid){
    $eid = crmDecryptWithParameter($_GET['q'])[0]['eid'];
}
if($newLeaveGroup){ ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Employee Leave Group</div>
                <div class="card-body">
                    <a href="<?= base_url('leave/leaveGroup?q='.crmEncryptUrlParameter('eid='.$eid).'&n=y') ?>" class="btn btn-primary btn-sm mb-3">Add New Group</a>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="empLGr">
                            <thead>
                                <th>Leave Group</th>
                                <th>Start Period</th>
                                <th>End Period</th>
                                <th>Is Active</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($content['oldLeave'] as $value) {
                                    $dataset = 'elid=' . $value[0] .
                                        '&eid=' . $value[1] .
                                        '&ent_date=' . $value[8]; ?>
                                    <tr>
                                        <td><?= $value[3] ?></td>
                                        <td><?php echo explode('T', $value[4])[0] ?></td>
                                        <td><?php echo explode('T', $value[5])[0] ?></td>
                                        <td><?php echo $value[6] == 1 ? 'Active' : 'Inactive' ?></td>
                                        <td><button class="btn btn-info btn-sm edit_lg" data-e="<?php echo crmEncryptUrlParameter($dataset) ?>" data-json='<?php echo json_encode($value)  ?>'>Edit</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <p><small>*Note:- Please keep only one group active at one time.</small></p>
                </div>
            </div>
        </div>
    </div>
<?php }
elseif (!$content['oldLeave'] || $newinsert) { ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Assign Leave Group</div>
                <div class="card-body">

                    <div class="offset-md-2">
                        <form id="leaveGroupForm" action="<?= base_url('leave/insertUpdateLeaveGroup') ?>" method="POST">
                            <input type="hidden" name="eeff" id="eeff" value="<?php if (isset($_GET['q'])) echo $_GET['q'];  ?>">
                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="leave_group" class="col-md-3 col-sm-3 col-xs-12">Leave Group<span class="required">*</span> </label>
                                    <select name="leave_group" id="leave_group" class="form-control col-md-6 col-sm-6 col-xs-12">
                                        <?php foreach ($content['lGroup'] as $value) {
                                            printf('<option value="%s">%s</option>', $value->GId, $value->LeaveGroup);
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="start_period" class="col-md-3 col-sm-3 col-xs-12">Start Period<span class="required">*</span> </label>
                                    <input id="start_period" type="text" name="start_period" class="form-control col-md-6 col-sm-6 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group mb-3">
                                    <label for="end_period" class="col-md-3 col-sm-3 col-xs-12">End Period<span class="required">*</span> </label>
                                    <input id="end_period" type="text" name="end_period" class="form-control col-md-6 col-sm-6 col-xs-12">
                                </div>
                            </div>

                            <div class="form-row form-inline">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">IsActive<span class="required">*</span> </label>
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

                            <button id="saver" class="mt-2 btn btn-primary pull-right"><?= $isReg ?></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Employee Leave Group</div>
                <div class="card-body">
                    <a href="<?= base_url('leave/leaveGroup?n=y') ?>" class="btn btn-primary btn-sm mb-3">Add New Group</a>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="empLGr">
                            <thead>
                                <th>Leave Group</th>
                                <th>Start Period</th>
                                <th>End Period</th>
                                <th>Is Active</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($content['oldLeave'] as $value) {
                                    $dataset = 'elid=' . $value[0] .
                                        '&eid=' . $value[1] .
                                        '&ent_date=' . $value[8]; ?>
                                    <tr>
                                        <td><?= $value[3] ?></td>
                                        <td><?php echo explode('T', $value[4])[0] ?></td>
                                        <td><?php echo explode('T', $value[5])[0] ?></td>
                                        <td><?php echo $value[6] == 1 ? 'Active' : 'Inactive' ?></td>
                                        <td><button class="btn btn-info btn-sm edit_lg" data-e="<?php echo crmEncryptUrlParameter($dataset) ?>" data-json='<?php echo json_encode($value)  ?>'>Edit</button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <p><small>*Note:- Please keep only one group active at one time.</small></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>