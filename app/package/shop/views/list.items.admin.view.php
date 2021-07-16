<?php use CMS\Model\Shop\CategoryModel;
use CMS\Model\Shop\ItemModel;

$title = SHOP_ITEM_LIST_TITLE;
$description = SHOP_ITEM_LIST_DESCRIPTION;
?>

<?php
$styles = '<link rel="stylesheet" href="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables-bs4/css/dataTables.bootstrap4.min.css">';
$styles .= '<link rel="stylesheet" href="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables-responsive/css/responsive.bootstrap4.min.css">';
$styles .= "<link rel='stylesheet' href='" . getenv("PATH_SUBFOLDER") . "admin/resources/vendors/sweetalert2/sweetalert2.min.css'>";

$scripts = '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables/jquery.dataTables.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/sweetalert2/sweetalert2.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables-bs4/js/dataTables.bootstrap4.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables-responsive/js/dataTables.responsive.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/datatables-responsive/js/responsive.bootstrap4.min.js" ></script>';
$scripts .= '<script>
$(".deleteButton").click((el) => {

    let successMessage = () => {
        Swal.fire(
            "Supprimé!",
            "L\'article a bien été supprimé.",
            "success",
        )
    }
    let itemId         = el.target.parentNode.dataset.itemId

    Swal.fire({
                  title             : "Êtes-vous sûr ?",
                  text              : "Vous ne pourrez plus retourner en arrière !",
                  icon              : "warning",
                  showCancelButton  : true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor : "#d33",
                  confirmButtonText : "Oui, je supprime cet article!",
                  cancelButtonText  : "Annuler",
              }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                       url    : "' . getenv('PATH_SUBFOLDER') . 'cms-admin/shop/items/delete",
                       type   : "POST",
                       data   : {
                           "item_id": itemId,
                       },
                       success: res => {
                           if (parseInt(res) === 1)  {
                               successMessage()
                               let tableRow = el.target.offsetParent.parentNode
                               tableRow.remove()
                               table.row(tableRow).remove();
                               table.draw();
                               console.log()
                           }
                       },
                   })
        }
    })

})

let table = $("#users_table").DataTable({
                                            "responsive": true, 
                                            "lengthChange": false, 
                                            "autoWidth": false,
                                            language      : {
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
                                                },
                                            },
                                        });
</script>';
?>

<?php ob_start(); ?>
    <!-- main-content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Contenu ici -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= SHOP_ITEM_LIST ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="users_table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><?= SHOP_ITEM_ID ?></th>
                                    <th><?= SHOP_ITEM_NAME ?></th>
                                    <th><?= SHOP_ITEM_STOCK ?></th>
                                    <th><?= SHOP_ITEM_CATEGORIES ?></th>
                                    <th><?= SHOP_ITEM_STATE ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                /** @var ItemModel[] $itemList fetchAll function *
                                 * @var ItemModel $item
                                 */
                                foreach ($itemList as $item) : ?>
                                    <tr>
                                        <td><?= $item->itemId ?></td>
                                        <td><?= $item->itemName ?></td>
                                        <td><?= ($item->itemStock === -1) ? SHOP_ITEM_NOLIMIT : $item->itemStock ?></td>

                                        <?php $item->itemCategoriesId = $item->getCategories();
                                        $categories = '';
                                        foreach ($item->itemCategoriesId as $categoryId) {
                                            $category = new categoryModel();
                                            $category->fetch($categoryId);
                                            $categories .= "<b>$category->categoryName</b>, ";
                                        } ?>

                                        <td><?= ($categories === '') ? SHOP_ITEM_NOCATEGORY : mb_substr($categories, 0, -2) ?></td>
                                        <td class="text-center">
                                            <i class='nav-icon fas fa-circle text-<?= ($item->itemState ? 'success' : 'danger') ?>'></i>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="../shop/item/edit/<?= $item->itemId ?>" target="_blank"><i
                                                            class="fa fa-cog"></i></a>
                                                <a class="text-danger deleteButton" data-item-id="<?= $item->itemId ?>"
                                                   href="#">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
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

<?php require(getenv('PATH_ADMIN_VIEW') . 'template.php'); ?>