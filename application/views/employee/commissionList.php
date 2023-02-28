<?php
//$depar = $depart;
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
<!-- action="<?php //echo base_url('employee/getcommissionlist');?>" -->
<form id="searchEmp">
    <div class="row">

    <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="from" id="from" class="form-control" placeholder="From Date" value="<?= set_value('from') ?>" required>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="to" id="to" class="form-control" placeholder="To Date" value="<?= set_value('to') ?>"required>
        </div>

        <div class="col-md-3 col-sm-5 col-xs-12 form-group">
            <select name="empTypeId" id="empTypeId" class="form-control" required="required">
                <option value="">Select Employee Type</option>
                 <option value="1">All</option>
                  <option value="2">Chief Markeing Officer</option>
                  <option value="3">Marketing Officer</option>
                 
            </select>
        </div>

        <div class="col-md-3 col-sm-5 col-xs-12 form-group">
            <select name="empid" id="empid" class="form-control" required="required">
                <option value="">Select Employee</option>
                <?php //foreach ($nepMonth as $key => $value) {
                    //printf('<option %s value="%s">%s</option>', set_select('salMonth', $value->monthName), $value->monthName, $value->monthName);
               // } ?>
            </select>
        </div>
<!-- 
        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="from" id="from" class="form-control" placeholder="From Date" value="<?= set_value('from') ?>">
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <input type="text" name="to" id="to" class="form-control" placeholder="To Date" value="<?= set_value('to') ?>">
        </div> -->

        <div class="col-md-2 col-sm-4 col-xs-12 form-group">
            <button class="btn btn-primary btn-sm" id="searchcommission">Search</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mt-3 mb-3 card">
            <div class="card-header">View Employees</div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover commissionlist" id="tblBulk">
                        <thead>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Commission Percentage</th>
                            <th>Commission Amount</th>
                            <th>Paid Amount</th>
                            <th>Agent Name</th>
                            <th>InstallmentType</th>
                            <th>EntryDate</th>
                            
                            
                        </thead>
                        <tbody>
                            
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>