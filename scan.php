<?php
require_once 'functions.php';

if (empty($_POST['path'])) {
    throw new Exception('Chemin non défini ' . print_r($_POST, true));
}

$path = $_POST['path'];
$ignore = !empty($_POST['ignore']);

$features = myScanDir($path, $ignore);

affFeatures($features);