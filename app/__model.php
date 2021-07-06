<?php

$packages_folder = 'app/package/';
$scanned_directory = array_diff(scandir($packages_folder), array('..', '.'));

foreach ($scanned_directory as $package) :
    $packages_subfolder = "app/package/$package/Models/";
    $scanned_subdirectory = array_diff(scandir($packages_subfolder), array('..', '.'));
    foreach ($scanned_subdirectory as $model) :
        require("package/$package/Models/$model");
    endforeach;
endforeach;