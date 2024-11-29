<?php

require 'conn.php';
$result = '';

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
function loggato()
{
    session_start();

    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
        header("Location: ../index");
        exit;
    }

    $timeout = 1200; // 20 minuti di timeout

    if (isset($_SESSION['ultimo_accesso'])) {
        $tempo_trascorso = time() - $_SESSION['ultimo_accesso'];

        if ($tempo_trascorso > $timeout) {
            session_unset(); 
            session_destroy(); 

            header("Location: ../logout");
            exit;
        }
    }

    $_SESSION['ultimo_accesso'] = time();
}

// Funzione Impostazioni Negozio ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

$resolution = "'width=1920,height=1080'";

// Funzione di Login ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function login()
{
    session_start(); 

    if (isset($_SESSION['loggato']) && $_SESSION['loggato'] === true) {
        header("Location: ui/homepage");
        exit;
    }

    $login_error = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require '../conn.php';

        $email = strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
        $password = $_POST['password']; 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $login_error = "Formato email non valido.";
        } else {
            $sql = "SELECT id_admin, nome, cognome, ruolo, email, telefono, password FROM administrator WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggato'] = true;
                    $_SESSION['id_admin'] = $row['id_admin'];
                    $_SESSION['nome'] = $row['nome'];
                    $_SESSION['cognome'] = $row['cognome'];
                    $_SESSION['ruolo'] = $row['ruolo'];
                    $_SESSION['telefono'] = $row['telefono'];
                    $_SESSION['email'] = $row['email'];

                    header("Location: ui/homepage");
                    exit;
                } else {
                    $login_error = "Credenziali non valide. Riprova.";
                }
            } else {
                $login_error = "Utente non trovato. Riprova.";
            }

            $stmt->close(); 
        }

        $conn->close(); 
    }

    return $login_error; 
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Logout ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function logout()
{
    session_start();
    session_destroy();
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Registrazione Utente ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

function sign_in()
{
    require ('../conn.php');
    
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Registrazione ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------


function subscribe()
{
    require('../public/phpmailer.php');
    require '../conn.php';

    $query_dettagli_negozio = "SELECT * FROM dettagli_negozio";
    $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);
    if ($dettagli = mysqli_fetch_assoc($result_dettagli_negozio)) {
        $nome_negozio = $dettagli['nome_negozio'];
    }

    $host = $_SERVER['HTTP_HOST'];
    $sitoweb = (string) $host;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST['nome']);
        $cognome = trim($_POST['cognome']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $telefono = trim($_POST['telefono']);
        $ruolo = 'Amministratore';
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("<p class='text-red-500'>Formato email non valido.</p>");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO administrator (nome, cognome, ruolo, email, telefono, password) VALUES (?, ?,?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("<p class='text-red-500'>Errore nella preparazione della query: " . $conn->error . "</p>");
        }

        $stmt->bind_param("ssssss", $nome, $cognome, $ruolo, $email, $telefono, $hashed_password);

        if ($stmt->execute()) {
            $email_user = $email;
            $oggetto = 'Registrazione a LinkBay';
            $template = file_get_contents('../templates/email_subscribed.html'); 
            $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}', '{{id_admin}}'], [$nome, $nome_negozio, $sitoweb, $id_admin], $template); // Nel template usa {{ nome }} per passare i valori

            send_mail($email_user, $oggetto, $messaggio);

            $messaggio = "Registrazione effettuata con successo";
            $url = "index?messaggio=" . urlencode($messaggio);
            header('location:' . $url);
        } else {
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: login");
        exit;
    }
}

