<?php 
require ('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Ordini Abbandonati</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'ordini'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- BARRA STRUMENTI -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="input-group">
            <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i>&nbsp; Esporta Tabella</button>
        </div>
    </div>

    
    <!-- TABELLA CONTENUTI -->

        <?php echo stampaTabellaOrdiniCompleti(); ?>
    </main>

    <script>
        // SCRIPT DI APERTURA MODIFICA
        function apriModifica(idOrdine) {
            // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
            window.open('../ui-gestisci/ordine_modifica.php?id=' + idOrdine, 'ModificaOrdine', <?php echo $resolution;?>);
        }

        
        // Funzione per filtrare le righe della tabella
        function filterTable(searchValue) {
            var tableRows = document.getElementById('myTable').getElementsByTagName('tr');
            for (var i = 1; i < tableRows.length; i++) {
                var currentRow = tableRows[i];
                var textContent = currentRow.textContent.toLowerCase();
                if (textContent.includes(searchValue)) {
                    currentRow.style.display = '';
                } else {
                    currentRow.style.display = 'none';
                }
            }
        }
        
        // SCRIPT DI RICERCA
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            // Imposta il valore dell'input con il valore salvato nel localStorage
            const savedSearchValue = localStorage.getItem('searchValue') || '';
            searchInput.value = savedSearchValue;
        
            // Applica il filtro basato sul valore salvato non appena la pagina viene caricata
            filterTable(savedSearchValue);
        
            searchInput.addEventListener('keyup', function() {
                var searchValue = this.value.toLowerCase();
                // Salva il valore corrente nel localStorage
                localStorage.setItem('searchValue', searchValue);
                // Filtra le righe della tabella basandosi sul valore di ricerca
                filterTable(searchValue);
            });
        });
        
        // SCRIPT DI ESPORTAZIONE EXCEL
        function exportToExcel() {
            const table = document.getElementById("myTable");
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Tabella");
            XLSX.writeFile(wb, "<?php echo substr($currentPage, 0, -4); ?>.xlsx");
        }
        </script>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
