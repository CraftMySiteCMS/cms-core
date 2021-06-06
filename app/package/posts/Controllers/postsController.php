<?php

namespace CMS\Controller\posts;

use CMS\Controller\coreController;
use CMS\Model\posts\postsModel;
use CMS\Model\posts\categoriesModel;

class postsController extends coreController {
    public function show($id) {
        echo "<form method='post' action=''>
                <input type='text' name='text'>
                <input type='submit' name='submit' value='Envoyer'>
              </form>";
        echo "Je suis l'article $id";
    }

    public function admin() {
        require('app/package/posts/views/list.admin.view.php');
    }


    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Vérifie si une catégorie existe. Retourne 1 si existe, 0 le cas contraire
     */
    public function cms_category_exist($var): bool {
        $categoriesModel = new categoriesModel();
        return $categoriesModel->checkCategory($var,true);
    }
    /*
     * Récupère toutes les informations de la catégorie d'après le slug dans l'URL
     */
    public function cms_category_infos(): categoriesModel {
        $categoriesModel = new categoriesModel();
        if(isset($_GET['category_slug'])) :
            $categoriesModel = new categoriesModel();
            $categoriesModel->category_slug = $_GET['category_slug'];
            $categoriesModel->getCategory();
        else :
            cms_errors(1);
        endif;

        return $categoriesModel;
    }
    /*
     * Retourne l'ID de la catégorie courante
     */
    public function cms_category_id(): int {
        $r = "";
        $CategoryInfos = cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_id";
        else :
            cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Retourne le nom de la catégorie courante
     */
    public function cms_category_name(): string {
        $r = "";
        $CategoryInfos = cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_name";
        else :
            cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Retourne la description de la catégorie courante
     */
    public function cms_category_description(): string {
        $r = "";
        $CategoryInfos = cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_description";
        else :
            cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Vérifie si une actualité existe. Retourne 1 si existe, 0 le cas contraire
     */
    public function cms_posts_list_exist($var): bool {
        $postsModel = new postsModel();
        return $postsModel->checkPosts($var,true);
    }

    /*
     * Récupère toutes les informations de l'actualité d'après le slug dans l'URL
     */
    public function cms_posts_list_infos(): postsModel {
        $postsModel = new postsModel();
        if(isset($_GET['posts_slug'])) :
            $postsModel = new postsModel();
            $postsModel->posts_slug = $_GET['posts_slug'];
            $postsModel->getPosts(true);
        else :
            cms_errors(1);
        endif;

        return $postsModel;
    }
    /*
     * Retourne l'id de l'actualité courante
     */
    public function cms_posts_list_id(): int {
        $r = 0;
        $PostsInfos = cms_posts_list_infos();
        if($PostsInfos != 'error') :
            $r .= "$PostsInfos->posts_id";
        else :
            cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Retourne le titre de l'actualité courante
     */
    public function cms_posts_list_title(): string {
        $r = "";
        $PostsInfos = cms_posts_list_infos();
        if($PostsInfos != 'error') :
            $r .= "$PostsInfos->posts_title";
        else :
            cms_errors(1);
        endif;

        return $r;
    }

    /*
     * Récupération de toutes les actualités enregistrées en base de données
     */
    public function cms_posts_list_list($limit = null, $offset = null, $category = null): array {
        $postsModel = new postsModel();
        return $postsModel->getAllPosts($limit, $offset, $category);
    }
    /*
     * Récupération d'une actualité d'après son slug
     */
    public function cms_posts_list(): postsModel {
        $postsModel = new postsModel();
        $postsModel->posts_slug = $_GET['posts_slug'];
        $postsModel->getPosts(true);

        return $postsModel;
    }
    /*
     * Barre de recherche des actualités
     */
    public function cms_searchbar_posts(): string {
        $keyword = isset($_POST['search']['keyword']) ? $_POST['search']['keyword'] : "";
        $r = "";
        $r .= "<form action='/index.php?action=search_posts' method='post'>";
        $r .= "<input type='text' name='search[keyword]' value='$keyword'>";
        $r .= "<input type='submit' value='rechercher'>";
        $r .= "</form>";

        return $r;
    }

    /* END GLOBALS FUNCTIONS */
}