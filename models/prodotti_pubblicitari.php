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
                    genere, eta, tipo_periodo, valore_periodo, slot, posizionamento, spot
                ) VALUES (
                    :nome, :slug, :description, :mezzo_pubblicitario, :dimensione, :concessionaria,
                    :genere, :eta, :tipo_periodo, :valore_periodo, :slot, :posizionamento, :spot
                )";

        $stmt = $this->pdo->prepare($sql);

        // Assumiamo che $data contenga tutte le chiavi richieste.
        // Se alcuni campi possono essere null, ricordati di gestirli opportunamente.
        return $stmt->execute([
            ':nome'               => $data['nome'],
            ':slug'               => $data['slug'],
            ':description'        => $data['description'] ?? null,
            ':mezzo_pubblicitario'=> $data['mezzo_pubblicitario'],
            ':dimensione'         => $data['dimensione'],
            ':concessionaria'     => $data['concessionaria'],
            ':genere'             => $data['genere'],
            ':eta'                => $data['eta'],
            ':tipo_periodo'       => $data['tipo_periodo'],
            ':valore_periodo'     => $data['valore_periodo'],
            ':slot'               => $data['slot'] ?? null,
            ':posizionamento'     => $data['posizionamento'] ?? null,
            ':spot'               => $data['spot'] ?? null,
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
                    tipo_periodo = :tipo_periodo,
                    valore_periodo = :valore_periodo,
                    slot = :slot,
                    posizionamento = :posizionamento,
                    spot = :spot,
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
            ':tipo_periodo'       => $data['tipo_periodo'],
            ':valore_periodo'     => $data['valore_periodo'],
            ':slot'               => $data['slot'] ?? null,
            ':posizionamento'     => $data['posizionamento'] ?? null,
            ':spot'               => $data['spot'] ?? null,
            ':id'                 => $id,
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