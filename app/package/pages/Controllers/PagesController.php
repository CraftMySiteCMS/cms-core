<?php

namespace CMS\Controller\pages;

use CMS\Controller\CoreController;
use CMS\Controller\Users\UsersController;
use CMS\Model\Pages\PagesModel;
use CMS\Model\Users\UsersModel;

/**
 * Class: @PagesController
 * @package Pages
 * @author LoGuardiaN | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class PagesController extends CoreController
{

    public static string $themePath;

    public function __construct($theme_path = null)
    {
        parent::__construct($theme_path);
    }

    public function adminPagesList()
    {
        $pagesModel = new PagesModel();
        $pagesList = $pagesModel->fetchAll();

        require('app/package/pages/views/list.admin.view.php');
    }

    public function adminPagesAdd(): void
    {
        usersController::isAdminLogged();

        require('app/package/pages/views/add.admin.view.php');
    }

    public function adminPagesAddPost(): void
    {
        usersController::isAdminLogged();


        $user = new UsersModel();

        $page = new PagesModel();
        $page->pageTitle = $_POST["news_title"];
        $page->pageSlug = $_POST["news_slug"];
        $page->pageContent = $_POST["news_content"];
        $page->pageState = $_POST["page_state"];
        $page->userId = $user->getLoggedUser();

        $page->create();

        echo $page->pageId;
    }

    public function adminPagesEdit($id): void
    {
        usersController::isAdminLogged();

        $page = new pagesModel();
        $page->pageId = $id;
        $page->fetch();

        $pageContent = $page->pageContent;
        require('app/package/pages/views/edit.admin.view.php');
    }

    public function adminPagesEditPost(): void
    {
        usersController::isAdminLogged();

        $page = new pagesModel();
        $page->pageId = $_POST["news_id"];
        $page->pageTitle = $_POST["news_title"];
        $page->pageSlug = $_POST["news_slug"];
        $page->pageContent = $_POST["news_content"];
        $page->pageState = $_POST["page_state"];

        $page->update();

        echo $page->pageId;
    }


}