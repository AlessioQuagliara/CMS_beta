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
            left: -125px; /* Posiziona il pulsante a sinistra della toolbar */
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
        .table-responsive {
            height: 795px; /* Altezza fissa per la tabella */
            overflow-y: auto;
        }
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
        }
        @media only screen and (max-width: 1440px) {
            .table-responsive {
            height: 615px; /* Altezza fissa per la tabella */
            overflow-y: auto;
        }
        }
    </style>
    <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + < }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
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
                    <option value="1">Ordini Spediti</option>
                    <option value="2">Ordini Evasi</option>
                    <option value="3">Abbandonati</option>
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
            if (event.key === 'f' && event.ctrlKey) { 
                var toolbar = document.getElementById('itembar');
                if (toolbar.classList.contains('expanded')) {
                    document.getElementById('searchInput').focus();
                } else {
                    toggleToolbar();
                    // Usare setTimeout per aspettare la fine dell'animazione di espansione
                    setTimeout(function() {
                        document.getElementById('searchInput').focus();
                    }, 200); // 200ms corrisponde alla durata della transizione CSS
                }
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