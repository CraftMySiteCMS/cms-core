<?php $title = _Pages_list_TITLE;
$description = _Pages_list_DESC; ?>

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
                processing:     "'._Datatables_list_processing.'",
                search:         "'._Datatables_list_search.'",
                lengthMenu:    "'._Datatables_list_lengthMenu.'",
                info:           "'._Datatables_list_info.'",
                infoEmpty:      "'._Datatables_list_infoEmpty.'",
                infoFiltered:   "'._Datatables_list_infoFiltered.'",
                infoPostFix:    "'._Datatables_list_infoPostFix.'",
                loadingRecords: "'._Datatables_list_loadingRecords.'",
                zeroRecords:    "'._Datatables_list_zeroRecords.'",
                emptyTable:     "'._Datatables_list_emptyTable.'",
                paginate: {
                    first:      "'._Datatables_list_first.'",
                    previous:   "'._Datatables_list_previous.'",
                    next:       "'._Datatables_list_next.'",
                    last:       "'._Datatables_list_last.'"
                },
                aria: {
                    sortAscending:  "'._Datatables_list_sortAscending.'",
                    sortDescending: "'._Datatables_list_sortDescending.'"
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
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date de création</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pages_list as $page) : ?>
                                    <tr>
                                        <td><?=$page->page_title?></td>
                                        <td><?=$page->user->user_pseudo?></td>
                                        <td><?=$page->page_created?></td>
                                        <td><a href="../pages/edit/<?=$page->page_id?>" target="_blank"><i class="fa fa-cog"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date de création</th>
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