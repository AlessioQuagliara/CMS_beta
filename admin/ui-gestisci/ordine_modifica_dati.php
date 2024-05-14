<?php 
require '../../app.php';
loggato();

if(isset($_GET['id']) && is_numeric($_GET['id']) ){
    $id_order = $_GET['id'];
} else {
    $result = 'Id Ordine non trovato';
    exit;
}

$dettagli_ordine = dettagliOrdine($id_order);

if(isset($dettagli_ordine['error'])){
    echo $dettagli_ordine['error'];
} else {
    $id_ordine = $dettagli_ordine['id_ordine'];
    $email = $dettagli_ordine['email'];
    $data_ordine = $dettagli_ordine['data_ordine'];
    $stato_ordine = $dettagli_ordine['stato_ordine'];
    $totale_ordine = $dettagli_ordine['totale_ordine'];
    $indirizzo_spedizione = $dettagli_ordine['indirizzo_spedizione'];
    $paese = $dettagli_ordine['paese'];
    $cap = $dettagli_ordine['cap'];
    $citta = $dettagli_ordine['citta'];
    $provincia = $dettagli_ordine['provincia'];
    $telefono = $dettagli_ordine['telefono'];
    $nome = $dettagli_ordine['nome'];
    $cognome = $dettagli_ordine['cognome'];
    $tipo_spedizione = $dettagli_ordine['tipo_spedizione'];
}

$dettagli_articoli = dettagliArticoliOrdine($id_order);
if(isset($dettagli_articoli['error'])){

} else {
    $id_prodotto = $dettagli_articoli['id_prodotto'];
}

function dettagliTabella($dettagli_articoli) {
    foreach ($dettagli_articoli as $articolo) {
        echo '<tr>';
        echo "<td>" . htmlspecialchars($articolo['id_prodotto']) . "</td>";
        echo "<td>" . htmlspecialchars($articolo['titolo']) . "</td>";
        echo "<td>" . htmlspecialchars($articolo['varianti']) . "</td>";
        echo "<td>" . htmlspecialchars($articolo['quantita']) . "</td>";
        echo "<td>" . htmlspecialchars($articolo['prezzo']) . "€</td>";
        echo '</tr>';
    }
}


?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Ordine </title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<!-- FORM --> 
<form action="ordine_modifica_dati_esegui.php" method="POST" style="padding: 10px;">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Modifica Ordine #ODV00<?php echo $id_ordine; ?></h1> <!-- Modificato per usare il titolo dal database -->
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva</button>
                <a href="ordine_modifica?id=<?php echo $id_ordine; ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-chevron-left"></i>&nbsp; Torna Indietro</a>
            </div>
        </div>
    </div>

<?php echo $result;?>


    <div class="row">

        <!-- Colonna di sinistra -->
        <div class="col-md-6">
            <!-- DETTAGLI ORDINE, mettere lista articoli -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Ordine</h5>
                    <!-- Qui inserire i dettagli ordine -->
                    
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">ID ORDINE</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="#ODV00<?php echo $id_ordine;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Data Ordine</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" value="<?php echo $data_ordine;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <?php if($stato_ordine == 'Inevaso'){$colore_ordine = 'text-danger';}else if($stato_ordine == 'Evaso'){$colore_ordine = 'text-success';}else{$colore_ordine = 'text-warning';}?>
                        <label class="col-sm-2 col-form-label">Stato Ordine</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control <?php echo $colore_ordine; ?>" value="<?php echo $stato_ordine;?>">
                        </div>
                    </div>

                    <div class="mb-6 row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="" class="btn btn-outline-secondary">Modifica Dati</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- DETTAGLI SPEDIZIONE, inserire dettagli della spedizione -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Spedizione</h5>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tipo di Spedizione</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $tipo_spedizione;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Paese</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $paese;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Città</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $citta;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Cap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $cap;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Provincia</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $provincia;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Indirizzo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $indirizzo_spedizione;?>">
                        </div>
                    </div>

                </div>
            </div>

        <!-- Colonna di destra -->
        <div class="col-md-6">
            <!-- DETTAGLI CLIENTE, inserire i dettagli del cliente -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Cliente</h5>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $nome;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Cognome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $cognome;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="<?php echo $email;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Telefono</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="<?php echo $telefono;?>">
                        </div>
                    </div>

                </div>
            </div>

    </div>
</form>




<!-- FUNZIONI DI USCITA ---------------------------------------------------------------------------------------------------------------------------------------------------------->
<script>
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Se esci ora, le modifiche non verranno salvate.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.close(); // Chiude la finestra corrente
        }
    });
}

function confirmDeleteOrder(id_order) {
    swal({
        title: "Sei sicuro?",
        text: "Vuoi abbandonare questo ordine? Verrà notificato il cliente ma non rimborsato, per rimborsare il cliente dovrai accedere alla sezione 'rimborsi'.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = 'ordine_modifica?id=' + id_order;
        }
    });
}


function autoSaveEvaso() {
    if (window.opener && !window.opener.closed) {
        window.opener.location.href = '../ui/ordini_completi';
    }
}

function autoSaveInevaso() {
    if (window.opener && !window.opener.closed) { 
        window.opener.location.href = '../ui/ordini_inevasi';
    }
}

function autoSaveAbbandonato() {
    if (window.opener && !window.opener.closed) {
        window.opener.location.href = '../ui/ordini_abbandonati';
    }
}


</script>




<?php include '../materials/script.php'; ?>
</body>
</html>
