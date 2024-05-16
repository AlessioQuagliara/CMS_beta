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

// FAI APPARIRE UN TOAST PER L'AGGIUNTA DEL PRODOTTO

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success');
    
    if (successMessage) {
        const toastContainer = document.getElementById('toastContainer');
        const toastHTML = `
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-circle-check"></i> ${decodeURIComponent(successMessage.replace(/\+/g, ' '))}
                    </div>
                    <button id="closeToastButton" type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <br><br>
        `;
        toastContainer.innerHTML = toastHTML;
        const toastElement = toastContainer.querySelector('.toast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        document.getElementById('closeToastButton').addEventListener('click', function() {
            // Rimuovi il parametro 'success' dalla URL
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.pushState({}, document.title, url.toString());
        });
    }
});