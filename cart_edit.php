<script>
$(document).ready(function() {
    // Funzione per aggiornare il carrello nel front-end
    function updateCart() {
    $.ajax({
        url: 'cart_api.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("🛒 Dati ricevuti dal carrello:", response);

            if (!response || !response.items || !Array.isArray(response.items)) {
                console.error('⚠️ Errore: il carrello è vuoto o non è stato caricato correttamente.');
                $('#cart-items').html('<p class="text-muted text-center">Il carrello è vuoto.</p>');
                $('#cart-count').text(0).hide().fadeIn();
                return;
            }

            let cartHTML = '';
            let totalItems = response.total_items || 0;

            response.items.forEach(item => {
                cartHTML += `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <img src="${item.image}" width="40" height="40" class="me-2">
                        <div>
                            <small>${item.name}</small><br>
                            <small class="text-muted">€${item.price} x ${item.quantity}</small>
                        </div>
                        <button class="btn btn-sm btn-danger remove-item" data-id="${item.unique_id}">&times;</button>
                    </div>
                `;
            });

            $('#cart-items').html(cartHTML);
            $('#cart-count').text(totalItems).hide().fadeIn(); // Forza aggiornamento UI
        },
        error: function(xhr, status, error) {
            console.error('🚨 Errore nella richiesta AJAX:', error);
            $('#cart-items').html('<p class="text-muted text-center">Errore nel recupero del carrello.</p>');
            $('#cart-count').text(0);
        }
    });
}

    $(document).on('click', '.remove-item', function() {
    let uniqueId = $(this).data('id'); // Ora prende la chiave univoca corretta

    console.log("🗑️ Tentativo di rimozione dal carrello:", uniqueId);

    $.post('remove_from_cart.php', { id: uniqueId }, function(response) {
        console.log("🔄 Risposta rimozione:", response);

        if (response.success) {
            Swal.fire({
                icon: 'success',
                title: 'Rimosso!',
                text: response.message,
                timer: 2000
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Errore',
                text: response.message
            });
        }

        updateCart(); // Ricarica il carrello
    }, "json");
});

    // Aggiorna il carrello all'avvio
    updateCart();
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginSystem = document.getElementById('loginSystem');

        // Supponiamo che lo stato di autenticazione sia memorizzato in un cookie o in localStorage
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

        if (isLoggedIn) {
            loginSystem.innerHTML = '<a href="/dashboard.php" class="nav-link text-secondary">Dashboard</a>';
        } else {
            loginSystem.innerHTML = '<a href="/login" class="nav-link text-secondary">Login</a>';
        }
    });
</script>