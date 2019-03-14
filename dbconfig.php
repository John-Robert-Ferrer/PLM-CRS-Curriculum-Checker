<?php
session_start();

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'plmcrsdb';
$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    exit('Error: could not establish database connection');
}
