<?php
$depar = $depart;
?>
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
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee Id" value="<?php echo set_value('emp_id') ?>">
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <select name="departId" id="departId" class="form-control">
                <option value="">Select</option>
                <?php foreach ($depar as $key => $value) { ?>
                    <option <?= set_select('departId', $value->DId) ?> value="<?= $value->DId ?>"><?= $value->DepartmentName ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <select name="salMonth" id="salMonth" class="form-control">
                <option value="">Select Month</option>
                <?php foreach ($nepMonth as $key => $value) {
                    printf('<option %s value="%s">%s</option>', set_select('salMonth', $value->monthName), $value->monthName, $value->monthName);
                } ?>
            </select>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="from" id="from" class="form-control" placeholder="From Date" value="<?= set_value('from') ?>">
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="to" id="to" class="form-control" placeholder="To Date" value="<?= set_value('to') ?>">
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm">Search</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mt-3 mb-3 card">
            <div class="card-header">View Employees</div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover" id="tblBulk">
                        <thead>
                            <th>Employee Name</th>
                            <th>Basic Salary</th>
                            <th>Festival Bonus</th>
                            <th>Allowance</th>
                            <th>Others</th>
                            <th>Provident Fund</th>
                            <th>Citizen Investment Trust</th>
                            <th>Insurance</th>
                            <th>Other Fund</th>
                            <th>TDS</th>
                            <th>Total Payable</th>
                            <th>Ded. Amt</th>
                            <th>Sal. Dis</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                            $rowNo = 0;
                            foreach ($salList as $key => $value) { 
                                // var_dump($value);
                                ?>
                                <tr class="row_<?= $rowNo ?>">
                                    <td>
                                        <input type="hidden" name="allD" value='<?= $value->allP ?>'>
                                        <?= $value->EmployeeName ?>
                                        <p><?php echo $value->MaritalStatus == 2 ? '(Married)' : '(Unmarried)' ?></p>
                                    </td>
                                    <td><?= $value->BasicSalary ?></td>
                                    <td><?= $value->FestivalBonus ?></td>
                                    <td><?= $value->Allowance ?></td>
                                    <td><?= $value->Others ?></td>
                                    <td><?= $value->ProvidentFund ?></td>
                                    <td><?= $value->CitizenInvestmentTrust ?></td>
                                    <td><?= $value->Insurane ?></td>
                                    <td><?= $value->OtherFund ?></td>
                                    <td><?= $value->TDS ?></td>
                                    <td class="pay_row_<?= $rowNo ?>">
                                        <span class="shower"><?= $value->TotalPayable ?></span>
                                        <span class="hiderer"><?= $value->TotalPayable ?></span>
                                    </td>
                                    <td>
                                        <input type="number" name="dedAmt" value="" max="<?= $value->TotalPayable ?>">
                                    </td>
                                    <td>
                                        <?php 
                                            $salPa = $value->IsSalaryDispatched != '' && $value->IsSalaryDispatched != false && $value->IsSalaryDispatched != null ? 'checked' : '';
                                            if($salPa == 'checked'){
                                                echo '<span class="badge badge-success">Dispatched</span>';
                                            }else{ ?>
                                                <input type="checkbox" name="salDis" <?= $salPa ?>>
                                            <?php } ?>
                                    </td>
                                    <td>
                                        <textarea name="remarks"><?= $value->Remarks ?></textarea>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm save_one_sal" data-row="row_<?= $rowNo ?>">Save</button>
                                    </td>
                                </tr>
                            <?php 
                            $rowNo++;
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>