<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto
loggato();
require '../../conn.php'; // Assicurati che la connessione al database sia aperta

$tool = isset($_GET['tool']) ? $_GET['tool'] : '';
$messaggio_risultato = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tool_id = $_POST['tool_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE marketing_tools SET tool_id = ?, status = ? WHERE tool = ?");
    $stmt->bind_param("sss", $tool_id, $status, $tool);
    if ($stmt->execute()) {
        $messaggio_risultato = '<div class="alert alert-success" role="alert">Modifiche salvate con successo!</div>';
    } else {
        $messaggio_risultato = '<div class="alert alert-danger" role="alert">Errore nel salvataggio delle modifiche.</div>';
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM marketing_tools WHERE tool = ?");
$stmt->bind_param("s", $tool);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$tool_id = $row['tool_id'];
$status = $row['status'];
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica ID Strumenti di Marketing</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
<form action="" method="POST">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;<?php echo htmlspecialchars($tool); ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <?php echo $messaggio_risultato; ?>
        <div class="p-3 mb-2 bg-light rounded-3">
            <!-- Nome e descrizione -->
            <div class="card-body">
                <h5 class="card-title">Strumento di Marketing: <?php echo htmlspecialchars($tool); ?></h5>
            </div>
            <input type="hidden" name="tool" value="<?php echo htmlspecialchars($tool); ?>">
            <div class="card-body">
                <h5 class="card-title">ID Strumento</h5>
                <input type="text" class="form-control" id="tool_id" name="tool_id" value="<?php echo htmlspecialchars($tool_id); ?>" required>
            </div>

            <div class="card-body">
                <h5 class="card-title">Stato</h5>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" <?php echo $status == 'active' ? 'selected' : ''; ?>>Attivo</option>
                    <option value="inactive" <?php echo $status == 'inactive' ? 'selected' : ''; ?>>Inattivo</option>
                </select>
            </div>
        </div>
    </div>
</form>

<script>
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Tutte le modifiche non salvate andranno perse. Vuoi continuare?",
        icon: "warning",
        buttons: ["Annulla", "Conferma"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            // Se l'utente conferma di voler uscire, prima aggiorna la pagina genitore
            if (window.opener && !window.opener.closed) {
                window.opener.location.reload(); // Aggiorna la pagina genitore
            }
            window.close(); // Poi chiude la finestra corrente
        }
    });
}
</script>

<?php include '../materials/script.php'; ?>
</body>
</html>