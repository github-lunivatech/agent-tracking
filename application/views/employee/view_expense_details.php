<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<style>
    .emp_button{
        margin-right:5px;
        margin-top: 5px;
        width: 123px;
 }
</style>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Expense Head List</div>
            <div class="card-body">
                
              <!-- <a href="<?= base_url('employeelevel/empYearListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Year</a>  -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline expense_details" id="expense_head_details">
                        <thead>
                            <tr>
                               <th>Expense Head</th>
                               <th>Expense Head Description</th>
                               <th>Created At</th>
                               <th></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($expenseHeadDetails as $details):?>
                            <tr>
                                <td><?php echo $details->ExpenseHead;?></td>
                                <td><?php echo $details->ExpensesDescription;?></td>
                                <td><?php echo $details->EntryDate;?></td>
                                <td><a  href="<?php echo base_url('employee/edit_expense_head?q='.crmEncryptUrlParameter('ExId='.$details->ExId))?>"class="btn btn-info btn-sm emp_button">Edit</a></td>
                            </tr>   
                           <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 
