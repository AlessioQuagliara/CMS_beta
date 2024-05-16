<?php if ($sidebar_cate == 'ordini') : ?>
    <!---------------------------------------------------------------------- PROMETHEUS ORDINI ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <style>
            .toolbar {
                position: fixed;
                bottom: 0;
                right: 0;
                /* Posizione iniziale a destra */
                width: 70%;
                /* Larghezza della toolbar */
                transform: translateX(100%);
                /* Nasconde la toolbar fuori dallo schermo */
                transition: transform 0.2s ease;
            }

            .toolbar.expanded {
                border-radius: 20px 0 0 0;
                transform: translateX(0);
                /* Mostra la toolbar */
            }

            .toggle-button {
                position: absolute;
                left: -140px;
                /* Posiziona il pulsante a sinistra della toolbar */
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

            .clickable-row {
                cursor: pointer;
            }

            .table-responsive {
                height: 795px;
                /* Altezza fissa per la tabella */
                overflow-y: auto;
            }

            .table thead th {
                position: sticky;
                top: 0;
                z-index: 2;
            }

            @media only screen and (max-width: 1440px) {
                .table-responsive {
                    height: 615px;
                    /* Altezza fissa per la tabella */
                    overflow-y: auto;
                }
            }
        </style>
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Ordine Manuale { CTRL + N }" onclick="addOrder()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-light" title="Seleziona Tutte le Righe { CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                    <button class="btn btn-sm btn-outline-primary" title="Evadi Selezionati { CTRL + M }" onclick=""><i class="fa-solid fa-boxes-packing"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
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
                var toolbar = document.getElementById('itembar');
                if (localStorage.getItem('toolbarExpanded') === 'true') {
                    toolbar.classList.add('expanded');
                }
            });
            // COMANDI SHORTCUT ------------------------------------------------------------------------------------------------------------------------------------------
            document.addEventListener('keydown', function(event) {
                if (event.key === 'q' && event.ctrlKey) {
                    toggleToolbar();
                }
                if (event.key === 'e' && event.ctrlKey) {
                    exportToExcel();
                }
                if (event.key === 'n' && event.ctrlKey) {
                    addOrder();
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
                if (event.key === 'r' && event.ctrlKey) {
                    refreshPage();
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addOrder() {
                window.location.href = '../ui-gestisci/aggiunta_ordine.php';
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>
<?php elseif ($sidebar_cate == 'prodotti') : ?>
    <!---------------------------------------------------------------------- PROMETHEUS PRODOTTI ------------------------------------------------------------------------------------------>

    <div id="itembar" class="toolbar bg-dark text-white">
        <style>
            .toolbar {
                position: fixed;
                bottom: 0;
                right: 0;
                width: 70%;
                transform: translateX(100%);
                transition: transform 0.2s ease;
            }

            .toolbar.expanded {
                border-radius: 20px 0 0 0;
                transform: translateX(0);
            }

            .toggle-button {
                position: absolute;
                left: -140px;
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

            .clickable-row {
                cursor: pointer;
            }

            .table-responsive {
                height: 795px;
                overflow-y: auto;
            }

            .table thead th {
                position: sticky;
                top: 0;
                z-index: 2;
            }

            @media only screen and (max-width: 1440px) {
                .table-responsive {
                    height: 615px;
                    overflow-y: auto;
                }
            }
        </style>
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + < }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputProdotti" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <a href="../ui-gestisci/aggiunta_prodotto.php" class="btn btn-sm btn-outline-danger" title="Aggiungi Prodotto { CTRL + N }" type="submit"><i class="fa-solid fa-plus"></i></a>
                    <!-- <button class="btn btn-sm btn-outline-danger" title="Aggiungi Prodotto { CTRL + N }" onclick="addOrder()"><i class="fa-solid fa-plus"></i></button> -->
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-light" title="Seleziona Tutte le Righe { CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                    <button class="btn btn-sm btn-outline-primary" title="Cancella Selezionati { CTRL + M }" onclick=""><i class="fa-solid fa-boxes-packing"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statoProdotto">
                        <option selected value="10">Stato Prodotto</option>
                        <option value="20">Online</option>
                        <option value="50">Offline</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="rowsPerPageProdotti">
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
                var toolbar = document.getElementById('itembar');
                if (localStorage.getItem('toolbarExpanded') === 'true') {
                    toolbar.classList.add('expanded');
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'q' && event.ctrlKey) {
                    toggleToolbar();
                }
                if (event.key === 'e' && event.ctrlKey) {
                    exportToExcel();
                }
                if (event.key === 'n' && event.ctrlKey) {
                    addOrder();
                }
                if (event.key === 'a' && event.ctrlKey) {
                    setSelectedTrueForAll();
                }
                if (event.key === 'f' && event.ctrlKey) {
                    var toolbar = document.getElementById('itembar');
                    if (toolbar.classList.contains('expanded')) {
                        document.getElementById('searchInputProdotti').focus();
                    } else {
                        toggleToolbar();
                        // Usare setTimeout per aspettare la fine dell'animazione di espansione
                        setTimeout(function() {
                            document.getElementById('searchInputProdotti').focus();
                        }, 200); // 200ms corrisponde alla durata della transizione CSS
                    }
                }
                if (event.key === 'r' && event.ctrlKey) {
                    refreshPage();
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function refreshPage() {
                location.reload(true);
            }

            function addOrder() {
                window.location.href = '../ui-gestisci/aggiunta_prodotto.php';
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>

<?php else : ?>


<?php endif; ?>