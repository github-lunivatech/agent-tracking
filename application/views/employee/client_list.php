
<?php //var_dump(($desId==2 && $customerLists!=null));exit;?>
<?php if($desId==2 && $customerLists!=null):?>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Marketing Officer List(CMO:<?php echo $name;?>)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline clientlist" id="empdatatable">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Phone no</th>
                                <th>Email </th>
                                <th>Designation</th>
                                <th>CMO</th>
                                <th>MO</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($Lists as $list):?>      
                            <tr>
                                <td><?php echo $list['Marketing Officer']; ?></td>
                                <td><?php echo $list['EmployeeMobileNumber']; ?></td>
                                <td><?php echo $list['EmployeeEmailId']; ?></td>
                                <td><?php echo $list['Designation']; ?></td>
                                <td><?php echo $list['CMO']; ?></td>
                                <td><?php echo $list['MO']; ?></td>
                                <td><a href="<?php echo base_url('employee/getcustomerListByMOId?&q='.crmEncryptUrlParameter('eid='.$list['EId']))?>" class="btn btn-info btn-sm emp_button">View</a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 
<?php //elseif($desId==2 && $customerLists!=null):?>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline clientlist" id="empdatatable1">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Phone no</th>
                                <th>Email </th>
                                <th>Designation</th>
                                <th>CMO</th>
                                <th>MO</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($customerLists as $list):?>      
                            <tr>
                                <td><?php echo $list['Customer']; ?></td>
                                <td><?php echo $list['Mobile']; ?></td>
                                <td><?php echo $list['Email']; ?></td>
                                <td><?php echo $list['Designation']; ?></td>
                                <td><?php echo $list['CMO']; ?></td>
                                <td><?php echo $list['MO']; ?></td>
                                <td><a  href="<?php echo base_url('employee/getListofMonthlyInstallmentPayment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-primary btn-sm " target="_blank">View Installment</a>
                                <a  href="<?php echo base_url('employee/installment_payment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-info btn-sm" target="_blank">Create Installment</a>
                            </td> 
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 
<?php elseif($desId==2 && $customerLists ==null):?>  
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Marketing Officer List(CMO:<?php echo $name;?>)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline clientlist" id="empdatatable">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Phone no</th>
                                <th>Email </th>
                                <th>Designation</th>
                                <th>CMO</th>
                                <th>MO</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($Lists as $list):?>      
                            <tr>
                                <td><?php echo $list['Marketing Officer']; ?></td>
                                <td><?php echo $list['EmployeeMobileNumber']; ?></td>
                                <td><?php echo $list['EmployeeEmailId']; ?></td>
                                <td><?php echo $list['Designation']; ?></td>
                                <td><?php echo $list['CMO']; ?></td>
                                <td><?php echo $list['MO']; ?></td>
                                <td><a href="<?php echo base_url('employee/getcustomerListByMOId?&q='.crmEncryptUrlParameter('eid='.$list['EId']))?>" class="btn btn-info btn-sm emp_button">View</a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<?php endif;?>
<?php //endif;?>

<?php if($desId==3):?>
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer List(MO:<?php echo $name;?>)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline clientlist" id="empdatatable">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Phone no</th>
                                <th>Email </th>
                                <th>Designation</th>
                                <th>CMO</th>
                                <th>MO</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($customerListsFromMO as $list):?>      
                            <tr>
                            <td><?php echo $list['Customer']; ?></td>
                                <td><?php echo $list['Mobile']; ?></td>
                                <td><?php echo $list['Email']; ?></td>
                                <td><?php echo $list['Designation']; ?></td>
                                <td><?php echo $list['CMO']; ?></td>
                                <td><?php echo $list['MO']; ?></td>
                                <td > <a  href="<?php echo base_url('employee/getListofMonthlyInstallmentPayment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-primary btn-sm " target="_blank">View Installment</a>

                                <a  href="<?php echo base_url('employee/installment_payment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-info btn-sm " style="margin-left:-11px;" target="_blank">Create Installment</a>
                                
                            </td>     
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 
<?php endif?>

<div class="modal fade" id="viewInstallmentModal" tabindex="-1" role="dialog" aria-labelledby="viewInstallmentModallLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewInstallmentModal">Installment Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                        <div class="modal-body">
                        <div class="form-row form-inline">
                                <input type="hidden" name="empidencrypt" id="empidencrypt" value="" readonly> 
                        </div>
                                 <table class="table table-bordered customerinstallmentlist" id="customerlist1">
                                    <thead>
                                         <th>Id </th>
                                        <th>Payment</th>
                                        <th>Installment Type </th>
                                        <th>Date</th>
                                        <!-- <th>CMO</th>
                                        <th>MO</th> -->
                                        <th>Action</th> 
                                    </thead>
                                    <tbody>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:right">GrandTotal:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                       
                        </div>
                </div>
            </div>
        </div>
