<?php
$leaveReq = $content['leaveReq'];
$leaveEnt = $content['leaveEnt'];
$leavePen = $content['leavePen'];
$leaveApp = $content['leaveApp'];
$isFiltered = $content['isFiltered'];

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <?php if (!$isFiltered) : ?>
                <li class="nav-item"><a data-toggle="tab" href="#myle" class="nav-link active"><?= $header['my'] . ' ' . $header['leave'] . $header['haru'] ?></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#leda" class="nav-link"><?= $header['leave'] . ' ' . $header['day'] . $header['haru'] ?></a></li>
            <?php endif; ?>
            <li class="nav-item"><a data-toggle="tab" href="#pele" class="nav-link <?= $isFiltered ? 'active' : '' ?>" id="viewPen"><?= $header['pending'] . ' ' . $header['leave'] . $header['haru'] ?> <small><span class="badge badge-info"><?= count($leavePen) ?></span></small></a></li>
            <li class="nav-item"><a data-toggle="tab" href="#aple" class="nav-link">Approved Leaves</a></li>
            <?php if (!$isFiltered) : ?>
                <li class="nav-item"><a data-toggle="tab" href="#holi" class="nav-link">Public Holidays</a></li>
            <?php endif; ?>
        </ul>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="tab-content">
                    <?php if (!$isFiltered) : ?>
                        <div class="tab-pane active" id="myle" role="tabpanel">
                            <h5 class="card-title">Leaves you have requested</h5>

                            <a href="<?= base_url('leave/leaveReq') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> <?php echo $nep ? $header['leave'] . ' ' . $header['apply'] : $header['apply'] . ' ' . $header['leave']  ?></a>

                            <table class="table table-bordered table-hover" id="leaveManageTbl">
                                <thead>
                                    <th><?= $header['leave'] . ' ' . $header['type'] ?></th>
                                    <th><?= $header['start'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['end'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['status'] ?></th>
                                    <th class="all"><?= $header['action'] ?></th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($leaveReq as $value) {

                                        $eSD = explode('T', $value['4'])[0]; //startdate
                                        $eED = explode('T', $value['5'])[0]; //enddate
                                        $view = "<button class='btn btn-primary btn-sm mt-1 view_leavedet' data-json='" . json_encode($value) . "' data-toggle='modal' title='Show Leave Details'>View<i class='fa fa-fw'></i></button>";
                                        $cancel = '';
                                        if ($value['8'] == 'Pending') //leave status
                                            $cancel = "<button class='btn btn-danger btn-sm mt-1 cancel_leavedet' data-json='" . json_encode($value) . "' title='Cancel Leave'>Cancel<i class='fa fa-fw'></i></button>";
                                        printf(
                                            '<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s %s</td>
                                </tr>',
                                            $value['12'], //leave head
                                            $eSD,
                                            $eED,
                                            $value['8'], //leave status
                                            $view,
                                            $cancel
                                        );
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane" id="leda" role="tabpanel">
                            <h5 class="card-title">Leave Days Remaining for you</h5>
                            <div class="row">
                                <?php
                                foreach ($leaveEnt as $key => $value) { ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <?= $value->LeaveType; ?>&nbsp;<span class="badge badge-pill badge-success"><?= $value->Available ?></span>
                                            </div>
                                            <div class="card-body">
                                                <p class="period_color"><?= $header['leave'] . ' ' . $header['period'] . ' ' . $header['start'] ?> : <?php echo explode('T', $value->PeriodStart)[0]  ?></p>
                                                <p class="period_color"><?= $header['leave'] . ' ' . $header['period'] . ' ' . $header['end'] ?> : <?php echo explode('T', $value->EndPeriod)[0]  ?></p>
                                                <div class="divider"></div>
                                                <p><?= $header['total'] . ' ' . $header['leave'] . ' ' . $header['day'] . $header['haru'] ?>: <strong><?= $value->LeaveCount ?></strong></p>
                                                <p><?= $header['available'] . ' ' . $header['leave'] . ' ' . $header['day'] . $header['haru'] ?>: <strong><?= $value->Available ?></strong></p>
                                                <p><?= $header['taken'] . ' ' . $header['leave'] . ' ' . $header['day'] . $header['haru'] ?>: <strong><?= $value->Taken ?></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane <?= $isFiltered ? 'active' : '' ?>" id="pele" role="tabpanel">
                        <h5 class="card-title">Pending Leaves requested to you</h5>
                        <div class="">
                            <!-- table-responsive -->
                            <table class="table table-bordered table-hover" id="pendTbl">
                                <thead>
                                    <th><?= $header['employee'] . ' ' . $header['name'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['status'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['head'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['type'] ?></th>
                                    <th><?= $header['start'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['end'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['remarks'] ?></th>
                                    <th class="all"><?= $header['option'] ?></th>
                                </thead>
                                <tbody>
                                    <?php
                                    // 11 link
                                    foreach ($leavePen as $key => $value) {
                                        $eSD = explode('T', $value[4])[0];
                                        $eED = explode('T', $value[5])[0];
                                        $view = "<button class='btn btn-primary btn-sm mt-1 view_leavedet' data-json='" . json_encode($value) . "' data-toggle='modal' title='Show Leave Details'>View<i class='fa fa-fw'></i></button>";
                                        $setStat = '';
                                        if ($value[8] == 'Pending') //leave status
                                            $setStat = "<button class='btn btn-info btn-sm mt-1 change_leavedet' data-json='" . json_encode($value) . "' title='Change Leave Status'>Edit Status<i class='fa fa-fw'></i></button>";
                                        printf(
                                            '<tr>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s %s</td>
                                    </tr>',
                                            $value[14],
                                            $value[8],
                                            $value[12],
                                            $value[13],
                                            $eSD,
                                            $eED,
                                            $value[7],
                                            $view,
                                            $setStat
                                        );
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane" id="aple" role="tabpanel">
                        <h5 class="card-title">Approved Leaves requested to you</h5>
                        <div class="">
                            <!-- table-responsive -->
                            <table class="table table-bordered table-hover" id="appTbl">
                                <thead>
                                    <th><?= $header['employee'] . ' ' . $header['name'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['status'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['head'] ?></th>
                                    <th><?= $header['leave'] . ' ' . $header['type'] ?></th>
                                    <th><?= $header['start'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['end'] . ' ' . $header['date'] ?></th>
                                    <th><?= $header['remarks'] ?></th>
                                    <th class="all"><?= $header['option'] ?></th>
                                </thead>
                                <tbody>
                                    <?php
                                    // 11 link
                                    foreach ($leaveApp as $key => $value) {
                                        $eSD = explode('T', $value[4])[0];
                                        $eED = explode('T', $value[5])[0];
                                        $view = "<button class='btn btn-primary btn-sm mt-1 view_leavedet' data-json='" . json_encode($value) . "' data-toggle='modal' title='Show Leave Details'>View<i class='fa fa-fw'></i></button>";
                                        $setStat = '';
                                        if ($value[8] == 'Pending') //leave status
                                            $setStat = "<button class='btn btn-info btn-sm mt-1 change_leavedet' data-json='" . json_encode($value) . "' title='Change Leave Status'>Edit Status<i class='fa fa-fw'></i></button>";
                                        printf(
                                            '<tr>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s %s</td>
                                    </tr>',
                                            $value[14],
                                            $value[8],
                                            $value[12],
                                            $value[13],
                                            $eSD,
                                            $eED,
                                            $value[7],
                                            $view,
                                            $setStat
                                        );
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <?php if (!$isFiltered) : ?>
                        <div class="tab-pane" id="holi" role="tabpanel">
                            <h5 class="card-title">Public holidays</h5>

                            <form action="" id="searchHoliday" method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <input type="text" name="from" id="from" class="form-control" placeholder="From">
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <input type="text" name="to" id="to" class="form-control" placeholder="To">
                                    </div>
                                    <button class="btn btn-primary btn-sm">Search</button>
                                </div>
                            </form>

                            <div class="">
                                <!-- table-responsive -->
                                <table class="table table-bordered table-hover" id="holiTbl">
                                    <thead>
                                        <th>Fiscal Year</th>
                                        <th>Holiday Date</th>
                                        <th>Holiday Remarks</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>