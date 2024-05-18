 //SCRIPT DI SELECT PAGINE Prodotto
 document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('rowsPerPageProdotti');

    function updateVisibleRows() {
        const selectedValue = selectElement.value === 'Tutti' ? Number.MAX_SAFE_INTEGER : parseInt(selectElement.value, 10);
        const tableRows = document.getElementById('myTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        for (let i = 0; i < tableRows.length; i++) {
            tableRows[i].style.display = i < selectedValue ? '' : 'none';
        }
    }

    // Recupera il valore dal Local Storage se disponibile
    if (localStorage.getItem('selectedrowsPerPageProdotti')) {
        selectElement.value = localStorage.getItem('selectedrowsPerPageProdotti');
    }

    // Applica il filtro basato sul valore selezionato al caricamento della pagina
    updateVisibleRows();

    // Applica il filtro e salva nel Local Storage ogni volta che l'utente cambia selezione
    selectElement.addEventListener('change', function() {
        updateVisibleRows();
        localStorage.setItem('selectedrowsPerPageProdotti', selectElement.value);
    });
});

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


  // SCRIPT DI APERTURA MODIFICA
  function apriModifica(idProdotto) {
    // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
    window.open('../ui-gestisci/prodotto_modifica.php?id=' + idProdotto, 'ModificaProdotto', 'width=1920,height=1080');
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
    const searchInput = document.getElementById('searchInputProdotti');
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

// SCRIPT DI ESPORTAZIONE EXCEL ----------------------------------------------------------------------------------------------------------------------------------------------------------------
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
    XLSX.writeFile(wb, 'Prodotti' + ".xlsx");
}

//SCRIPT DI SELECT PAGINE
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('rowsPerPageProdotti');

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

// SCRIPT SELEZIONE RIGHE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$(document).ready(function() {
    $('.clickable-row').click(function() {
        var $this = $(this);  // Cattura l'elemento cliccato
        var id = $this.data('id');
        var stato = $this.data('stato');
        var nuovoStato = (stato === 'true' ? 'false' : 'true');  // Cambia lo stato logicamente

        $.ajax({
            url: '../ui-gestisci/update_selezione_prodotto.php',  // Percorso al tuo file PHP che gestisce l'update
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
        url: '../ui-gestisci/update_selezioni_prodotti.php', 
        type: 'POST',
        data: {
            action: 'toggleAllSelected',
        },
        success: function(response) {
            location.reload();  // Ricarica la pagina per riflettere le modifiche
        },
        error: function() {
            alert('Errore');
        }
    });
}