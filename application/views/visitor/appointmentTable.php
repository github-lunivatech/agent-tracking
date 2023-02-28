<?php
$stList = array();
if ($content['iList']) {
    $stList = $content['iList'];
}
?>
<form action="<?= base_url('visitor/appointmentTab') ?>" method="POST">
    <div class="row">
        <div class="col-md-2">
            <label for=""><?php echo $header['date'].' ' .$header['from'] ?></label>
            <input type="text" name="fromDate" id="fromDate" class="form-control mb-2" placeholder="<?php echo $header['date'].' ' .$header['from'] ?>" required="" value="<?php echo set_value('fromDate'); ?>">
        </div>
        <div class="col-md-2">
            <label for=""><?php echo $header['date'].' '.$header['to'] ?></label>
            <input type="text" name="toDate" id="toDate" class="form-control mb-2" placeholder="<?php echo $header['date'].' '.$header['to'] ?>" required="" value="<?php echo set_value('toDate'); ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary mt-4 mb-3"><?php echo $header['load'] ?></button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">

        <div class="main-card mb-3 card">
            <div class="card-header"><?= $header['appointment']. ' '.$header['list'] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="appTab" width="100%">
                        <thead>
                            <th><?= $header['sn'] ?></th>
                            <th><?= $header['visitor'].' '.$header['name'] ?></th>
                            <th><?= $header['visitor'].' '.$header['address'] ?></th>
                            <th><?= $header['appointment'].' '.$header['with'] ?></th>
                            <th><?= $header['appointment'].' '.$header['reason'] ?></th>
                            <th><?= $header['in'].' '.$header['time'] ?></th>
                            <th><?= $header['out'].' '.$header['time'] ?></th>
                            <th><?= $header['appointment'].' '.$header['date'] ?></th>
                            <th><?= $header['status'] ?></th>
                            <th class="all"><?= $header['action'] ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 1;
                            foreach ($stList as $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $value->VisitorName ?></td>
                                    <td><?= $value->VisitorAddress ?></td>
                                    <td><?= $value->AppointmentWith ?></td>
                                    <td><?= $value->AppointmentReason ?></td>
                                    <td><?= $value->InTime ?></td>
                                    <td><?= $value->OutTime ?></td>
                                    <td><?php echo explode('T', $value->AppointmentDate)[0]; ?></td>
                                    <td><?php if($value->AppointmentStatus == 0){
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    }elseif ($value->AppointmentStatus == 1) {
                                        echo '<span class="badge badge-success">Done</span>';
                                    }else {
                                        echo '<span class="badge badge-danger">Cancel</span>';
                                    } ?></td>
                                    <td>
                                        <?php $aid = crmEncryptUrlParameter('aid=' . $value->AId);
                                        $enc = crmEncryptUrlParameter(
                                            'aid=' . $value->AId .
                                            '&vid=' . $value->VisitorId .
                                            '&vname=' . $value->VisitorName .
                                            '&vaddress=' . $value->VisitorAddress .
                                            '&vmob=' . $value->VisitorMobileNo .
                                            '&vgen=' . $value->VisitorGender .
                                            '&vorg=' . $value->VisitorOrganization .
                                            '&vdes=' . $value->VisitorDesigation .
                                            '&appwith=' . $value->AppointmentWith .
                                            '&apprea=' . $value->AppointmentReason .
                                            '&appdate=' . $value->AppointmentDate .
                                            '&intime=' . $value->InTime .
                                            '&outtime=' . $value->OutTime .
                                            '&apptype=' . $value->AppointmentType .
                                            '&userid=' . $value->UserId .
                                            '&appstat=' . $value->AppointmentStatus .
                                            '&isseen=' . $value->IsSeenBy .
                                            '&nepdate=' . $value->NepaliDate .
                                            '&novisit=' . $value->NoOfVisitors
                                        );
                                        ?>
                                        <a href="<?= base_url('visitor/editAppointment?q=').$enc ?>" class="btn btn-sm btn-primary mt-2 view_det">View</a>
                                        <?php if($value->OutTime == '--:--:--' || $value->AppointmentStatus == 0){ ?>
                                            <button class="btn btn-sm btn-info mt-2 edit_det" data-i="<?= $aid ?>" data-in="<?= $value->InTime ?>">Out Time</button>
                                        <?php } ?>
                                        <?php if($value->AppointmentStatus == 0){ ?>
                                            <button class="btn btn-sm btn-danger mt-2 canc_det" data-i="<?= $aid ?>">Cancel</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>