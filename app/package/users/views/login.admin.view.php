<?php $title = USERS_LOGIN_TITLE;
$description = USERS_LOGIN_DESC; ?>

<?php use CMS\Controller\coreController; ?>

<?php $noBody = 1; ?>

<?php ob_start(); ?>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo mb-4">
            <img src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/images/identity/CraftMySite_Logo.svg" alt="<?=ALT_LOGO?>" width="100px">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><?=USERS_LOGIN_TITLE?></p>
                <form action="" method="post" class="mb-4">
                    <div class="input-group mb-3">
                        <input name="login_email" type="email" class="form-control" placeholder="<?=USERS_MAIL?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="login_password" type="password" class="form-control" placeholder="<?=USERS_PASS?>">
                        <div class="input-group-append">
                            <DIV CLASS="input-group-text">
                                <SPAN CLASS="fas fa-lock"></SPAN>
                            </DIV>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input type="checkbox" id="login_keep_connect" name="login_keep_connect">
                                <label for="login_keep_connect"><?=USERS_LOGIN_REMEMBER?></label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block"><?=USERS_LOGIN_SIGNIN?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href=""><?=USERS_LOGIN_LOST_PASSWORD?></a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW").'template.php'); ?>
