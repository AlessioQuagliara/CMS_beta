<?php 
require '../../app.php'; 
require '../../conn.php';
loggato();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'], $_POST['namePage'])) {
  $content = $_POST['content']; 
  $namePage = $_POST['namePage']; 

  $stmt = $conn->prepare("INSERT INTO editor_contents (name_page, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = VALUES(content)");
  $stmt->bind_param("ss", $namePage, $content);

  if ($stmt->execute()) {
    echo "Salvataggio effettuato con successo";
  } else {
    echo "Errore durante il salvataggio: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>

