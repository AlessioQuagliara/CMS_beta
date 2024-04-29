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
    <title>LinkBay - Prodotti</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'prodotti'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- BARRA STRUMENTI -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="input-group">
            <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i>&nbsp; Esporta Tabella</button>&nbsp;
            <form action="../ui-gestisci/aggiunta_prodotto.php" method="POST" style="display: inline;">&nbsp;
                <input type="hidden" name="action" value="addProduct"> <!-- Campo nascosto per controllare l'azione nel backend -->
                <button type="submit" class="btn btn-sm btn-outline-dark">
                    <i class="fa-solid fa-plus"></i>&nbsp; Aggiungi Prodotto
                </button>
            </form>
        </div>
    </div>
        <!-- SELECT PER PAGINE-->

        <div class="row mb-3">
        <div class="col-auto">
            <label for="rowsPerPage" class="col-form-label">Righe per pagina:</label>
        </div>
        <div class="col-auto">
            <select class="form-select" id="rowsPerPage">
                <option selected value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="Tutti">Tutti</option>
            </select>
        </div>
    </div>
    <!-- TABELLA CONTENUTI -->

    <?php echo listaProdotti(); ?>
    
    <!-- MESSAGGIO -->

    <?php 
    $feedback = isset($_GET['success']) ? $_GET['success'] : '';
    if(!empty($feedback)): ?>
        <div id="successAlert" class="alert alert-success fade show" role="alert">
            <?php echo htmlspecialchars($feedback); ?>
        </div>
    <?php endif; ?>


    </main>

    <script>
        // SCRIPT DI APERTURA MODIFICA
        function apriModifica(idProdotto) {
            // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
            window.open('../ui-gestisci/prodotto_modifica.php?id=' + idProdotto, 'ModificaProdotto', <?php echo $resolution;?>);
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

        //SCRIPT DI SELECT PAGINE
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('rowsPerPage');
        
            function updateVisibleRows() {
                const selectedValue = selectElement.value === 'Tutti' ? Number.MAX_SAFE_INTEGER : parseInt(selectElement.value, 10);
                const tableRows = document.getElementById('myTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (let i = 0; i < tableRows.length; i++) {
                    tableRows[i].style.display = i < selectedValue ? '' : 'none';
                }
            }
        
            // Applica il filtro basato sul valore selezionato al caricamento della pagina
            updateVisibleRows();
        
            // Applica il filtro ogni volta che l'utente cambia selezione
            selectElement.addEventListener('change', updateVisibleRows);
        });
        </script>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
