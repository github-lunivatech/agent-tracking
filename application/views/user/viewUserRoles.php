<?php
$roleName = $content['roleName'];

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">View Roles Details</h5>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <th>Role Name</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach ($roleName as $key => $value) {
                        $rolenc = crmEncryptUrlParameter('rid=' . $value->RId . '&rolena=' . $value->RightName);
                    ?>
                        <tr>
                            <td><?= $value->RightName ?></td>
                            <td><span class="badge badge-<?= $value->IsActive == true ? 'success' : 'danger' ?>"><?= $value->IsActive == true ? 'Active' : 'Inactive' ?></span></td>
                            <td>
                                <?php if ($value->IsActive == true) { ?>
                                    <?php if (in_array("update rights", $permissions)) { ?>
                                        <a class="btn btn-success btn-sm" href="<?= base_url('user/add_rolesRights?q=') . $rolenc ?>">Update</a>
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm" href="<?= base_url('user/view_rolesRights?q=') . $rolenc ?>">View</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>