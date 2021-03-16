<?php

$hostName = getenv('HTTP_HOST');
$projectName = 'alquran';
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
$rootUrl = $protocol.$hostName.'/'.$projectName.'/';


define("PROJECT_PATH", $rootUrl);//http://localhost/alquran/
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT'] . "/" . $projectName);//C:/xampp/htdocs/alquran