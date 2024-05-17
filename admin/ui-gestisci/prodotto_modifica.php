<?php 
require '../../app.php'; // Inclusione Principale

// Verifica se l'ID del prodotto è stato fornito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_prodotto = $_GET['id'];

    // Se è stato inviato un form di modifica fa un processing sulle modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $messaggio = modificaProdotto($id_prodotto);
        echo " <script>window.opener.location.href = '../ui/prodotti'; // Aggiorna la pagina genitore </script>";
    }

    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $messaggio = modificaProdotto($id_prodotto);
        echo "<script>
        window.opener.location.href = '../ui/prodotti'; // Aggiorna la pagina genitore
        window.close(); // Chiude la finestra corrente
        </script>";
    }

    $dettagliProdotto = ottieniDettagliProdotto($id_prodotto); // Funzione che recupera i dettagli del prodotto
} else {
    header("Location: ../ui/prodotti?warning=Prodotto+non+trovato"); // Reindirizza se l'ID del prodotto non è valido o mancante
    exit;
}
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Modifica <?php echo $dettagliProdotto['titolo']; ?></title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
<form id="deleteProductForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_prodotto; ?>" method="POST">
    <input type="hidden" name="action" value="delete">
</form>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_prodotto; ?>" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Modifica "<?php echo $dettagliProdotto['titolo']; ?>"</h1> <!-- Modificato per usare il titolo dal database -->
    <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
        <a href="../../prodotti/<?php echo urlencode($dettagliProdotto['titolo']); ?>" target="__blank" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-eye"></i>&nbsp; Visualizza</a>
        <a href="#" class="btn btn-sm btn-outline-light" onclick="creaVarianteProdotto(<?php echo $id_prodotto; ?>);"><i class="fa-solid fa-clone"></i> Crea Variante</a>
        <a href="#" class="btn btn-sm btn-outline-light" onclick="confirmDeleteProduct();"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Prodotto</a>
        <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
    </div>
    </div>
    </div>
        <?php echo $result;?>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_prodotto; ?>" method="POST">
    <div class="row">
        <!-- Colonna di sinistra -->
        <div class="col-md-6">
            <!-- Qui inserisci i campi del form che vuoi a sinistra -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Nome Prodotto</h5>
                    <input type="text" class="form-control" id="titolo" name="titolo" value="<?php echo $dettagliProdotto['titolo']; ?>" required>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Descrizione Personalizzata</h5>
                    <textarea class="form-control custom-description" id="descrizione" name="descrizione" rows="4" required><?php echo $dettagliProdotto['descrizione']; ?></textarea>
                </div>
            </div>

            <!-- PREZZO PRODOTTO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Prezzo</h5>
                    <div class="mb-3">
                        <label for="prezzo" class="form-label">Prezzo (con IVA)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="prezzo" name="prezzo" value="<?php echo $dettagliProdotto['prezzo']; ?>" placeholder="Inserisci il prezzo di vendita" required aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="prezzoComparato" class="form-label">Prezzo Comparato</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="prezzo_comparato" value="<?php echo $dettagliProdotto['prezzo_comparato']; ?>" name="prezzo_comparato" placeholder="Inserisci Il prezzo di paragone" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">€</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GESTIONE INVENTARIO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rimanenze</h5>
                    <div class="mb-3">
                        <label for="quantita" class="form-label">Quantità inventario</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="quantita" name="quantita" value="<?php echo $dettagliProdotto['quantita']; ?>" placeholder="Inserisci la quantità del Prodotto" required aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Qnt.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GESTIONE PESO PER SPEDIZIONI -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Spedizioni</h5>
                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?php echo $dettagliProdotto['peso']; ?>" placeholder="Inserisci il peso in Kg" required aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonna di destra -->
        <div class="col-md-6">
            <!-- Qui inserisci i campi del form che vuoi a destra -->
            <!-- STATO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Stato</h5>
                    <select class="form-select form-select-sm" id="stato" name="stato" required>
                        <option value="online" <?php if ($dettagliProdotto['stato'] == 'online') echo 'selected'; ?>>Metti Online 🟢</option>
                        <option value="offline" <?php if ($dettagliProdotto['stato'] == 'offline') echo 'selected'; ?>>Metti Offline 🔴</option>
                    </select>
                </div>
            </div>

            <!-- COLLEZIONE -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Collezione</h5>
                    <?php
                    require '../../conn.php';
                    $query_coll = "SELECT nome_c FROM collezioni"; // Query corretta
                    $result_coll = mysqli_query($conn, $query_coll);
                    
                    if ($result_coll) {
                        echo '<div class="mb-3">';
                        echo '<label for="collezione" class="form-label">Seleziona una collezione</label>';
                        echo '<select class="form-select" id="collezione" name="collezione" required>';
            
                        // Popola il menu a discesa con i dati dal database
                        while ($row_coll = mysqli_fetch_assoc($result_coll)) {
                          echo '<option value="' . htmlspecialchars($row_coll['nome_c']) . '"' . ($dettagliProdotto['collezione'] == $row_coll['nome_c'] ? ' selected' : '') . '>' . htmlspecialchars($row_coll['nome_c']) . '</option>';
                        }
            
                        echo '</select>';
                        echo '</div>';
                    } else {
                        echo "Errore durante l'esecuzione della query: " . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>

                        <!-- CATEGORIA -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Categoria</h5>
                    <?php
                    require '../../conn.php';
                    $query_cat = "SELECT nome_cat FROM categorie"; // Query corretta
                    $result_cat = mysqli_query($conn, $query_cat);
                    
                    if ($result_cat) {
                        echo '<div class="mb-3">';
                        echo '<label for="collezione" class="form-label">Seleziona una Categoria</label>';
                        echo '<select class="form-select" id="categoria" name="categoria" required>';
            
                        // Popola il menu a discesa con i dati dal database
                        while ($row_cat = mysqli_fetch_assoc($result_cat)) {
                          echo '<option value="' . htmlspecialchars($row_cat['nome_cat']) . '"' . ($dettagliProdotto['categoria'] == $row_cat['nome_cat'] ? ' selected' : '') . '>' . htmlspecialchars($row_cat['nome_cat']) . '</option>';
                        }
            
                        echo '</select>';
                        echo '</div>';
                    } else {
                        echo "Errore durante l'esecuzione della query: " . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>

            <!-- VARIANTI -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Nome della Variante</h5>
                    <div class="mb-3">
                        <label for="varianti" class="form-label">Nome Variante</label>
                        <input type="text" class="form-control" id="varianti" name="varianti" value="<?php echo $dettagliProdotto['varianti']; ?>" placeholder="Inserisci il nome del differenziatore, es: 'rosso', 'xl', 'grande', 'senza', ecc..">
                    </div>
                </div>
            </div>

            <!-- FORM IMMAGINI -->
            <div class="card mb-3">
                <div class="card-body">
                    <style>
                    .product-images .img-container {
                        display: inline-block; /* Renderizza gli elementi inline con un blocco */
                        width: 20%; /* Imposta la larghezza per ogni container dell'immagine */
                        vertical-align: top; /* Allinea gli elementi in alto */
                        margin-right: 5px; /* Aggiunge un margine a destra di ogni container per un po' di spazio */
                        text-align: center; /* Centra il testo e altri elementi all'interno del container */
                    }
                    .product-images img {
                        width: 100%; /* Assicura che le immagini si adattino alla larghezza del container */
                        height: auto; /* Mantiene il rapporto di aspetto delle immagini */
                        background-color: #f1f1f1;
                        border-radius: 20px;
                        padding: 10px;
                    }
                </style>
                    <h5 class="card-title">Immagini del Prodotto</h5>
                    <!-- Sezione per le immagini esistenti -->
                    <?php 
                    require ('../../conn.php');
                    $query = "SELECT * FROM media WHERE id_prodotto = $id_prodotto";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <div class="product-images mb-3">
                        <!-- Immagini recuperate dal database -->
                        <?php while ($immagine = mysqli_fetch_assoc($result)): ?>
                        <div class="img-container">
                            <?php $id_immagine = $immagine['id_media'];?>
                            <img src="<?php echo $immagine['immagine']; ?>" alt="Immagine del prodotto" width="20%">
                            <!-- Tasto per modificare/rimuovere l'immagine; implementa la logica JS come necessario -->
                            <a href="immagini_elimina.php?id_immagine=<?php echo urlencode($id_immagine); ?>&id_prodotto=<?php echo urlencode($id_prodotto); ?>" class="btn btn-outline-secondary img-edit-btn">Elimina</a>
                        </div>
                        <?php endwhile; ?>
                        <hr>
                    </div>
                    <!-- Tasto per aggiungere nuove immagini -->
                    <a href="#" class="btn btn-outline-secondary" onclick="checkBeforeRedirect();">Aggiungi Immagini</a>
                </div>
            </div>
        </div>
    </div>
</form>
</form>





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
function confirmDeleteProduct() {
    swal({
        title: "Sei sicuro?",
        text: "Vuoi eliminare questo prodotto? Non sarà possibile recuperarlo.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteProductForm').submit();
        }
    });
}

function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/prodotti'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
function checkBeforeRedirect(idProdotto) {
    swal({
        title: "Conferma Azione",
        text: "Assicurati di aver salvato tutte le modifiche prima di procedere ad aggiungere immagini. Vuoi continuare?",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((willContinue) => {
        if (willContinue) {
            // L'utente ha cliccato 'OK', può essere reindirizzato alla pagina di caricamento immagini
            window.location.href = 'immagini_modifica.php?id=<?php echo urlencode($id_prodotto); ?>';
        }
    });
}

function creaVarianteProdotto(idProdotto) {
    swal({
        title: "Sei sicuro?",
        text: "Assicurati di aver salvato tutte le modifiche prima di procedere a creare una variante di questo prodotto.",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((willCreate) => {
        if (willCreate) {
            window.location.href = 'crea_variante_prodotto.php?id=' + idProdotto;
        }
    });
}
</script>




<?php include '../materials/script.php'; ?>
</body>
</html>
