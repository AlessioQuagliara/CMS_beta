<?php
session_start();

// Inizializza il carrello se non esiste
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Aggiunge un prodotto al carrello con i dettagli selezionati.
 *
 * @param int    $product_id    ID del prodotto.
 * @param string $nome          Nome del prodotto.
 * @param float  $price         Prezzo del prodotto.
 * @param string $image         Immagine del prodotto.
 * @param string $tipo_periodo  Tipo di periodo selezionato.
 * @param string $slot          Slot selezionato.
 * @param string $spot          Spot selezionato.
 */
function addToCart($product_id, $nome, $price, $image, $tipo_periodo, $slot, $spot) {
    session_start();

    if (!empty($tipo_periodo)) {
        $timestamp = strtotime($tipo_periodo);
        if ($timestamp !== false) {
            setlocale(LC_TIME, 'it_IT.UTF-8');
            $tipo_periodo_esteso = strftime("%A %d %B %Y", $timestamp);
        } else {
            $tipo_periodo_esteso = "Data non valida";
        }
    } else {
        $tipo_periodo_esteso = "Nessun periodo";
    }

    $unique_id = md5($product_id . $tipo_periodo . $slot . $spot);

    if (isset($_SESSION['cart'][$unique_id])) {
        $_SESSION['cart'][$unique_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$unique_id] = [
            'id' => $product_id,
            'name' => $nome,
            'price' => $price,
            'image' => $image,
            'tipo_periodo' => $tipo_periodo_esteso, // Ora garantiamo che sia sempre una stringa
            'slot' => $slot,
            'spot' => $spot,
            'quantity' => 1
        ];
    }

    error_log("✅ Aggiunto al carrello: " . print_r($_SESSION['cart'][$unique_id], true));
}

// Funzione per ottenere il carrello
function getCartItems() {
    return array_values($_SESSION['cart']); // Convertiamo in array senza chiavi personalizzate
}

// Funzione per rimuovere un prodotto dal carrello
function removeCartItem($unique_id) {
    if (isset($_SESSION['cart'][$unique_id])) {
        unset($_SESSION['cart'][$unique_id]);
    }
}

// Funzione per svuotare il carrello
function clearCart() {
    $_SESSION['cart'] = [];
}
?>