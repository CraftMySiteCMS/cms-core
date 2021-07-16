<!DOCTYPE html>
<?php session_start();
require_once("../app/EnvBuilder.php");
if (file_exists("../.env")) {
    (new Env("../.env"))->load();
} ?>
<html lang="fr-FR">
<head>
    <meta charset="utf-8"/>
    <title>CraftMySite | Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="NOINDEX, NOFOLLOW">
    <meta name="description" content="Installation du CMS">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../admin/resources/vendors/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../admin/resources/css/adminlte.min.css">

    <script src="../admin/resources/vendors/jquery/jquery.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link">
            <img src="../admin/resources/images/identity/CraftMySite_Logo.svg" alt="<?= ALT_LOGO ?>"
                 class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Craft My Site</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a class="nav-link <?= (!isset($_GET['step']) || $_GET['step'] == 1) ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-hourglass-start"></i>
                            <p>Etape 1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['step']) && $_GET['step'] == 2) ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-hourglass-half"></i>
                            <p>Etape 2</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['step']) && $_GET['step'] == 3) ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-hourglass-end"></i>
                            <p>Etape 3</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Installation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../cms-admin">CraftMySite</a></li>
                            <li class="breadcrumb-item active">Installation</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-7">
                    <?php if (!isset($_GET['step']) || $_GET['step'] == 1) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informations sur votre base de données</h3>
                            </div>
                            <!-- form start -->
                            <form action="controller.php" role="form" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="bdd_name">Nom de la base de donnéess</label>
                                        <input type="text" name="bdd_name" class="form-control" id="bdd_name" required>
                                        <small class="text-muted">Le nom de la base de données sur laquelle vous
                                            souhaitez installer Craft My Website (Elle se créée <b>automatiquement</b>
                                            si elle n'existe pas encore)</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="bdd_login">Identifiant</label>
                                        <input type="text" name="bdd_login" class="form-control" id="bdd_login"
                                               required>
                                        <small class="text-muted">Nom d'utilisateur de la base de données</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="bdd_pass">Mot de passe</label>
                                        <input type="text" name="bdd_pass" class="form-control" id="bdd_pass">
                                        <small class="text-muted">Mot de passe de la base de données</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="bdd_address">Adresse de la base de données</label>
                                        <input type="text" name="bdd_address" class="form-control" id="bdd_address"
                                               required>
                                        <small class="text-muted">Généralement <code>localhost</code>. Si localhost ne
                                            fonctionne pas, veuillez demander l'information à votre hébergeur.</small>
                                    </div>
                                    <hr>
                                    <h2>A propos du site :</h2>
                                    <div class="form-group">
                                        <label for="install_folder">Dossier d'installation</label>
                                        <input type="text" name="install_folder" class="form-control"
                                               id="install_folder" required>
                                        <small class="text-muted">Généralement <code>/</code>. Si CraftMySite se trouve
                                            dans un dossier, veuillez indiquer <code>/dossier/</code>.</small>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" name="update_env" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['step']) && $_GET['step'] == 2) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Créez votre compte administrateur</h3>
                            </div>
                            <!-- form start -->
                            <form action="controller.php" role="form" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Adresse email</label>
                                        <input type="text" name="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pseudo">Identifiant</label>
                                        <input type="text" name="pseudo" class="form-control" id="pseudo" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Mot de passe</label>
                                        <input type="text" name="password" class="form-control" id="password">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" name="create_admin" class="btn btn-primary">Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['step']) && $_GET['step'] == 3) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Succès !</h3>
                            </div>
                            <div class="card-body">
                                <p>CraftMySite est installé. Merci de l'utiliser et profitez bien de votre site !</p>
                                <hr>
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Attention</span>
                                        <span class="progress-description">Supprimez le dossier installation !</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="../" class="btn btn-primary">Aller voir mon site !</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">A propos de votre installation</h3>
                        </div>
                        <div class="card-body">
                            <?php if (file_exists("../.env")) : ?>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-server"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text font-weight-bold">Félicitation</span>
                                        <span class="progress-description">Votre base a été créée</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>

                                <?php $dbHost = getenv("DB_HOST") ?? "<span class='text-danger'>erreur</span>";
                                $dbUsername = getenv("DB_USERNAME") ?? "<span class='text-danger'>erreur</span>";
                                $dbPassword = !empty(getenv("DB_PASSWORD")) ? "*****" : "<span class='text-danger'>erreur / vide</span>";
                                $dbName = getenv("DB_NAME") ?? "<span class='text-danger'>erreur</span>"; ?>
                                <p>
                                    <b>Adresse de la base de données :</b> <?= $dbHost ?><br>
                                    <b>Identifiant de la base de données :</b> <?= $dbUsername ?><br>
                                    <b>Mot de passe de la base de données :</b> <?= $dbPassword ?><br>
                                    <b>Nom de la base de données :</b> <?= $dbName ?>
                                </p>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include_once("../admin/resources/views/includes/footer.inc.php") ?>
</div>

<!-- Bootstrap 4 -->
<script src="../admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../admin/resources/js/adminlte.min.js"></script>
</body>
</html>