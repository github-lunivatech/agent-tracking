<?php
 //var_dump($goodsDet);exit;
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
<?php //var_dump($goodsDet);?>
 <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Inventory Goods In List</div>
            <div class="card-body">
           
              <!-- <a href="<?= base_url('employeelevel/empYearListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Year</a>  -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline goodsInList" id="inventoryGoodsInList">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Goods In Date</th>
                                <th>Verified By</th>
                                <th>Verified By</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($goodsDet):
                                foreach($goodsDet as $det):?>
                                <tr>
                                <td><?php echo $det->GId;?></td>
                                 <td><?php echo $det->ProductName;?></td>
                                <td><?php echo $det->Quantity;?></td>
                                <td><?php echo $det->GoodsInDate;?></td>
                                <td><?php echo $det->VerifiedBy;?></td>
                                <td><?php echo $det->Remarks;?></td>
                                <td><a  href="<?php echo base_url('employee/editGoodsIn?&q='.crmEncryptUrlParameter('eid='.$det->GId))?> " class="btn btn-info btn-sm emp_button" target="_blank">Edit</a></td>
                                </tr>
                                <?php endforeach;
                                endif;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 

