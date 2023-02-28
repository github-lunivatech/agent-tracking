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
        width: 123px;
 }
</style>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Customer List</div>
            <div class="card-body">
                <div class="row">
                    <select name="designationId" id="emp_type" class="form-control col-md-4 " style="margin-bottom: 26px; margin-left: 12px;">

                        <option value="">Select Customer type</option>
                        <?php foreach($desDet as $des):?>
                                            <option value="<?php echo $des->DId?>"><?php echo $des->Designation?></option>
                        <?php endforeach;?>
                    </select>
                </div>
              <!-- <a href="<?= base_url('employeelevel/empYearListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Year</a>  -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline emptype" id="empdatatable">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Address</th>
                                <th>Phone no</th>
                                <th>Designation</th>
                                <th>CMO</th>
                                <th>MO</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>    
                            <!-- <tr>
                                <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createcustomer">Launch demo modal</button></td>
                            </tr>    -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div> 
