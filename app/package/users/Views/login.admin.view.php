<?php $title = _Users_login_TITLE;
$description = _Users_login_DESC; ?>

<?php use CMS\Controller\coreController; ?>

<?php $no_body = 1; ?>

<?php ob_start(); ?>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo mb-4">
            <img src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/images/identity/CraftMySite_Logo.svg" alt="<?=_ALT_LOGO?>" width="100px">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><?=_Users_login_title?></p>
                <?= coreController::cms_errors_display(); ?>

                <form action="" method="post" class="mb-4">
                    <div class="input-group mb-3">
                        <input name="login_email" type="email" class="form-control" placeholder="<?=_Users_login_email?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="login_password" type="password" class="form-control" placeholder="<?=_Users_login_password?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input type="checkbox" id="login_keep_connect" name="login_keep_connect">
                                <label for="login_keep_connect"><?=_Users_login_remember?></label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block"><?=_Users_login_signin?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href=""><?=_Users_login_lost_password?></a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW").'template.php'); ?>
