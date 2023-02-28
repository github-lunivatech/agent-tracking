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
 }
</style>
 <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer Monthly Payment List (<?php 
                echo $name;
                ?>)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline installmentlist" id="installment_list">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Customer Name</th>
                                <th>Installment Date</th>
                                <th>Installment Type</th>
                                <th>Paid Amount</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach($installmentlist as $list):?>
                            <tr>
                                 <td><?= $list->MId?></td>
                                 <td><?= $list->EmployeeName?></td>
                                 <td><?= $list->EntryDate?></td>
                                 <td><?= $list->InstallmentType?></td>
                                 <td><?= $list->PaidAmount?></td>
                                 <td><button class="btn btn-warning btn-sm mb-3 print" data-url="<?php echo crmEncryptUrlParameter('eid='.$list->EmpId)  ?>">Print</button></td>
                                
                            </tr>
                            <?php endforeach;?>      
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right">GrandTotal:</th>
                                    <th></th>
                                </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 



    

