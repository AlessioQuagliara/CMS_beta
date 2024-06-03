<?php 
require ('../../app.php');
loggato();
require '../../conn.php';
$risultato = dettagliNegozio(); // Chiamata alla funzione
if ($risultato) { // Controlla se c'è un risultato
    $messaggio_errore = "<div class='".$risultato["class"]."'>".$risultato["message"]."</div>";
};

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Payments</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'impostazioni'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">

            <div class="p-3 mb-2 bg-light rounded-3 border">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Imposta i tuoi pagamenti</h4>
                </div>
            </div>
            <?php
            // Connettiti al database
            require '../../conn.php';
            
            // Esegui la query per ottenere tutti i metodi di pagamento
            $query = "SELECT * FROM payment_systems";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                // Itera attraverso ogni riga risultato
                while($row = $result->fetch_assoc()) {
                    $statusBadge = $row['status'] == 'active' ? 'bg-success' : 'bg-danger';
                    $statusText = $row['status'] == 'active' ? 'Attivo' : 'Disattivo';
                    $buttonText = $row['status'] == 'active' ? 'Gestisci' : 'Imposta';
                    if ($row['provider'] == 'Stripe'){$icon = '<i class="fa-brands fa-cc-stripe fa-3x" style="color: #635bff;"></i>';}
                    else if ($row['provider'] == 'PayPal'){$icon = '<i class="fa-brands fa-cc-paypal fa-3x" style="color: #003087;"></i>';}
                    else if ($row['provider'] == 'Bonifico'){$icon = '<i class="fa-solid fa-building-columns fa-3x" style="color: #dcdde1;"></i>';}
                    else if ($row['provider'] == 'Pagolight'){$icon = '<img src="../materials/icon-pagolight.ico" style="width: 170px; height: 38px; color: #003087;" alt="PagoLight Icon">';}
                    // Genera il markup HTML per il metodo di pagamento
                    echo "<div id='metodo{$row['provider']}' class='p-3 mb-2 bg-light rounded-3 d-flex justify-content-between align-items-center border'>";
                    echo "<p class='d-none'>{$row['provider']}</p>";
                    echo $icon; 
                    echo "<span class='badge {$statusBadge}'>{$statusText}</span>";
                    echo "<button class='btn btn-outline-secondary' type='button' data-value='{$row['provider']}' onclick='apriModifica(this)'>{$buttonText} Pagamenti con {$row['provider']}</button>";
                    echo "</div>";
                }
            } else {
                echo "Nessun metodo di pagamento trovato.";
            }
            
            // Chiudi la connessione al database
            $conn->close();
            ?>
        </div>
    </main>

    <script>
        function apriModifica(button) {
            var provider = button.getAttribute('data-value'); // Recupera il valore dal bottone
            var url = "../ui-gestisci/pagamento_modifica.php?provider=" + provider; // Aggiungi il metodo all'URL come parametro query
            window.open(url, "Modifica Metodo", <?php echo $resolution;?>); // Apri la nuova finestra con le dimensioni specificate
        }

        function mostraInputRicerca() {
            var inputRicerca = document.getElementById('inputRicerca');
            if (inputRicerca.style.display === 'none') {
                inputRicerca.style.display = 'inline-block'; // Modificato da 'block' a 'inline-block'
                inputRicerca.focus(); // Mette il focus sull'input appena diventa visibile
            } else {
                inputRicerca.style.display = 'none';
            }
        }
    </script>
    
<?php include '../materials/script.php'; ?>
</body>
</html>
