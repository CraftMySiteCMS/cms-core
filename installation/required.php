<?php

/// DETECT THE PHP VERSION
///
/// / ! \ CMS Require php 7.4 or higher / ! \
///

$currentPHPVersion = phpversion();

if ($currentPHPVersion <= 7.3){

    include "required.view.php";

    die();
}