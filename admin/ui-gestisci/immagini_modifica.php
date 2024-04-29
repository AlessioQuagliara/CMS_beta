<?php
include '../../app.php';

// Controlla se l'ID del prodotto è passato tramite GET e se è un numero valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_prodotto = intval($_GET['id']);
} else {
    // Gestisci l'errore se l'ID del prodotto non è valido o mancante
    echo "ID del prodotto non valido o mancante.";
    exit; // Termina l'esecuzione dello script per evitare ulteriori errori
}

aggiuntaImmagini($id_prodotto);
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiungi/Modifica Immagini</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
<form id="productImageForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_prodotto; ?>" method="POST" enctype="multipart/form-data" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Aggiungi Immagini al Prodotto</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            &nbsp;&nbsp;
            <div class="btn-group me-2">
                <a href="prodotto_modifica.php?id=<?php echo urldecode($id_prodotto);?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-chevron-left"></i>&nbsp; Torna indietro</a> 
                <button type="submit" name="uploadImages" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-upload"></i>&nbsp; Carica Immagini</button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Seleziona Immagini</h5>
            <input type="file" class="form-control" id="immagini" name="immagini[]" multiple="multiple" required>
        </div>
    </div>
</form>
<div style="padding: 20px;">
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
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    </div>
</div>



<script>
function exit() {
    window.close(); // Chiude la finestra corrente
}
</script>

<?php include '../materials/script.php'; ?>
</body>
</html>
