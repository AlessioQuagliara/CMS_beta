<?php
if (isset($_GET['id_categoria'])) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto
    $id_categoria = intval($_GET['id_categoria']);

    // Qui va il codice per eliminare la categoria dal database
    // Ad esempio:
    $query = "DELETE FROM categorie WHERE id_categoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_categoria);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'ID categoria non fornito.']);
}
?>
