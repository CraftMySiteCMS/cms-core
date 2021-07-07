<?php
namespace CMS\Controller\pages;

use CMS\Controller\coreController;
use CMS\Controller\users\usersController;
use CMS\Model\pages\pagesModel;
use CMS\Model\users\usersModel;

class pagesController extends coreController {

    public static string $theme_path;

    public function __construct($theme_path = null) {
        parent::__construct($theme_path);
    }

    public function admin_pages_add() {
        usersController::is_admin_logged();

        require('app/package/pages/views/add.admin.view.php');
    }
    
    public function admin_pages_add_post() {
        usersController::is_admin_logged();


        $user = new usersModel();

        $page = new pagesModel();
        $page->page_title = $_POST["news_title"];
        $page->page_slug = $_POST["news_slug"];
        $page->page_content = $_POST["news_content"];
        $page->page_state = 1;
        $page->user_id = $user->getLogedUser();

        $page->create();

        echo 1;
    }

}