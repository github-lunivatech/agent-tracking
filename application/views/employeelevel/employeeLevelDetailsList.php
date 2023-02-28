<?php
if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-card mb-3 card">
            <div class="card-header header_decider">Level List</div>
            <div class="card-body">
            <a href="<?= base_url('employeelevel/empLevelListAdd') ?>" class="btn btn-primary mb-3"><i class="fa fa-fw"></i> Add Level</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Level Code</th>
                            <th>Employee Level</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($empList as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->LevelCode ?></td>
                                    <td><?= $value->EmployeeLevel ?></td>
                                    <td><?= $value->IsActive == true ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td>
                                        <a href="<?= base_url('employeelevel/empLevelListAdd?q=' . crmEncryptUrlParameter('yid=' . $value->LId)) ?>" class="btn btn-primary btn-sm">Edit</a>
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