<?php
require 'conn.php'; // Importa la funzione di connessione al database 


// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// --------------------------------------------Autore: Alessio Quagliara------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------Spotex SRL-------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// -----------------------------------------LinkBay CMS Tutti i diritti riservati---------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// Funzioni Interne ----------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// --------------------------------------------Autore: Alessio Quagliara------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------Spotex SRL-------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// -----------------------------------------LinkBay CMS Tutti i diritti riservati---------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// Funzione Autenticazione ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function loggato() {
    session_start();

    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
        header("Location: ../index");
        exit;
    }

    // Imposta il timeout di inattività (es. 10 minuti = 600 secondi)
    $timeout = 1200; // 20 minuti in secondi

    // Controlla se è impostato il timestamp dell'ultima attività
    if (isset($_SESSION['ultimo_accesso'])) {
        // Calcola il tempo trascorso dall'ultima attività
        $tempo_trascorso = time() - $_SESSION['ultimo_accesso'];

        // Se il tempo trascorso è maggiore del timeout, distruggi la sessione e reindirizza all'accesso
        if ($tempo_trascorso > $timeout) {
            // Distruggi la sessione
            session_unset(); // Rimuovi tutte le variabili di sessione
            session_destroy(); // Distruggi la sessione

            // Reindirizza alla pagina di accesso
            header("Location: ../logout");
            exit;
        }
    }   

    // Aggiorna il timestamp dell'ultimo accesso a ora
    $_SESSION['ultimo_accesso'] = time();
}

// Funzione Impostazioni Negozio ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

$resolution = "'width=1920,height=1080'";

// Funzione di Login ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function login(){
    session_start(); // Inizia la sessione 

// Verifica se l'utente è già autenticato
if (isset($_SESSION['loggato']) && $_SESSION['loggato'] === true) {
    // Utente già autenticato, reindirizzalo alla dashboard
    header("Location: ui/homepage");
    exit;
}

$login_error = ""; // Inizializza la variabile qui per assicurarti che sia sempre definita

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include il file di connessione al database
    require '../conn.php';

    // Ottieni i dati dal form e sanifica l'input
    $email = strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
    $password = $_POST['password']; // La password verrà verificata, quindi non è necessario sanificarla

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $login_error = "Formato email non valido.";
    } else {
        // Esegui la query per verificare le credenziali dell'utente usando una dichiarazione preparata
        $sql = "SELECT id_admin, nome, cognome, ruolo, email, telefono, password FROM administrator WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verifica la password
            if (password_verify($password, $row['password'])) {
                // Credenziali corrette, autentica l'utente
                $_SESSION['loggato'] = true;
                $_SESSION['id_admin'] = $row['id_admin'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cognome'] = $row['cognome'];
                $_SESSION['ruolo'] = $row['ruolo'];
                $_SESSION['telefono'] = $row['telefono'];
                $_SESSION['email'] = $row['email'];

                // Reindirizza l'utente alla dashboard
                header("Location: ui/homepage");
                exit;
            } else {
                $login_error = "Credenziali non valide. Riprova.";
            }
        } else {
            $login_error = "Utente non trovato. Riprova.";
        }

        $stmt->close(); // Chiudi la dichiarazione preparata
    }

    $conn->close(); // Chiudi la connessione al database
}

return $login_error; // Restituisci la stringa di errore
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Logout ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function logout(){
    session_start();
    session_destroy();
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Registrazione ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function subscribe(){
    require ('../php_email.php');
    // Includi il file di connessione al database
    require '../conn.php'; // Usa 'require' per assicurarti che il file esista.
    
    // Estrai i dettagli del negozio
    $query_dettagli_negozio = "SELECT * FROM dettagli_negozio";
    $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);
    if ($dettagli = mysqli_fetch_assoc($result_dettagli_negozio)) {
        // Estrai i dettagli del negozio e assegnali a variabili
        $nome_negozio = $dettagli['nome_negozio'];
        $sitoweb = $dettagli['sitoweb'];
        // Qui puoi aggiungere altre variabili se necessario
    }

    // Verifica se il form è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prendi e tratta i dati del form
        $nome = trim($_POST['nome']);
        $cognome = trim($_POST['cognome']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $telefono = trim($_POST['telefono']);
        $ruolo = 'Amministratore';
        $password = $_POST['password']; // La password verrà hashata quindi non è necessario sanificarla.

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("<p class='text-red-500'>Formato email non valido.</p>");
        }

        // Genera l'hash della password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepara la query SQL per inserire i dati nel database
        $sql = "INSERT INTO administrator (nome, cognome, ruolo, email, telefono, password) VALUES (?, ?,?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("<p class='text-red-500'>Errore nella preparazione della query: " . $conn->error . "</p>");
        }

        $stmt->bind_param("ssssss", $nome, $cognome, $ruolo, $email, $telefono, $hashed_password);

        if ($stmt->execute()) {
            // Prepara il contenuto dell'email
            $email_user = $email;
            $oggetto = 'Registrazione a LinkBay';
            $template = file_get_contents('../templates/email_subscribed.html'); // Assicurati che il percorso al file sia corretto
            $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}', '{{id_admin}}'], [$nome, $nome_negozio, $sitoweb, $id_admin], $template); // Nel template usa {{ nome }} per passare i valori
    
            // Invia l'email all'utente con le istruzioni per resettare la password
            send_mail($email_user, $oggetto, $messaggio);

            $messaggio = "Registrazione effettuata con successo";
            $url = "index?messaggio=" . urlencode($messaggio);
            header('location:' . $url);
        } else {
            // MESSAGGIO PER CLIENTE di Errore
        }

        // Chiudi lo statement e la connessione
        $stmt->close();
        $conn->close();
    } else {
        // Se il form non è stato inviato, reindirizza l'utente alla pagina di registrazione
        header("Location: login");
        exit;
    }

}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Ripristino Password ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
    function ripristina(){
        require ('../php_email.php'); // Assicurati che il percorso del file sia corretto

    $errore = ''; // Inizializza la variabile per memorizzare messaggi di errore


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require ('../conn.php'); // Include il file di connessione al database

        // Estrai i dettagli del negozio
        $query_dettagli_negozio = "SELECT * FROM dettagli_negozio";
        $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);
        if ($dettagli = mysqli_fetch_assoc($result_dettagli_negozio)) {
            // Estrai i dettagli del negozio e assegnali a variabili
            $nome_negozio = $dettagli['nome_negozio'];
            $sitoweb = $dettagli['sitoweb'];
            // Qui puoi aggiungere altre variabili se necessario
        }
        
        // Prendi l'email inviata dal form
        $admin_email = $_POST['email'];

        // Prepara la query SQL per evitare SQL Injection
        $stmt = $conn->prepare("SELECT * FROM administrator WHERE email = ?");
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Estrai l'ID dell'admin
            $id_admin = $row['id_admin'];
            $nome = $row['nome'];

            // Carica il contenuto del template HTML per l'email
            $template = file_get_contents('../templates/email_pass.html'); // Assicurati che il percorso sia corretto
            // Sostituisci un placeholder nel tuo template con l'ID admin
            $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}', '{{id_admin}}'], [$nome, $nome_negozio, $sitoweb, $id_admin], $template); // Nel template usa {{ nome }} per passare i valori

            // Invia l'email
            $oggetto = "Ripristino Password";
            if (send_mail($admin_email, $oggetto, $messaggio)) {
                $messaggio = "Istruzioni per il ripristino della password inviate a: " . $admin_email;
                $url = "index?messaggio=" . urlencode($messaggio);
                header('location:' . $url);
                exit;

            } else {
                $errore = "Si è verificato un errore durante l'invio dell'email.";
            }
        } else {
            $errore = "Nessun account trovato con quella email.";
        }
        $stmt->close();
        $conn->close();
    }
    }

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Aggiornamento Password ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function update_pass() {
    include '../conn.php'; // Includi il file di connessione al database

    $response = ['errore' => "", 'risultato' => ''];    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_admin = $_POST['id_admin'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        if ($new_password == $confirm_new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = "UPDATE administrator SET password = ? WHERE id_admin = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                $response['errore'] = "Errore nella preparazione dello statement.";
                $response['risultato'] = 'Errore';
            } else {
                $stmt->bind_param("si", $hashed_password, $id_admin);
                if ($stmt->execute()) {
                    $response['errore'] = ""; // Nessun errore
                    $response['risultato'] = 'Successo';
                } else {
                    $response['errore'] = "Errore nell'aggiornamento della password.";
                    $response['risultato'] = 'Errore';
                }
            }
        } else {
            $response['errore'] = "La nuova password e la conferma non corrispondono.";
            $response['risultato'] = 'Errore';
        }
        $stmt->close();
        $conn->close();
    }

    return $response;
}

