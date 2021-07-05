<?php $title = _Users_edit_title; //Variables du fichier lang
$description = _Users_edit_desc; ?>

<?php ob_start(); ?>
    <!-- main-content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <form action="" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Utilisateur : <?=$user->user_pseudo?></h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="email" value="<?=$user->user_email?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" name="pseudo" class="form-control" placeholder="Surnom" value="<?=$user->user_pseudo?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="Prénom" value="<?=$user->user_firstname?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="lastname" class="form-control" placeholder="Nom" value="<?=$user->user_lastname?>">
                                </div>
                                <div class="form-group">
                                    <label>Rôle</label>
                                    <select name="role" class="form-control">
                                        <?php foreach ($roles as $role) : ?>
                                            <option value="<?=$role['role_id']?>" <?=($user->role_id == $role['role_id'] ? "selected" : "")?>><?=$role['role_name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Modifier le mot de passe</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" name="pass" class="form-control" placeholder="******">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Retaper le mot de passe</label>
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
                                <button type="submit" class="btn btn-primary float-right">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">A propos</h3>
                        </div>
                        <div class="card-body">
                            <p><b>Date de création :</b> <?=$user->user_created?></p>
                            <p><b>Dernière modification :</b> <?=$user->user_updated?></p>
                            <div>
                                <form action="../edit-state" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?=$user->user_id?>" name="id">
                                    <input type="hidden" value="<?=$user->user_state?>" name="actual_state">
                                    <?php if($user->user_state) : ?>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-user-slash"></i> Désactiver le compte</button>
                                    <?php else : ?>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-user"></i> Activer le compte</button>
                                    <?php endif; ?>
                                </form>
                                <form action="../delete" method="post" class="d-inline-block">
                                    <input type="hidden" value="<?=$user->user_id?>" name="id">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-user-times"></i> Supprimer le compte</button>
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