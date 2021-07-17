<?php use CMS\Model\Shop\CategoryModel;
use CMS\Model\Shop\ItemModel;

$title = SHOP_CATEGORY_LIST_TITLE;
$description = SHOP_CATEGORY_LIST_DESCRIPTION;

$styles = '<link rel="stylesheet" href="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/dragula/dragula.css">';
$styles .= "<link rel='stylesheet' href='" . getenv("PATH_SUBFOLDER") . "admin/resources/vendors/sweetalert2/sweetalert2.min.css'>";
$styles .= '<style>
::marker {
    content: none;
}
</style>';

$scripts = '<script type="text/javascript" src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/dragula/dragula.js"> </script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/jquery-ui/jquery-ui.js" ></script>';
$scripts .= '<script src="' . getenv("PATH_SUBFOLDER") . 'admin/resources/vendors/sweetalert2/sweetalert2.min.js" ></script>';
$scripts .= "<script>

$('.save-change').hide();

let setToNotSaved = element => {
    if(!element.classList.contains('not-saved')) {
        element.classList.add('not-saved');
        element.children[0].innerHTML = `<span title='Unsaved' class='badge bg-danger'>Unsaved</span> ` + element.children[0].innerHTML
    }
},
removeNotSaved = element => {
     element.children[0].removeChild( element.children[0].firstElementChild)
}


let drake = dragula([...document.querySelectorAll('[data-category-id ^=category-]'), document.querySelector('#itemList')],{
    removeOnSpill: true,
    copy: (el, source) => {
    return source === document.getElementById('itemList')
  },
  accepts: (el, target) => {
    let elements = [...target.children],
    accept = true
    for(let item of elements) {
        let itemId = item.dataset.itemId,
        itemToAdd = el.dataset.itemId
        if(itemId === itemToAdd) {
            if(el !== item && !(el.classList.contains('dragging') && item.classList.contains('gu-transit'))) accept = false
        }
    }
    return target !== document.getElementById('itemList') && accept
  }
});

drake.on('drag', (el, source) => {
    el.classList.add('dragging')
});

drake.on('dragend', el => {
    el.classList.remove('dragging')
});

drake.on('drop', (el, target, source, sibling) => {
      let itemModified = el.dataset.itemId,
      categoryWhereAdded = target.dataset.categoryId,
      categoryWhereRemoved = source.id === 'itemList' ? 'null-null' : source.dataset.categoryId
      
      let itemId = itemModified.split('-')[1]
      let addCategoryId = categoryWhereAdded.split('-')[1]
      let removeCategoryId = categoryWhereRemoved.split('-')[1]
      setToNotSaved(el);
      
      $.ajax({
        url    : '" . getenv('PATH_SUBFOLDER') . "cms-admin/shop/categories/swapItem',
        type   : 'POST',
        data   : {
            'begin_category': removeCategoryId,
            'end_category': addCategoryId,
            'item_id': itemId,
        },
        success: res => {
        
                console.log(res)
                let toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                toast.fire({
                      icon: (res === -1) ? 'error' : 'success',
                      title:  (res === -1) ? '" . SHOP_ERROR_RETRY . "' : '" . SHOP_SUCCESS_ACTION . "'
               })
               
               setTimeout(() => removeNotSaved(el), 200);

        },
      })
      console.log(`L'objet déplacé a comme id \${itemModified} de catégorie de départ \${categoryWhereRemoved} et d'arrivé \${categoryWhereAdded}...`);
      
      });

