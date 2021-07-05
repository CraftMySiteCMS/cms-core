<?php $title = "";
$description = ""; ?>

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
</div>
<!-- /.content-wrapper -->
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW").'template.php'); ?>