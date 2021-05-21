<?php
/*
*  ---------------------------
*  Load All Controller
*  ---------------------------
*/
require('app/__controller.php');

/*
*  ---------------------------
*  Load All Model
*  ---------------------------
*/
require('app/__model.php');

/*
* -------------------
*     MAIN ROUTES
* -------------------
*/
if(isset($_GET['page'])) :
    switch ($_GET['page']) :

    endswitch;
elseif(isset($_GET['action'])) :
    switch ($_GET['action']) :

    endswitch;
else :
    MainController::home();
endif;