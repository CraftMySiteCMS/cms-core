<?php

$packages_folder = 'app/package/';
$scanned_directory = array_diff(scandir($packages_folder), array('..', '.'));

foreach ($scanned_directory as $package) :
    require('package/'.$package.'/Models/'.$package.'Model.php');
endforeach;