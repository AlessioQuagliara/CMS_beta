<?php
class ChatManager {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Recupera i messaggi tra un utente e l'admin.
     *
     * @param string $userName Nome dell'utente.
     * @return array Lista dei messaggi.
     */
    public function getMessaggiPerUtente($userName) {
        $sql = "SELECT * FROM chat_messages 
                WHERE (sender_name = :user_name AND sender_type = 'user') 
                OR (receiver_name = :user_name AND sender_type = 'admin') 
                ORDER BY created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_name' => $userName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera i messaggi di una conversazione tra un utente e l'admin.
     *
     * @param string $userName Nome dell'utente.
     * @return array Lista dei messaggi.
     */
    public function getMessaggiPerAdmin($userName) {
        $sql = "SELECT * FROM chat_messages 
                WHERE (sender_name = :user_name AND sender_type = 'user') 
                OR (receiver_name = :user_name AND sender_type = 'admin') 
                ORDER BY created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_name' => $userName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Invia un messaggio nella chat.
     *
     * @param string $senderType Tipo di mittente (user/admin).
     * @param string $senderName Nome del mittente.
     * @param string $receiverName Nome del destinatario.
     * @param string $message Contenuto del messaggio.
     * @return bool True se il messaggio è stato inviato, false altrimenti.
     */
    public function inviaMessaggio($senderType, $senderName, $receiverName, $message) {
        $sql = "INSERT INTO chat_messages (sender_type, sender_name, receiver_name, message, created_at, is_read, is_read_admin)
                VALUES (:sender_type, :sender_name, :receiver_name, :message, NOW(), 0, 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':sender_type'   => $senderType,
            ':sender_name'   => $senderName,
            ':receiver_name' => $receiverName,
            ':message'       => $message
        ]);
    }

    /**
     * Marca i messaggi come letti per un utente.
     *
     * @param string $userName Nome dell'utente.
     * @return bool True se l'operazione è riuscita, false altrimenti.
     */
    public function marcaMessaggiComeLetti($userName) {
        $sql = "UPDATE chat_messages 
                SET is_read = 1 
                WHERE receiver_name = :user_name AND sender_type = 'admin'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':user_name' => $userName]);
    }

    /**
     * Marca i messaggi come letti per l'admin.
     *
     * @param string $userName Nome dell'utente.
     * @return bool True se l'operazione è riuscita, false altrimenti.
     */
    public function marcaMessaggiComeLettiAdmin($userName) {
        $sql = "UPDATE chat_messages 
                SET is_read_admin = 1 
                WHERE receiver_name = 'admin' AND sender_name = :user_name";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':user_name' => $userName]);
    }

    /**
     * Conta i messaggi non letti per un utente.
     *
     * @param string $userName Nome dell'utente.
     * @return int Numero di messaggi non letti.
     */
    public function contaMessaggiNonLettiUtente($userName) {
        $sql = "SELECT COUNT(*) as non_letti FROM chat_messages 
                WHERE receiver_name = :user_name AND sender_type = 'admin' AND is_read = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_name' => $userName]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['non_letti'];
    }

    /**
     * Conta i messaggi non letti per l'admin.
     *
     * @param string $userName Nome dell'utente.
     * @return int Numero di messaggi non letti.
     */
    public function contaMessaggiNonLettiAdmin($userName) {
        $sql = "SELECT COUNT(*) as non_letti FROM chat_messages 
                WHERE receiver_name = 'admin' AND sender_name = :user_name AND is_read_admin = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_name' => $userName]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['non_letti'];
    }

    /**
     * Elimina tutti i messaggi di un utente.
     *
     * @param string $userName Nome dell'utente.
     * @return bool True se l'operazione è riuscita, false altrimenti.
     */
    public function eliminaMessaggiUtente($userName) {
        $sql = "DELETE FROM chat_messages WHERE sender_name = :user_name OR receiver_name = :user_name";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':user_name' => $userName]);
    }

    /**
     * Ottiene la lista degli utenti che hanno inviato messaggi, con l'ultimo messaggio ricevuto.
     *
     * @return array
     */
    public function getUtentiConMessaggi() {
        $sql = "
            SELECT DISTINCT sender_name AS user_name, 
                            MAX(created_at) AS last_message_time
            FROM chat_messages
            WHERE sender_type = 'user'
            GROUP BY sender_name
            ORDER BY last_message_time DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>