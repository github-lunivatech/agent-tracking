<?php
$roleName = $content['roleName'];
$roleIder = $content['roleId'];
$roleNameSee = $content['roleNameSee'];

$senPar = crmDecryptWithParameter($_GET['q'])[0];
$reEnc = crmEncryptUrlParameter('rid=' . $senPar['rid'] . '&rolena=' . $senPar['rolena']);

if ($this->session->flashdata('success') != null) {
    echo '<div class="alert alert-success col-md-12" role="alert">' . $this->session->flashdata('success') . '</div>';
}
if ($this->session->flashdata('error') != null) {
    echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
}
?>
<div class="main-card card mb-3">
    <div class="card-body">
        <h5 class="card-title">Rights & Roles Details of <span><?= $roleNameSee ?></span></h5>

        <?php if (in_array("update rights", $permissions)) { ?>
            <a href="<?= base_url('user/add_rolesRights?q=') . $reEnc ?>" class="btn btn-primary btn-sm mb-2">Change Rights</a>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover viewRolesTable">
                <thead>
                    <th>Rights Name</th>
                    <th>Has Rights</th>
                </thead>
                <tbody>
                    <?php foreach ($roleName as $key => $value) {
                        if ($value->IsActive) { ?>
                            <tr>
                                <td><?= $value->Right ?></td>
                                <td>
                                    <span class="badge badge-<?= $value->IsActive == true ? 'success' : 'danger' ?>"><?= $value->IsActive == true ? 'Yes' : 'No' ?></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>