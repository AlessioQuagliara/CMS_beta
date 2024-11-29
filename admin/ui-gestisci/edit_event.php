<?php
require_once '../../app.php'; // Assicura che la connessione e le dipendenze siano caricate correttamente
header('Content-Type: application/json');

// Verifica il metodo della richiesta
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito']);
    exit();
}

// Ottieni i dati dal corpo della richiesta
$data = json_decode(file_get_contents('php://input'), true);

// Validazione dei dati richiesti
if (empty($data['id_evento']) || empty($data['titolo']) || empty($data['descrizione']) || empty($data['categoria']) || empty($data['data_evento']) || empty($data['ora_evento'])) {
    echo json_encode(['success' => false, 'message' => 'Tutti i campi sono obbligatori']);
    exit();
}

// Associa i dati
$id_evento = htmlspecialchars($data['id_evento'], ENT_QUOTES, 'UTF-8');
$titolo = htmlspecialchars($data['titolo'], ENT_QUOTES, 'UTF-8');
$descrizione = htmlspecialchars($data['descrizione'], ENT_QUOTES, 'UTF-8');
$categoria = htmlspecialchars($data['categoria'], ENT_QUOTES, 'UTF-8');
$data_evento = htmlspecialchars($data['data_evento'], ENT_QUOTES, 'UTF-8');
$ora_evento = htmlspecialchars($data['ora_evento'], ENT_QUOTES, 'UTF-8');

try {
    // Prepara la query di aggiornamento
    $stmt = $conn->prepare("
        UPDATE eventi 
        SET titolo = ?, descrizione = ?, categoria = ?, data_evento = ?, ora_evento = ? 
        WHERE id_evento = ?
    ");

    if (!$stmt) {
        throw new Exception('Errore nella preparazione della query: ' . $conn->error);
    }

    // Bind dei parametri
    $stmt->bind_param('sssssi', $titolo, $descrizione, $categoria, $data_evento, $ora_evento, $id_evento);

    // Esecuzione della query
    $stmt->execute();

    // Controllo delle modifiche
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Evento aggiornato con successo']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nessuna modifica apportata']);
    }

    // Chiusura dello statement
    $stmt->close();

} catch (Exception $e) {
    // Gestione degli errori
    echo json_encode(['success' => false, 'message' => 'Errore durante la modifica dell\'evento: ' . $e->getMessage()]);
}
?>