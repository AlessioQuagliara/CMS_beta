<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto
loggato();
require '../../conn.php'; // Assicurati che la connessione al database sia aperta

$messaggio_risultato = '';
$row = getPaymentProviderDetailsAndUpdate($conn, $messaggio_risultato);


$provider = $row['provider'];
$client_id = $row['client_id'];
$secret_key = $row['secret_key'];
$statu = $row['status'];
$environment = $row['environment'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Dettagli Pagamento</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
<form action="" method="POST">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;<?php echo htmlspecialchars($row['provider']); ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>


    
    <div class="container mt-5">
    <?php echo $messaggio_risultato;?>
    <div class="p-3 mb-2 bg-light rounded-3">
            <!-- NOME E DESCRIZIONE -->
            <div class="card-body">
                <h5 class="card-title">Provider Pagamento:
                    <?php echo $provider; ?>
                </h5>
            </div>
            <input type="hidden" name="provider" value="<?php echo htmlspecialchars($provider); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo ($provider == 'Bonifico') ? 'Intestatario' : 'Client ID'; ?></h5>
                    <input type="text" class="form-control" id="client_id" name="client_id" value="<?php echo $client_id; ?>" required>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?php echo ($provider == 'Bonifico') ? 'IBAN' : 'Chiave segreta'; ?></h5>
                    <input type="text" class="form-control" id="secret_key" name="secret_key" value="<?php echo $secret_key; ?>" required>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title">Stato</h5>
                    <select class="form-select" id="status" name="status" required>
                        <option selected>Scegli uno stato</option>
                        <option value="active" <?php echo isset($statu) && $statu == 'active' ? 'selected' : ''; ?>>Attivo</option>
                        <option value="inactive" <?php echo isset($statu) && $statu == 'inactive' ? 'selected' : ''; ?>>Inattivo</option>
                    </select>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Ambiente</h5>
                    <select class="form-select" id="environment" name="environment" required>
                        <option selected>Scegli un ambiente</option>
                        <option value="production" <?php echo isset($environment) && $environment == 'production' ? 'selected' : ''; ?>>Reale</option>
                        <option value="sandbox" <?php echo isset($environment) && $environment == 'sandbox' ? 'selected' : ''; ?>>Sviluppo</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

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
                window.opener.location.href = '../ui/pagamenti.php'; // Aggiorna la pagina genitore
            }
            window.close(); // Poi chiude la finestra corrente
        }
    });
}
</script>


<?php include '../materials/script.php'; ?>
</body>
</html>