// ---------------------------------------------------------------------------------------------------------------------
// HomePage.php (dashboard) ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LE VISITE DEL SITO ---------------------------------------------------------------------------------------
function visite(){
    require '../../conn.php'; // Assicurati che questo file contenga la connessione al tuo database
    
    // Prepara e esegui la query per il numero totale di visite
    $totalVisitsQuery = "SELECT COUNT(*) as total FROM visitatori";
    $totalResult = $conn->query($totalVisitsQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalVisits = $totalRow['total'];
    
    // Prepara e esegui la query per le visite mensili
    $monthlyVisitsQuery = "SELECT YEAR(data_visita) as year, MONTH(data_visita) as month, COUNT(*) as visits FROM visitatori GROUP BY YEAR(data_visita), MONTH(data_visita) ORDER BY YEAR(data_visita) DESC, MONTH(data_visita) DESC";
    $monthlyResult = $conn->query($monthlyVisitsQuery);
    
    // Costruisci l'HTML per la visualizzazione
    $html = '<div class="container mt-5">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Visite Totali</h4>';
    $html .= '<p class="fs-1">' . $totalVisits . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Visite per Mese</h4>';
    $html .= '<ul class="list-group">';
    
    while ($row = $monthlyResult->fetch_assoc()) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">';
        $html .= $row['month'] . '/' . $row['year'];
        $html .= '<span class="badge bg-primary rounded-pill">' . $row['visits'] . '</span>';
        $html .= '</li>';
    }
    
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER GLI ORDINI DELLA NAVBAR
function ordiniNav() {
    // Includi la connessione al database
    require '../../conn.php';

    // Array per i totali degli ordini per stato
    $ordersByState = [];

    // Prepara e esegui la query per il numero totale di ordini
    $totalOrdersQuery = "SELECT COUNT(*) as total FROM ordini WHERE stato_ordine != 'Completo' AND stato_ordine != 'Abbandonato'";
    $totalOrdersResult = $conn->query($totalOrdersQuery);
    if ($totalOrdersRow = $totalOrdersResult->fetch_assoc()) {
        $ordersByState['totali'] = $totalOrdersRow['total'];
    }

    // Stati degli ordini
    $states = ['Inevaso', 'Da Spedire', 'Abbandonato'];

    // Recupera il conteggio degli ordini per ogni stato 
    foreach ($states as $state) {
        $query = "SELECT COUNT(*) as total FROM ordini WHERE stato_ordine = '$state'";
        $result = $conn->query($query);
        if ($row = $result->fetch_assoc()) {
            // Usa strtolower per uniformità nei nomi delle chiavi
            $ordersByState[strtolower($state)] = $row['total'];
        }
    }

    // Chiudi la connessione se necessario
    $conn->close();

    // Restituisci i totali degli ordini per ogni stato
    return $ordersByState;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER GLI ORDINI DEL SITO ---------------------------------------------------------------------------------------
function ordini() {
    // Includi la connessione al database
    require '../../conn.php';

    // Prepara e esegui la query per il numero totale di ordini
    $totalOrdersQuery = "SELECT COUNT(*) as total FROM ordini";
    $totalOrdersResult = $conn->query($totalOrdersQuery);
    $totalOrdersRow = $totalOrdersResult->fetch_assoc();
    $totalOrders = $totalOrdersRow['total'];

    // Prepara e esegui le query per gli ordini in base allo stato
    $states = ['inevaso', 'completo', 'abbandonato'];
    $ordersByState = [];
    
    foreach ($states as $state) {
        $query = "SELECT COUNT(*) as total FROM ordini WHERE stato_ordine = '$state'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $ordersByState[$state] = $row['total'];
    }

    // Costruisci l'HTML per la visualizzazione
    $html = '<div class="container mt-5">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Ordini Totali</h4>';
    $html .= '<p class="fs-1">' . $totalOrders . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Ordini per stato</h4>';
    
    foreach ($ordersByState as $state => $total) {
        $html .= '<div>' . ucfirst($state) . ': ' . $total . '</div>';
    }

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    // Chiudi la connessione se necessario
    $conn->close();

    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LE VENDITE DEL SITO ---------------------------------------------------------------------------------------
function vendite() {
    // Includi la connessione al database
    require '../../conn.php';
    // Prepara e esegui la query per il totale venduto
    $totalSoldQuery = "SELECT SUM(totale_ordine) as totalSold FROM ordini WHERE stato_ordine = 'Completo'";
    $totalSoldResult = $conn->query($totalSoldQuery);
    $totalSoldRow = $totalSoldResult->fetch_assoc();
    $totalSold = $totalSoldRow['totalSold'];
    
    // Prepara e esegui la query per gli ordini raggruppati per mese
    $ordersByMonthQuery = "SELECT YEAR(data_ordine) as year, MONTH(data_ordine) as month, COUNT(*) as totalOrders FROM ordini GROUP BY YEAR(data_ordine), MONTH(data_ordine) ORDER BY YEAR(data_ordine) DESC, MONTH(data_ordine) DESC";
    $ordersByMonthResult = $conn->query($ordersByMonthQuery);
    
    // Costruisci l'HTML per la visualizzazione
    $html = '<div class="container mt-5">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Incassi Totali</h4>';
    $html .= '<p class="fs-1">' . number_format($totalSold, 2, '.', ',') . ' €</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Vendite per data</h4>';
    $html .= '<ul class="list-group">';
    
    while ($row = $ordersByMonthResult->fetch_assoc()) {
        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">';
        $html .= $row['month'] . '/' . $row['year'];
        $html .= '<span class="badge bg-primary rounded-pill">' . $row['totalOrders'] . '</span>';
        $html .= '</li>';
    }
    
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER POP DETTAGLI DEL NEGOZIO ---------------------------------------------------------------------------------------
function dettagli_negozio() {
    require '../../conn.php';  // Includi la connessione al database

    $query = "SELECT COUNT(*) as total FROM dettagli_negozio"; 
    $result = mysqli_query($conn, $query);
    
    // Inizializza le variabili
    $progresso = 0;
    $titolo = '';
    $descrizione = '';
    $btn_dati = '';

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] > 0) {
            $progresso = 100;
            $titolo = 'Hai Completato i dati richiesti';
            $descrizione = 'Fantastico! Hai completato tutti i dati richiesti per il tuo negozio.';
            $btn_dati = '<a href="dettagli_negozio" class="btn btn-outline-secondary">Modifica i tuoi dati</a>';
        } else {
            $progresso = 10;
            $titolo = 'Completa i dati nel tuo negozio';
            $descrizione = 'Ci sono dati importanti che dovresti inserire per completare le impostazioni del tuo negozio.';
            $btn_dati = '<a href="dettagli_negozio" class="btn btn-outline-secondary">Completa Ora i Tuoi Dati</a>';
        }
    } else {
        // Gestisci l'errore della query
        $titolo = 'Errore';
        $descrizione = 'Errore nell\'esecuzione della query: ' . mysqli_error($conn);
        // Nessun pulsante in questo caso
    }
    
    mysqli_close($conn); // Chiudi la connessione al database
    
    // Costruisci l'HTML per la visualizzazione
    $html = '<div class="card">';
    $html .= '<div class="card-body">';
    $html .= '<h5 class="card-title">' . $titolo . '</h5>';
    $html .= '<p class="card-text">' . $descrizione . '</p>';
    $html .= '<div class="progress mb-3">';
    $html .= '<div class="progress-bar" role="progressbar" style="width: ' . $progresso . '%;" aria-valuenow="' . $progresso . '" aria-valuemin="0" aria-valuemax="100">' . $progresso . '%</div>';
    $html .= '</div>';
    $html .= $btn_dati;
    $html .= '</div>';
    $html .= '</div>';

    // Restituisci l'HTML costruito
    return $html;
}
//---------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER POPOLARE I DETTAGLI DEL NEGOZIO -----------------------------------------------------------------------------

function stampaDettagli_negozio() {
    require '../../conn.php';  // Includi la connessione al database

    $query_dettagli_negozio = "SELECT * FROM dettagli_negozio"; 
    $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);
    
    // Prepariamo un array vuoto per i dettagli
    $dettagli = [];
    
    // Popoliamo l'array con i risultati della query
    if ($result_dettagli_negozio) {
        while($row_dettagli_negozio = mysqli_fetch_assoc($result_dettagli_negozio)) {
            // Aggiungi ogni riga dei risultati all'array dei dettagli
            $dettagli[] = $row_dettagli_negozio;
        }
    }

    mysqli_close($conn); // Chiudi la connessione al database
    
    // Restituisci i dettagli come array associativo
    return $dettagli;
}

// Funzione per stampare

// $dettagli_negozio = stampaDettagli_negozio();
//foreach ($dettagli_negozio as $dettaglio) {
//    echo "Nome del negozio: " . $dettaglio['nome'] . "<br>";  // Assicurati che 'nome' corrisponda alla colonna del tuo database
    // Aggiungi qui altre proprietà come necessario
//}


// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER VISUALIZZARE LEADS E CLIENTI ---------------------------------------------------------------------------
function visualizzaClientiELeads() {
    // Includi la connessione al database
    require '../../conn.php';

    // Prepara e esegui la query per il numero totale di clienti
    $totalClientsQuery = "SELECT COUNT(*) as totalClients FROM user_db";
    $totalClientsResult = $conn->query($totalClientsQuery);
    $totalClientsRow = $totalClientsResult->fetch_assoc();
    $totalClients = $totalClientsRow['totalClients'];
    
    // Prepara e esegui la query per il numero totale di leads
    $totalLeadsQuery = "SELECT COUNT(*) as totalLeads FROM leads";
    $totalLeadsResult = $conn->query($totalLeadsQuery);
    $totalLeadsRow = $totalLeadsResult->fetch_assoc();
    $totalLeads = $totalLeadsRow['totalLeads'];
    
    // Costruisci l'HTML per la visualizzazione
    $html = '<div class="container mt-5">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Clienti Registrati</h4>';
    $html .= '<p class="fs-1">' . number_format($totalClients, 0, '', ',') . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<div class="p-3 mb-3 bg-light rounded-3">';
    $html .= '<h4>Leads</h4>';
    $html .= '<p class="fs-1">' . number_format($totalLeads, 0, '', ',') . '</p>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// OrdiniInevasi.php ---------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER Tabella Inevasi ----------------------------------------------------------------------------------------
function stampaTabellaOrdiniInevasi() {
    // Includi la connessione al database
    require '../../conn.php';
    
    // Prepara e esegui la query per ottenere i dati degli ordini
    $ordersQuery = "SELECT * FROM ordini WHERE stato_ordine = 'Inevaso'";
    $ordersResult = $conn->query($ordersQuery);
    
    // Costruisci l'HTML per la tabella
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>ID Ordine</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Stato Ordine</th>';
    $html .= '<th>Data Ordine</th>';
    $html .= '<th>Tipo Spedizione</th>';
    $html .= '<th>Totale Ordine</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';
    
    // Verifica se ci sono risultati
    if ($ordersResult->num_rows > 0) {
        while($row = $ordersResult->fetch_assoc()) {
            if($row['selected'] == 'false' ){
                $selected = '<i class="fa-regular fa-square fs-5"></i>';
            } else {
                $selected = '<i class="fa-solid fa-square-check fs-5"></i>';
            }
            $html .= '<tr>';
            $html .= '<td class="clickable-row" data-id="'.$row['id_ordine'].'" data-stato="'.$row['selected'].'">' . $selected . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >#00' . $row['id_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['email'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['stato_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['data_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['tipo_spedizione'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . number_format($row['totale_ordine'], 2, '.', ',') . ' €</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="6">Nessun ordine trovato</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ----------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA ORDINE MANUALE ---------------------------------------------------------------------------------
function aggiuntaOrdine(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto
    
    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addOrder') {
        // Valori predefiniti
        $email = 'scrivi@laemail.it';	
        $data_ordine = 'inserisci la data';	
        $stato_ordine = 'inevaso';	
        $totale_ordine = '0';	
        $indirizzo_spedizione = 'Inserisci la via';	
        $paese = 'Inserisci il paese';	
        $cap = 'inserisci il cap';	
        $citta = 'Inserisci la città';	
        $provincia = 'Inserisci la provincia';	
        $telefono = 'Inserisci il telefono';	
        $nome = 'Inserisci il nome';	
        $cognome = 'inserisci il cognome';	
        $tipo_spedizione = 'Inserisci la spedizione';	

        

        $query = "INSERT INTO ordini (email, data_ordine, stato_ordine, totale_ordine, indirizzo_spedizione, paese, cap, citta, provincia, telefono, nome, cognome, tipo_spedizione) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssssssssssss", $email, $data_ordine, $stato_ordine, $totale_ordine, $indirizzo_spedizione, $paese, $cap, $citta, $provincia, $telefono, $nome, $cognome, $tipo_spedizione);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Ordine aggiunto con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/ordini_inevasi?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento dell'ordine: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/ordini_inevasi?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/ordini_inevasi?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/ordini_inevasi');
        exit;
    }
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI ORDINE ----------------------------------------------------------------------------------------
function dettagliOrdine($id_order){
    require ('conn.php');

    $stmt = $conn->prepare("SELECT * FROM ordini WHERE id_ordine = ?");
    $stmt->bind_param("i", $id_order);

    $stmt->execute();
    $result = $stmt->get_result();

    $ordine = array();

    if($result->num_rows > 0) {
        $ordine = $result->fetch_assoc();
    } else{
        $ordine['error'] = "Nessun ordine trovato con l'ID specificato.";
    }

    $stmt->close();
    $conn->close();

    return $ordine;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI ARTICOLI ORDINE -------------------------------------------------------------------------------
function dettagliArticoliOrdine($id_order){
    require ('conn.php');

    $query = "SELECT do.id_dettaglio, do.id_ordine, do.id_prodotto, do.quantita, do.prezzo, 
                     p.titolo, p.descrizione, p.categoria, p.collezione, p.stato, p.prezzo_comparato, p.quantita AS quantita_disponibile, p.peso, p.varianti
              FROM dettagli_ordini do
              JOIN prodotti p ON do.id_prodotto = p.id_prodotto
              WHERE do.id_ordine = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();

    $dettagli = [];

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $dettagli[] = $row;
        }
    } else {
        $dettagli['error'] = "Non è stato trovato nessun dettaglio per questo ordine";
    }

    $stmt->close();
    $conn->close();
    
    return $dettagli;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER PREZZO TOTALE ----------------------------------------------------------------------------------------
function stampaTotaleOrdine($id_order) {
    require('conn.php'); 

    $query = "SELECT quantita, prezzo FROM dettagli_ordini WHERE id_ordine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();

    $totale = 0; // Inizializza il totale a 0

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totale += $row['quantita'] * $row['prezzo'];
        }
        echo "Il tuo ordine da: €" . number_format($totale, 2);
    } else {
        echo "Nessun totale, aggiungi articoli all'ordine.";
    }

    $stmt->close();
    $conn->close();
}

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA ORDINE ----------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// OrdiniSpedire.php ---------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER Tabella Spedizioni -------------------------------------------------------------------------------------
function stampaTabellaOrdiniSpedire() {
    // Includi la connessione al database
    require '../../conn.php';
    
    // Prepara e esegui la query per ottenere i dati degli ordini
    $ordersQuery = "SELECT * FROM ordini WHERE stato_ordine = 'Da Spedire'";
    $ordersResult = $conn->query($ordersQuery);
    
    // Costruisci l'HTML per la tabella
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>ID Ordine</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Stato Ordine</th>';
    $html .= '<th>Data Ordine</th>';
    $html .= '<th>Tipo Spedizione</th>';
    $html .= '<th>Totale Ordine</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';
    
    // Verifica se ci sono risultati
    if ($ordersResult->num_rows > 0) {
        while($row = $ordersResult->fetch_assoc()) {
            if($row['selected'] == 'false' ){
                $selected = '<i class="fa-regular fa-square fs-5"></i>';
            } else {
                $selected = '<i class="fa-solid fa-square-check fs-5"></i>';
            }
            $html .= '<tr>';
            $html .= '<td class="clickable-row" data-id="'.$row['id_ordine'].'" data-stato="'.$row['selected'].'">' . $selected . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >#00' . $row['id_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['email'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['stato_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['data_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['tipo_spedizione'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . number_format($row['totale_ordine'], 2, '.', ',') . ' €</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="6">Nessun ordine trovato</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER Spedizioni ---------------------------------------------------------------------------------------------
function mostraDettagliOrdineSpedizione($idOrdine) {
    // Connessione al database
    require('../../conn.php');
    
    // Inizializza l'HTML del contenuto
    $html = '<div class="container mt-5">';
    
    // Query per ottenere i dettagli dell'ordine
    $query_ordine = "SELECT * FROM ordini WHERE id_ordine = $idOrdine";
    $result_ordine = mysqli_query($conn, $query_ordine);
    if ($result_ordine && $row_ordine = mysqli_fetch_assoc($result_ordine)) {
        // Estrazione dati dell'ordine
        $id_ordine = $row_ordine['id_ordine'];
        $nome = $row_ordine['nome'];
        $cognome = $row_ordine['cognome'];
        $indirizzo_spedizione = $row_ordine['indirizzo_spedizione'];
        $paese = $row_ordine['paese'];
        $cap = $row_ordine['cap'];
        $citta = $row_ordine['citta'];
        $provincia = $row_ordine['provincia'];
        $stato_ordine = $row_ordine['stato_ordine'];
        $data_ordine = $row_ordine['data_ordine'];
        $email = $row_ordine['email'];
        $telefono = $row_ordine['telefono'];
        $tipo_spedizione = $row_ordine['tipo_spedizione'];
        $totale_ordine = $row_ordine['totale_ordine'];
    
        // Aggiungi le informazioni dell'ordine all'HTML
        $html .= "<h1>Ordine #00$id_ordine</h1>
                  <p><strong>Cliente:</strong> $nome $cognome</p>
                  <p><strong>Indirizzo di Spedizione:</strong> $indirizzo_spedizione, $paese, $cap, $citta, $provincia</p>
                  <p><strong>Tipo Di Spedizione Selezionata:</strong> $tipo_spedizione</p>
                  <p><strong>Numero di Telefono:</strong> $telefono</p>
                  <table class='table'>
                      <thead>
                          <tr>
                              <th>Prodotto</th>
                              <th>Quantità</th>
                              <th>Prezzo</th>
                          </tr>
                      </thead>
                      <tbody>";

        // Query per ottenere i dettagli dei prodotti ordinati
        $queryDettagliOrdine = "SELECT dettagli_ordini.quantita, dettagli_ordini.prezzo, prodotti.titolo 
                                FROM dettagli_ordini 
                                JOIN prodotti ON dettagli_ordini.id_prodotto = prodotti.id_prodotto 
                                WHERE dettagli_ordini.id_ordine = $idOrdine";
        $resultDettagliOrdine = mysqli_query($conn, $queryDettagliOrdine);
        $totale = 0;
        while ($resultDettagliOrdine && $dettagli = mysqli_fetch_assoc($resultDettagliOrdine)) {
            $html .= "<tr>
                        <td>" . $dettagli['titolo'] . "</td>
                        <td>" . $dettagli['quantita'] . "</td>
                        <td>€" . number_format($dettagli['prezzo'], 2) . "</td>
                      </tr>";
            $totale += $dettagli['quantita'] * $dettagli['prezzo'];
        }

        // Calcola il costo di spedizione
        $tipo_spedizione = mysqli_real_escape_string($conn, $tipo_spedizione);
        $querySpedizione = "SELECT * FROM spedizioni WHERE tipo_spedizione = '$tipo_spedizione'";
        $resultSpedizione = mysqli_query($conn, $querySpedizione);
        $prezzo_spedizione = 0;
        if ($rowSpedizione = mysqli_fetch_assoc($resultSpedizione)) {
            $prezzo_spedizione = $rowSpedizione['prezzo_spedizione']; // Prezzo spedizione dal database
        }

        // Aggiungi i totali all'HTML
        $html .= "<tr>
                    <td>Spedizione</td>
                    <td>1</td>
                    <td>€" . number_format($prezzo_spedizione, 2) . "</td>
                  </tr>
                  <tr>
                    <td><strong>Totale</strong></td>
                    <td></td>
                    <td><strong>€" . number_format($totale + $prezzo_spedizione, 2) . "</strong></td>
                  </tr>
                  </tbody>
                  </table>";

        // Modifica lo stato dell'ordine con un menu a tendina
        $html .= "<form action='cambia_stato_ordine' method='POST'>
                    <input type='hidden' name='id_ordine' value='$id_ordine'>
                    <p><strong>Stato Ordine:</strong>
                    <select name='stato_ordine' onchange='this.form.submit()'>
                        <option value='Inevaso' " . ($stato_ordine == 'Inevaso' ? 'selected' : '') . ">Inevaso</option>
                        <option value='Da Spedire' " . ($stato_ordine == 'Da Spedire' ? 'selected' : '') . ">Da Spedire</option>
                        <option value='Completo' " . ($stato_ordine == 'Completo' ? 'selected' : '') . ">Completo</option>
                        <option value='Abbandonato' " . ($stato_ordine == 'Abbandonato' ? 'selected' : '') . ">Abbandonato</option>
                    </select>
                    </p>
                  </form>";
    }

    
        // Query per verificare l'esistenza di un tracking ID
        $query_tracking = "SELECT tracking FROM tracking WHERE id_ordine = $id_ordine";
        $result_tracking = mysqli_query($conn, $query_tracking);
        $tracking = null;
        if ($result_tracking && $row_tracking = mysqli_fetch_assoc($result_tracking)) {
            $tracking = $row_tracking['tracking'];
        }

        if ($tracking === null) {
            // Non esiste un tracking ID, mostra il form per l'inserimento
            $html .= "<div class='tracking-form mt-4'>
                        <h3>Inserisci il Tracking ID</h3>
                        <form action='inserisci_tracking' method='POST'>
                            <input type='hidden' name='id_ordine' value='$id_ordine'>
                            <div class='mb-3'>
                                <label for='tracking_id' class='form-label'>Tracking ID:</label>
                                <input type='text' class='form-control' id='tracking_id' name='tracking_id' required>
                            </div>
                            <button type='submit' class='btn btn-outline-secondary'>Inserisci Tracking</button> 
                        </form>
                    </div>";
        } else {
            // Esiste già un tracking ID, mostra il form per la modifica
            $html .= "<div class='tracking-form mt-4'>
                        <h3>Modifica il Tracking ID</h3>
                        <form action='modifica_tracking' method='POST'>
                            <input type='hidden' name='id_ordine' value='$id_ordine'>
                            <div class='mb-3'>
                                <label for='tracking_id' class='form-label'>Tracking ID:</label>
                                <input type='text' class='form-control' id='tracking_id' name='tracking_id' value='$tracking' required>
                            </div>
                            <button type='submit' class='btn btn-outline-secondary'>Modifica Tracking</button>
                        </form>
                    </div>";
        }

    
    $html .= '</div></div></div>';

    return $html;
}
// -------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER INSERIRE IL TRACKING ---------------------------------------------------------------------------------------
function modificaDettagliTracking() {
    require('../../conn.php'); // Connessione al database
    $id_ordine = $_POST['id_ordine'];
    $tracking_id = mysqli_real_escape_string($conn, $_POST['tracking_id']);
    
    // Inserisci o aggiorna il tracking ID
    $query = "INSERT INTO tracking (id_ordine, tracking) VALUES ('$id_ordine', '$tracking_id') ON DUPLICATE KEY UPDATE tracking='$tracking_id'";
    
    if (mysqli_query($conn, $query)) {
        // Redireziona indietro o mostra un messaggio di successo
        header("Location: ordine_modifica?id=$id_ordine");
    } else {
        // Gestisci l'errore
        echo "Errore: " . mysqli_error($conn);
    }
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICARE IL TRACKING ------------------------------------------------------------------------------------
function aggiornaDettagliTracking() {
    require('../../conn.php'); // Connessione al database

    // Assicurati che i dati siano stati inviati tramite POST
    if (isset($_POST['id_ordine']) && isset($_POST['tracking_id'])) {
        $id_ordine = mysqli_real_escape_string($conn, $_POST['id_ordine']);
        $tracking_id = mysqli_real_escape_string($conn, $_POST['tracking_id']);

        // Query di aggiornamento per il tracking ID
        $query = "UPDATE tracking SET tracking = '$tracking_id' WHERE id_ordine = '$id_ordine'";

        // Esegui la query
        if (mysqli_query($conn, $query)) {
            // Controlla se il numero di righe interessate è 1
            if (mysqli_affected_rows($conn) > 0) {
                // Redireziona indietro o mostra un messaggio di successo
                header("Location: ordine_modifica?id=$id_ordine&update=success");
            } else {
                // Nessuna riga interessata, potrebbe non esistere un tracking per questo id_ordine
                echo "Nessun tracking ID esistente per l'ordine specificato o nessuna modifica effettuata.";
            }
        } else {
            // Gestisci l'errore di query
            echo "Errore durante l'aggiornamento del tracking: " . mysqli_error($conn);
        }
    } else {
        // I dati POST necessari non sono stati inviati
        echo "Errore: Dati form non completi.";
    }
}

// ---------------------------------------------------------------------------------------------------------------------
// OrdiniAbbandonati.php -----------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER Tabella Inevasi ----------------------------------------------------------------------------------------
function stampaTabellaOrdiniAbbandonati() {
    // Includi la connessione al database
    require '../../conn.php';
    
    // Prepara e esegui la query per ottenere i dati degli ordini
    $ordersQuery = "SELECT * FROM ordini WHERE stato_ordine = 'Abbandonati'";
    $ordersResult = $conn->query($ordersQuery);
    
    // Costruisci l'HTML per la tabella
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>ID Ordine</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Stato Ordine</th>';
    $html .= '<th>Data Ordine</th>';
    $html .= '<th>Tipo Spedizione</th>';
    $html .= '<th>Totale Ordine</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';
    
    // Verifica se ci sono risultati
    if ($ordersResult->num_rows > 0) {
        while($row = $ordersResult->fetch_assoc()) {
            if($row['selected'] == 'false' ){
                $selected = '<i class="fa-regular fa-square fs-5"></i>';
            } else {
                $selected = '<i class="fa-solid fa-square-check fs-5"></i>';
            }
            $html .= '<tr>';
            $html .= '<td class="clickable-row" data-id="'.$row['id_ordine'].'" data-stato="'.$row['selected'].'">' . $selected . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >#00' . $row['id_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['email'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['stato_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['data_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['tipo_spedizione'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . number_format($row['totale_ordine'], 2, '.', ',') . ' €</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="6">Nessun ordine trovato</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// OrdiniCompleti.php --------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER Tabella Inevasi ----------------------------------------------------------------------------------------
function stampaTabellaOrdiniCompleti() {
    // Includi la connessione al database
    require '../../conn.php';
    
    // Prepara e esegui la query per ottenere i dati degli ordini
    $ordersQuery = "SELECT * FROM ordini WHERE stato_ordine = 'Evaso'";
    $ordersResult = $conn->query($ordersQuery);
    
    // Costruisci l'HTML per la tabella
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>ID Ordine</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Stato Ordine</th>';
    $html .= '<th>Data Ordine</th>';
    $html .= '<th>Tipo Spedizione</th>';
    $html .= '<th>Totale Ordine</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';
    
    // Verifica se ci sono risultati
    if ($ordersResult->num_rows > 0) {
        while($row = $ordersResult->fetch_assoc()) {
            if($row['selected'] == 'false' ){
                $selected = '<i class="fa-regular fa-square fs-5"></i>';
            } else {
                $selected = '<i class="fa-solid fa-square-check fs-5"></i>';
            }
            $html .= '<tr>';
            $html .= '<td class="clickable-row" data-id="'.$row['id_ordine'].'" data-stato="'.$row['selected'].'">' . $selected . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >#00' . $row['id_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['email'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['stato_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['data_ordine'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . $row['tipo_spedizione'] . '</td>';
            $html .= '<td style="cursor: pointer;" onclick="apriModifica(' . $row['id_ordine'] . ')" >' . number_format($row['totale_ordine'], 2, '.', ',') . ' €</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="6">Nessun ordine trovato</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    
    // Chiudi la connessione se necessario
    $conn->close();
    
    // Restituisci l'HTML costruito
    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// ListaProdotti.php ---------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA PRODOTTI -----------------------------------------------------------------------------------------
function listaProdotti() {
    require '../../conn.php';
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>Pic</th>';
    $html .= '<th>Prodotto</th>';
    $html .= '<th>Stato</th>';
    $html .= '<th>Collezione</th>';
    $html .= '<th>N°</th>';
    $html .= '<th>Rimanenze</th>';
    $html .= '<th>Prezzo</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    // Prima Query: Ottiene i dettagli dei prodotti
    $queryProdotti = "SELECT * FROM prodotti ORDER BY id_prodotto DESC";
    $resultProdotti = mysqli_query($conn, $queryProdotti);

    // Preparazione di un array per tenere traccia delle immagini dei prodotti
    $immaginiProdotti = [];

    // Seconda Query (da eseguire dopo aver raccolto gli ID dei prodotti): Ottiene le immagini principali
    $queryImmagini = "SELECT id_prodotto, immagine FROM media WHERE position = 1";
    $resultImmagini = mysqli_query($conn, $queryImmagini);

    // Popolazione dell'array con le immagini dei prodotti
    while ($row = mysqli_fetch_assoc($resultImmagini)) {
        $immaginiProdotti[$row['id_prodotto']] = $row['immagine'];
    }

    while ($row = mysqli_fetch_assoc($resultProdotti)) {
        // Costruzione dei vari elementi della tabella
        $idProdotto = $row['id_prodotto'];
        $immagine = array_key_exists($idProdotto, $immaginiProdotti) ? $immaginiProdotti[$idProdotto] : 'default.jpg'; // Imposta un'immagine predefinita se non disponibile
        if ($row['stato'] == 'online') {
            $check = '<i class="fa-solid fa-circle text-success"></i>';
        } else if ($row['stato'] == 'offline') {
            $check = '<i class="fa-solid fa-circle text-danger"></i>';
        } else {
            $check = 'NAN';
        }

        if ($row['quantita'] >= 1 && $row['quantita'] <= 5) {
            $check_qnt = '<b class="text-warning">Scorte basse</b>';
        } else if ($row['quantita'] == 0) {
            $check_qnt = '<b class="text-danger">Scorte esaurite</b>';
        } else {
            $check_qnt = '<b class="text-success">Scorte Sufficenti</b>'; // Nessun messaggio se la quantità è maggiore di 5
        }
        // Inserimento delle informazioni del prodotto nell'HTML
        $html .= "<tr style='cursor: pointer;' onclick='apriModifica($idProdotto)'>";
        $html .= "<td><img src='" . htmlspecialchars($immagine, ENT_QUOTES) . "' width='30px'></td>";
        $html .= "<td>" . htmlspecialchars($row['titolo'], ENT_QUOTES) . "</td>";
        $html .= "<td>$check&nbsp;" . htmlspecialchars($row['stato'], ENT_QUOTES) . "</td>"; // Aggiungi qui la logica per visualizzare $check
        $html .= "<td>" . htmlspecialchars($row['collezione'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['quantita'], ENT_QUOTES) . "</td>"; // Aggiungi qui la logica per visualizzare $check_qnt
        $html .= "<td>" .$check_qnt. "</td>"; // Aggiungi qui la logica per visualizzare $check_qnt
        $html .= "<td>" . htmlspecialchars($row['prezzo'], ENT_QUOTES) . "€</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ----------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA PRODOTTO ---------------------------------------------------------------------------------------
function aggiuntaProdotto(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto
    
    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addProduct') {
        // Valori predefiniti
        $titolo = 'Nuovo Prodotto';
        $descrizione = 'Descrizione del tuo Prodotto';
        $categoria = 'Categoria Predefinita';
        $collezione = 'Collezione Predefinita';
        $stato = 'offline';
        $prezzo = '0';
        $prezzo_comparato = '0';
        $quantita = '0';
        $peso = '0';
        $varianti = '0';
        
        $query = "INSERT INTO prodotti (titolo, descrizione, categoria, collezione, stato, prezzo, prezzo_comparato, quantita, peso, varianti) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssssssss", $titolo, $descrizione, $categoria, $collezione, $stato, $prezzo, $prezzo_comparato, $quantita, $peso, $varianti);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Prodotto aggiunto con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/prodotti?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento del prodotto: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/prodotti?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/prodotti?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/prodotti');
        exit;
    }
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA IMMAGINI PRODOTTO -----------------------------------------------------------------------------
function aggiuntaImmagini($id_prodotto) {
    
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';

    // Controlla se il metodo di richiesta è POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['immagini'])) {
        $numeroImmagini = count($_FILES['immagini']['name']);
        
        for ($i = 0; $i < $numeroImmagini; $i++) {
            // Ottieni i dati dell'immagine corrente
            $nomeFile = $_FILES['immagini']['name'][$i];
            $fileTemp = $_FILES['immagini']['tmp_name'][$i];
            $posizione = $i + 1; // Imposta la posizione basandoti sull'indice dell'array

            // Definisci il percorso di destinazione dell'immagine
            $percorsoSalvataggio = "../../src/media/" . basename($nomeFile);

            // Sposta il file dalla posizione temporanea alla destinazione finale
            if (move_uploaded_file($fileTemp, $percorsoSalvataggio)) {
                // Prepara la query SQL per inserire i dettagli dell'immagine nel database
                $query = "INSERT INTO media (id_prodotto, immagine, position) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("isi", $id_prodotto, $percorsoSalvataggio, $posizione);
                    $result = $stmt->execute();

                    if ($result) {
                        $feedback .= "Immagine $nomeFile caricata con successo. ";
                    } else {
                        $feedback .= "Errore durante il caricamento dell'immagine $nomeFile: " . $stmt->error . ". ";
                    }

                    $stmt->close();
                } else {
                    $feedback .= "Errore durante la preparazione della query per l'immagine $nomeFile: " . $conn->error . ". ";
                }
            } else {
                $feedback .= "Errore durante il caricamento dell'immagine $nomeFile. ";
            }
        }

        // Chiudi la connessione al database
        $conn->close();

        // Restituisce il feedback complessivo
        return $feedback;
    } else {
        // Se il metodo non è POST o non ci sono immagini, restituisci un messaggio
        return "Nessuna immagine inviata o metodo di richiesta non valido.";
    }
}
// ----------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA PRODOTTO ---------------------------------------------------------------------------------------
function modificaProdotto($id_prodotto) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID del prodotto è valido (puoi aggiungere ulteriori controlli)
    if (!is_numeric($id_prodotto)) {
        return "ID del prodotto non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione del prodotto
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM prodotti WHERE id_prodotto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_prodotto);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Prodotto eliminato con successo."; // Potresti voler restituire qualcosa che il chiamante possa verificare
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione del prodotto: " . $stmt->error;
        }
    }

    // Processa la modifica del prodotto se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        // Ottieni i dati del modulo
        $titolo = $_POST["titolo"];
        $descrizione = $_POST["descrizione"];
        $prezzo = $_POST["prezzo"];
        $prezzo_comparato = $_POST["prezzo_comparato"];
        $stato = $_POST["stato"];
        $peso = $_POST["peso"];
        $quantita = $_POST["quantita"];
        $categoria = $_POST["categoria"];
        $collezione = $_POST["collezione"];
        $varianti = $_POST["varianti"];

        // Esegui la query di aggiornamento
        $query = "UPDATE prodotti SET titolo=?, descrizione=?, categoria=?, collezione=?, stato=?, prezzo=?, prezzo_comparato=?, quantita=?, peso=?, varianti=? WHERE id_prodotto = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssssdiisi", $titolo, $descrizione, $categoria, $collezione, $stato, $prezzo, $prezzo_comparato, $quantita, $peso, $varianti, $id_prodotto);
            if ($stmt->execute()) {
                $result = "Modifiche apportate con successo.";
            } else {
                $result = "Errore durante la modifica del prodotto: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
        }
    }

    $conn->close();
    return $result;
}
// ----------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DUPLICAZIONE PRODOTTO ---------------------------------------------------------------------------------------
function duplicaProdotto($idProdottoOriginale) {
    require '../../conn.php'; // Assicurati che il percorso del file sia corretto
    
    // Recupera i dettagli del prodotto originale
    $query = "SELECT * FROM prodotti WHERE id_prodotto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idProdottoOriginale);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Prepara la query per duplicare il prodotto escludendo l'ID prodotto
        $queryDuplica = "INSERT INTO prodotti (titolo, descrizione, categoria, collezione, stato, prezzo, prezzo_comparato, quantita, peso, varianti) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtDuplica = $conn->prepare($queryDuplica);
        if ($stmtDuplica) {
            // Sostituisci 'Variante di ' al titolo per indicare che si tratta di una variante
            $nuovoTitolo = 'Variante di ' . $row['titolo'];
            // Bind dei parametri escludendo l'ID (sarà auto-generato se impostato come autoincrement)
            $stmtDuplica->bind_param("ssssssssss", $nuovoTitolo, $row['descrizione'], $row['categoria'], $row['collezione'], $row['stato'], $row['prezzo'], $row['prezzo_comparato'], $row['quantita'], $row['peso'], $row['varianti']);
            $stmtDuplica->execute();
            
            // Ottieni l'ID del nuovo prodotto duplicato
            $nuovoIdProdotto = $stmtDuplica->insert_id;
            $stmtDuplica->close();
            
            // Restituisci l'ID del nuovo prodotto per il reindirizzamento
            return $nuovoIdProdotto;
        } else {
            // Gestisci l'errore nella preparazione della query
            echo "Errore nella preparazione della query di duplicazione: " . $conn->error;
            return false;
        }
    } else {
        // Gestisci l'errore nel recupero dei dettagli del prodotto
        echo "Prodotto originale non trovato.";
        return false;
    }
    $stmt->close();
    $conn->close();
}

// ----------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI PRODOTTO ---------------------------------------------------------------------------------------
function ottieniDettagliProdotto($id_prodotto) {
    require 'conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID del prodotto è valido
    if (!is_numeric($id_prodotto)) {
        return "ID del prodotto non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM prodotti WHERE id_prodotto = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $id_prodotto);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessun prodotto trovato con l'ID specificato.";
    }

    // Estrai i dettagli del prodotto
    $dettagliProdotto = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli del prodotto
    return $dettagliProdotto;
}
// ---------------------------------------------------------------------------------------------------------------------
// ListaCollezioni.php -------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA COLLEZIONI ---------------------------------------------------------------------------------------
function listaCollezioni() {
    require '../../conn.php'; // Utilizza lo stesso file di connessione del DB
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>ID</th>'; // ID della collezione
    $html .= '<th>Nome</th>'; // Nome della collezione
    $html .= '<th>Descrizione</th>'; // Descrizione della collezione
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    $query = "SELECT * FROM collezioni ORDER BY id_collezione DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr style='cursor: pointer;' onclick='apriModifica(" . $row['id_collezione'] . ")'>";
        $html .= "<td>#00" . htmlspecialchars($row['id_collezione'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['nome_c'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['descrizione_c'], ENT_QUOTES) . "</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA COLLEZIONE ---------------------------------------------------------------------------------------
function aggiuntaCollezione(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addColl') {
        // Valori predefiniti
        $nome_c = 'Nuova Collezione';
        $descrizione_c = 'Aggiungi descrizione';
    
        $query = "INSERT INTO collezioni (nome_c, descrizione_c) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ss", $nome_c, $descrizione_c);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Collezione aggiunta con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/collezioni?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento della collezione: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/collezioni?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/collezioni?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/collezioni');
        exit;
    }
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA COLLEZIONE ---------------------------------------------------------------------------------------
function modificaCollezione($id_collezione) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID della collezione è valido (puoi aggiungere ulteriori controlli)
    if (!is_numeric($id_collezione)) {
        return "ID della collezione non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione della collezione
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Recupera il nome della collezione associata all'ID
        $queryNome = "SELECT nome_c FROM collezioni WHERE id_collezione = ?";
        $stmt = $conn->prepare($queryNome);
        $stmt->bind_param('i', $id_collezione);
        $stmt->execute();
        $resultNome = $stmt->get_result();
        $nomeCollezione = $resultNome->fetch_assoc()['nome_c'];
        $stmt->close();

        if ($nomeCollezione) {
            // Elimina tutte le categorie associate al nome della collezione
            $queryCategorie = "DELETE FROM categorie WHERE associazione = ?";
            $stmt = $conn->prepare($queryCategorie);
            $stmt->bind_param('s', $nomeCollezione);
            if (!$stmt->execute()) {
                $stmt->close();
                $conn->close();
                return "Errore durante l'eliminazione delle categorie associate: " . $stmt->error;
            }
            $stmt->close(); // Chiudi lo statement dopo l'eliminazione delle categorie

            // Elimina la collezione
            $queryCollezione = "DELETE FROM collezioni WHERE id_collezione = ?";
            $stmt = $conn->prepare($queryCollezione);
            $stmt->bind_param('i', $id_collezione);
            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                return "Collezione e categorie associate eliminate con successo.";
            } else {
                $stmt->close();
                $conn->close();
                return "Errore durante l'eliminazione della collezione: " . $stmt->error;
            }
        } else {
            $conn->close();
            return "Errore: non è stato possibile recuperare il nome della collezione.";
        }
    }

// Processa la modifica della collezione se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
    // Ottieni i dati del modulo
    $nome_c = $_POST["nome_c"];
    $descrizione_c = $_POST["descrizione_c"];

    // Recupera il vecchio nome della collezione per aggiornare le categorie associate
    $queryVecchioNome = "SELECT nome_c FROM collezioni WHERE id_collezione = ?";
    $stmt = $conn->prepare($queryVecchioNome);
    $stmt->bind_param('i', $id_collezione);
    $stmt->execute();
    $resultVecchioNome = $stmt->get_result();
    $vecchioNome = $resultVecchioNome->fetch_assoc()['nome_c'];
    $stmt->close();

    if ($vecchioNome) {
        // Esegui la query di aggiornamento della collezione
        $query = "UPDATE collezioni SET nome_c=?, descrizione_c=? WHERE id_collezione = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssi", $nome_c, $descrizione_c, $id_collezione);
            if ($stmt->execute()) {
                $stmt->close();
                
                // Se il nome della collezione è cambiato, aggiorna anche tutte le associazioni nelle categorie
                if ($nome_c != $vecchioNome) {
                    $queryAggiornaCategorie = "UPDATE categorie SET associazione = ? WHERE associazione = ?";
                    $stmt = $conn->prepare($queryAggiornaCategorie);
                    $stmt->bind_param('ss', $nome_c, $vecchioNome);
                    if (!$stmt->execute()) {
                        $conn->close();
                        return "Modifiche apportate con successo alla collezione, ma errore durante l'aggiornamento delle categorie associate: " . $stmt->error;
                    }
                    $stmt->close();
                }

                $conn->close();
                return "Modifiche apportate con successo alla collezione e alle categorie associate.";
            } else {
                $result = "Errore durante la modifica della collezione: " . $stmt->error;
                $stmt->close();
                $conn->close();
                return $result;
            }
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
            $conn->close();
            return $result;
        }
    } else {
        $conn->close();
        return "Errore: non è stato possibile recuperare il vecchio nome della collezione.";
    }
}


    $conn->close();
    return $result;
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI COLLEZIONE ---------------------------------------------------------------------------------------
function ottieniDettagliCollezione($id_collezione) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID della collezione è valido
    if (!is_numeric($id_collezione)) {
        return "ID della collezione non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM collezioni WHERE id_collezione = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $id_collezione);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessuna collezione trovato con l'ID specificato.";
    }

    // Estrai i dettagli della collezione
    $dettagliCollezione = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli della collezione
    return $dettagliCollezione;
}
// ---------------------------------------------------------------------------------------------------------------------
// ListaCategorie.php --------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA CATEGORIE
function visualizzaCategorie($nomeCollezione) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Escaping del nome della collezione per evitare problemi SQL
    $nomeCollezione = mysqli_real_escape_string($conn, $nomeCollezione);

    // Query per ottenere le categorie associate al nome della collezione specificato
    $query = "SELECT id_categoria, nome_cat, associazione FROM categorie WHERE associazione = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nomeCollezione); // 's' sta per string
    $stmt->execute();
    $result = $stmt->get_result();

    // Se ci sono categorie associate, genera una tabella per mostrarle
    if ($result->num_rows > 0) {
        echo "<table class='table'>";
        echo "<thead>
                <tr>
                    <th>Nome Categoria</th>
                    <th>Associazione</th>
                    <th>Azioni</th>
                </tr>
            </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>" . htmlspecialchars($row['nome_cat'], ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['associazione'], ENT_QUOTES) . "</td>
            <td><button onclick='confermaEliminazione(" . $row['id_categoria'] . ")' class='btn btn-danger'>Elimina</button></td>
            </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nessuna categoria associata a questa collezione.</p>";
    }

    // Chiudi la connessione e lo statement
    $stmt->close();
    $conn->close();
}
// ---------------------------------------------------------------------------------------------------------------------
// codiciSconto.php ----------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA CODICE SCONTO ---------------------------------------------------------------------------------
function aggiunta_codicesconto(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addCodice') {
        // Valori predefiniti
        $codicesconto = 'NUOVOCODICESCONTO';
        $importo = '20';
        $stato = 'Non Valido';
    
        $query = "INSERT INTO codici_sconto (codicesconto, importo, stato) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sss", $codicesconto, $importo, $stato);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Codice sconto creato con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/codicisconto?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento della collezione: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/codicisconto?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/codicisconto?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/codicisconto');
        exit;
    }
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA CODICI SCONTO ---------------------------------------------------------------------------------------
function listaCodicisconto() {
    require '../../conn.php'; // Utilizza lo stesso file di connessione del DB
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>ID</th>'; 
    $html .= '<th>Codice</th>';
    $html .= '<th>Importo</th>'; 
    $html .= '<th>Stato</th>'; 
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    $query = "SELECT * FROM codici_sconto ORDER BY id_codicesconto DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['stato'] == 'Valido') {
            $check = '<i class="fa-solid fa-circle text-success"></i>';
        } else if ($row['stato'] == 'Non Valido') {
            $check = '<i class="fa-solid fa-circle text-danger"></i>';
        } else {
            $check = 'NAN';
        }

        $html .= "<tr style='cursor: pointer;' onclick='apriModifica(" . $row['id_codicesconto'] . ")'>";
        $html .= "<td>#00" . htmlspecialchars($row['id_codicesconto'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['codicesconto'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['importo'], ENT_QUOTES) . "</td>";
        $html .= "<td>$check&nbsp;" . htmlspecialchars($row['stato'], ENT_QUOTES) . "</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA CODICE SCONTO ---------------------------------------------------------------------------------
function modificaCodicesconto($id_codicesconto) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID è valido
    if (!is_numeric($id_codicesconto)) {
        return "ID del codice sconto non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM codici_sconto WHERE id_codicesconto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_codicesconto);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Codice Sconto eliminato con successo."; // Potresti voler restituire qualcosa che il chiamante possa verificare
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione Codice Sconto eliminato: " . $stmt->error;
        }
    }

    // Processa la modifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        // Ottieni i dati del modulo
        $codicesconto = $_POST["codicesconto"];
        $importo = $_POST["importo"];
        $stato = $_POST["stato"];

        // Esegui la query di aggiornamento
        $query = "UPDATE codici_sconto SET codicesconto=?, importo=?, stato=?  WHERE id_codicesconto = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssi", $codicesconto, $importo, $stato, $id_codicesconto);
            if ($stmt->execute()) {
                $result = "Modifiche apportate con successo.";
            } else {
                $result = "Errore durante la modifica: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
        }
    }

    $conn->close();
    return $result;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI CODICE SCONTO ---------------------------------------------------------------------------------
