<?php
class UserModel {
    /**
     * @var PDO
     */
    private $pdo;

    // Iniettiamo la connessione PDO nel costruttore
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Crea un nuovo utente con tutti i campi richiesti per la fatturazione.
     *
     * @param array $data I dati dell'utente
     * @return bool True se l'inserimento è andato a buon fine, false altrimenti.
     */
    public function createUser(array $data) {
        $sql = "INSERT INTO user_db (
                    nome, cognome, email, telefono, codice_fiscale, partita_iva, ragione_sociale, indirizzo, cap, citta, provincia, nazione, password, data_registrazione, ultimo_accesso
                ) VALUES (
                    :nome, :cognome, :email, :telefono, :codice_fiscale, :partita_iva, :ragione_sociale, :indirizzo, :cap, :citta, :provincia, :nazione, :password, :data_registrazione, :ultimo_accesso
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome'               => $data['nome'],
            ':cognome'            => $data['cognome'],
            ':email'              => $data['email'],
            ':telefono'           => $data['telefono'],
            ':codice_fiscale'     => $data['codice_fiscale'],
            ':partita_iva'        => $data['partita_iva'],
            ':ragione_sociale'    => $data['ragione_sociale'],
            ':indirizzo'          => $data['indirizzo'],
            ':cap'                => $data['cap'],
            ':citta'              => $data['citta'],
            ':provincia'          => $data['provincia'],
            ':nazione'            => $data['nazione'],
            ':password'           => password_hash($data['password'], PASSWORD_BCRYPT),
            ':data_registrazione' => date('Y-m-d H:i:s'),
            ':ultimo_accesso'     => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Recupera tutti gli utenti.
     *
     * @return array L'elenco degli utenti.
     */
    public function getAllUsers() {
        $sql = "SELECT * FROM user_db ORDER BY data_registrazione DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera un utente in base all'ID.
     *
     * @param int $id_utente L'ID dell'utente.
     * @return array|false L'utente come array associativo, oppure false se non trovato.
     */
    public function getUserById(int $id_utente) {
        $sql = "SELECT * FROM user_db WHERE id_utente = :id_utente LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera un utente in base all'email.
     *
     * @param string $email L'email dell'utente.
     * @return array|false L'utente come array associativo, oppure false se non trovato.
     */
    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM user_db WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Aggiorna un utente esistente con tutti i nuovi campi.
     *
     * @param int   $id_utente L'ID dell'utente da aggiornare.
     * @param array $data      I nuovi dati dell'utente.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updateUser(int $id_utente, array $data) {
        $sql = "UPDATE user_db SET
                    nome = :nome,
                    cognome = :cognome,
                    email = :email,
                    telefono = :telefono,
                    codice_fiscale = :codice_fiscale,
                    partita_iva = :partita_iva,
                    ragione_sociale = :ragione_sociale,
                    indirizzo = :indirizzo,
                    cap = :cap,
                    citta = :citta,
                    provincia = :provincia,
                    nazione = :nazione,
                    ultimo_accesso = :ultimo_accesso
                WHERE id_utente = :id_utente";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome'           => $data['nome'],
            ':cognome'        => $data['cognome'],
            ':email'          => $data['email'],
            ':telefono'       => $data['telefono'],
            ':codice_fiscale' => $data['codice_fiscale'],
            ':partita_iva'    => $data['partita_iva'],
            ':ragione_sociale' => $data['ragione_sociale'],
            ':indirizzo'      => $data['indirizzo'],
            ':cap'            => $data['cap'],
            ':citta'          => $data['citta'],
            ':provincia'      => $data['provincia'],
            ':nazione'        => $data['nazione'],
            ':ultimo_accesso' => date('Y-m-d H:i:s'),
            ':id_utente'      => $id_utente
        ]);
    }

    /**
     * Aggiorna la password dell'utente.
     *
     * @param int $id_utente L'ID dell'utente.
     * @param string $new_password La nuova password.
     * @return bool True se l'aggiornamento è andato a buon fine, false altrimenti.
     */
    public function updateUserPassword(int $id_utente, string $new_password) {
        $sql = "UPDATE user_db SET password = :password WHERE id_utente = :id_utente";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':password'  => password_hash($new_password, PASSWORD_BCRYPT),
            ':id_utente' => $id_utente
        ]);
    }

    /**
     * Elimina un utente in base all'ID.
     *
     * @param int $id_utente L'ID dell'utente da eliminare.
     * @return bool True se l'eliminazione è andata a buon fine, false altrimenti.
     */
    public function deleteUser(int $id_utente) {
        $sql = "DELETE FROM user_db WHERE id_utente = :id_utente";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function aggiornaDatiUtente($userId, array $data) {
        $sql = "UPDATE user_db 
                SET codice_fiscale = :codice_fiscale, 
                    partita_iva = :partita_iva, 
                    ragione_sociale = :ragione_sociale, 
                    indirizzo = :indirizzo, 
                    cap = :cap, 
                    citta = :citta, 
                    provincia = :provincia, 
                    nazione = :nazione 
                WHERE id_utente = :id_utente";
    
        $stmt = $this->pdo->prepare($sql);
    
        return $stmt->execute([
            ':codice_fiscale' => $data['codice_fiscale'],
            ':partita_iva' => $data['partita_iva'],
            ':ragione_sociale' => $data['ragione_sociale'],
            ':indirizzo' => $data['indirizzo'],
            ':cap' => $data['cap'],
            ':citta' => $data['citta'],
            ':provincia' => $data['provincia'],
            ':nazione' => $data['nazione'],
            ':id_utente' => $userId
        ]);
    }

}
?>