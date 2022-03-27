<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$host = 'localhost';
$dbname = 'dataljb7_smartdemo';
$user = 'dataljb7_smart';
$password = 'andy247742';
$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4', $user, $password);
?>