// ---------------------------------------------------------------------------------------------------------------------
// Funzione di Ripristino Password ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function ripristina()
{
    require('../public/phpmailer.php');
    $errore = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require('../conn.php');
        $query_dettagli_negozio = "SELECT * FROM dettagli_negozio";
        $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);
        if ($dettagli = mysqli_fetch_assoc($result_dettagli_negozio)) {
            $nome_negozio = $dettagli['nome_negozio'];
        }
        $host = $_SERVER['HTTP_HOST'];
        $sitoweb = (string) $host;
        $admin_email = $_POST['email'];

        $stmt = $conn->prepare("SELECT * FROM administrator WHERE email = ?");
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $id_admin = $row['id_admin'];
            $nome = $row['nome'];

            $template = file_get_contents('../templates/email_pass.html');
            $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}', '{{id_admin}}'], [$nome, $nome_negozio, $sitoweb, $id_admin], $template); // Nel template usa {{ nome }} per passare i valori

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
function update_pass()
{
    include '../conn.php'; 

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
                    $response['errore'] = ""; 
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
// FUNZIONE PER ASSISTENZA ORE ---------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function stampaOreAssistenza()
{
    echo '        
    <div class="progress">
    <div class="progress-bar bg-danger" role="progressbar" style="width: 5%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
    <div class="progress-number fw-bold">&nbsp; 1 ore disponibili</div>
    </div>
    ';
}



// ---------------------------------------------------------------------------------------------------------------------
// HomePage.php (dashboard) ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LE VISITE DEL SITO ---------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function visite()
{
    require '../../conn.php'; 

    $totalVisitsQuery = "SELECT COUNT(*) as total FROM visitatori";
    $totalResult = $conn->query($totalVisitsQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalVisits = $totalRow['total'];

    $monthlyVisitsQuery = "SELECT YEAR(data_visita) as year, MONTH(data_visita) as month, COUNT(*) as visits FROM visitatori GROUP BY YEAR(data_visita), MONTH(data_visita) ORDER BY YEAR(data_visita) DESC, MONTH(data_visita) DESC";
    $monthlyResult = $conn->query($monthlyVisitsQuery);

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

    $conn->close();

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER POP DETTAGLI DEL NEGOZIO ---------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function dettagli_negozio()
{
    require '../../conn.php'; 

    $query = "SELECT COUNT(*) as total FROM dettagli_negozio";
    $result = mysqli_query($conn, $query);

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
        $titolo = 'Errore';
        $descrizione = 'Errore nell\'esecuzione della query: ' . mysqli_error($conn);
    }

    mysqli_close($conn); 

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

    return $html;
}
//---------------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER POPOLARE I DETTAGLI DEL NEGOZIO -----------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------
function stampaDettagli_negozio()
{
    require '../../conn.php';  

    $query_dettagli_negozio = "SELECT * FROM dettagli_negozio";
    $result_dettagli_negozio = mysqli_query($conn, $query_dettagli_negozio);

    $dettagli = [];

    if ($result_dettagli_negozio) {
        while ($row_dettagli_negozio = mysqli_fetch_assoc($result_dettagli_negozio)) {
            $dettagli[] = $row_dettagli_negozio;
        }
    }

    mysqli_close($conn); 

    return $dettagli;
}

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER VISUALIZZARE LEADS E CLIENTI ---------------------------------------------------------------------------
function visualizzaClientiELeads()
{
    require '../../conn.php';

    $totalClientsQuery = "SELECT COUNT(*) as totalClients FROM user_db";
    $totalClientsResult = $conn->query($totalClientsQuery);
    $totalClientsRow = $totalClientsResult->fetch_assoc();
    $totalClients = $totalClientsRow['totalClients'];

    $totalLeadsQuery = "SELECT COUNT(*) as totalLeads FROM leads";
    $totalLeadsResult = $conn->query($totalLeadsQuery);
    $totalLeadsRow = $totalLeadsResult->fetch_assoc();
    $totalLeads = $totalLeadsRow['totalLeads'];

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

    $conn->close();

    return $html;
}
// ---------------------------------------------------------------------------------------------------------------------
// ListaClienti.php ----------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER LISTA CLIENTI ------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function listaClienti()
{
    require '../../conn.php'; 
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
// ---------------------------------------------------------------------------------------------------------------------
function aggiuntaClienti()
{
    require '../../conn.php'; 

    $feedback = '';

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
            header('Location: ../ui/clienti?success=' . urlencode($feedback));
            exit;
        } else {
            $feedback = "Errore durante l'inserimento del nuovo Cliente: " . $stmt->error;
            header('Location: ../ui/clienti?error=' . urlencode($feedback));
            exit;
        }
        $stmt->close();
    } else {
        $feedback = "Errore durante la preparazione della query: " . $conn->error;
        header('Location: ../ui/clienti?error=' . urlencode($feedback));
        exit;
    }
}
// ---------------------------------------------------------------------------------------------------------------------
// DettagliNegozio.php -------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER MODIFICA CLIENTI ---------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function modificaClienti($id_utente)
{
    require '../../conn.php'; 

    if (!is_numeric($id_utente)) {
        return "ID del Cliente non valido.";
    }

    $result = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM user_db WHERE id_utente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_utente);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Anagrafica Cliente eliminata con successo."; 
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione della anagrafica cliente: " . $stmt->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $password = $_POST["password"];

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
// ---------------------------------------------------------------------------------------------------------------------
function dettagliNegozio()
{
    require '../../conn.php'; 

    $resulting = '';
    $class = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $stmt = $conn->prepare("SELECT COUNT(*) FROM dettagli_negozio WHERE identificatore = ?");
        $stmt->bind_param("i", $identificatore);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $stmt = $conn->prepare("UPDATE dettagli_negozio SET imprenditore=?, impresa=?, CF_fiscale=?, IVA=?, REA=?, via=?, paese=?, cap=?, email_impresa=?, pec=?, telefono_impresa=?, capitale_sociale=?, sitoweb=?, nome_negozio=?, cosa_vuoi_vendere=? WHERE identificatore = ?");
            $stmt->bind_param("sssssssssssssssi", $imprenditore, $impresa, $CF_fiscale, $IVA, $REA, $via, $paese, $cap, $email_impresa, $pec, $telefono_impresa, $capitale_sociale, $sitoweb, $nome_negozio, $cosa_vuoi_vendere, $identificatore);
        } else {
            $stmt = $conn->prepare("INSERT INTO dettagli_negozio (imprenditore, impresa, CF_fiscale, IVA, REA, via, paese, cap, email_impresa, pec, telefono_impresa, capitale_sociale, sitoweb, nome_negozio, cosa_vuoi_vendere, identificatore) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssi", $imprenditore, $impresa, $CF_fiscale, $IVA, $REA, $via, $paese, $cap, $email_impresa, $pec, $telefono_impresa, $capitale_sociale, $sitoweb, $nome_negozio, $cosa_vuoi_vendere, $identificatore);
        }

        if ($stmt->execute()) {
            $resulting = "Record aggiornato con successo";
            $class = "text-success";
        } else {
            $resulting = "Errore: " . $stmt->error;
            $class = "text-danger";
        }

        $stmt->close();
    }

    $conn->close(); 

    return array("message" => $resulting, "class" => $class);
}
// ---------------------------------------------------------------------------------------------------------------------
// ruoli.php -----------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI AMMINISTRATORI --------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function estraiDatiAmministratori()
{
    require '../../conn.php'; 

    // Prepara la query SQL
    $stmt = $conn->prepare("SELECT nome, cognome, ruolo, telefono, email FROM administrator WHERE ruolo IN ('Amministratore', 'Co-Amministratore', 'Collaboratore')");
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="container mt-5">';
    echo '<form>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card mb-4 shadow-sm">';
            echo '<div class="card-header bg-dark text-white">Dettagli Amministratore</div>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']) . '</h5>';
            echo '<h6 class="mb-2"><span class="badge bg-secondary">' . htmlspecialchars($row['ruolo']) . '</span></h6>';
            echo '<p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p class="card-text"><strong>Telefono:</strong> ' . htmlspecialchars($row['telefono']) . '</p>';
            echo '</div>'; 
            echo '</div>'; 
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
// ---------------------------------------------------------------------------------------------------------------------
function estraiDatiSviluppatori()
{
    require '../../conn.php'; 

    $stmt = $conn->prepare("SELECT nome, cognome, ruolo, telefono, email FROM administrator WHERE ruolo IN ('Developer', 'Designer', 'Marketing')");
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="container mt-5">';
    echo '<form>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card mb-4 shadow-sm">';
            echo '<div class="card-header bg-danger text-white">Dettagli Sviluppatore</div>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nome']) . ' ' . htmlspecialchars($row['cognome']) . '</h5>';
            echo '<h6 class="mb-2"><span class="badge bg-secondary">' . htmlspecialchars($row['ruolo']) . '</span></h6>';
            echo '<p class="card-text"><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p class="card-text"><strong>Telefono:</strong> ' . htmlspecialchars($row['telefono']) . '</p>';
            echo '</div>'; 
            echo '</div>'; 
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
// ---------------------------------------------------------------------------------------------------------------------
function inviaEmailAggiuntaAdmin()
{
    $dettagli_negozio = stampaDettagli_negozio();
    $sitoweb = '';
    $nome_negozio = '';
    foreach ($dettagli_negozio as $dettaglio) {
        $nome_negozio = $dettaglio['nome_negozio'];
        break;
    }

    $host = $_SERVER['HTTP_HOST'];
    $sitoweb = (string) $host;

    include('public/phpmailer_admin.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['nome']) && isset($_POST['email'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];

            $oggetto = 'LinkBay - Invito di Collaborazione';
            $template = file_get_contents('../../templates/email_collabora.html');
            $messaggio = str_replace(['{{nome}}', '{{nome_negozio}}', '{{sitoweb}}'], [$nome, $nome_negozio, $sitoweb], $template);

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
// FUNZIONE PER MODIFICA RUOLI ADMINISTRATOR ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function visualizzaRuoliAdmin()
{
    require('../../conn.php');

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

    $query_admin = "SELECT * FROM administrator";
    $result_admin = mysqli_query($conn, $query_admin);
    if ($result_admin) {
        while ($row_admin = mysqli_fetch_assoc($result_admin)) {
            $id_admin = $row_admin['id_admin'];
            $nome_admin = $row_admin['nome'];
            $cognome_admin = $row_admin['cognome'];
            $telefono_admin = $row_admin['telefono'];
            $ruolo_admin = $row_admin['ruolo'];

            $html .= '<tr>
            <td>' . $id_admin . '</td>
            <td>' . $nome_admin . '</td>';
            $html .= '<td>' . $cognome_admin . '</td><td>' . $telefono_admin . '</td>';
            $html .= '<td>' . $ruolo_admin . '</td><td>';
            $html .= '<form method="POST" action="administrator_modifica">';  
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
    mysqli_close($conn); 

    return $html;
}
function modificaRuoliAdmin()
{
    require('../../conn.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id_admin']) && isset($_POST['ruolo'])) {
            $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
            $ruolo = mysqli_real_escape_string($conn, $_POST['ruolo']);

            $query = "UPDATE administrator SET ruolo='$ruolo' WHERE id_admin='$id_admin'";

            if (mysqli_query($conn, $query)) {
                header('Location: aggiunta_administrator');
                exit;
            } else {
                echo "Errore nell'aggiornamento del database: " . mysqli_error($conn);
            }
        } else {
            echo "Dati del form incompleti";
        }

        mysqli_close($conn);
    } else {
        echo "Metodo della richiesta non valido";
    }
}
// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER DETTAGLI LEADS ---------------------------------------------------------------------------------------
function listaLeads()
{
    require '../../conn.php'; 
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
function modificaLead($lead)
{
    require '../../conn.php';

    if (!is_numeric($lead)) {
        return "ID del Lead non valido.";
    }

    $result = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $query = "DELETE FROM leads WHERE lead = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $lead);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return "Anagrafica Lead eliminata con successo."; 
        } else {
            $stmt->close();
            $conn->close();
            return "Errore durante l'eliminazione della anagrafica Lead: " . $stmt->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
        $nome = $_POST["nome"];
        $messaggio = $_POST["messaggio"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $data_rec = $_POST["data_rec"];

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
// ---------------------------------------------------------------------------------------------------------------------
// Marketing.php -------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER GESTIONE SEO -------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------

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
// FUNZIONE PER VISUALIZZARE LE PAGINE -------------------------------------------------------------------------------
function customPage($namePage)
{
    require 'conn.php'; 

    // Recupera il contenuto della pagina specificata dal database
    $stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $namePage); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se la pagina esiste, stampa il contenuto
        $row = $result->fetch_assoc();
        echo $row['content']; 
    } else {
        // Se la pagina non esiste, mostra una schermata "In costruzione"
        echo "
        <style>
            /* Stili per rendere la sezione full screen e centrare il contenuto */
            .construction-section {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: black; /* Sfondo scuro */
                text-align: center;
            }

            /* Aggiungi qui ulteriori stili personalizzati se necessario */
        </style>
        <section class='construction-section text-light'>
            <img src='admin/materials/logo_sidebar.png' alt='Logo LinkBay' width='200'> 
            <h1 class='mt-3'>Sito Web in Costruzione</h1>
            <p>Stiamo lavorando per portarti una nuova esperienza incredibile. Presto sarà disponibile la seguente pagina: " . htmlspecialchars($namePage) . "!</p>
        </section>
        "; 
    }

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();
}

// ---------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER VISUALIZZARE LA NAVBAR ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
function customNav()
{
    require 'conn.php';
    $standard = 'navbar';

    $stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $standard); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $content = $row['content']; 

        // Stampa direttamente il contenuto senza elaborazioni aggiuntive
        echo $content;
    } else {
        // Nessun contenuto trovato, non stampa nulla
        echo "";
    }

    // Chiude lo statement e la connessione al database
    $stmt->close();
    $conn->close();
}


