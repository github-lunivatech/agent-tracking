<?php 
//$url=crmDecryptUrlParameter()[0];
//var_dump($customerListsFromMO);exit;?>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer List List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline clientlist" id="customerlist">

                               
                                    <thead>
                                         <th>Name </th>
                                        <th>Phone no</th>
                                        <th>Email </th>
                                        <th>Designation</th>
                                        <th>CMO</th>
                                        <th>MO</th>
                                        <th>Action</th> 
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($customerListsFromMO as $list) { ?>
                                            <tr>
                                            <td><?php echo $list['Customer']; ?></td>
                                            <td><?php echo $list['Mobile']; ?></td>
                                            <td><?php echo $list['Email']; ?></td>
                                            <td><?php echo $list['Designation']; ?></td>
                                            <td><?php echo $list['CMO']; ?></td>
                                            <td><?php echo $list['MO']; ?></td>

                                            <td><a  href="<?php echo base_url('employee/getListofMonthlyInstallmentPayment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-primary btn-sm emp_button" target="_blank">View Installment</a>
                                         <a  href="<?php echo base_url('employee/installment_payment?q='.crmEncryptUrlParameter('eid='.$list['EId']));?>" class="btn btn-info btn-sm emp_button" target="_blank">Create Installment</a>
                                        </td>                                                     
                                            </tr>
                                        <?php } ?>
                
   </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 