drake.on('remove', (el, target, source) => {
    if(el.classList.contains('not-saved')) return console.log('L\'objet retiré n\'a pas été sauvegardé à la base...');
    
    let itemRemoved = el.dataset.itemId,
    categoryWhereRemoved = target.dataset.categoryId
    
    let removeCategoryId = categoryWhereRemoved.split('-')[1],
    itemId = itemRemoved.split('-')[1]
    
    
    
    $.ajax({
            url    : '" . getenv('PATH_SUBFOLDER') . "cms-admin/shop/categories/swapItem',
            type   : 'POST',
            data   : {
                'begin_category': removeCategoryId,
                'end_category': 'null',
                'item_id': itemId,
            },
            success: res => {
                console.log(res)
                    let toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                    toast.fire({
                          icon: (res === -1) ? 'error' : 'success',
                          title:  (res === -1) ? '" . SHOP_ERROR_RETRY . "' : '" . SHOP_SUCCESS_DELETE . "'
                   })
    
            },
          })    
})
</script>";
$scripts .= '<script>

$(".deleteButton").click((el) => {

    let successMessage = () => {
        Swal.fire(
            "Supprimé!",
            "L\'article a bien été supprimé.",
            "success",
        )
    }
    let categoryId         = el.target.parentNode.dataset.categoryId

    Swal.fire({
                  title             : "Êtes-vous sûr ?",
                  text              : "Vous ne pourrez plus retourner en arrière !",
                  icon              : "warning",
                  showCancelButton  : true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor : "#d33",
                  confirmButtonText : "Oui, je supprime cette catégorie !",
                  cancelButtonText  : "Annuler",
              }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                       url    : "' . getenv('PATH_SUBFOLDER') . 'cms-admin/shop/categories/delete",
                       type   : "POST",
                       data   : {
                           "categoryId": categoryId,
                       },
                       success: res => {
                           if (parseInt(res) === 1)  {
                               successMessage()
                               let column = el.target.offsetParent.offsetParent.offsetParent
                               column.remove();
                           }
                       },
                   })
        }
    })

})

</script>';

ob_start();
?>

<div class="container">


    <div class="row">
        <div class="col-3 mt-5">

            <div class="card sticky-top">

                <div class="card-header">
                    <h3 class="card-title"><?= SHOP_ITEM_LIST ?></h3>
                </div>

                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column" id="itemList">

                        <?php
                        /** @var ItemModel[] $itemList fetchAll function *
                         * @var ItemModel $item
                         */
                        foreach ($itemList as $item): ?>
                            <li class="nav-item" data-item-id="item-<?= $item->itemId ?>">
                                <div class="d-block nav-link" href="#"><?= $item->itemName ?>
                                    <small>(<?= $item->itemId ?>)</small>
                                    <a class="float-right d-inline-block" href="../item/edit/<?= $item->itemId ?>">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>


        <div class="col-8 ml-auto">

            <div class="card card-primary">

                <div class="card-header">
                    <h4>Catégories</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        /** @var categoryModel[] $categoriesList fetchAll function *
                         * @var categoryModel $category
                         */
                        foreach ($categoriesList as $category): ?>
                            <div class="col-6">

                                <div class="card card-light">

                                    <div class="card-header">
                                        <div class="card-option float-left mr-3">
                                            <a href="#" data-category-id="<?= $category->categoryId ?>" class="deleteButton text-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <h3 class="card-title"><?= $category->categoryName ?></h3>
                                        <!-- <h6><?= mb_strimwidth($category->categoryDesc, 0, 255, '...') ?></h6> -->
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                        class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body"
                                         data-category-id="category-<?= $category->categoryId ?>">

                                        <?php $category->categoryItemId = $category->getItems();
                                        foreach ($category->categoryItemId as $itemId):
                                            $item = new ItemModel();
                                            $item->fetch($itemId)
                                            ?>
                                            <li class="nav-item" data-item-id="item-<?= $item->itemId ?>">
                                                <div class="d-block nav-link" href="#"><?= $item->itemName ?>
                                                    <small>(<?= $item->itemId ?>)</small>
                                                    <a class="float-right d-inline-block"
                                                       href="../item/edit/<?= $item->itemId ?>">
                                                        <i class="fa fas fa-cog"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>

                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW") . 'template.php'); ?>