function ottieniDettagliCodicesconto($id_codicesconto) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID  è valido
    if (!is_numeric($id_codicesconto)) {
        return "ID del codice sconto non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM codici_sconto WHERE id_codicesconto = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $id_codicesconto);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessun codice sconto trovato con l'ID specificato.";
    }

    // Estrai i dettagli 
    $dettagliCodicesconto = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli
    return $dettagliCodicesconto;
}
// ---------------------------------------------------------------------------------------------------------------------
// ListaClienti.php ----------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA CLIENTI ------------------------------------------------------------------------------------------
function listaClienti() {
    require '../../conn.php'; // Utilizza lo stesso file di connessione del DB
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>ID</th>'; 
    $html .= '<th>Nome</th>'; 
    $html .= '<th>Cognome</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Telefono</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    $query = "SELECT * FROM user_db ORDER BY id_utente DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr style='cursor: pointer;' onclick='apriModifica(" . $row['id_utente'] . ")'>";
        $html .= "<td>#00" . htmlspecialchars($row['id_utente'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['nome'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['cognome'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['email'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['telefono'], ENT_QUOTES) . "</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA Clienti ---------------------------------------------------------------------------------------
function aggiuntaClienti(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addCliente') {
        // Valori predefiniti
        $nome = 'Nuovo';
        $cognome = 'Cliente';
        $email = 'nuovo.cliente@mail.it';
        $telefono = '0000000000';
        $password = 'password';
    
        $query = "INSERT INTO user_db (nome, cognome, email, telefono, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssss", $nome, $cognome, $email, $telefono, $password);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Cliente aggiunto con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/clienti?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento del nuovo Cliente: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/clienti?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/clienti?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/clienti');
        exit;
    }
}
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI COLLEZIONE ---------------------------------------------------------------------------------------
function ottieniDettagliClienti($id_utente) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID della collezione è valido
    if (!is_numeric($id_utente)) {
        return "ID della collezione non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM user_db WHERE id_utente = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $id_utente);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessun cliente trovato con l'ID specificato.";
    }

    // Estrai i dettagli della collezione
    $dettagliClienti = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli della collezione
    return $dettagliClienti;
}

// ---------------------------------------------------------------------------------------------------------------------
// DettagliNegozio.php -------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA CLIENTI ---------------------------------------------------------------------------------------
function modificaClienti($id_utente){ 
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID è valido
    if (!is_numeric($id_utente)) {
        return "ID del Cliente non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM user_db WHERE id_utente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_utente);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Anagrafica Cliente eliminata con successo."; // Potresti voler restituire qualcosa che il chiamante possa verificare
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione della anagrafica cliente: " . $stmt->error;
        }
    }

    // Processa la modifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        // Ottieni i dati del modulo
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $password = $_POST["password"];

        // Esegui la query di aggiornamento
        $query = "UPDATE user_db SET nome=?, cognome=?, email=?, telefono=?, password=?  WHERE id_utente = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssssi", $nome, $cognome, $email, $telefono, $password, $id_utente);
            if ($stmt->execute()) {
                $result = "Modifiche apportate con successo.";
            } else {
                $result = "Errore durante la modifica: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
        }
    }

    $conn->close();
    return $result;
 }
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI CLIENTI ---------------------------------------------------------------------------------------
 function dettagliNegozio() {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    $resulting = '';
    $class = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Estrai i dati inviati tramite POST
        $identificatore = $_POST['identificatore'];
        $imprenditore = $_POST['imprenditore'];
        $impresa = $_POST['impresa'];
        $CF_fiscale = $_POST['CF_fiscale'];
        $IVA = $_POST['IVA'];
        $REA = $_POST['REA'];
        $via = $_POST['via'];
        $paese = $_POST['paese'];
        $cap = $_POST['cap'];
        $email_impresa = $_POST['email_impresa'];
        $pec = $_POST['pec'];
        $telefono_impresa = $_POST['telefono_impresa'];
        $capitale_sociale = $_POST['capitale_sociale'];
        $sitoweb = $_POST['sitoweb'];
        $nome_negozio = $_POST['nome_negozio'];
        $cosa_vuoi_vendere = $_POST['cosa_vuoi_vendere'];

        // Verifica l'esistenza del record
        $stmt = $conn->prepare("SELECT COUNT(*) FROM dettagli_negozio WHERE identificatore = ?");
        $stmt->bind_param("i", $identificatore);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Record esistente, aggiorna
            $stmt = $conn->prepare("UPDATE dettagli_negozio SET imprenditore=?, impresa=?, CF_fiscale=?, IVA=?, REA=?, via=?, paese=?, cap=?, email_impresa=?, pec=?, telefono_impresa=?, capitale_sociale=?, sitoweb=?, nome_negozio=?, cosa_vuoi_vendere=? WHERE identificatore = ?");
            $stmt->bind_param("sssssssssssssssi", $imprenditore, $impresa, $CF_fiscale, $IVA, $REA, $via, $paese, $cap, $email_impresa, $pec, $telefono_impresa, $capitale_sociale, $sitoweb, $nome_negozio, $cosa_vuoi_vendere, $identificatore);
        } else {
            // Record non esistente, inserisci
            $stmt = $conn->prepare("INSERT INTO dettagli_negozio (imprenditore, impresa, CF_fiscale, IVA, REA, via, paese, cap, email_impresa, pec, telefono_impresa, capitale_sociale, sitoweb, nome_negozio, cosa_vuoi_vendere, identificatore) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssi", $imprenditore, $impresa, $CF_fiscale, $IVA, $REA, $via, $paese, $cap, $email_impresa, $pec, $telefono_impresa, $capitale_sociale, $sitoweb, $nome_negozio, $cosa_vuoi_vendere, $identificatore);
        }

        // Esecuzione della query
        if ($stmt->execute()) {
            $resulting = "Record aggiornato con successo";
            $class = "text-success";
        } else {
            $resulting = "Errore: " . $stmt->error;
            $class = "text-danger";
        }

        $stmt->close();
    }

    $conn->close(); // Considera se è adeguato chiudere la connessione qui

    // Ritorna i risultati come array associativo
    return array("message" => $resulting, "class" => $class);
}
// ---------------------------------------------------------------------------------------------------------------------
// ruoli.php -----------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI AMMINISTRATORI --------------------------------------------------------------------------------
function estraiDatiAmministratori() {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Prepara la query SQL
    $stmt = $conn->prepare("SELECT nome, cognome, ruolo, telefono, email FROM administrator WHERE ruolo IN ('Amministratore', 'Co-Amministratore', 'Collaboratore')");
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="container mt-5">';
    echo '<form>';
    
    // Controlla se ci sono amministratori nel risultato
    if ($result->num_rows > 0) {
        // Cicla su tutti gli amministratori trovati
        while ($row = $result->fetch_assoc()) {
            // Card Bootstrap per ogni amministratore
            echo '<div class="card mb-4 shadow-sm">';
            echo '<div class="card-header bg-dark text-white">Dettagli Amministratore</div>';
            echo '<div class="card-body">';
            
            // Nome e Cognome in una linea con titolo
            echo '<h5 class="card-title">' . htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']) . '</h5>';
            
            // Ruolo in un badge per dargli risalto
            echo '<h6 class="mb-2"><span class="badge bg-secondary">' . htmlspecialchars($row['ruolo']) . '</span></h6>';
            
            // Email e Telefono come dettagli informativi
            echo '<p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p class="card-text"><strong>Telefono:</strong> ' . htmlspecialchars($row['telefono']) . '</p>';
            
            echo '</div>'; // Chiusura card-body
            echo '</div>'; // Chiusura card
        }
    } else {
        echo "Nessun amministratore trovato.";
    }
    
    echo '</form>';
    echo '</div>';        

    $stmt->close();
    $conn->close();
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI AMMINISTRATORI --------------------------------------------------------------------------------
function estraiDatiSviluppatori() {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Prepara la query SQL
    $stmt = $conn->prepare("SELECT nome, cognome, ruolo, telefono, email FROM administrator WHERE ruolo IN ('Developer', 'Designer', 'Marketing')");
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="container mt-5">';
    echo '<form>';
    
    // Controlla se ci sono amministratori nel risultato
    if ($result->num_rows > 0) {
        // Cicla su tutti gli amministratori trovati
        while ($row = $result->fetch_assoc()) {
            // Card Bootstrap per ogni amministratore
            echo '<div class="card mb-4 shadow-sm">';
            echo '<div class="card-header bg-danger text-white">Dettagli Sviluppatore</div>';
            echo '<div class="card-body">';
            
            // Nome e Cognome in una linea con titolo
            echo '<h5 class="card-title">' . htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']) . '</h5>';
            
            // Ruolo in un badge per dargli risalto
            echo '<h6 class="mb-2"><span class="badge bg-secondary">' . htmlspecialchars($row['ruolo']) . '</span></h6>';
            
            // Email e Telefono come dettagli informativi
            echo '<p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p class="card-text"><strong>Telefono:</strong> ' . htmlspecialchars($row['telefono']) . '</p>';
            
            echo '</div>'; // Chiusura card-body
            echo '</div>'; // Chiusura card
        }
    } else {
        echo "Nessun sviluppatore trovato.";
    }
    
    echo '</form>';
    echo '</div>';        

    $stmt->close();
    $conn->close();
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA ADMINISTRATOR ---------------------------------------------------------------------------------
function inviaEmailAggiuntaAdmin(){

    // Recuperiamo i dati negozio
    $dettagli_negozio = stampaDettagli_negozio();
    $sitoweb = '';
    $nome_negozio = '';
    foreach ($dettagli_negozio as $dettaglio) {
        $sitoweb = $dettaglio['sitoweb'];
        $nome_negozio = $dettaglio['nome_negozio'];
        break; // Suppongo che ci sia un solo negozio, quindi interrompiamo il ciclo dopo il primo
    }


require ('../../php_email.php'); // Includi lo script con la funzione send_mail

// Controlla se i dati sono stati inviati tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assicurati che sia nome che email siano presenti
    if(isset($_POST['nome']) && isset($_POST['email'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        // Impostazioni del template email

        $oggetto = 'LinkBay - Invito di Collaborazione';
        $template = file_get_contents('../../templates/email_collabora.html'); // Assicurati che il percorso al file sia corretto
        $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}'], [$nome, $nome_negozio, $sitoweb], $template); // Nel template usa {{ nome }} per passare i valori

        // Invia l'email all'utente con le istruzioni per resettare la password
        send_mail($email, $oggetto, $messaggio);

        header('Location: aggiunta_administrator');
        
        } else {
            echo "Errore nella lettura del template dell'email";
        }
    } else {
        header('Location: aggiunta_administrator');
    }

}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA RUOLI ADMINISTRATOR ---------------------------------------------------------------------------------
function visualizzaRuoliAdmin() {
    // Connessione al database
    require('../../conn.php');
    
    // Inizializza l'HTML del contenuto
    $html = '<div class="container mt-5">
    <table class="table">
    <thead>
    <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Cognome</th>
    <th>Telefono</th>
    <th>Ruolo</th>
    <th>Modifica</th>
    </tr>
    </thead>
    <tbody>';

    // Query per ottenere tutti gli amministratori
    $query_admin = "SELECT * FROM administrator";
    $result_admin = mysqli_query($conn, $query_admin);
    if ($result_admin) {
        while ($row_admin = mysqli_fetch_assoc($result_admin)) {
            // Estrazione dati di ogni amministratore
            $id_admin = $row_admin['id_admin'];
            $nome_admin = $row_admin['nome'];
            $cognome_admin = $row_admin['cognome'];
            $telefono_admin = $row_admin['telefono'];
            $ruolo_admin = $row_admin['ruolo'];
            // Inserimento dati nella tabella HTML
            $html .= '<tr>
            <td>' . $id_admin . '</td>
            <td>' . $nome_admin . '</td>';
            $html .= '<td>' . $cognome_admin . '</td><td>' . $telefono_admin . '</td>';
            $html .= '<td>' . $ruolo_admin . '</td><td>';
            $html .= '<form method="POST" action="administrator_modifica">';  // Sostituisci 'administrator_modifica.php' con il percorso effettivo dello script che gestisce il cambio del ruolo
            $html .= '<input type="hidden" name="id_admin" value="' . $id_admin . '">';
            $html .= '<select name="ruolo" onchange="this.form.submit()">';
            $html .= '<option value="Seleziona">Seleziona</option>';  
            $html .= '<option value="Amministratore">Amministratore</option>'; 
            $html .= '<option value="Co-Amministratore">Co-Amministratore</option>';
            $html .= '<option value="Collaboratore">Collaboratore</option>';
            $html .= '<option value="Developer">Developer</option>';
            $html .= '<option value="Marketing">Marketing</option>';
            $html .= '<option value="Designer">Designer</option>';
            $html .= '</select>';
            $html .= '</form>';
            $html .= '</td></tr>';
        }
    }

    $html .= '</tbody></table></div>';
    mysqli_close($conn); // Chiudi la connessione al database
    
    return $html;
}
function modificaRuoliAdmin(){
    // Connessione al database
    require('../../conn.php');
    
    // Controlla se i dati sono stati inviati tramite POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['id_admin']) && isset($_POST['ruolo'])) {
            // Pulisci i dati di input per evitare attacchi di iniezione SQL
            $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
            $ruolo = mysqli_real_escape_string($conn, $_POST['ruolo']);
    
            // Costruisci la query SQL per aggiornare il ruolo dell'amministratore
            $query = "UPDATE administrator SET ruolo='$ruolo' WHERE id_admin='$id_admin'";
    
            // Esegui la query
            if(mysqli_query($conn, $query)) {
                // Reindirizzamento a una pagina di conferma o di successo, o dove preferisci
                header('Location: aggiunta_administrator');
                exit;
            } else {
                // Gestisci l'errore - per esempio stampando un messaggio di errore
                echo "Errore nell'aggiornamento del database: " . mysqli_error($conn);
            }
        } else {
            // Gestisci il caso in cui non tutti i dati necessari sono stati inviati
            echo "Dati del form incompleti";
        }
    
        // Chiudi la connessione al database
        mysqli_close($conn);
    } else {
        // Gestisci il caso in cui il form non sia stato inviato con il metodo POST
        echo "Metodo della richiesta non valido";
    }
    
}
// ---------------------------------------------------------------------------------------------------------------------
// Pagamenti.php ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER PAGAMENTI E MODIFICA ---------------------------------------------------------------------------------------
function getPaymentProviderDetailsAndUpdate($conn, &$messaggio_risultato) {
    $provider = isset($_GET['provider']) ? $_GET['provider'] : null;

    if ($provider === null) {
        echo 'Provider non trovato nel Database';
        exit;
    }

    
    $query_pay = "SELECT * FROM payment_systems WHERE provider = ?";
    $stmt = $conn->prepare($query_pay);
    if ($stmt) {
        $stmt->bind_param("s", $provider);
        $stmt->execute();
        $result_set = $stmt->get_result();
        if ($result_set->num_rows == 1) {
            $row = $result_set->fetch_assoc();
        } else {
            echo 'Errore 404: Provider non trovato.';
            exit;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Errore nella preparazione della query: " . $conn->error . "');</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $client_id = $_POST["client_id"];
        $secret_key = $_POST["secret_key"];
        $environment = $_POST["environment"];
        $status = $_POST["status"];
        $provider = $_POST["provider"];

        $query_pay = "UPDATE payment_systems SET client_id=?, secret_key=?, environment=?, status=? WHERE provider = ?";
        $stmt = $conn->prepare($query_pay);
        if ($stmt) {
            $stmt->bind_param("sssss", $client_id, $secret_key, $environment, $status, $provider);
            if ($stmt->execute()) {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?provider=' . urlencode($provider));
                $messaggio_risultato = "<div class='alert alert-success' role='alert'>Dati Salvati con successo! </div>";
            } else {
                $messaggio_risultato = "<div class='alert alert-danger' role='alert'>Errore durante la modifica del pagamento: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            $messaggio_risultato = "<div class='alert alert-danger' role='alert'>Errore nella preparazione della query: " . $conn->error . "</div>";
        }
    }
    return $row; // Ritorna i dettagli del provider per l'uso nella pagina.
}
// ---------------------------------------------------------------------------------------------------------------------
// Spedizioni.php ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA SPEDIZIONI ---------------------------------------------------------------------------------------
function listaSpedizioni() {
    require '../../conn.php'; // Utilizza lo stesso file di connessione del DB
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>ID</th>'; 
    $html .= '<th>Tipo</th>';
    $html .= '<th>Prezzo</th>'; 
    $html .= '<th>Peso</th>'; 
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    $query = "SELECT * FROM spedizioni ORDER BY id_spedizione DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        $html .= "<tr style='cursor: pointer;' onclick='apriModifica(" . $row['id_spedizione'] . ")'>";
        $html .= "<td>#00" . htmlspecialchars($row['id_spedizione'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['tipo_spedizione'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['prezzo_spedizione'], ENT_QUOTES) . "€</td>";
        $html .= "<td>&nbsp;" . htmlspecialchars($row['peso_spedizione'], ENT_QUOTES) . "Kg</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER AGGIUNTA SPEDIZIONE ---------------------------------------------------------------------------------------
function aggiunta_spedizione(){
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Inizializzo una variabile per il messaggio di feedback
    $feedback = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addSpedizione') {
        // Valori predefiniti
        $tipo_spedizione = 'Nuova Spedizione';
        $prezzo_spedizione = '0';
        $peso_spedizione = '0';
    
        $query = "INSERT INTO spedizioni (tipo_spedizione, prezzo_spedizione, peso_spedizione) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sss", $tipo_spedizione, $prezzo_spedizione, $peso_spedizione);
            $result = $stmt->execute();
            if ($result) {
                $feedback = "Spedizione creata con successo.";
                // Reindirizza alla pagina desiderata con un messaggio di successo
                header('Location: ../ui/spedizioni?success=' . urlencode($feedback));
                exit;
            } else {
                $feedback = "Errore durante l'inserimento della spedizione: " . $stmt->error;
                // Reindirizza alla pagina desiderata con un messaggio di errore
                header('Location: ../ui/spedizioni?error=' . urlencode($feedback));
                exit;
            }
            $stmt->close();
        } else {
            $feedback = "Errore durante la preparazione della query: " . $conn->error;
            // Reindirizza alla pagina desiderata con un messaggio di errore
            header('Location: ../ui/spedizioni?error=' . urlencode($feedback));
            exit;
        }
        $conn->close();
    } else {
        // Se il metodo non è POST o l'azione non corrisponde, reindirizza l'utente
        header('Location: ../ui/spedizioni');
        exit;
    }
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA SPEDIZIONE ---------------------------------------------------------------------------------------
function modificaSpedizione($id_spedizione) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID è valido
    if (!is_numeric($id_spedizione)) {
        return "ID della spedizione non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM spedizioni WHERE id_spedizione = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_spedizione);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Spedizione eliminata con successo."; // Potresti voler restituire qualcosa che il chiamante possa verificare
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione della spedizione: " . $stmt->error;
        }
    }

    // Processa la modifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        // Ottieni i dati del modulo
        $tipo_spedizione = $_POST["tipo_spedizione"];
        $prezzo_spedizione = $_POST["prezzo_spedizione"];
        $peso_spedizione = $_POST["peso_spedizione"];

        // Esegui la query di aggiornamento
        $query = "UPDATE spedizioni SET tipo_spedizione=?, prezzo_spedizione=?, peso_spedizione=?  WHERE id_spedizione = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssi", $tipo_spedizione, $prezzo_spedizione, $peso_spedizione, $id_spedizione);
            if ($stmt->execute()) {
                $result = "Modifiche apportate con successo.";
            } else {
                $result = "Errore durante la modifica: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
        }
    }

    $conn->close();
    return $result;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI SPEDIZIONE ---------------------------------------------------------------------------------------
