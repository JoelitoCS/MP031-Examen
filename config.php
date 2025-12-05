<?php
$host = 'mysql-adaw.alwaysdata.net';
$dbname = 'adaw_examen_canojoel';
$username = 'adaw';
$password = '16082006jcs';


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error){
    die("Error de conexión: " . $mysqli->connect_error);
}