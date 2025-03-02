// =====================================================
// ✅ GESTIONE DEL PREZZO DEL PRODOTTO
// =====================================================
document.addEventListener("DOMContentLoaded", function () {
    const tipoPeriodoSelect = document.getElementById("tipo_periodo");
    const slotSelect = document.querySelector("select[name='slot']");
    const spotSelect = document.querySelector("select[name='spot']");
    const productPriceInput = document.getElementById("product_price");

    // Crea un elemento per mostrare il prezzo totale
    const priceDisplay = document.createElement("h5");
    priceDisplay.classList.add("text-center", "mt-3");

    // Posiziona l'elemento del prezzo nella card del prodotto
    let container = slotSelect.closest(".card-body");
    if (container) {
        container.appendChild(priceDisplay);
    }

    function getOptionPrice(selectElement) {
        let selectedOption = selectElement.selectedOptions[0];
        return selectedOption ? parseFloat(selectedOption.getAttribute("data-price")) || 0 : 0;
    }

    function aggiornaPrezzo() {
        let periodoPrice = getOptionPrice(tipoPeriodoSelect);
        let slotPrice = getOptionPrice(slotSelect);
        let spotPrice = getOptionPrice(spotSelect);

        // ✅ Somma tutti i valori selezionati
        let totalPrice = periodoPrice + slotPrice + spotPrice;

        // Aggiorna il valore del form e la UI
        productPriceInput.value = totalPrice.toFixed(2);
        priceDisplay.innerHTML = `<strong>Prezzo Totale: €${totalPrice.toFixed(2)}</strong>`;

        console.log("📊 Prezzo aggiornato:", totalPrice);
    }

    // Assegna gli eventi per aggiornare il prezzo in tempo reale
    tipoPeriodoSelect.addEventListener("change", aggiornaPrezzo);
    slotSelect.addEventListener("change", aggiornaPrezzo);
    spotSelect.addEventListener("change", aggiornaPrezzo);

    // Calcola il prezzo iniziale al caricamento della pagina
    aggiornaPrezzo();
});

// =====================================================
// ✅ GESTIONE DEL CARRELLO E INVIO ORDINE
// =====================================================
$(document).ready(function () {
    // Gestisce l'invio del modulo per aggiungere il prodotto al carrello
    $('#add-to-cart-form').on('submit', function (e) {
        e.preventDefault();

        let tipoPeriodo = $('#tipo_periodo').val();
        let slotSelezionato = $('select[name="slot"]').val();
        let spotSelezionato = $('select[name="spot"]').val();
        let product_id = $('input[name="product_id"]').val();
        let product_name = $('input[name="product_name"]').val();
        let product_price = $('#product_price').val();
        let product_image = $('input[name="product_image"]').val();

        // Controllo di validità prima di aggiungere al carrello
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

        // Invia i dati al backend tramite AJAX
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
            success: function (response) {
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
            error: function (xhr, status, error) {
                console.error('🚨 Errore AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Errore',
                    text: 'Si è verificato un problema con l\'aggiunta al carrello. Riprova.'
                });
            }
        });
    });

    // =====================================================
    // ✅ FUNZIONE PER AGGIORNARE IL CARRELLO
    // =====================================================
    function updateCart() {
        $.ajax({
            url: 'cart_api.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log("🛒 Dati ricevuti dal carrello:", response);

                if (!response || !response.items || !Array.isArray(response.items)) {
                    console.error('⚠️ Il carrello è vuoto o non è stato caricato correttamente.');
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
            error: function (xhr, status, error) {
                console.error('🚨 Errore nella richiesta AJAX:', error);
                $('#cart-items').html('<p class="text-muted text-center">Errore nel recupero del carrello.</p>');
                $('#cart-count').text(0);
            }
        });
    }

    // =====================================================
    // ✅ RIMOZIONE PRODOTTI DAL CARRELLO
    // =====================================================
    $(document).on('click', '.remove-item', function () {
        let uniqueId = $(this).data('id'); // Chiave univoca del prodotto

        console.log("🗑️ Tentativo di rimozione dal carrello:", uniqueId);

        $.post('remove_from_cart.php', { id: uniqueId }, function (response) {
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