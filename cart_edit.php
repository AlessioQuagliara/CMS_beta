<script>
$(document).ready(function() {
    // Aggiorna il prezzo del prodotto quando viene selezionato un periodo
    $('#tipo_periodo').change(function() {
        let selectedOption = $(this).find(':selected');
        let price = selectedOption.data('price') || 0; // Prende il prezzo associato o 0 se non esiste
        $('#product_price').val(price);
        console.log("Prezzo aggiornato:", price);
    });

    // Gestisce l'invio del modulo per aggiungere al carrello
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();

        let tipoPeriodo = $('#tipo_periodo').val();
        let slotSelezionato = $('input[name="slot"]:checked').val();
        let spotSelezionato = $('input[name="spot"]:checked').val();
        let product_id = $('input[name="product_id"]').val();
        let product_name = $('input[name="product_name"]').val();
        let product_price = $('#product_price').val();
        let product_image = $('input[name="product_image"]').val();

        // Verifica che tutti i dati obbligatori siano presenti
        if (!tipoPeriodo || !slotSelezionato || !spotSelezionato || !product_id || !product_name || !product_price) {
            Swal.fire({
                icon: 'error',
                title: 'Errore',
                text: 'Seleziona un periodo, uno slot e uno spot prima di aggiungere al carrello.',
            });
            return;
        }

        console.log("🔼 Invio dati al carrello:", { 
            product_id, product_name, product_price, product_image, tipoPeriodo, slotSelezionato, spotSelezionato 
        });

        // Invia i dati al backend
        $.ajax({
            url: window.location.href,
            method: 'POST',
            dataType: 'json',
            data: {
                add_to_cart: true,
                product_id: product_id,
                product_name: product_name,
                product_price: product_price,
                product_image: product_image,
                tipo_periodo: tipoPeriodo,
                slot: slotSelezionato,
                spot: spotSelezionato
            },
            success: function(response) {
                console.log("✅ Risposta ricevuta:", response);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Aggiunto!',
                        text: response.message,
                        timer: 2000
                    });
                    updateCart(); // Aggiorna il carrello dopo l'aggiunta
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Errore',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('🚨 Errore AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Errore',
                    text: 'Si è verificato un problema con l\'aggiunta al carrello. Riprova.'
                });
            }
        });
    });

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