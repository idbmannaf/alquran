<?php
require __DIR__ . '../../vendor/autoload.php';
use App\classes\Surah;

$surah = new Surah();
$errors = $surah->errors;
?>