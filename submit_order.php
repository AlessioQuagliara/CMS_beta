<?php
// Attiva la segnalazione degli errori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "config.php"; // Assicura che $pdo sia correttamente definito
require_once 'models/orders.php';
require_once 'models/order_items.php';

$ordersModel = new OrdersModel($pdo);
$orderItemsModel = new OrderItemsModel($pdo);

try {
    // Verifica che il carrello non sia vuoto
    if (empty($_SESSION['cart'])) {
        throw new Exception("Il carrello è vuoto.");
    }

    // Controlla se l'utente è loggato, altrimenti reindirizza
    if (!isset($_SESSION['user'])) {
        throw new Exception("Devi effettuare il login per completare l'ordine.");
    }

    $user = $_SESSION['user'];
    $user_id = $user['id'];
    $total_price = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    // Avvia una transazione
    $pdo->beginTransaction();

    // Crea l'ordine
    $order_id = $ordersModel->createOrder($user_id, $total_price, 'pending');
    if (!$order_id) {
        throw new Exception("Errore durante la creazione dell'ordine.");
    }

    // Aggiungi i prodotti all'ordine
    foreach ($_SESSION['cart'] as $item) {
        $result = $orderItemsModel->addItemToOrder(
            $order_id,
            $item['id'],
            $item['tipo_periodo'],
            $item['valore_periodo'],
            $item['slot'],
            $item['spot'],
            $item['price']
        );

        if (!$result) {
            throw new Exception("Errore durante l'inserimento degli articoli dell'ordine.");
        }
    }

    // Conferma la transazione
    $pdo->commit();

    // Svuota il carrello
    $_SESSION['cart'] = [];

    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Ordine inviato con successo!'
    ]);
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log("❌ Errore durante l'invio dell'ordine: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}