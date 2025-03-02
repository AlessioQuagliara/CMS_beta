<?php
class ProdottiPubblicitariModel {
    /**
     * @var PDO
     */
    private $pdo;

    // Iniettiamo la connessione PDO nel costruttore
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Crea un nuovo prodotto pubblicitario.
     *
     * @param array $data I dati del prodotto (es. nome, slug, description, ecc.)
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function createProduct(array $data) {
        $sql = "INSERT INTO prodotti_pubblicitari (
                    nome, slug, description, mezzo_pubblicitario, dimensione, concessionaria,
                    genere, eta
                ) VALUES (
                    :nome, :slug, :description, :mezzo_pubblicitario, :dimensione, :concessionaria,
                    :genere, :eta
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome'               => $data['nome'],
            ':slug'               => $data['slug'],
            ':description'        => $data['description'] ?? null,
            ':mezzo_pubblicitario'=> $data['mezzo_pubblicitario'],
            ':dimensione'         => $data['dimensione'],
            ':concessionaria'     => $data['concessionaria'],
            ':genere'             => $data['genere'],
            ':eta'                => $data['eta']
        ]);
    }

    /**
     * Recupera tutti i prodotti pubblicitari.
     *
     * @return array L'elenco dei prodotti.
     */
    public function getAllProducts() {
        $sql = "SELECT * FROM prodotti_pubblicitari ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera un prodotto in base all'ID.
     *
     * @param int $id L'ID del prodotto.
     * @return array|false Il prodotto come array associativo, oppure false se non trovato.
     */
    public function getProductById(int $id) {
        $sql = "SELECT * FROM prodotti_pubblicitari WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera un prodotto in base allo slug.
     *
     * @param string $slug Lo slug del prodotto.
     * @return array|false Il prodotto come array associativo, oppure false se non trovato.
     */
    public function getProductBySlug(string $slug) {
        $sql = "SELECT * FROM prodotti_pubblicitari WHERE slug = :slug LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna un prodotto esistente.
     *
     * @param int   $id   L'ID del prodotto da aggiornare.
     * @param array $data I nuovi dati del prodotto.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updateProduct(int $id, array $data) {
        $sql = "UPDATE prodotti_pubblicitari SET
                    nome = :nome,
                    slug = :slug,
                    description = :description,
                    mezzo_pubblicitario = :mezzo_pubblicitario,
                    dimensione = :dimensione,
                    concessionaria = :concessionaria,
                    genere = :genere,
                    eta = :eta,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome'               => $data['nome'],
            ':slug'               => $data['slug'],
            ':description'        => $data['description'] ?? null,
            ':mezzo_pubblicitario'=> $data['mezzo_pubblicitario'],
            ':dimensione'         => $data['dimensione'],
            ':concessionaria'     => $data['concessionaria'],
            ':genere'             => $data['genere'],
            ':eta'                => $data['eta'],
            ':id'                 => $id
        ]);
    }

    /**
     * Elimina un prodotto in base all'ID.
     *
     * @param int $id L'ID del prodotto da eliminare.
     * @return bool True se l'eliminazione è andata a buon fine, false altrimenti.
     */
    public function deleteProduct(int $id) {
        $sql = "DELETE FROM prodotti_pubblicitari WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}





class ProductImagesModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addImageToProduct($product_id, $image_url) {
        $sql = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':product_id' => $product_id,
            ':image_url' => $image_url
        ]);
    }

    public function getImagesByProductId($product_id) {
        $sql = "SELECT * FROM product_images WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImageById($image_id) {
        $sql = "SELECT * FROM product_images WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $image_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteImage($image_id) {
        $sql = "DELETE FROM product_images WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $image_id]);
    }
}




class ProductSpotModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Aggiunge uno spot a un prodotto con valore associato.
     *
     * @param int $product_id L'ID del prodotto a cui associare lo spot.
     * @param string $spot Il valore dello spot.
     * @param string|null $valore_spot Il valore dello spot opzionale.
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function addSpotToProduct($product_id, $spot, $valore_spot = null) {
        $sql = "INSERT INTO prodotti_spot (prodotto_id, spot, valore_spot) 
                VALUES (:prodotto_id, :spot, :valore_spot)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':prodotto_id' => $product_id,
            ':spot'        => $spot,
            ':valore_spot' => $valore_spot
        ]);
    }

    /**
     * Recupera tutti gli spot associati a un prodotto.
     *
     * @param int $product_id L'ID del prodotto.
     * @return array L'elenco degli spot.
     */
    public function getSpotsByProductId($product_id) {
        $sql = "SELECT * FROM prodotti_spot WHERE prodotto_id = :prodotto_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':prodotto_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna il valore dello spot per un prodotto.
     *
     * @param int $spot_id L'ID dello spot.
     * @param string $valore_spot Il valore aggiornato dello spot.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updateSpotValue($spot_id, $valore_spot) {
        $sql = "UPDATE prodotti_spot SET valore_spot = :valore_spot WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $spot_id,
            ':valore_spot' => $valore_spot
        ]);
    }

    public function deleteSpot($spot_id) {
        $sql = "DELETE FROM prodotti_spot WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $spot_id]);
    }
}

class ProductSlotModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Aggiunge uno slot a un prodotto con valore associato.
     *
     * @param int $product_id L'ID del prodotto a cui associare lo slot.
     * @param string $slot Il valore dello slot.
     * @param string|null $valore_slot Il valore dello slot opzionale.
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function addSlotToProduct($product_id, $slot, $valore_slot = null) {
        $sql = "INSERT INTO prodotti_slot (prodotto_id, slot, valore_slot) 
                VALUES (:prodotto_id, :slot, :valore_slot)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':prodotto_id' => $product_id,
            ':slot'        => $slot,
            ':valore_slot' => $valore_slot
        ]);
    }

    /**
     * Recupera tutti gli slot associati a un prodotto.
     *
     * @param int $product_id L'ID del prodotto.
     * @return array L'elenco degli slot.
     */
    public function getSlotsByProductId($product_id) {
        $sql = "SELECT * FROM prodotti_slot WHERE prodotto_id = :prodotto_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':prodotto_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna il valore dello slot per un prodotto.
     *
     * @param int $slot_id L'ID dello slot.
     * @param string $valore_slot Il valore aggiornato dello slot.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updateSlotValue($slot_id, $valore_slot) {
        $sql = "UPDATE prodotti_slot SET valore_slot = :valore_slot WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $slot_id,
            ':valore_slot' => $valore_slot
        ]);
    }

    public function deleteSlot($slot_id) {
        $sql = "DELETE FROM prodotti_slot WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $slot_id]);
    }
}

class ProdottiPeriodiModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Aggiunge un periodo a un prodotto.
     *
     * @param int $product_id L'ID del prodotto a cui associare il periodo.
     * @param string $tipo_periodo Il tipo di periodo (giornaliero, settimanale, mensile).
     * @param int $valore_periodo Il valore del periodo (numero di giorni, settimane o mesi).
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function addPeriodoToProduct($product_id, $tipo_periodo, $valore_periodo) {
        $sql = "INSERT INTO prodotti_periodi (prodotto_id, tipo_periodo, valore_periodo) 
                VALUES (:prodotto_id, :tipo_periodo, :valore_periodo)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':prodotto_id'   => $product_id,
            ':tipo_periodo'  => $tipo_periodo,
            ':valore_periodo'=> $valore_periodo
        ]);
    }

    /**
     * Recupera tutti i periodi associati a un prodotto.
     *
     * @param int $product_id L'ID del prodotto.
     * @return array L'elenco dei periodi.
     */
    public function getPeriodiByProductId($product_id) {
        $sql = "SELECT * FROM prodotti_periodi WHERE prodotto_id = :prodotto_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':prodotto_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna il valore di un periodo per un prodotto.
     *
     * @param int $periodo_id L'ID del periodo.
     * @param string $valore_periodo Il valore aggiornato del periodo.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updatePeriodoValue($periodo_id, $valore_periodo) {
        $sql = "UPDATE prodotti_periodi SET valore_periodo = :valore_periodo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'             => $periodo_id,
            ':valore_periodo' => $valore_periodo
        ]);
    }

    public function deletePeriodo($periodo_id) {
        $sql = "DELETE FROM prodotti_periodi WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $periodo_id]);
    }
}
?>