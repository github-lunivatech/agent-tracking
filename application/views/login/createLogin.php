<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Login</title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/clinic_favicon.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
</head>

<body>
    <?php if (!$iscreated) : ?>
        <div class="modal-dialog">
            <!-- w-100 -->
            <?php echo validation_errors(); ?>
            <div class="modal-content">
                <form action="<?= base_url('login/createEmployeeLogin') ?>" method="POST">
                    <div class="modal-body">
                        <h5 class="modal-title">
                        </h5>
                        <h4 class="mt-2">
                            <div>Welcome, <span>Create login</span></div>
                        </h4>

                        <div class="divider row"></div>
                        <input type="hidden" name="cl" id="cl" value="<?php echo $_GET['q'] ?>">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <input name="username" id="username" placeholder="Username" type="text" class="form-control" required>
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <input name="password" id="password" placeholder="Password" type="password" class="form-control" required>
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <input name="rep_password" id="rep_password" placeholder="Repeat password" type="password" class="form-control" required>
                                    <?php echo form_error('rep_password'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <select name="roles" id="roles" class="form-control" required>
                                        <option value="">Select Roles</option>
                                        <?php
                                        foreach ($ro as $key => $value) {
                                            if ($value->IsActive) {
                                                printf('<option value="%s">%s</option>', $value->RId, $value->RightName);
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="divider row"></div>
                    </div>
                    <div class="modal-footer d-block text-center">
                        <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Create Login</button>
                    </div>

                </form>
            </div>
        </div>
    <?php else : ?>
        Login has already been created. Please login using the credentials entered. If you forgot the username or password please contact the administrator.
    <?php endif; ?>

    <script type="text/javascript" src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>