<?php
$saveName = 'Add';
$pcode = '';
$pname = '';
$ptype = '';
$isactive = true;
if ($content) {
    $saveName = 'Edit';
    $pcode = $content->ProductCode;
    $pname = $content->ProductName;
    $ptype = $content->ProductType;
    $isactive = $content->IsActive;
}
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= $saveName ?> Product</h5>

        <div class="offset-md-2">
            <form id="productForm" action="<?= base_url('product/productAdd') ?>" method="post" class="">
                <div class="form-row form-inline">

                    <?php if ($saveName == 'Edit') { ?>
                        <input type="hidden" name="hider" id="hider" value="<?= crmEncryptUrlParameter('pid=' . $content->PId . '&ent_date=' . $content->EntryDate) ?>">
                    <?php } ?>
                    <div class="col-md-12 form-group mb-3">
                        <label for="product_code" class="col-md-3 col-sm-3 col-xs-12">Product Code </label>
                        <input id="product_code" type="text" name="product_code" class="form-control col-md-5 col-sm-6 col-xs-12" value="<?= $pcode ?>">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="product_name" class="col-md-3 col-sm-3 col-xs-12">Product Name </label>
                        <input id="product_name" type="text" name="product_name" class="form-control col-md-5 col-sm-6 col-xs-12" value="<?= $pname ?>">
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="product_type" class="col-md-3 col-sm-3 col-xs-12">Product Type<span class="required">*</span> </label>
                        <select name="product_type" id="product_type" class="form-control col-md-5 col-sm-6 col-xs-12">
                            <option value="">Select</option>
                            <?php foreach ($gProd as $key => $value) {
                                if ($value->IsActive) { ?>
                                    <option <?= $ptype == $value->TId ? 'selected' : '' ?> value="<?= $value->TId ?>"><?= $value->ProductType ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label for="is_active" class="col-md-3 col-sm-3 col-xs-12">Is Active </label>
                        <input id="is_active" type="checkbox" name="is_active" <?= $isactive == true ? 'checked' : '' ?>>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary btn-sm pull-right"><?= $saveName ?> Product</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

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
                            foreach ($productDetails as $key => $value) { ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $value->ProductCode ?></td>
                                    <td><?= $value->ProductName ?></td>
                                    <td><?= $value->ProductType ?></td>
                                    <td><?= $value->IsActive ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td><a href="<?= base_url('product/add_product?q=') . crmEncryptUrlParameter('pid=' . $value->PId) ?>" class="btn btn-primary btn-sm">Edit</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>