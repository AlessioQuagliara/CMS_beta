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
<?php if ($sidebar_cate == 'ordini') : ?>
    <!---------------------------------------------------------------------- PROMETHEUS ORDINI ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { WIN = CTRL + Y | MAC = CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Ordine { WIN = CTRL + I | MAC = CTRL + N }" onclick="addOrder()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta come Tabella { WIN = CTRL + U | MAC = CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-light" title="Seleziona Tutto { WIN = CTRL + U | MAC = CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                    <button class="btn btn-sm btn-outline-primary" title="Evadi Selezionati { WIN = CTRL + O | MAC = CTRL + D }" onclick="evadiSelezionati()"><i class="fa-solid fa-boxes-packing"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna la pagina { WIN = CTRL + K | MAC = CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
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
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addOrder();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        evadiSelezionati();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
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
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addOrder();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        evadiSelezionati();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
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
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addOrder() {
                window.location.href = '../ui-gestisci/aggiunta_ordine.php';
            }

            function evadiSelezionati() {
                swal({
                        title: "Vuoi Evadere tutti gli ordini selezionati?",
                        text: "Verranno evasi tutti gli ordini selezionati, l'azione è reversibile manualmente",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/evadi_ordini_selezionati';
                        }
                    });
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>
<?php elseif ($currentPage == 'prodotti.php') : ?>
    <!---------------------------------------------------------------------- PROMETHEUS PRODOTTI ------------------------------------------------------------------------------------------>

    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputProdotti" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Prodotto { CTRL + N }" onclick="addProduct()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-light" title="Seleziona Tutte le Righe { CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                    <button class="btn btn-sm btn-outline-danger" title="Cancella Selezionati { CTRL + D }" onclick="deleteProduct()"><i class="fa-solid fa-trash"></i></button>
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

            // COMANDI SHORTCUT ------------------------------------------------------------------------------------------------------------------------------------------
            document.addEventListener('keydown', function(event) {
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addProduct();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteProduct('');
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
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
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addProduct();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteProduct('');
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
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
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addProduct() {
                window.location.href = '../ui-gestisci/aggiunta_prodotto.php';
            }

            function deleteProduct() {
                swal({
                        title: "Cancellare i Prodotti Selezionati?",
                        text: "Verranno cancellati tutti i prodotti che hai selezionato, l'azione è irreversibile.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/cancella_prodotti_selezionati';
                        }
                    });
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>

<?php elseif ($currentPage == 'collezioni.php') : ?>
    <!---------------------------------------------------------------------- PROMETHEUS COLLEZIONI ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputCollezioni" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Collezione { CTRL + N }" onclick="addCollect()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-light" title="Seleziona Tutte le Righe { CTRL + A }" onclick="setSelectedTrueForAll()"><i class="fa-regular fa-square-check"></i></button>
                    <button class="btn btn-sm btn-outline-danger" title="Cancella Selezionati { CTRL + D }" onclick="deleteCollect()"><i class="fa-solid fa-trash"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="rowsPerPageCollezioni">
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
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addCollect();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'r' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addCollect();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addCollect() {
                window.location.href = '../ui-gestisci/aggiunta_collezione.php';
            }

            function deleteCollect() {
                swal({
                        title: "Cancellare le collezioni Selezionate?",
                        text: "Verranno cancellate tutte le collezioni e le rispettive categorie, l'azione è irreversibile.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/cancella_collezioni_selezionate';
                        }
                    });
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>
<?php elseif ($currentPage == 'codicisconto.php') : ?>

    <!---------------------------------------------------------------------- PROMETHEUS CODICISCONTO ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputCodicesconto" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Collezione { CTRL + N }" onclick="addCollect()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="rowsPerPageCodiceSconto">
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
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addCollect();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'r' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addCollect();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addCollect() {
                window.location.href = '../ui-gestisci/aggiunta_codicesconto.php';
            }

            function deleteCollect() {
                swal({
                        title: "Cancellare le collezioni Selezionate?",
                        text: "Verranno cancellate tutte le collezioni e le rispettive categorie, l'azione è irreversibile.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/cancella_collezioni_selezionate';
                        }
                    });
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>



<?php elseif ($currentPage == 'clienti.php') : ?>

    <!---------------------------------------------------------------------- PROMETHEUS CLIENTI ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputClienti" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger" title="Aggiungi Cliente { CTRL + N }" onclick="addClient()"><i class="fa-solid fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="rowsPerPageClienti">
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
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addClient();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'r' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addClient();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addClient() {
                window.location.href = '../ui-gestisci/aggiunta_cliente.php';
            }

            function deleteCollect() {
                swal({
                        title: "Cancellare le collezioni Selezionate?",
                        text: "Verranno cancellate tutte le collezioni e le rispettive categorie, l'azione è irreversibile.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/cancella_collezioni_selezionate';
                        }
                    });
            }

            function toggleToolbar() {
                var toolbar = document.getElementById('itembar');
                toolbar.classList.toggle('expanded');
                // Salva lo stato della toolbar in localStorage
                localStorage.setItem('toolbarExpanded', toolbar.classList.contains('expanded'));
            }
        </script>
    </div>

<?php elseif ($currentPage == 'leads.php') : ?>

    <!---------------------------------------------------------------------- PROMETHEUS LEADS ------------------------------------------------------------------------------------------>
    <div id="itembar" class="toolbar bg-dark text-white">
        <div class="toggle-button btn-outline-danger" title="Shortcut { CTRL + Q }" onclick="toggleToolbar()">Prometheus <i class="fa-solid fa-fire-flame-curved"></i></div>
        <div class="toolbar-content">
            <div class="row">
                <div class="col-md-2">
                    <input class="form-control" id="searchInputLeads" type="text" placeholder="Cerca..." aria-label="Cerca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-success" title="Esporta in Excel { CTRL + E }" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" title="Aggiorna pagina { CTRL + R }" onclick="refreshPage()"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <button class="btn btn-sm btn-outline-info" title="Tutorial & Istruzioni" onclick=""><i class="fa-solid fa-circle-info"></i></button>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="rowsPerPageLeads">
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
                var isWindows = navigator.platform.toUpperCase().indexOf('WIN') !== -1;

                // Scorciatoie per sistemi non Windows
                if (!isWindows) {
                    if (event.key === 'q' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'e' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'n' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addClient();
                    }
                    if (event.key === 'a' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'd' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'f' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'r' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
                // Scorciatoie per Windows
                else {
                    if (event.key === 'y' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        toggleToolbar();
                    }
                    if (event.key === 'u' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        exportToExcel();
                    }
                    if (event.key === 'i' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        addClient();
                    }
                    if (event.key === 'o' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        setSelectedTrueForAll();
                    }
                    if (event.key === 'p' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        deleteCollect('');
                    }
                    if (event.key === 'l' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        var toolbar = document.getElementById('itembar');
                        if (toolbar.classList.contains('expanded')) {
                            document.getElementById('searchInputCollezioni').focus();
                        } else {
                            toggleToolbar();
                            // Usare setTimeout per aspettare la fine dell'animazione di espansione
                            setTimeout(function() {
                                document.getElementById('searchInputCollezioni').focus();
                            }, 200); // 200ms corrisponde alla durata della transizione CSS
                        }
                    }
                    if (event.key === 'k' && event.ctrlKey) {
                        event.preventDefault(); // Previene il comportamento predefinito
                        refreshPage();
                    }
                }
            });

            function refreshPage() {
                location.reload(true);
            }

            function addClient() {
                window.location.href = '../ui-gestisci/aggiunta_cliente.php';
            }

            function deleteCollect() {
                swal({
                        title: "Cancellare le collezioni Selezionate?",
                        text: "Verranno cancellate tutte le collezioni e le rispettive categorie, l'azione è irreversibile.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = '../ui-gestisci/cancella_collezioni_selezionate';
                        }
                    });
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