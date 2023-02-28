<?php 
$totVisit = 0;
$pendApp = 0;
$pendLea = 0;
$totEmp = 0;
if(isset($content)){
    $totVisit = $content['todayAppointment'];
    $pendApp = $content['pending_appointment'];
    $pendLea = $content['pending_leave'];
    $totEmp = $content['total_employee'];
} ?>
<!-- <div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><?= $header['total'].' '.$header['visitor'].$header['haru'] ?></div>
                    <div class="widget-subheading"><?php echo $nep ? $header['today'].$header['for'] : $header['for'].' '.$header['today'] ?></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span class="visit_num"><?= $totVisit ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><?= $header['pending'].' '.$header['appointment'].$header['haru'] ?></div>
                    <div class="widget-subheading"><?php echo $nep ? $header['today'].$header['for'] : $header['for'].' '.$header['today'] ?></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span class="pen_app"><?= $pendApp ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-grow-early">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><?= $header['pending'].' '.$header['leave'].$header['haru'] ?></div>
                    <div class="widget-subheading"></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span class="pen_lev"><?= $pendLea ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->session->userdata('loggedInRole') == 'Admin' || $this->session->userdata('loggedInRole') == 'Manager') : ?>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><?= $header['total'].' '.$header['employee'].$header['haru'] ?></div>
                    <div class="widget-subheading"></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-warning"><span class="tot_emp"><?= $totEmp ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div> -->