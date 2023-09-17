<?php
$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "aplicacao_fotos";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>