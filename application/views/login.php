<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>ECRM | Login</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
    <link rel="shortcut icon" href="<?= base_url('assets/images/clinic_favicon.png') ?>" type="image/x-icon">
    <style>
        /* .logo-src {
            height: 23px;
            width: 97px;
            background: url(../assets/images/logo-inverse.png);
        } */
        .head-img {
            width: 200px;
        }

        .center-text {
            text-align: center;
        }

        .login_box {
            background: #f6f8fa;
            padding: 20px;
            border-radius: 5px;
        }

        .bolderr {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-12">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-3">
                            <div class="head-img-div center-text"><img class="head-img" src="<?= base_url('assets/images/logo.png') ?>" alt="" srcset=""> </div>
                            <h4 class="mb-0 center-text">
                                <!-- <span class="d-block">Welcome back,</span> -->
                                <span>Sign in to your account</span>
                            </h4>
                            <div class="divider row"></div>
                            <div class="login_box">
                                <form action="<?= base_url('login/auth') ?>" method="POST">
                                    <?php
                                    if (isset($_GET['redirectCpage'])) {
                                        printf('<input type="hidden" name="redirectCpage" value="%s">', $_GET['redirectCpage']);
                                        if (isset($_GET['qs'])) {
                                            printf('<input type="hidden" name="qs" value="%s">', str_replace('+', '%2B', $_GET['qs']));
                                        }
                                    }
                                    ?>
                                    <div class="form-row">
                                        <?php
                                        if ($this->session->flashdata('error') != null) {
                                            echo '<div class="col-md-12 alert alert-danger" role="alert">' . $this->session->flashdata('error') . '</div>';
                                        }
                                        ?>

                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label for="username" class="bolderr">Username</label>
                                                <input name="username" id="username" placeholder="" type="text" class="form-control" autofocus tabindex="1">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label for="password" class="bolderr">Password</label>
                                                <input name="password" id="password" placeholder="" type="password" class="form-control" tabindex="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider row"></div>
                                    <div class="align-items-center">
                                        <div class="">
                                            <!-- <a href="javascript:void(0);" class="btn-lg btn btn-link">Lost Password?</a> -->
                                            <button class="btn btn-primary btn-lg btn-block">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>