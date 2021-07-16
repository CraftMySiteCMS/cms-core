<?php use CMS\Model\Users\RolesModel;
use CMS\Model\Users\UsersModel;

$title = USERS_EDIT_TITLE;
$description = USERS_EDIT_DESC;

/** @var UsersModel $user */
?>

<?php ob_start(); ?>
    <!-- main-content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <form action="" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?= USERS_USER ?> : <?= $user->userPseudo ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="<?= USERS_MAIL ?>" value="<?= $user->userEmail ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" name="pseudo" class="form-control"
                                           placeholder="<?= USERS_PSEUDO ?>" value="<?= $user->userPseudo ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control"
                                           placeholder="<?= USERS_FIRSTNAME ?>" value="<?= $user->userFirstname ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="lastname" class="form-control"
                                           placeholder="<?= USERS_SURNAME ?>" value="<?= $user->userLastname ?>">
                                </div>
                                <div class="form-group">
                                    <label><?= USERS_ROLE ?></label>
                                    <select name="role" class="form-control">
                                        <?php /** @var RolesModel[] $roles */
                                        foreach ($roles as $role) : ?>
                                            <option value="<?= $role['role_id'] ?>" <?= ($user->roleId === $role['role_id'] ? "selected" : "") ?>><?= $role['role_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?= USERS_NEW_PASS ?></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="pass" class="form-control" placeholder="******">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?= USERS_REPEAT_PASS ?></label>
                                    <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="pass_verif" class="form-control"
                                               placeholder="*****">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit"
                                        class="btn btn-primary float-right"><?= USERS_LIST_BUTTON_SAVE ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?= USERS_ABOUT ?></h3>
                        </div>
                        <div class="card-body">
                            <p><b><?= USERS_CREATION ?> :</b> <?= $user->userCreated ?></p>
                            <p><b><?= USERS_LAST_EDIT ?> :</b> <?= $user->userUpdated ?></p>
                            <p><b><?= USERS_LAST_CONNECTION ?> :</b> <?= $user->userLogged ?></p>
                            <div>
                                <form action="../edit-state" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?= $user->userId ?>" name="id">
                                    <input type="hidden" value="<?= $user->userState ?>" name="actual_state">
                                    <?php if ($user->userState) : ?>
                                        <button type="submit" class="btn btn-warning"><i
                                                    class="fa fa-user-slash"></i> <?= USERS_EDIT_DISABLE_ACCOUNT ?>
                                        </button>
                                    <?php else : ?>
                                        <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-user"></i> <?= USERS_EDIT_ACTIVATE_ACCOUNT ?></button>
                                    <?php endif; ?>
                                </form>
                                <form action="../delete" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?= $user->userId ?>" name="id">
                                    <button type="submit" class="btn btn-danger"><i
                                                class="fa fa-user-times"></i> <?= USERS_EDIT_DELETE_ACCOUNT ?></button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.main-content -->
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW") . 'template.php'); ?>