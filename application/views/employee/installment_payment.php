<?php
// var_dump($employeeDetails);exit;
if($employeeDetails){
    $employeeDetails=$employeeDetails[0];
    $empName=$employeeDetails->EmployeeName;
    if($employeeDetails->EmpCode !=''){
         $empCode=$employeeDetails->EmpCode;
    }else{
        $empCode='';
    }

}
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

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer Installment Payment</div>
                <div class="card-body">
                    
                <form action="<?php echo base_url('employee/insertUpdateInstallmentPayment')?>" method="POST">
                  <?php if(isset($_GET['q'])){?>
                            <input type="hidden" name="eid" value="<?php echo $_GET['q'] ?>">
                    <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Customer Code<span class="required">*</span> </label>
                            <input name="customercode" id="customercode" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $empCode?>">

                                    <!-- <option value="">Select Customer type</option>
                                    <?php foreach($desDet as $des):?>
                                            <option value="<?php echo $des->DId?>"><?php echo $des->Designation?></option>
                                    <?php endforeach;?> -->
                                    
                                </select>
                        </div>       
                    </div>

                    <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Customer Name<span class="required">*</span> </label>
                                <input name="empName" id="empName" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?php echo $empName;?>" readonly>

                                    <!-- <option value="">Select Customer type</option>
                                    <?php foreach($desDet as $des):?>
                                            <option value="<?php echo $des->DId?>"><?php echo $des->Designation?></option>
                                    <?php endforeach;?> -->
                                    
                                </select>
                        </div>       
                    </div>
                    
                    
                            <?php } ?>
                    
                    <input type="hidden" name="MId" value="">
                    <div class="form-row form-inline cust_name" style="display:none">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12" id="customer_type_name"><span class="required">*</span> </label>
                                <select name="EmpId" id="emp_type1" class="form-control col-md-6 col-sm-6 col-xs-12 select2">
                            </select>
                        </div>       
                    </div>
                    <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Installment Type<span class="required">*</span> </label>
                            <select id="InstallmentType"  name="InstallmentType" class="form-control col-md-6 col-sm-6 col-xs-12"  onchange="if(this.options[this.selectedIndex].value=='customOption'){
                                                    toggleField(this,this.nextSibling);
                                                    this.selectedIndex='0';
                                                }" required> 
                                    <option value=""></option>
                                    <option value="customOption">[Type custom value]</option>                                                
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10 क">10 क</option>
                                    <option value="10 ख">10 ख</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15 क">15 क</option>
                                    <option value="15 ख">15 ख</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20 क">20 क </option>
                                    <option value="20 ख">20 ख</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>



                            </select><input name="InstallmentType" class="form-control col-md-6 col-sm-6 col-xs-12"style="display:none;" disabled="disabled" 
                                                    onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
                                                    <script>
                                            function toggleField(hideObj,showObj){
                                            hideObj.disabled=true;        
                                            hideObj.style.display='none';
                                            showObj.disabled=false;   
                                            showObj.style.display='inline';
                                            showObj.focus();
                                            }
                                </script>                                                    
                        </div>
                    </div>
                    <!-- <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Customer Code<span class="required">*</span> </label>
                            <input id="InstallmentType" type="text" name="InstallmentType" class="form-control col-md-6 col-sm-6 col-xs-12" ?>
                        </div>
                    </div> -->
                    <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Paid Amount<span class="required">*</span> </label>
                            <input id="PaidAmount" type="text" name="PaidAmount" class="Remarks form-control col-md-6 col-sm-6 col-xs-12" value="1200" required>
                        </div>
                    </div>
                    <div class="form-row form-inline">
                        <div class="col-md-12 form-group mb-3">
                            <label for="emp_code" class="col-md-3 col-sm-3 col-xs-12">Remarks<span class="required">*</span> </label>
                            <textarea id="Remarks" type="text" name="Remarks" class=" form-control col-md-6 col-sm-6 col-xs-12" > </textarea>
                        </div>
                    </div>
                    <input type="submit" id="saver" class="mt-2 btn btn-primary pull-right" value="Add"></button>

                </form>
                </div>
            </div>
        </div>
    </div>


