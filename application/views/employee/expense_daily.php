<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    <?php if($image2 != ''){ ?>
        .file-upload-content {
            display: block;
        }
        .image-upload-wrap {
            display: none;
        }
    <?php } 
    
    $TId='';
    $expheadid='';
    $expenses='';
    $expensedescription='';
    $expenseamount='';
    $discountamount='';
    $totalexpenses='';
    $remarks='';
    $referenceid='';
    if($expensedailyDetails){
        $TId=$expensedailyDetails[0]->TId;
        $expheadid=$expensedailyDetails[0]->ExpensesHead;
        $expenses=$expensedailyDetails[0]->Expenses;
        $expensedescription=$expensedailyDetails[0]->ExpensesDesc;
        $expenseamount=$expensedailyDetails[0]->ExpensesAmount;
        $discountamount=$expensedailyDetails[0]->DiscountAmount;
        $totalexpenses=$expensedailyDetails[0]->TotalExpenses;
        $remarks=$expensedailyDetails[0]->Remarks;
        $referenceid=$expensedailyDetails[0]->ReferenceId;
    }
    ?>
</style>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Daily Expense Register</h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('employee/insertUpdateDailyExpense') ?>" method="post" class="">
                <input type="hidden" id="eid" name="TId" value="<?php if($TId !='') echo $TId;?>">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Expenses Head<span class="required">*</span> </label>
                        <select id="emp_code" type="text" name="ExpensesHead" class="form-control col-md-6 col-sm-6 col-xs-12" >
                           <?php foreach($expenseHeadDetails as $details):?>
                          
                        
                            <?php $selc = $expheadid == $details->ExId ? 'selected' : '';
                                printf('<option %s value="%s">%s</option>', $selc, $details->ExId,$details->ExpenseHead);?>
                           
                            <?php endforeach;?>

                        </select>
                    </div>
                </div>

                <?php ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="ExpensesDesc" class="col-md-3 col-sm-3 col-xs-12">Expenses Description<span class="required">*</span> </label>
                        <textarea id="ExpensesDesc" type="text" name="ExpensesDesc" class="form-control col-md-6 col-sm-6 col-xs-12"  placeholder="Expense Head Description" required><?php echo $expensedescription?></textarea>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="ExpensesAmount" class="col-md-3 col-sm-3 col-xs-12">Expenses Amount<span class="required">*</span> </label>
                        <input id="ExpensesAmount" type="text" name="ExpensesAmount" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $expenseamount?>" placeholder="Expense Amount" >
                    </div>
                </div>

                 <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="DiscountAmount" class="col-md-3 col-sm-3 col-xs-12">Discount Amount<span class="required">*</span> </label>
                        <input id="DiscountAmount" type="text" name="DiscountAmount" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $discountamount?>" placeholder="Discount Amount" >
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="TotalExpenses" class="col-md-3 col-sm-3 col-xs-12">Total Expenses<span class="required">*</span> </label>
                        <input id="TotalExpenses" type="text" name="TotalExpenses" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $totalexpenses?>"  placeholder="Total Expenses" >
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="ExpensesDesc" class="col-md-3 col-sm-3 col-xs-12">Remarks<span class="required">*</span> </label>
                        <textarea id="Remarks" type="text" name="Remarks" class="form-control col-md-6 col-sm-6 col-xs-12" value="" placeholder="Remarks" required><?php echo $remarks?></textarea>
                    </div>
                </div>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="ReferenceId" class="col-md-3 col-sm-3 col-xs-12">Reference Id<span class="required">*</span> </label>
                        <input id="ReferenceId" type="text" name="ReferenceId" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $referenceid?>" placeholder="Reference Id" >
                    </div>
                </div>

                </div>
                <input id="saver" type="submit"class="mt-2 btn btn-primary pull-right" value="Add">
                <!-- <button id="saver" type="submit"class="mt-2 btn btn-primary pull-right">Add</button> -->

            </form>
        </div>
    </div>
</div>