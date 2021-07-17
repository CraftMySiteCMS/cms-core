<?php

use CMS\Model\Shop\CategoryModel;

$title = SHOP_CATEGORY_ADD_TITLE;
$description = SHOP_CATEGORY_ADD_DESCRIPTION;

$styles = "<link rel='stylesheet' href='" . getenv("PATH_SUBFOLDER") . "admin/resources/vendors/summernote/summernote-bs4.min.css'>";
$styles .= "<link rel='stylesheet' href='" . getenv("PATH_SUBFOLDER") . "admin/resources/vendors/summernote/summernote.min.css'>";
$styles .= "<link rel='stylesheet' href='" . getenv("PATH_SUBFOLDER") . "admin/resources/vendors/sweetalert2/sweetalert2.min.css'>";

$scripts = '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/summernote/summernote.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/summernote/summernote-bs4.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/sweetalert2/sweetalert2.min.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/jquery-validation/jquery.validate.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/jquery-validation/additional-methods.js" ></script>';
$scripts .= '<script type="text/javascript">

       $("#summernote").summernote({
        tabsize: 2,
        height: 100
      });
      
       $("#categoryForm").validate({
                                rules         : {
                                    category_name      : {required: true},
                                },
                                messages      : {},
                                errorElement  : "span",
                                errorPlacement: (error, element) => {
                                    error.addClass("invalid-feedback");
                                    element.closest(".form-group").append(error);
                                },
                                highlight     : (element, errorClass, validClass) => {
                                    $(element).addClass("is-invalid");
                                },
                                unhighlight   : (element, errorClass, validClass) => {
                                    $(element).addClass("is-valid");
                                    $(element).removeClass("is-invalid");
                                },
                                submitHandler : () => {

                                    $.ajax({
                                               url    : "' . getenv("PATH_SUBFOLDER") . 'cms-admin/shop/categories/add",
                                               type   : "POST",
                                               data   : {
                                                   "category_name"      : jQuery("#category_name").val(),
                                                   "category_description": $("#summernote").summernote("code")
                                               },
                                               success: (res) => {
                                                   
                                                   console.log(res)
                                                   res = parseInt(res)
                                                   
                                                   let toast = Swal.mixin({
                                                        toast: true,
                                                        position: "top-end",
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                   });
                                                   
                                                   toast.fire({
                                                     icon: (res === -1) ? "error" : "success",
                                                     title:  (res === -1) ? "'. SHOP_ERROR_RETRY .'" : "'. SHOP_SUCCESS_ACTION .'"
                                                   })
                                                   
                                                   if(res !== -1) {
                                                       document.getElementById("categoryForm").reset();                                                  
                                                   }
                                               },
                                           })
                                },
                            })


</script>';
?>


<?php ob_start(); ?>
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ajout d'une catégorie pour la boutique</h3>
                </div>
                <form id="categoryForm" method="post" novalidate="novalidate">
                    <div class="card-body">
                        <div class="container">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="category_name"> Nom de la catégorie</label>
                                        <input name="category_name" id="category_name" type="text"
                                               class="form-control form-control-border border-width-2"
                                               placeholder="Exemple : Chaussures Taille 46">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="category_name"> Description</label>
                                    <div id="summernote"></div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <button type="submit" class="btn btn-primary float-right">Ajouter une Catégorie</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(getenv('PATH_ADMIN_VIEW') . 'template.php'); ?>
