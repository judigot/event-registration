<?php

ob_start();
include 'defaultTools.php';
include 'customTools.php';

$CurrentPage = substr(basename($_SERVER['PHP_SELF']), 0, -4);
$SiteName = "Site Name";
$PageTitle;

// Choose Title
switch ($CurrentPage) {

    case 'blank':
        $PageTitle = "Blank Page - $SiteName";
        break;

    default:
        $PageTitle = "Untitled Page!";
}
