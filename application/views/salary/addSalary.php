<?php 
$nepMonth = $content;
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Add Salary</h5>

        <div class="offset-md-2">
            <form id="employeeSalary" action="" method="post" class="">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="salary_month" class="col-md-3 col-sm-3 col-xs-12">Salary Month<span class="required">*</span> </label>
                        <select name="salary_month" id="salary_month" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php 
                            $i = 1;
                            foreach ($nepMonth as $key => $value) { ?>
                                <option value="<?= $i++ ?>"><?= $value->monthName ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="salaryFromDate" class="col-md-3 col-sm-3 col-xs-12">Salary From Date </label>
                        <input id="salaryFromDate" type="text" name="salaryFromDate" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="salaryToDate" class="col-md-3 col-sm-3 col-xs-12">Salary To Date </label>
                        <input id="salaryToDate" type="text" name="salaryToDate" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="basicSalary" class="col-md-3 col-sm-3 col-xs-12">Basic Salary </label>
                        <input id="basicSalary" type="number" name="basicSalary" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="bonus" class="col-md-3 col-sm-3 col-xs-12">Bonus </label>
                        <input id="bonus" type="number" name="bonus" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="allowance" class="col-md-3 col-sm-3 col-xs-12">Allowance </label>
                        <input id="allowance" type="number" name="allowance" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <!-- <input type="text" name="fullSalary" id="fullSalary"> -->

                    <div class="col-md-12 form-group mb-3">
                        <label for="deductionAmt" class="col-md-3 col-sm-3 col-xs-12">Deduction Amt </label>
                        <input id="deductionAmt" type="number" name="deductionAmt" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="advanceAmt" class="col-md-3 col-sm-3 col-xs-12">Advance Amt </label>
                        <input id="advanceAmt" type="number" name="advanceAmt" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="tds" class="col-md-3 col-sm-3 col-xs-12">TDS<span class="required">*</span> </label>
                        <input id="tds" type="number" name="tds" class="form-control col-md-5 col-sm-6 col-xs-12" placeholder="TDS" required min="0">
                    </div>

                    <!-- <div class="col-md-12 form-group mb-3">
                        <label for="salaryDispatchedDate" class="col-md-3 col-sm-3 col-xs-12">Salary Dispached Date </label>
                        <input id="salaryDispatchedDate" type="number" name="salaryDispatchedDate" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="isSalaryDispatched" class="col-md-3 col-sm-3 col-xs-12">Is Salary Dispatched </label>
                        <input id="isSalaryDispatched" type="number" name="isSalaryDispatched" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div> -->

                    <div class="col-md-12 form-group mb-3">
                        <label for="totalPayable" class="col-md-3 col-sm-3 col-xs-12">Total Payable </label>
                        <input id="totalPayable" type="number" name="totalPayable" class="form-control col-md-5 col-sm-6 col-xs-12">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="remarks" class="col-md-3 col-sm-3 col-xs-12">Remarks </label>
                        <textarea name="remarks" id="remarks" class="form-control col-md-5 col-sm-6 col-xs-12"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary btn-sm pull-right">Save Salary</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>