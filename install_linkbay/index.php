<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];

    $conn = new mysqli($host, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Creare il database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database creato con successo<br>";
    } else {
        die("Errore nella creazione del database: " . $conn->error);
    }

    // Seleziona il database
    $conn->select_db($dbname);

    // Funzione per eseguire file SQL
    function runSQLFile($conn, $file) {
        $queries = file_get_contents($file);
        $queries = explode(";", $queries);

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if ($conn->query($query) === TRUE) {
                    echo "Query eseguita: $query<br>";
                } else {
                    echo "Errore nell'esecuzione della query: " . $conn->error . "<br>";
                }
            }
        }
    }

    // Esegui i file SQL
    runSQLFile($conn, 'path/to/schema.sql');
    runSQLFile($conn, 'path/to/data.sql');

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione Database</title>
</head>
<body>
    <h1>Installazione Database</h1>
    <form method="post">
        <label for="host">Host:</label><br>
        <input type="text" id="host" name="host" required><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="dbname">Nome Database:</label><br>
        <input type="text" id="dbname" name="dbname" required><br><br>
        <input type="submit" value="Installa">
    </form>
</body>
</html>
