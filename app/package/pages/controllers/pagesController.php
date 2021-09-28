<?php

namespace CMS\Controller\pages;

use CMS\Controller\coreController;
use CMS\Controller\Users\usersController;
use CMS\Model\Pages\pagesModel;
use CMS\Model\Users\usersModel;

/**
 * Class: @pagesController
 * @package Pages
 * @author LoGuardiaN | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class pagesController extends coreController
{
    public static string $themePath;

    public function __construct($theme_path = null)
    {
        parent::__construct($theme_path);
    }

    public function adminPagesList()
    {
        $pagesModel = new pagesModel();
        $pagesList = $pagesModel->fetchAll();

        view('pages', 'list.admin', ["pagesList" => $pagesList], 'admin');
    }

    public function adminPagesAdd(): void
    {
        view('pages', 'add.admin', [], 'admin');
    }

    public function adminPagesAddPost(): void
    {
        usersController::isAdminLogged();

        $user = new usersModel();

        $page = new pagesModel();
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
        $page = new pagesModel();
        $page->pageId = $id;
        $page->fetch();

        $pageContent = $page->pageContent;

        view('pages', 'edit.admin', ["page"=> $page, "pageContent" => $pageContent], 'admin');
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