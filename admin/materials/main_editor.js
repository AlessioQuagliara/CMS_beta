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