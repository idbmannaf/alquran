<?php
require __DIR__ . '/vendor/autoload.php';
use App\classes\Login;

Login::logout();

header("Location: ".PROJECT_PATH."index.php");