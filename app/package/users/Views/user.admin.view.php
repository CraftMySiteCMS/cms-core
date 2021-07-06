<?php $title = _Users_edit_TITLE;
$description = _Users_edit_DESC; ?>

<?php ob_start(); ?>
    <!-- main-content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <form action="" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?=_Users_user?> : <?=$user->user_pseudo?></h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="<?=_Users_mail?>" value="<?=$user->user_email?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" name="pseudo" class="form-control" placeholder="<?=_Users_pseudo?>" value="<?=$user->user_pseudo?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="<?=_Users_firstname?>" value="<?=$user->user_firstname?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="lastname" class="form-control" placeholder="<?=_Users_surname?>" value="<?=$user->user_lastname?>">
                                </div>
                                <div class="form-group">
                                    <label><?=_Users_role?></label>
                                    <select name="role" class="form-control">
                                        <?php foreach ($roles as $role) : ?>
                                            <option value="<?=$role['role_id']?>" <?=($user->role_id == $role['role_id'] ? "selected" : "")?>><?=$role['role_name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?=_Users_new_pass?></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="pass" class="form-control" placeholder="******">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?=_Users_repeat_pass?></label>
                                    <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="pass_verif" class="form-control" placeholder="*****">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right"><?=_Users_list_button_save?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?=_Users_about?></h3>
                        </div>
                        <div class="card-body">
                            <p><b><?=_Users_creation?> :</b> <?=$user->user_created?></p>
                            <p><b><?=_Users_last_edit?> :</b> <?=$user->user_updated?></p>
                            <p><b><?=_Users_last_connection?> :</b> <?=$user->user_logged?></p>
                            <div>
                                <form action="../edit-state" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?=$user->user_id?>" name="id">
                                    <input type="hidden" value="<?=$user->user_state?>" name="actual_state">
                                    <?php if($user->user_state) : ?>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-user-slash"></i> <?=_Users_edit_disable_account?></button>
                                    <?php else : ?>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-user"></i> <?=_Users_edit_activate_account?></button>
                                    <?php endif; ?>
                                </form>
                                <form action="../delete" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?=$user->user_id?>" name="id">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-user-times"></i> <?=_Users_edit_delete_account?></button>
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

<?php require(getenv("PATH_ADMIN_VIEW").'template.php'); ?>