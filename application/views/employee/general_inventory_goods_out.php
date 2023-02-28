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
     $oid='';
    $productId='';
    $quantity='';
    $goodsOutDate='';
    $receivedBy='';
    $remarks='';
    $isactive='';
    if($goodsDet){
        $oid=$goodsDet[0]->GId;
        $productId=$goodsDet[0]->ProductId;
        $quantity=$goodsDet[0]->GoodsOutQuantity;
        $goodsOutDate=$goodsDet[0]->GoodsOutDate;
        $receivedBy=$goodsDet[0]->ReceivedBy;
        $remarks=$goodsDet[0]->Remarks;
        $isactive=$goodsDet[0]->IsActive;
    }
    ?>
</style>

<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Inventory Goods Out Register</h5>
        <div class="offset-md-2">
            <form id="employeeRegisterForm" action="<?= base_url('employee/InventoryInsertUpdateGoodsOut') ?>" method="post" class="">
                <input type="hidden" id="" name="OId" value="<?php if($oid !='') echo $oid;?>">
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Product<span class="required">*</span> </label>
                        <select id="ProductId"  name="ProductId" class="form-control col-md-6 col-sm-6 col-xs-12" >
                               <?php foreach ($products as $key => $value) {
                                $selc = $productId == $value->PId ? 'selected' : '';
                                printf('<option %s value="%s">%s</option>', $selc, $value->PId,$value->ProductName);
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="emp_first_name" class="col-md-3 col-sm-3 col-xs-12">Quantity<span class="required">*</span> </label>
                        <input id="GoodsOutQuantity" type="number" name="GoodsOutQuantity" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $quantity;?>" placeholder="Quantity" required>
                    </div>
                </div>
                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="GoodsInDate" class="col-md-3 col-sm-3 col-xs-12">Goods In Date<span class="required">*</span> </label>
                        <input id="GoodsOutDate" type="text" name="GoodsOutDate" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $goodsOutDate;?>" required>
                    </div>
                </div>
                 <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="VerifiedBy" class="col-md-3 col-sm-3 col-xs-12">Verified By<span class="required">*</span> </label>
                        <input id="ReceivedBy" type="text" name="ReceivedBy" class="form-control col-md-6   col-sm-6 col-xs-12"  value="<?php echo $receivedBy;?>" required>
                    </div>
                </div>

                <div class="form-row form-inline">
                    <div class="col-md-12 form-group mb-3">
                        <label for="Remarks" class="col-md-3 col-sm-3 col-xs-12">Remarks<span class="required">*</span> </label>
                        <textarea id="Remarks" name="Remarks" class="form-control col-md-6 col-sm-6 col-xs-12" required><?php echo $remarks;?></textarea>
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
                                            echo $isactive == true ? 'checked' : '' ;
                                        else:
                                            echo 'checked';
                                        endif;
                                    ?> type="radio" name="isactive" value="1" class="form-check-input"> Active
                                </label>
                            </div>
                            <div class="position-relative form-check">
                                <label class="form-check-label mr-3">
                                    <input type="radio" <?php
                                        if($isactive != ''):
                                            echo $isactive == false ? 'checked' : '' ;
                                        
                                        endif;
                                    ?>name="isactive" value="0" class="form-check-input"> Inactive
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <button id="saver" class="mt-2 btn btn-primary pull-right">Add</button>

            </form>
        </div>
    </div>
</div>