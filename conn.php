<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CMS_DATABASE";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

?>