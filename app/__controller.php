<?php

$packageFolder = 'app/package/';
$scannedDirectory = array_diff(scandir($packageFolder), array('..', '.'));

foreach ($scannedDirectory as $package) :
    require('package/'.$package.'/Controllers/'.$package.'Controller.php');
endforeach;