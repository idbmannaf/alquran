<?php
require __DIR__ . '../../vendor/autoload.php';
use App\classes\Ayat;

$ayat = new Ayat();
$errors = $ayat->errors;
?>