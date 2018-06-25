<?php
require_once 'functions.php';

if (empty($_POST['path'])) {
    throw new Exception('Chemin non défini ' . print_r($_POST, true));
}

$path = $_POST['path'];
$ignore = !empty($_POST['ignore']);
$chbx = !empty($_POST['chbx']);

$features = myScanDir($path, $ignore);

affFeatures($features, $chbx);