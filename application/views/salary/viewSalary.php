<style>
    .inTab,
    .app-main__outer {
        width: 100%;
    }

    .hiderer {
        display: none;
    }
</style>
<form action="" id="searchEmp" method="POST">
    <div class="row">
        <?php if (in_array('show own salary', $permissions)) {
            $empIder = crmDecryptUrlParameter()[0]; ?>
            <input type="hidden" name="emp_id" id="emp_id" class="form-control" placeholder="Employee Id" required readonly value="<?= $empIder['logEmpId'] ?>">
        <?php } else { ?>
            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee Id" required>
            </div>
        <?php } ?>

        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="from" id="from" class="form-control" placeholder="From" required>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="to" id="to" class="form-control" placeholder="To" required>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm">Search</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" id="doMore">
        <div class="main-card mb-3 card">
            <div class="card-header">View Employees</div>
            <div class="card-body">

                <!-- <a class="btn btn-info btn-sm add_new_sal mb-3" href="#" target="_blank">Add New</a> -->

                <div class="table-responsive">
                    <table class="table table-hover" id="salEmpTbl">
                        <thead>
                            <th>Employee Name</th>
                            <th>Salary Month</th>
                            <th>Basic Salary</th>
                            <th>Allowance</th>
                            <th>Bonus</th>
                            <th>Provident Fund</th>
                            <th>Insurance</th>
                            <th>Citizen Investment Trust</th>
                            <th>Deduction Amt</th>
                            <th>Other Funds</th>
                            <th>Others</th>
                            <th>TDS Amount</th>
                            <th>Total Payable</th>
                            <th>Remarks</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>