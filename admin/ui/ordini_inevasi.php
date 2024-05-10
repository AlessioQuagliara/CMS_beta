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
    <title>LinkBay - Ordini Inevasi</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'ordini'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    
    <!-- TABELLA CONTENUTI -->
        <?php echo stampaTabellaOrdiniInevasi(); ?>
    </main>

<!---------------------------------------------------------------------- MAGIC ITEMS BAR ------------------------------------------------------------------------------------------>
<div id="itembar" class="toolbar bg-dark text-white">
    <style>
        .toolbar {
            position: fixed;
            bottom: 0;
            right: 0; /* Posizione iniziale a destra */
            width: 75%; /* Larghezza della toolbar */
            transform: translateX(100%); /* Nasconde la toolbar fuori dallo schermo */
            transition: transform 0.2s ease;
        }
        
        .toolbar.expanded {
            border-radius: 20px 0 0 0;
            transform: translateX(0); /* Mostra la toolbar */
        }
        
        .toggle-button {
            position: absolute;
            left: -160px; /* Posiziona il pulsante a sinistra della toolbar */
            top: 10px;
            cursor: pointer;
            padding: 8px 15px;
            background: #ff5758;
            color: black;
            border-radius: 4px;
        }
        
        .toolbar-content {
            padding: 10px;
        }
    </style>
    <div class="toggle-button" onclick="toggleToolbar()">Strumenti{ctrl+<}<i class="fa-solid fa-pen"></i></div>
    <div class="toolbar-content">
        <div class="row">
            <div class="col-md-2">
                <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-outline-success" title="Esporta in Excel" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                <form action="../ui-gestisci/aggiunta_ordine.php" method="POST" style="display: inline;">&nbsp;
                    <input type="hidden" name="action" value="addOrder"> <!-- Campo nascosto per controllare l'azione nel backend -->
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Aggiungi Ordine Manuale">
                        <i class="fa-solid fa-plus"></i>
                </form>
            </div>
            <div class="col-md-2">
                <select class="form-select" aria-label="Selezione">
                    <option selected>Ordini Inevasi</option>
                    <option value="1">Ordini da Spedire</option>
                    <option value="2">Ordini Evasi</option>
                </select>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verifica lo stato salvato al caricamento della pagina e aggiorna la toolbar di conseguenza
            var toolbar = document.getElementById('itembar');
            if (localStorage.getItem('toolbarExpanded') === 'true') {
                toolbar.classList.add('expanded');
            }
        });
        
        document.addEventListener('keydown', function(event) {
            if (event.key === '<' && event.ctrlKey) {
                toggleToolbar();
            }
            if (event.key === 'e' && event.ctrlKey) {
                exportToExcel();
            }
        });
        
        function toggleToolbar() {
            var toolbar = document.getElementById('itembar');
            toolbar.classList.toggle('expanded');
            // Salva lo stato della toolbar in localStorage
            localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
        }
        
        function exportToExcel() {
            // Implementa la logica per esportare i dati in Excel
            console.log('Exporting to Excel');
        }
    </script>
    </div>
<!---------------------------------------------------------------------- MAGIC ITEMS BAR ------------------------------------------------------------------------------------------>


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
        // STOP PROPAGAZIONE SELECT
        document.addEventListener('DOMContentLoaded', function() {
            var noClickElements = document.querySelectorAll('.no-click');
            
            noClickElements.forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });

        // SELECT SCRIPT
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const stato = this.getAttribute('data-stato') === 'false' ? 'true' : 'false'; // Cambia lo stato
                    const data = { id: id, stato: stato }; // Crea un oggetto con i dati da inviare
                    
                    // Esegui una richiesta fetch per inviare i dati al server
                    fetch('../ui-gestisci/update_selezione_ordine.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        if (data.success) {
                            window.location.reload(); // Ricarica la pagina per mostrare gli aggiornamenti
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                });
            });
        });
        </script>


    
<?php include '../materials/script.php'; ?>
</body>
</html>
