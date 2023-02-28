<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<!-- <form action="<?= base_url('product/viewProducts') ?>" id="searchApp" method="POST">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <input type="text" name="customerId" id="customerId" class="form-control" value="<?= set_value('customerId') ?>" placeholder="Product Id" required autocomplete="off">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
            <button class="btn btn-primary">Load</button>
        </div>
    </div>
</form> -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header">View Product Details</div>
            <div class="card-body">
                <div class="">
                <!-- table-responsive -->
                    <table class="table table-bordered table-hover crmdata" id="viewCustDet">
                        <thead>
                            <th>SN</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Type</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            echo 'update service for product type (3)';
                            $sn = 1;
                            foreach ($content as $key => $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $value->ProductCode ?></td>
                                    <td><?= $value->ProductName ?></td>
                                    <td><?= $value->ProductType ?></td>
                                    <td><?= $value->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td><a href="<?= base_url('product/add_product?q=').crmEncryptUrlParameter('pid='.$value->PId) ?>" class="btn btn-primary btn-sm">Edit</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>