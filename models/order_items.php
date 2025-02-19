<?php
class OrderItemsModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Aggiunge un prodotto a un ordine.
     *
     * @param int $order_id ID dell'ordine.
     * @param int $product_id ID del prodotto selezionato.
     * @param string|null $tipo_periodo Tipo di periodo (giornaliero, settimanale, mensile).
     * @param int|null $valore_periodo Valore del periodo (es. 3 giorni, 2 settimane).
     * @param string|null $slot Slot orario (formato HH:MM).
     * @param int|null $spot Posizione dello spot.
     * @param float $price Prezzo del prodotto selezionato.
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function addItemToOrder($order_id, $product_id, $tipo_periodo, $valore_periodo, $slot, $spot, $price) {
        $sql = "INSERT INTO order_items 
                (order_id, product_id, tipo_periodo, valore_periodo, slot, spot, price) 
                VALUES 
                (:order_id, :product_id, :tipo_periodo, :valore_periodo, :slot, :spot, :price)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':tipo_periodo' => $tipo_periodo,
            ':valore_periodo' => $valore_periodo,
            ':slot' => $slot,
            ':spot' => $spot,
            ':price' => $price
        ]);
    }

    /**
     * Recupera tutti gli elementi di un ordine.
     *
     * @param int $order_id ID dell'ordine.
     * @return array Elenco degli elementi nell'ordine.
     */
    public function getItemsByOrderId($order_id) {
        $sql = "SELECT * FROM order_items WHERE order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un elemento dall'ordine.
     *
     * @param int $item_id ID dell'elemento dell'ordine.
     * @return bool True se eliminato con successo, false altrimenti.
     */
    public function deleteItem($item_id) {
        $sql = "DELETE FROM order_items WHERE id = :item_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':item_id' => $item_id]);
    }

    /**
     * Elimina tutti gli elementi di un ordine specifico.
     *
     * @param int $order_id ID dell'ordine.
     * @return bool True se eliminati con successo, false altrimenti.
     */
    public function deleteItemsByOrderId($order_id) {
        $sql = "DELETE FROM order_items WHERE order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':order_id' => $order_id]);
    }
}
?>