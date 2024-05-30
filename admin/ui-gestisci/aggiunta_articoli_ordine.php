<?php 
require '../../app.php';
loggato();
require '../../conn.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_ordine = $_GET['id'];
} else {
    die('Id ordine non trovato');
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiungi Articoli </title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">
<div class="container">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Aggiunta Articoli</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-light" onclick="saveOrder()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva</button>
                <a href="ordine_modifica?id=<?php echo $id_ordine; ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-chevron-left"></i>&nbsp; Torna Indietro</a>
            </div>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Aggiungi Articolo</h5>
            <div class="mb-3">
                <label for="productSearch" class="form-label">Cerca Prodotto</label>
                <input type="text" id="productSearch" class="form-control" placeholder="Inserisci nome prodotto">
            </div>
            <div id="productList" class="list-group"></div>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Dettagli Ordine</h5>
            <ul id="orderDetails" class="list-group">
                <!-- Qui verranno aggiunti dinamicamente gli articoli -->
            </ul>
        </div>
    </div>
</div>

<script>
function searchProduct(query) {
    if (query.length < 3) return;
    
    $.ajax({
        url: 'cerca_prodotto.php',
        type: 'GET',
        data: { q: query },
        success: function(data) {
            $('#productList').html(data);
        }
    });
}

function addProductToOrder(id_prodotto, titolo, prezzo) {
    const listItem = `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h5>${titolo}</h5>
                <input type="hidden" name="id_prodotto[]" value="${id_prodotto}">
                <input type="number" name="quantita[]" class="form-control" placeholder="Quantità" value="1" min="1">
                <input type="hidden" name="prezzo[]" value="${prezzo}">
            </div>
            <span class="badge bg-primary rounded-pill">${prezzo}€</span>
            <button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('li').remove();">Rimuovi</button>
        </li>
    `;
    $('#orderDetails').append(listItem);
}

$('#productSearch').on('input', function() {
    const query = $(this).val();
    searchProduct(query);
});

function saveOrder() {
    let formData = $('#orderDetails :input').serialize();
    formData += '&id_ordine=<?php echo $id_ordine; ?>';

    console.log(formData); // Log per verificare i dati inviati

    $.ajax({
        url: 'salva_aggiunta_articoli.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log(response); // Log per vedere la risposta del server
            swal({
                title: "Ordine Salvato con Successo",
                text: "Sono stati associati gli articoli al tuo ordine",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'ordine_modifica?id=<?php echo $id_ordine; ?>';
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", status, error); // Log per vedere eventuali errori AJAX
        }
    });
}


</script>

<?php include '../materials/script.php'; ?>
</body>
</html>
