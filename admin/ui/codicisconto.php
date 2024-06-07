<?php
require('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Discount Codes</title>
    <?php include '../materials/head_content.php'; ?>
</head>

<body style="background-color: #f1f1f1;">

    <?php
    $sidebar_cate = 'prodotti';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php';
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <!-- TABELLA CONTENUTI -->

        <?php echo listaCodicisconto(); ?>

        <!-- MESSAGGIO -->

        <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 999;"></div>

    </main>

    <!-- PROMETEUS -->

    <?php include "prometheus.php" ?>

    <script>
        // SCRIPT DI APERTURA MODIFICA 
        function apriModifica(idCodicesconto) {
            // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
            window.open('../ui-gestisci/codicesconto_modifica.php?id=' + idCodicesconto, 'ModificaCodicesconto', <?php echo $resolution; ?>);
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
            const searchInput = document.getElementById('searchInputCodicesconto');
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

        // FAI APPARIRE UN TOAST PER L'AGGIUNTA DEL PRODOTTO o ERRORE DI RICERCA-----------------------------------------------------------------------------------------------------------------------------------------------
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success');
            const warningMessage = urlParams.get('warning');

            if (successMessage) {
                displayToast('success', successMessage);
            }
            if (warningMessage) {
                displayToast('warning', warningMessage);
            }

            function displayToast(type, message) {
                const toastContainer = document.getElementById('toastContainer');
                const backgroundColor = type === 'success' ? 'bg-success' : 'bg-warning';
                const icon = type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'; // Aggiungi qui l'icona per warning se diversa

                const toastHTML = `
            <div class="toast show align-items-center text-white ${backgroundColor} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid ${icon}"></i> ${decodeURIComponent(message.replace(/\+/g, ' '))}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <br><br>
        `;
                toastContainer.innerHTML = toastHTML;
                const toastElement = toastContainer.querySelector('.toast');
                const toast = new bootstrap.Toast(toastElement);
                toast.show();

                toastElement.querySelector('.btn-close').addEventListener('click', function() {
                    urlParams.delete(type === 'success' ? 'success' : 'warning');
                    window.history.pushState({}, document.title, '?' + urlParams.toString());
                });
            }
        });
    </script>


    <?php include '../materials/script.php'; ?>
</body>

</html>