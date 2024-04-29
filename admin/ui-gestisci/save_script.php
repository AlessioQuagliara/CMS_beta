<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto
require '../../conn.php';
loggato(); // Assumi che loggato() verifichi se l'utente è autenticato

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'], $_POST['namePage'])) {
  $content = $_POST['content']; // Ottiene il contenuto inviato dal front-end
  $namePage = $_POST['namePage']; // Ottiene il nome della pagina inviato dal front-end

  // Modifica la query per utilizzare ON DUPLICATE KEY UPDATE
  $stmt = $conn->prepare("INSERT INTO editor_contents (name_page, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = VALUES(content)");
  $stmt->bind_param("ss", $namePage, $content);

  // Esecuzione dello statement
  if ($stmt->execute()) {
    echo "Salvataggio effettuato con successo";
  } else {
    echo "Errore durante il salvataggio: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>

