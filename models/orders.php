<?php
class OrdersModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Crea un nuovo ordine.
     *
     * @param int $user_id ID dell'utente che effettua l'ordine.
     * @param float $total_price Prezzo totale dell'ordine.
     * @param string $status Stato iniziale dell'ordine (default: 'pending').
     * @return int|false ID dell'ordine appena creato o false in caso di errore.
     */
    public function createOrder($user_id, $total_price, $status = 'pending') {
        $sql = "INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':total_price' => $total_price,
            ':status' => $status
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     * Recupera un ordine in base all'ID.
     *
     * @param int $order_id ID dell'ordine.
     * @return array|false Dettagli dell'ordine o false se non trovato.
     */
    public function getOrderById($order_id) {
        $sql = "SELECT * FROM orders WHERE id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    /**
     * Recupera tutti gli ordini.
     *
     * @return array Elenco di tutti gli ordini.
     */
    public function getAllOrders() {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera tutti gli ordini di un utente.
     *
     * @param int $user_id ID dell'utente.
     * @return array Elenco degli ordini effettuati dall'utente.
     */
    public function getOrdersByUserId($user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna lo stato di un ordine.
     *
     * @param int $order_id ID dell'ordine.
     * @param string $status Nuovo stato dell'ordine.
     * @return bool True se aggiornato con successo, false altrimenti.
     */
    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':order_id' => $order_id
        ]);
    }

    /**
     * Elimina un ordine e tutti i suoi elementi associati.
     *
     * @param int $order_id ID dell'ordine.
     * @return bool True se eliminato con successo, false altrimenti.
     */
    public function deleteOrder($order_id) {
        $sql = "DELETE FROM order_items WHERE order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);

        $sql = "DELETE FROM orders WHERE id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':order_id' => $order_id]);
    }
}
?>