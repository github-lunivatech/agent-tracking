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
    $exid='';
    $expense_head='';
    $expense_desc='';
    $isactive='';
    
        if($expenseHeadDetails){
          $exid=$expenseHeadDetails[0]->ExId;
          $expense_head=$expenseHeadDetails[0]->ExpenseHead;
          $expense_desc=$expenseHeadDetails[0]->ExpensesDescription;
          $isactive=$expenseHeadDetails[0]->IsActive;  

        }
    ?>
</style>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Expense Head Register</h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('employee/insertUpdateExpenseHead') ?>" method="post" class="">
                <input type="hidden" id="eid" name="ExId" value="<?php if($exid != '') echo $exid ?>">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Expense Head<span class="required">*</span> </label>
                        <input id="emp_code" type="text" name="ExpenseHead" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $expense_head ?>" placeholder="Expense Head" required >
                    </div>
                </div>

                <?php ?>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_first_name" class="col-md-3 col-sm-3 col-xs-12">Expense Head Description<span class="required">*</span> </label>
                        <textarea id="emp_first_name" type="text" name="ExpensesDescription" class="form-control col-md-6 col-sm-6 col-xs-12" placeholder="Expense Head Description" required><?php echo $expense_desc ?> </textarea>
                    </div>
                </div>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="isactive" class="col-md-3 col-sm-3 col-xs-12">IsActive<span class="required">*</span> </label>
                        <fieldset class="position-relative form-group">
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input <?php 
                                        if($isactive != ''):
                                            echo $isactive == '1' ? 'checked' : '' ;
                                        else:
                                            echo 'checked';
                                        endif;
                                    ?> type="radio" name="isactive" value="1" class="form-check-input"> Active
                                </label>
                            </div>
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input type="radio" name="isactive" value="0" class="form-check-input"> Inactive
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <input id="saver" type="submit"class="mt-2 btn btn-primary pull-right" value="Add">

            </form>
        </div>
    </div>
</div>