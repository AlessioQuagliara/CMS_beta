<?php 
require '../../app.php'; 
require '../../conn.php';
loggato();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['namePage'])) {
  $namePage = $_POST['namePage'];

  // Prepara la query di cancellazione
  $stmt = $conn->prepare("DELETE FROM editor_contents WHERE name_page = ?");
  $stmt->bind_param("s", $namePage);

  if ($stmt->execute()) {
    echo "Cancellazione effettuata con successo";
  } else {
    echo "Errore durante la cancellazione: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>