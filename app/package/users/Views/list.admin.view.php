<?php $title = _Core_dashboard_TITLE;
$description = _Core_dashboard_DESC; ?>

<?php $styles = '<link rel="stylesheet" href="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/css/responsive.bootstrap4.min.css">';?>

<?php $scripts = '<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables/jquery.dataTables.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script>
    $(function () {
        $("#users_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
    });
</script>';?>

<?php ob_start(); ?>
    <!-- main-content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Contenu ici -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="users_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Adresse Email</th>
                                        <th>Surnom</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Rôle</th>
                                        <th>Date de création</th>
                                        <th>Date de modification</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users_list as $user) : ?>
                                    <tr>
                                        <td><?=$user['user_email']?></td>
                                        <td><?=$user['user_pseudo']?></td>
                                        <td><?=$user['user_firstname']?></td>
                                        <td><?=$user['user_lastname']?></td>
                                        <td><?=$user['user_role_name']?></td>
                                        <td><?=$user['user_created']?></td>
                                        <td><?=$user['user_updated']?></td>
                                        <td><a href="../users/edit/<?=$user['user_id']?>" target="_blank"><i class="fa fa-cog"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Adresse Email</th>
                                        <th>Surnom</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Rôle</th>
                                        <th>Date de création</th>
                                        <th>Date de modification</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.main-content -->
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW").'template.php'); ?>