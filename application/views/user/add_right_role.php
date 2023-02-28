<?php
// $isReg = 'Save';

$roleName = $content['roleName'];
$roleNameSee = $content['roleNameSee'];
// var_dump($roleName);
// exit;

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

        <?php if (in_array("add new rights", $permissions)) { ?>
        <a href="<?= base_url('user/add_user_details') ?>" class="btn btn-primary bt-sm mb-2">Add New Rights</a>
        <?php } ?>

        <div class="table-responsive">
            <form action="<?= base_url('user/ajaxRegisterRole') ?>" method="POST" id="rolerAS">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th></th>
                        <th>Rights Name</th>
                    </thead>
                    <tbody>
                        <?php foreach ($roleName as $key => $value) { ?>
                            <tr>
                                <td>
                                    <input type="checkbox" key="<?= $value->RId ?>" class="rightCheck" <?= $value->IsActive == true ? 'checked' : '' ?>>
                                    <input type="hidden" name="checked[<?= $value->RId ?>]" value="<?= $value->IsActive == true ? '1' : '0' ?>">
                                    <input type="hidden" name="rdid[]" value="<?= crmEncryptUrlParameter('rdid='.$value->RDID.'&rightId=' . $value->RId . '&roleId=' . $value->RoleId)  ?>">
                                </td>
                                <td><?= $value->Right ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <button class="btn btn-primary updater">Update</button>
            </form>
        </div>

    </div>
</div>