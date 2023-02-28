<?php
$iList = $content['iList'];
?>
<style>
    .aer {
        color: inherit;
    }
    .show_clicker, .aer {
        cursor: pointer;
    }

    .aer:hover {
        text-decoration: none;
        color: inherit;
    }

    .color-box {
        width: 10px;
        height: 10px;
        display: inline-block;
        background-color: #ccc;
        /* position: absolute;
        left: 70px;
        top: 5px; */
    }
</style>
<form action="<?= base_url('visitor/viewAppForAd') ?>" method="POST">
    <div class="row mb-3">
        <div class="col-md-2">
            <label for=""><?php echo $header['date'] . ' ' . $header['from'] ?></label>
            <input type="text" name="fromDate" id="fromDate" class="form-control mb-2" placeholder="<?php echo $header['date'] . ' ' . $header['from'] ?>" required="" value="<?php echo set_value('fromDate'); ?>">
        </div>
        <div class="col-md-2">
            <label for=""><?php echo $header['date'] . ' ' . $header['to'] ?></label>
            <input type="text" name="toDate" id="toDate" class="form-control mb-2" placeholder="<?php echo $header['date'] . ' ' . $header['to'] ?>" required="" value="<?php echo set_value('toDate'); ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary mt-4 mb-3"><?php echo $header['load'] ?></button>
        </div>
    </div>
</form>

<div class="row mb-1">
    <div class="col-md-2 col-4 show_clicker pender">
        <div class="color-box bg-warning"></div>
        <label for=""><?php echo $nep ? $header['isleft'] : $header['pending'] ?></label>
    </div>
    <div class="col-md-2 col-4 show_clicker accepter">
        <div class="color-box bg-success"></div>
        <label for=""><?php echo $nep ? $header['isfin'] : $header['accept'] ?></label>
    </div>
    <div class="col-md-2 col-4 show_clicker dangerer">
        <div class="color-box bg-danger"></div>
        <label for=""><?php echo $nep ? $header['cancel'].' '.$header['isdone'] : $header['cancel'] ?></label>
    </div>
    <div class="col-md-2 col-4 show_clicker otherer">
        <div class="color-box"></div>
        <label for=""><?= $header['other'] ?></label>
    </div>
</div>

<div class="row">

    <?php if ($iList) :
        foreach ($iList as $key => $value) {
            $fullData = array(
                'vname' => $value->VisitorName,
                'vaddress' => $value->VisitorAddress,
                'vremarks' => $value->AppointmentReason,
                'appdate' => $value->AppointmentDate,
                'intime' => $value->InTime,
                'appstat' => $value->AppointmentStatus,
                'encA' => crmEncryptUrlParameter('aid=' . $value->AId)
            );

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
            $bgcol = '';
            $textcol = '';
            $aer = 'aer';
            if ($value->AppointmentStatus == 0) {
                $bgcol = 'bg-warning';
                $textcol = 'text-dark';
            } elseif ($value->AppointmentStatus == 1) {
                $bgcol = 'bg-success';
                $textcol = 'text-white';
            } elseif ($value->AppointmentStatus == 2) {
                $bgcol = 'bg-danger';
                $textcol = 'text-white';
            }
    ?>
            <div class="col-md-6 col-xl-4">
                <?php // base_url('visitor/viewFromApp?q=' . $enc . '&a=true') 
                ?>
                <div class="<?= $aer ?> carder_<?= $key ?>" data-carder="carder_<?= $key ?>" data-all='<?= json_encode($fullData) ?>'>
                    <div class="card mb-3 widget-content <?= $bgcol ?>">
                        <div class="widget-content-wrapper <?= $textcol ?>">
                            <div class="widget-content-left">
                                <div class="widget-heading"><?= $header['name'] ?> : <?= $value->VisitorName ?></div>
                                <div class="widget-subheading"><?= $header['date'] ?> : <?php echo explode('T', $value->AppointmentDate)[0] ?></div>
                                <div class="widget-subheading"><?= $header['subject'] ?> : <?php echo $value->AppointmentReason ?></div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers"><span class="pen_app"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    endif;
    ?>

</div>