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
    $currentView = 'ordini';
    $currentViews = 'Ordini Inevasi';
    include '../materials/sidebar.php'; 
    ?>

<!---------------------------------------------------------------------- CONTENUTO PAGINA ------------------------------------------------------------------------------------------>
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
            left: -115px; /* Posiziona il pulsante a sinistra della toolbar */
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
        .clickable-row{
            cursor: pointer;
        }
    </style>
    <div class="toggle-button" title="Shortcut { CTRL + < }" onclick="toggleToolbar()">Strumenti <i class="fa-solid fa-pen"></i></div>
    <div class="toolbar-content">
        <div class="row">
            <div class="col-md-2">
                <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
            </div>
            <div class="col-md-6">
                <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                <button class="btn btn-sm btn-outline-light" title="Seleziona Tutte le Righe { CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                <form action="../ui-gestisci/aggiunta_ordine.php" method="POST" style="display: inline;">&nbsp;
                    <input type="hidden" name="action" value="addOrder"> <!-- Campo nascosto per controllare l'azione nel backend -->
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Aggiungi Ordine Manuale">
                        <i class="fa-solid fa-plus"></i>
                </form>
            </div>
            <div class="col-md-2">
                <select class="form-select" aria-label="Selezione">
                    <option selected><?php echo $currentViews; ?></option>
                    <option value="0">Ordini Inevasi</option>
                    <option value="1">Ordini da Spedire</option>
                    <option value="2">Ordini Evasi</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="rowsPerPage">
                    <option selected value="10">Mostra 10 Righe</option>
                    <option value="20">Mostra 20 Righe</option>
                    <option value="50">Mostra 50 Righe</option>
                    <option value="Tutti">Mostra Tutto</option>
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
            if (event.key === 'a' && event.ctrlKey) { 
                setSelectedTrueForAll();
            }
        });
        
        
        function toggleToolbar() {
            var toolbar = document.getElementById('itembar');
            toolbar.classList.toggle('expanded');
            // Salva lo stato della toolbar in localStorage
            localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
        }
    </script>
    </div>
<!---------------------------------------------------------------------- MAGIC ITEMS BAR ------------------------------------------------------------------------------------------>


<!---------------------------------------------------------------------- SCRIPT PAGINA ------------------------------------------------------------------------------------------>
    <script>
        // SCRIPT DI APERTURA MODIFICA ---------------------------------------------------------------------------------------------------------
        function apriModifica(idOrdine) {
            // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
            window.open('../ui-gestisci/ordine_modifica.php?id=' + idOrdine, 'ModificaOrdine', <?php echo $resolution;?>);
        }

        
        // Funzione per filtrare le righe della tabella ---------------------------------------------------------------------------------------------------------
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
        
        // SCRIPT DI RICERCA ---------------------------------------------------------------------------------------------------------
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
        
        // SCRIPT DI ESPORTAZIONE EXCEL ---------------------------------------------------------------------------------------------------------
        function exportToExcel() {
            const table = document.getElementById("myTable"); // La tua tabella originale
            const cloneTable = document.createElement("table"); // Creazione di una tabella temporanea
        
            // Clona le intestazioni della tabella
            cloneTable.appendChild(table.querySelector("thead").cloneNode(true));
            cloneTable.appendChild(document.createElement("tbody")); // Assicurati che ci sia un tbody nella tabella clonata
        
            // Filtra e clona solo le righe selezionate
            const rows = table.querySelectorAll("tbody tr");
            rows.forEach(row => {
                // Assicurati di ottenere correttamente il valore di data-stato
                let stato = row.querySelector(".clickable-row").getAttribute("data-stato");
                console.log("Stato:", stato); // Debug: stampa lo stato per verificare
                if (stato === 'true') {
                    cloneTable.querySelector("tbody").appendChild(row.cloneNode(true));
                }
            });
        
            // Controlla se ci sono righe da esportare
            if (cloneTable.querySelectorAll("tbody tr").length === 0) {
                alert("Nessuna riga selezionata per l'esportazione.");
                return;
            }
        
            // Continua con la creazione del foglio Excel
            const ws = XLSX.utils.table_to_sheet(cloneTable);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Tabella");
            XLSX.writeFile(wb, "<?php echo $currentView; ?>.xlsx");
        }



        // STOP PROPAGAZIONE SELECT ---------------------------------------------------------------------------------------------------------
        document.addEventListener('DOMContentLoaded', function() {
            var noClickElements = document.querySelectorAll('.no-click');
            
            noClickElements.forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });
        // SCRIPT CAMBIO PAGINA ---------------------------------------------------------------------------------------------------------
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('.form-select');
        
            selectElement.addEventListener('change', function() {
                const value = this.value;
                switch(value) {
                    case '0':
                        window.location.href = 'ordini_inevasi'; // Cambia con il tuo URL effettivo
                        break;
                    case '1':
                        window.location.href = 'ordini_spedire'; // Cambia con il tuo URL effettivo
                        break;
                    case '2':
                        window.location.href = 'ordini_completi'; // Cambia con il tuo URL effettivo
                        break;
                    default:
                        window.location.href = 'ordini_inevasi'; // Cambia con il tuo URL effettivo
                }
            });
        });
        
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
        
            // Recupera il valore dal Local Storage se disponibile
            if (localStorage.getItem('selectedRowsPerPage')) {
                selectElement.value = localStorage.getItem('selectedRowsPerPage');
            }
        
            // Applica il filtro basato sul valore selezionato al caricamento della pagina
            updateVisibleRows();
        
            // Applica il filtro e salva nel Local Storage ogni volta che l'utente cambia selezione
            selectElement.addEventListener('change', function() {
                updateVisibleRows();
                localStorage.setItem('selectedRowsPerPage', selectElement.value);
            });
        });
        </script>

<!---------------------------------------------------------------------- LINK SCRIPT PREDEFINITI ------------------------------------------------------------------------------------------>
<?php include '../materials/script.php'; ?>
<!---------------------------------------------------------------------- SCRIPT SELEZIONE RIGHE ------------------------------------------------------------------------------------------>
<script>
$(document).ready(function() {
    $('.clickable-row').click(function() {
        var $this = $(this);  // Cattura l'elemento cliccato
        var id = $this.data('id');
        var stato = $this.data('stato');
        var nuovoStato = (stato === 'true' ? 'false' : 'true');  // Cambia lo stato logicamente

        $.ajax({
            url: '../ui-gestisci/update_selezione_ordine.php',  // Percorso al tuo file PHP che gestisce l'update
            type: 'POST',
            data: {id: id, nuovoStato: nuovoStato},
            success: function(response) {
                $this.data('stato', nuovoStato);
                if (nuovoStato === 'true') {
                    $this.html('<i class="fa-solid fa-square-check fs-5"></i>');
                } else {
                    $this.html('<i class="fa-regular fa-square fs-5"></i>');
                }
            },
            error: function() {
                alert('Errore nella selezione della riga.');
            }
        });
    });
});
function setSelectedTrueForAll() {
    $.ajax({
        url: '../ui-gestisci/update_selezioni_ordine.php', 
        type: 'POST',
        data: {action: 'toggleAllSelected'},
        success: function(response) {
            location.reload();  // Ricarica la pagina per riflettere le modifiche
        },
        error: function() {
            alert('Errore');
        }
    });
}

</script>

</body>
</html>
