<?php 
require ('../../app.php');
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiungi Collaboratore</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
    <h1 class="h2">&nbsp;&nbsp;Aggiungi Collaboratore</h1> <!-- Modificato per usare il titolo dal database -->
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
          <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
      </div>
    </div>
</div>

<div style="padding: 20px;">
<div class="p-3 mb-2 bg-light rounded-3">
    <div class="container">
        <h2 class="mt-5">Invita collaboratore</h2>
        <form action="esegui_aggiunta_amministratori.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-outline-secondary">Invia Email</button>
        </form>
        <br><br>
    </div>
</div>
</div>


<div style="padding: 20px;">
<div class="p-3 mb-2 bg-light rounded-3">
    <div class="container">
        <h2 class="mt-5">Modifica Ruoli</h2>
    </div>
    <?php echo visualizzaRuoliAdmin(); ?>
</div>
</div>


<script>
function exit() {
    swal({
        title: "Uscire dalla vista?",
        text: "Vuoi davvero chiudere questa finestra? Tutte le modifiche non salvate andranno perse.",
        icon: "warning",
        buttons: ["Annulla", "Uscire"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            if (window.opener && !window.opener.closed) {
                window.opener.location.href = '../ui/utenti_ruoli.php'; // Aggiorna la pagina genitore
            }
            window.close(); // Chiude la finestra corrente
        }
    });
}

</script>

<?php include '../materials/script.php'; ?>
</body>
</html>