// -------------------------------------------------------------------------------------------------------------------
// FUNZIONE PER VISUALIZZARE LA NAVBAR -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------
function customFooter()
{
    require 'conn.php';
    $standard = 'footer';
    
    $stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $standard); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['content']; 
    } else {
        echo "";
    }
    
    $stmt->close();
    $conn->close();
}
// -------------------------------------------------------------------------------------------------------------------
// CLASSE PER EVENTI -------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------
class EventoManager {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Ottieni tutti gli eventi
    public function getEventi($status = null) {
        $query = "SELECT * FROM eventi";
        if ($status !== null) {
            $query .= " WHERE pubblicato = ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($status !== null) {
            $stmt->bind_param('i', $status); // 0 = bozza, 1 = pubblicato
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ottieni un singolo evento per ID
    public function getEventoById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM eventi WHERE id_evento = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Aggiungi un nuovo evento
    public function aggiungiEvento($titolo, $descrizione, $immagine, $categoria, $dataEvento, $oraEvento, $pubblicato) {
        $stmt = $this->conn->prepare("
            INSERT INTO eventi (titolo, descrizione, immagine, categoria, data_evento, ora_evento, pubblicato)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('ssssssi', $titolo, $descrizione, $immagine, $categoria, $dataEvento, $oraEvento, $pubblicato);
        return $stmt->execute();
    }

    // Modifica un evento esistente
    public function modificaEvento($id, $titolo, $descrizione, $immagine, $categoria, $dataEvento, $oraEvento, $pubblicato) {
        $stmt = $this->conn->prepare("
            UPDATE eventi 
            SET titolo = ?, descrizione = ?, immagine = ?, categoria = ?, data_evento = ?, ora_evento = ?, pubblicato = ?
            WHERE id_evento = ?
        ");
        $stmt->bind_param('ssssssii', $titolo, $descrizione, $immagine, $categoria, $dataEvento, $oraEvento, $pubblicato, $id);
        return $stmt->execute();
    }

    // Elimina un evento
    public function eliminaEvento($id) {
        $stmt = $this->conn->prepare("DELETE FROM eventi WHERE id_evento = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}

class ChatManager {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Ottieni tutti i messaggi per un utente
    public function getMessaggiPerUtente($senderName) {
        $stmt = $this->conn->prepare("
            SELECT * FROM chat_messages 
            WHERE sender_name = ? OR sender_type = 'admin' 
            ORDER BY created_at ASC
        ");
        $stmt->bind_param('s', $senderName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Invia un messaggio
    public function inviaMessaggio($senderType, $senderName, $message) {
        $stmt = $this->conn->prepare("
            INSERT INTO chat_messages (sender_type, sender_name, message, created_at, is_read, is_read_admin)
            VALUES (?, ?, ?, NOW(), 0, 0)
        ");
        $stmt->bind_param('sss', $senderType, $senderName, $message);
        return $stmt->execute();
    }

    // Marca i messaggi come letti per un utente
    public function marcaMessaggiComeLetti($senderName) {
        $stmt = $this->conn->prepare("
            UPDATE chat_messages 
            SET is_read = 1 
            WHERE sender_name = ? AND sender_type = 'user'
        ");
        $stmt->bind_param('s', $senderName);
        return $stmt->execute();
    }

    // Marca i messaggi come letti dall'admin
    public function marcaMessaggiComeLettiAdmin($senderName) {
        $stmt = $this->conn->prepare("
            UPDATE chat_messages 
            SET is_read_admin = 1 
            WHERE sender_name = ? AND sender_type = 'admin'
        ");
        $stmt->bind_param('s', $senderName);
        return $stmt->execute();
    }

    // Controlla i messaggi non letti per un utente
    public function contaMessaggiNonLettiUtente($senderName) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as non_letti 
            FROM chat_messages 
            WHERE sender_name = ? AND sender_type = 'user' AND is_read = 0
        ");
        $stmt->bind_param('s', $senderName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Controlla i messaggi non letti dall'admin
    public function contaMessaggiNonLettiAdmin($senderName) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as non_letti 
            FROM chat_messages 
            WHERE sender_name = ? AND sender_type = 'admin' AND is_read_admin = 0
        ");
        $stmt->bind_param('s', $senderName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Elimina tutti i messaggi di un utente
    public function eliminaMessaggiUtente($senderName) {
        $stmt = $this->conn->prepare("
            DELETE FROM chat_messages 
            WHERE sender_name = ?
        ");
        $stmt->bind_param('s', $senderName);
        return $stmt->execute();
    }
}