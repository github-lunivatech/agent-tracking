<?php
// var_dump($installmentlist);exit;
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
 }
</style>

 <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Daily Expenses Details List</div>
            <div class="card-body">
            <form id="formList">
                 <div class="row">
                    <span style="margin-left:15px;font-weight: bold;color: black;">From:</span>
                     <span style="margin-left:311px;font-weight: bold;color: black">To:</span>
                     </div>
                      <div class="row">
                    <input name="fromDate" type="date" id="fromDate" class="form-control col-md-4 " style="margin-bottom: 26px; margin-left: 12px;" placeholder="From Date" required>
                    
                    <input name="toDate" type="date" id="toDate" class="form-control col-md-4 " style="margin-bottom: 26px; margin-left: 12px;" placeholder="To Date" required><button id="saver" class="btn btn-primary btn-sm" style="height: 38px;margin-left: 57px; width: 71px;" required>Load</button>
                </div>
                </form>

              
               
              <!-- <a href="<?= base_url('employeelevel/empYearListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Year</a>  -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline viewdailyexpenses" id="viewdailyexpensesdetails">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Expenses</th>
                                <th>Expenses Description</th>
                                <th>Expenses Amount</th>
                                <th>Discount Amount</th>
                                <th>Total Expenses</th>
                                <th>Entry Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 

