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
    
<form id="deleteOrderForm" action="" method="POST">
    <input type="hidden" name="action" value="delete">
</form>

<form action="" method="POST" style="padding: 10px;">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;<?php stampaTotaleOrdine($id_order); ?></h1> <!-- Modificato per usare il titolo dal database -->
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <?php 
                if ($stato_ordine == 'Inevaso') {
                    echo '<a href="evadi_ordine?id='.$id_order.'" onclick="autoSaveEvaso()" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-circle-check"></i>&nbsp; Evadi Ordine</a>';
                } else if ($stato_ordine == 'Evaso') {
                    echo '<a href="inevadi_ordine?id='.$id_order.'" onclick="autoSaveInevaso()" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-circle-check"></i>&nbsp; Torna Inevaso</a>';
                } else if ($stato_ordine == 'Spedito') {
                    echo '<a href="" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-circle-check"></i>&nbsp; Spedito</a>';
                }
                ?>
                <?php 
                if ($stato_ordine != 'abbandonato') {
                    echo '<a href="#" class="btn btn-sm btn-outline-light" onclick="confirmDeleteOrder('.$id_order.');"><i class="fa-solid fa-right-from-bracket"></i>&nbsp; Abbandona Ordine</a>';
                }
                ?>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
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
                            <input type="date" readonly class="form-control" value="<?php echo $data_ordine;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <?php if($stato_ordine == 'Inevaso'){$colore_ordine = 'text-danger';}else if($stato_ordine == 'Evaso'){$colore_ordine = 'text-success';}else{$colore_ordine = 'text-warning';}?>
                        <label class="col-sm-2 col-form-label">Stato Ordine</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control <?php echo $colore_ordine; ?>" value="<?php echo $stato_ordine;?>">
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
                            <input type="text" readonly class="form-control" value="<?php echo $tipo_spedizione;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Paese</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $paese;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Città</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $citta;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Cap</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $cap;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Provincia</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $provincia;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Indirizzo</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $indirizzo_spedizione;?>">
                        </div>
                    </div>

                </div>
            </div>

            <!-- TRACK NUMBER, inserisci qui il tracking -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tracciabilità Pacco</h5>
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
                            <input type="text" readonly class="form-control" value="<?php echo $nome;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Cognome</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $cognome;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $email;?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Telefono</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $telefono;?>">
                        </div>
                    </div>

                </div>
            </div>

            <!-- ANALISI CONSUMATORE, inserisci l'analisi di quanti ordini ha fatto il cliente -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Analisi Cliente</h5>
                </div>
            </div>

            <!-- LISTA ARTICOLI ORDINATI -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Articoli Ordinati</h5>

                    <div class="mb-3 row">
                        <div>
                             
                            <div class='table-responsive'>
                                <table class='table table-striped table-hover'>
                                    <thead class='thead-dark'>
                                        <tr><th>img</th><th>Nome prodotto</th><th>Variante</th><th>Quantità</th><th>Prezzo</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (isset($dettagli_articoli['error'])) {
                                            echo $dettagli_articoli['error'];
                                        } else {
                                            dettagliTabella($dettagli_articoli); 
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

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
            window.location.href = 'abbandona_ordine?id=' + id_order;
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
