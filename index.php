<?php
require("main.php");

$api = new main_api(dirname(__FILE__));

$api->setHtmlAttr("lang","en");
$api->setBodyAttr("class","main_api");
$api->setThemplate_parts("body","body.php");
$api->setHeader('title','<title>Welcome to Phplus</title>');

$api->init();
?>
