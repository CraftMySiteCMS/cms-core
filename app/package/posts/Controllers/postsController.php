<?php

namespace CMS\Controller\posts;

use CMS\Controller\coreController;
use CMS\Model\posts\categoriesModel;
use CMS\Model\posts\postsModel;

class postsController extends coreController {
    public function show($id) {
        echo "<form method='post' action=''>
                <input type='text' name='text'>
                <input type='submit' name='submit' value='Envoyer'>
              </form>";
        echo "Je suis l'article $id";
    }

    public function admin() {
        require('app/package/posts/Views/list.admin.view.php');
    }


    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Check if a category exists. Returns 1 if exists, 0 otherwise
     */
    public function cms_category_exist($var): bool {
        $categoriesModel = new categoriesModel();
        return $categoriesModel->checkCategory($var,true);
    }
    /*
     * Get all the category information from the slug in the URL
     */
    public function cms_category_infos(): categoriesModel {
        $categoriesModel = new categoriesModel();
        if(isset($_GET['category_slug'])) :
            $categoriesModel = new categoriesModel();
            $categoriesModel->category_slug = $_GET['category_slug'];
            $categoriesModel->getCategory();
        else :
            coreController::cms_errors(1);
        endif;

        return $categoriesModel;
    }
    /*
     * Returns the ID of the current category
     */
    public function cms_category_id(): int {
        $r = "";
        $CategoryInfos = $this->cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_id";
        else :
            coreController::cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Returns the name of the current category
     */
    public function cms_category_name(): string {
        $r = "";
        $CategoryInfos = $this->cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_name";
        else :
            coreController::cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Returns the description of the current category
     */
    public function cms_category_description(): string {
        $r = "";
        $CategoryInfos = $this->cms_category_infos();
        if($CategoryInfos != 'error') :
            $r .= "$CategoryInfos->category_description";
        else :
            coreController::cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Checks if a news item exists. Returns 1 if exists, 0 otherwise
     */
    public function cms_posts_list_exist($var): bool {
        $postsModel = new postsModel();
        return $postsModel->checkPosts($var,true);
    }

    /*
     * Retrieves all news information from the slug in the URL
     */
    public function cms_posts_list_infos(): postsModel {
        $postsModel = new postsModel();
        if(isset($_GET['posts_slug'])) :
            $postsModel = new postsModel();
            $postsModel->posts_slug = $_GET['posts_slug'];
            $postsModel->getPosts(true);
        else :
            coreController::cms_errors(1);
        endif;

        return $postsModel;
    }
    /*
     * Returns the id of the current news
     */
    public function cms_posts_list_id(): int {
        $r = 0;
        $PostsInfos = $this->cms_posts_list_infos();
        if($PostsInfos != 'error') :
            $r .= "$PostsInfos->posts_id";
        else :
            coreController::cms_errors(1);
        endif;

        return $r;
    }
    /*
     * Returns the title of the current news
     */
    public function cms_posts_list_title(): string {
        $r = "";
        $PostsInfos = $this->cms_posts_list_infos();
        if($PostsInfos != 'error') :
            $r .= "$PostsInfos->posts_title";
        else :
            coreController::cms_errors(1);
        endif;

        return $r;
    }

    /*
     * Retrieval of all the news recorded in the database
     */
    public function cms_posts_list_list($limit = null, $offset = null, $category = null): array {
        $postsModel = new postsModel();
        return $postsModel->getAllPosts($limit, $offset, $category);
    }
    /*
     * Retrieving a news item from its slug
     */
    public function cms_posts_list(): postsModel {
        $postsModel = new postsModel();
        $postsModel->posts_slug = $_GET['posts_slug'];
        $postsModel->getPosts(true);

        return $postsModel;
    }
    /*
     * News search bar
     */
    public function cms_searchbar_posts(): string {
        $keyword = $_POST['search']['keyword'] ?? "";
        $r = "<form action='/index.php?action=search_posts' method='post'>";
        $r .= "<input type='text' name='search[keyword]' value='$keyword'>";
        $r .= "<input type='submit' value='rechercher'>";
        $r .= "</form>";

        return $r;
    }

    /* END GLOBALS FUNCTIONS */
}