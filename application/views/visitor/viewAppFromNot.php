<?php
$gender = '';
$isseen = '';
$isView = $content['isView'];
$allDet = array();
$appType = $content['appType'];
$appStat = $content['appStat'];
$emList = array();
if ($isView) {
    $allDet = $content['allDet'];
    $gender = $allDet['vgen'];
    $isseen = $allDet['isseen'];
}
if (!$isView) {
    $emList = $content['emList'];
}
?>
<style>
    .img-rounded {
        border-radius: 50%;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $header['appointment'].' '.$header['details'] ?></div>
            <div class="card-body">

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="<?= base_url('assets/images/unk.png') ?>" alt="" class="img-rounded img-responsive profile_img" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <h4 class="em_name mt-4"><?php if ($allDet) {
                                                                    echo $allDet['vname'];
                                                                } ?></h4>
                                    <?php if ($allDet) { ?>
                                        <div class="minor-details">
                                            <label for=""><i class="pe-7s-phone"></i>
                                                <?= $allDet['vmob'] ?></label> <br />
                                            <label for=""><i class="pe-7s-map-2"></i>
                                                <?= $allDet['vaddress'] ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <table class="table table-bordered mt-4">
                            <tr>
                                <th><?= $header['visitor'].' '.$header['code'] ?></th>
                                <td><?php if ($allDet) {
                                        echo $allDet['vid'];
                                    } ?></td>
                            </tr>
                            <tr>
                                <th><?= $header['gender'] ?></th>
                                <td><?php if ($allDet) {
                                        echo $allDet['vgen'];
                                    } ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-sm-3 col-3">

                    </div>
                    <div class="col-md-4 col-sm-4 col-12">
                        <table>
                            <tr>
                                <th><?= $header['visitor'].' '.$header['organization'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo $allDet['vorg'];
                                    } ?></td>
                            </tr>
                            <tr>
                                <th><?= $header['visitor'].' '.$header['designation'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo $allDet['vdes'];
                                    } ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $nep ? $header['visitor'].$header['haru'].$header['of'].' '.$header['number'] : $header['no'].' '.strtolower($header['of']).' '.$header['visitor'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo $allDet['novisit'];
                                    } ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5 col-sm-5 col-12">
                        <table>
                            <tr>
                                <th><?php echo $header['appointment'].' '.$header['with'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo $allDet['appwith'];
                                    } ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $header['appointment'].' '.$header['date'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo explode('T', $allDet['appdate'])[0];
                                    } ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $header['appointment'].' '.$header['reason'] ?></th>
                                <td>: <?php if ($allDet) {
                                        echo $allDet['apprea'];
                                    } ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="offset-md-2">

                    <input type="hidden" name="nepalidate" id="nepalidate" value="<?php if ($allDet) {
                                                                                        echo $allDet['nepdate'];
                                                                                    } ?>" />

                </div>

            </div>
        </div>
    </div>
</div>