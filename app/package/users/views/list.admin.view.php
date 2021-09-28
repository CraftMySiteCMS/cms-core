<?php use CMS\Model\Users\usersModel;

$title = USERS_LIST_TITLE;
$description = USERS_LIST_DESC; ?>

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
                processing:     "'.DATATABLES_LIST_PROCESSING.'",
                search:         "'.DATATABLES_LIST_SEARCH.'",
                lengthMenu:    "'.DATATABLES_LIST_LENGTHMENU.'",
                info:           "'.DATATABLES_LIST_INFO.'",
                infoEmpty:      "'.DATATABLES_LIST_INFOEMPTY.'",
                infoFiltered:   "'.DATATABLES_LIST_INFOFILTERED.'",
                infoPostFix:    "'.DATATABLES_LIST_INFOPOSTFIX.'",
                loadingRecords: "'.DATATABLES_LIST_LOADINGRECORDS.'",
                zeroRecords:    "'.DATATABLES_LIST_ZERORECORDS.'",
                emptyTable:     "'.DATATABLES_LIST_EMPTYTABLE.'",
                paginate: {
                    first:      "'.DATATABLES_LIST_FIRST.'",
                    previous:   "'.DATATABLES_LIST_PREVIOUS.'",
                    next:       "'.DATATABLES_LIST_NEXT.'",
                    last:       "'.DATATABLES_LIST_LAST.'"
                },
                aria: {
                    sortAscending:  "'.DATATABLES_LIST_SORTASCENDING.'",
                    sortDescending: "'.DATATABLES_LIST_SORTDESCENDING.'"
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
                            <h3 class="card-title"><?=USERS_LIST_CARD_TITLE?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="users_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?=USERS_MAIL?></th>
                                        <th><?=USERS_PSEUDO?></th>
                                        <th><?=USERS_FIRSTNAME?></th>
                                        <th><?=USERS_SURNAME?></th>
                                        <th><?=USERS_ROLE?></th>
                                        <th><?=USERS_CREATION?></th>
                                        <th><?=USERS_LAST_EDIT?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php /** @var usersModel[] $userList */
                                foreach ($userList as $user) : ?>
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
                                        <th><?=USERS_MAIL?></th>
                                        <th><?=USERS_PSEUDO?></th>
                                        <th><?=USERS_FIRSTNAME?></th>
                                        <th><?=USERS_SURNAME?></th>
                                        <th><?=USERS_ROLE?></th>
                                        <th><?=USERS_CREATION?></th>
                                        <th><?=USERS_LAST_EDIT?></th>
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