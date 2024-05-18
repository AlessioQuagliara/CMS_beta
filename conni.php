<?php

    // DATI CONNESSIONE AL DATABASE
$servername = "localhost"; $username = "root"; $password = "root"; $dbname = "CMS"; 
//$servername = "89.46.111.200"; $username = "Sql1701673"; $password = "WtQ5i8h20@"; $dbname = "Sql1701673_1";
// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);
// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}  


?>