<?php 
require ('../../app.php');
loggato();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'toggleAllSelected') {
    // Assicurati di eseguire l'escape della variabile per prevenire iniezioni SQL
    $whichPage = $conn->real_escape_string($_POST['whichPage']);
    
    $checkQuery = "SELECT selected FROM prodotti LIMIT 1";
    $result = $conn->query($checkQuery);
    $allTrue = true;  // Assumiamo che tutti siano true a meno che non troviamo un false
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['selected'] === 'false') {
                $allTrue = false;
                break;
            }
        }
    }

    // Basato sul controllo, cambia lo stato di tutti
    $newState = $allTrue ? 'false' : 'true';
    $updateQuery = "UPDATE prodotti SET selected='$newState'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $message = $allTrue ? "Tutti gli stati sono stati impostati a false!" : "Tutti gli stati sono stati impostati a true!";
        echo json_encode(['message' => $message]);
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
}
?>
