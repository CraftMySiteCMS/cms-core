<?php $title = _Users_list_TITLE;
$description = _Users_list_DESC; ?>

<?php $styles = '<link rel="stylesheet" href="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/css/responsive.bootstrap4.min.css">';?>

<?php $scripts = '<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables/jquery.dataTables.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function () {
        $("#users_table").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {
                processing:     "'._Users_list_processing.'",
                search:         "'._Users_list_search.'",
                lengthMenu:    "'._Users_list_lengthMenu.'",
                info:           "'._Users_list_info.'",
                infoEmpty:      "'._Users_list_infoEmpty.'",
                infoFiltered:   "'._Users_list_infoFiltered.'",
                infoPostFix:    "'._Users_list_infoPostFix.'",
                loadingRecords: "'._Users_list_loadingRecords.'",
                zeroRecords:    "'._Users_list_zeroRecords.'",
                emptyTable:     "'._Users_list_emptyTable.'",
                paginate: {
                    first:      "'._Users_list_first.'",
                    previous:   "'._Users_list_previous.'",
                    next:       "'._Users_list_next.'",
                    last:       "'._Users_list_last.'"
                },
                aria: {
                    sortAscending:  "'._Users_list_sortAscending.'",
                    sortDescending: "'._Users_list_sortDescending.'"
                }
            },
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
                            <h3 class="card-title"><?=_Users_list_card_title?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="users_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?=_Users_mail?></th>
                                        <th><?=_Users_pseudo?></th>
                                        <th><?=_Users_firstname?></th>
                                        <th><?=_Users_surname?></th>
                                        <th><?=_Users_role?></th>
                                        <th><?=_Users_creation?></th>
                                        <th><?=_Users_last_edit?></th>
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
                                        <th><?=_Users_mail?></th>
                                        <th><?=_Users_pseudo?></th>
                                        <th><?=_Users_firstname?></th>
                                        <th><?=_Users_surname?></th>
                                        <th><?=_Users_role?></th>
                                        <th><?=_Users_creation?></th>
                                        <th><?=_Users_last_edit?></th>
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