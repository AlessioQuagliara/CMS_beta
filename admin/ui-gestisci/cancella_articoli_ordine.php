<?php
require '../../conn.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID ordine non valido');
}

$id_ordine = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inizio transazione
    $conn->begin_transaction();

    try {
        // Esegui la query di cancellazione
        $sql = "DELETE FROM dettagli_ordini WHERE id_ordine = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_ordine);
        $stmt->execute();

        // Esegui la query per aggiornare il totale ordine a 0
        $sql_update = "UPDATE ordini SET totale_ordine = 0 WHERE id_ordine = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('i', $id_ordine);
        $stmt_update->execute();

        // Commit della transazione
        $conn->commit();

        $messaggio = "Articoli cancellati e totale ordine aggiornato con successo!";
        header("Location: ordine_modifica.php?id=$id_ordine");
        exit;
    } catch (Exception $e) {
        // Rollback in caso di errore
        $conn->rollback();
        $messaggio = "Errore durante la cancellazione degli articoli o l'aggiornamento del totale ordine: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Cancella Articoli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin/materials/login.css">
</head>
<body style="background-color: #f1f1f1;">
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Cancella Articoli</h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <?php if (isset($messaggio)): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($messaggio); ?>
                </div>
            <?php endif; ?>

            <p>Sei sicuro di voler cancellare tutti gli articoli associati all'ordine #<?php echo htmlspecialchars($id_ordine); ?>?</p>
            <form action="" method="post">
                <button type="submit" class="btn btn-danger">Cancella Articoli</button>
                <a href="ordine_modifica?id=<?php echo htmlspecialchars($id_ordine); ?>" class="btn btn-secondary">Annulla</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
