<?php

namespace CMS\Controller;

class newsController {
    public function show($id) {
        echo "<form method='post' action=''>
                <input type='text' name='text'>
                <input type='submit' name='submit' value='Envoyer'>
              </form>";
        echo "Je suis l'article $id";
    }

    public function admin() {
        require(PATH_ADMIN_VIEW.'news_list.view.php');
    }
}