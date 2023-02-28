<form action="<?= base_url('crm/viewsalesgoal') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="fromDate" id="fromDate" class="form-control" value="<?= set_value('fromDate') ?>">
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="toDate" id="toDate" class="form-control" value="<?= set_value('toDate') ?>">
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="number" name="customerId" id="customerId" class="form-control" min="1" required>
            <!-- <select name="customerId" id="customerId" class="form-control">
                <option value="0">All</option>
                <?php
                $isSel = set_value('customerId');
                foreach ($pDet as $key => $value) { ?>
                    <option <?= $value->PId == $isSel ? 'selected' : '' ?> value="<?= $value->PId ?>"><?= $value->ProductName ?></option>
                <?php } ?>
            </select> -->
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <button class="btn btn-primary">Load</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Performance Graph</div>
            <div class="card-body">
                <canvas id="salesChart" style="width:100%"></canvas>
            </div>
        </div>
    </div>
</div>