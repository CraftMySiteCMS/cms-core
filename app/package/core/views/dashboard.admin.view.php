<?php $title = CORE_DASHBOARD_TITLE;
$description = CORE_DASHBOARD_DESC; ?>

<?php ob_start(); ?>
        <!-- main-content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Contenu ici -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.main-content -->
<?php $content = ob_get_clean(); ?>