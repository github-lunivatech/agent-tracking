<?php
$stList = array();
if ($content['iList']) {
    $stList = $content['iList'];
}
?>
<style>
    /* body {
        table-layout: fixed;
        width: 100% !important;
    } */
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-12">
        <form action="<?= base_url('visitor/view_appointment') ?>" method="POST">
            <div class="row">
                <div class="col-md-2">
                     <label for=""><?php echo $header['date'].' ' .$header['from'] ?></label>
                    <input type="text" name="fromDate" id="fromDate" class="form-control mb-2" placeholder="" required="" value="<?php echo set_value('fromDate'); ?>">
                </div>
                <div class="col-md-2">
                    <label for=""><?php echo $header['date'].' '.$header['to'] ?></label>
                    <input type="text" name="toDate" id="toDate" class="form-control mb-2" placeholder="" required="" value="<?php echo set_value('toDate'); ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary mt-4 mb-3"><?php echo $header['load'] ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-11 col-sm-12 col-12 apper">

        <div class="mb-3 card">
            <div class="card-header"><?php echo $header['appointment']. ' '.$header['report'] ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dt-responsive" id="appReport" width="100%">
                        <thead>
                        <th><?= $header['sn'] ?></th>
                            <th><?= $header['visitor'].' '.$header['id'] ?></th>
                            <th><?= $header['visitor'].' '.$header['name'] ?></th>
                            <th><?= $header['visitor'].' '.$header['address'] ?></th>
                            <th><?= $header['visitor'].' '.$header['mobile'].' '.$header['no'] ?></th>
                            <th><?= $header['visitor'].' '.$header['gender'] ?></th>
                            <th><?= $header['visitor'].' '.$header['organization'] ?></th>
                            <th><?= $header['visitor'].' '.$header['designation'] ?></th>
                            <th><?= $header['appointment'].' '.$header['date'] ?></th>
                            <th><?= $header['appointment'].' '.$header['with'] ?></th>
                            <th><?= $header['appointment'].' '.$header['reason'] ?></th>
                            <th><?= $header['in'].' '.$header['time'] ?></th>
                            <th><?= $header['out'].' '.$header['time'] ?></th>
                            <th><?= $header['status'] ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 1;
                            foreach ($stList as $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $value->VisitorId ?></td>
                                    <td><?= $value->VisitorName ?></td>
                                    <td><?= $value->VisitorAddress ?></td>
                                    <td><?= $value->VisitorMobileNo ?></td>
                                    <td><?= $value->VisitorGender ?></td>
                                    <td><?= $value->VisitorOrganization ?></td>
                                    <td><?= $value->VisitorDesigation ?></td>
                                    <td><?php echo explode('T', $value->AppointmentDate)[0]; ?></td>
                                    <td><?= $value->AppointmentWith ?></td>
                                    <td><?= $value->AppointmentReason ?></td>
                                    <td><?= $value->InTime ?></td>
                                    <td><?= $value->OutTime ?></td>
                                    <td><?php if ($value->AppointmentStatus == 0) {
                                            echo '<span class="badge badge-warning">Pending</span>';
                                        } elseif ($value->AppointmentStatus == 1) {
                                            echo '<span class="badge badge-success">Done</span>';
                                        } else {
                                            echo '<span class="badge badge-danger">Cancel</span>';
                                        } ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>