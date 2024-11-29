// Funzione per filtrare le righe della tabella
function filterTable(searchValue) {
  var tableRows = document.getElementById("myTable").getElementsByTagName("tr");
  for (var i = 1; i < tableRows.length; i++) {
    var currentRow = tableRows[i];
    var textContent = currentRow.textContent.toLowerCase();
    if (textContent.includes(searchValue)) {
      currentRow.style.display = "";
    } else {
      currentRow.style.display = "none";
    }
  }
}
// SCRIPT DI RICERCA
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInputCodicesconto");
  // Imposta il valore dell'input con il valore salvato nel localStorage
  const savedSearchValue = localStorage.getItem("searchValue") || "";
  searchInput.value = savedSearchValue;

  // Applica il filtro basato sul valore salvato non appena la pagina viene caricata
  filterTable(savedSearchValue);
  searchInput.addEventListener("keyup", function () {
    var searchValue = this.value.toLowerCase();
    // Salva il valore corrente nel localStorage
    localStorage.setItem("searchValue", searchValue);
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
//SCRIPT DI SELECT RIGHE
document.addEventListener("DOMContentLoaded", function () {
  const selectElement = document.getElementById("rowsPerPageCodiceSconto");

  function updateVisibleRows() {
    const selectedValue =
      selectElement.value === "Tutti"
        ? Number.MAX_SAFE_INTEGER
        : parseInt(selectElement.value, 10);
    const tableRows = document
      .getElementById("myTable")
      .getElementsByTagName("tbody")[0]
      .getElementsByTagName("tr");
    for (let i = 0; i < tableRows.length; i++) {
      tableRows[i].style.display = i < selectedValue ? "" : "none";
    }
  }

  // Recupera il valore dal Local Storage se disponibile
  if (localStorage.getItem("selectedrowsPerPageProdotti")) {
    selectElement.value = localStorage.getItem("selectedrowsPerPageProdotti");
  }

  // Applica il filtro basato sul valore selezionato al caricamento della pagina
  updateVisibleRows();

  // Applica il filtro e salva nel Local Storage ogni volta che l'utente cambia selezione
  selectElement.addEventListener("change", function () {
    updateVisibleRows();
    localStorage.setItem("selectedrowsPerPageProdotti", selectElement.value);
  });
});
// FAI APPARIRE UN TOAST PER L'AGGIUNTA DEL PRODOTTO o ERRORE DI RICERCA-----------------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const successMessage = urlParams.get("success");
  const warningMessage = urlParams.get("warning");

  if (successMessage) {
    displayToast("success", successMessage);
  }
  if (warningMessage) {
    displayToast("warning", warningMessage);
  }

  function displayToast(type, message) {
    const toastContainer = document.getElementById("toastContainer");
    const backgroundColor = type === "success" ? "bg-success" : "bg-warning";
    const icon =
      type === "success" ? "fa-circle-check" : "fa-triangle-exclamation"; // Aggiungi qui l'icona per warning se diversa

    const toastHTML = `
    <div class="toast show align-items-center text-white ${backgroundColor} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fa-solid ${icon}"></i> ${decodeURIComponent(
      message.replace(/\+/g, " ")
    )}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <br>
`;
    toastContainer.innerHTML = toastHTML;
    const toastElement = toastContainer.querySelector(".toast");
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    toastElement
      .querySelector(".btn-close")
      .addEventListener("click", function () {
        urlParams.delete(type === "success" ? "success" : "warning");
        window.history.pushState(
          {},
          document.title,
          "?" + urlParams.toString()
        );
      });
  }
});