function ottieniDettagliSpedizione($id_spedizione) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID  è valido
    if (!is_numeric($id_spedizione)) {
        return "ID della spedizione non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM spedizioni WHERE id_spedizione = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $id_spedizione);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessuna Spedizione trovata con l'ID specificato.";
    }

    // Estrai i dettagli 
    $dettagliSpedizione = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli
    return $dettagliSpedizione;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI LEADS ---------------------------------------------------------------------------------------
function listaLeads() {
    require '../../conn.php'; // Utilizza lo stesso file di connessione del DB
    $html = '<div class="container mt-5">';
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-hover" id="myTable">';
    $html .= '<thead class="table-dark">';
    $html .= '<tr>';
    $html .= '<th>ID</th>'; 
    $html .= '<th>Nome</th>'; 
    $html .= '<th>Email</th>';
    $html .= '<th>Telefono</th>';
    $html .= '<th>Messaggio</th>';
    $html .= '<th>Data</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="table-light">';

    $query = "SELECT * FROM leads ORDER BY lead DESC";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr style='cursor: pointer;' onclick='apriModifica(" . $row['lead'] . ")'>";
        $html .= "<td>#00" . htmlspecialchars($row['lead'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['nome'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['email'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['telefono'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['messaggio'], ENT_QUOTES) . "</td>";
        $html .= "<td>" . htmlspecialchars($row['data_rec'], ENT_QUOTES) . "</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA CLIENTI ---------------------------------------------------------------------------------------
function modificaLead($lead){ 
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID è valido
    if (!is_numeric($lead)) {
        return "ID del Lead non valido.";
    }

    $result = ""; // Variabile per i messaggi di errore o successo

    // Controlla se è stata richiesta l'eliminazione 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM leads WHERE lead = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $lead);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Anagrafica Lead eliminata con successo."; // Potresti voler restituire qualcosa che il chiamante possa verificare
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione della anagrafica Lead: " . $stmt->error;
        }
    }

    // Processa la modifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        // Ottieni i dati del modulo
        $nome = $_POST["nome"];
        $messaggio = $_POST["messaggio"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $data_rec = $_POST["data_rec"];

        // Esegui la query di aggiornamento
        $query = "UPDATE leads SET nome=?, email=?, telefono=?, messaggio=?, data_rec=?  WHERE lead = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssssi", $nome, $email, $telefono, $messaggio, $data_rec, $lead);
            if ($stmt->execute()) {
                $result = "Modifiche apportate con successo.";
            } else {
                $result = "Errore durante la modifica: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $result = "Errore nella preparazione della query: " . $conn->error;
        }
    }

    $conn->close();
    return $result;
 }
// ------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI COLLEZIONE ---------------------------------------------------------------------------------------
function ottieniDettagliLead($lead) {
    require '../../conn.php'; // Assicurati che il percorso sia corretto

    // Verifica se l'ID della collezione è valido
    if (!is_numeric($lead)) {
        return "ID del Lead non valido.";
    }

    // Prepara la query SQL
    $query = "SELECT * FROM leads WHERE lead = ?";
    $stmt = $conn->prepare($query);

    // Verifica se la dichiarazione è stata preparata correttamente
    if ($stmt === false) {
        return "Errore nella preparazione della query: " . $conn->error;
    }

    // Associa i parametri alla dichiarazione preparata
    $stmt->bind_param('i', $lead);

    // Esegui la dichiarazione preparata
    $stmt->execute();

    // Ottieni il risultato
    $result = $stmt->get_result();

    // Verifica se sono stati trovati risultati
    if ($result->num_rows == 0) {
        return "Nessun Lead trovato con l'ID specificato.";
    }

    // Estrai i dettagli della collezione
    $dettagliLead = $result->fetch_assoc();

    // Chiudi la dichiarazione e la connessione
    $stmt->close();
    $conn->close();

    // Restituisci i dettagli della collezione
    return $dettagliLead;
}
// ---------------------------------------------------------------------------------------------------------------------
// Marketing.php ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER GESTIONE SEO ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// --------------------------------------------Autore: Alessio Quagliara------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------Spotex SRL-------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// -----------------------------------------LinkBay CMS Tutti i diritti riservati---------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// Funzioni Esterne ----------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// --------------------------------------------Autore: Alessio Quagliara------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------Spotex SRL-------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// -----------------------------------------LinkBay CMS Tutti i diritti riservati---------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER VISUALIZZARE LA HOMEPAGE -------------------------------------------------------------------------------
function customPage($namePage) {
    require 'conn.php'; // Include la connessione al database
    
    // Preparazione della query SQL utilizzando il parametro name_page per selezionare il contenuto specifico
    $stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $namePage); // Associa il parametro name_page alla tua query
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['content']; // Stampa il contenuto specifico della pagina
    } else {
        echo "
        <style>
            /* Stili per rendere la sezione full screen e centrare il contenuto */
            .construction-section {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: black; /* Sfondo chiaro, cambia a seconda delle tue preferenze */
                text-align: center;
            }

            /* Aggiungi qui ulteriori stili personalizzati se necessario */
        </style>
        <section class='construction-section text-light'>
            <img src='admin/materials/logo_sidebar.png' alt='Logo LinkBay' width='200'> 
            <h1 class='mt-3'>Sito Web in Costruzione</h1>
            <p>Stiamo lavorando per portarti una nuova esperienza incredibile. Presto sarà disponibile la seguente pagina: ". htmlspecialchars($namePage)."!</p>
        </section>
        "; // Sanitizza l'output per evitare XSS
    }
    
    $stmt->close();
    $conn->close();
}




?>