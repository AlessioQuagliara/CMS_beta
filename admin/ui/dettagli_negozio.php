<?php 
require ('../../app.php');
loggato();
require '../../conn.php';
$risultato = dettagliNegozio(); // Chiamata alla funzione
if ($risultato) { // Controlla se c'è un risultato
    $messaggio_errore = "<div class='".$risultato["class"]."'>".$risultato["message"]."</div>";
};

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Dettagli Negozio</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'impostazioni'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-5">
        
    <p class="<?php echo $class; ?>"><?php echo $resulting; ?></p>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="p-3 mb-2 bg-light rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Dettagli Negozio</h4>
                <div class="btn-toolbar mb-2 mb-md-0">
                &nbsp;&nbsp;
                    <div class="btn-group me-2">
                        <button onclick="apriModifica()" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <?php  
          require '../../conn.php';
          $query = "SELECT * FROM dettagli_negozio LIMIT 1"; // Assicurati di ottenere solo una riga, o specifica un criterio
          $result = mysqli_query($conn, $query);
          
          if($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              // Assumi che $row contenga i dati desiderati
          } else {
              // Gestisci l'errore o l'assenza di dati
              $row = array(
              );
          }
          ?>
        <div class="row">
            <div class="col-md-6">
                <div class="p-3 mb-2 bg-light rounded-3">
                <h6>Profilo</h6>
                <!-- SINISTRA ------------------------------------------------------------------------------>

                <div class="mb-3">
                    <label for="imprenditore" class="form-label">Nome e Cognome dell'Imprenditore</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['imprenditore']); ?>" id="imprenditore" name="imprenditore" placeholder="Nome e Cognome">
                </div>
                
            </div>
            <div class="p-3 mb-2 bg-light rounded-3">
            <h6>Dati Fiscali</h6>

                <div class="mb-3">
                    <label for="impresa" class="form-label">Nome dell'Impresa</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['impresa']); ?>" id="impresa" name="impresa" placeholder="La mia Società">
                </div>

                <div class="mb-3">
                    <label for="pec" class="form-label">PEC</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['pec']); ?>" id="pec" name="pec" placeholder="Inserisci l'indirizzo PEC">
                </div>

                <div class="mb-3">
                    <label for="capitale_sociale" class="form-label">Capitale sociale</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['capitale_sociale']); ?>" id="capitale_sociale" name="capitale_sociale" placeholder="SOLO nel caso di una società, scrivi il capitale sociale">
                </div>

                <div class="mb-3">
                    <label for="IVA" class="form-label">Codice Partita Iva</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['IVA']); ?>" id="IVA" name="IVA" placeholder="Numero Partita Iva">
                </div>

                <div class="mb-3">
                    <label for="REA" class="form-label">REA Impresa</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['REA']); ?>" id="REA" name="REA" placeholder="Numero Registro Delle Imprese">
                </div>

            </div>
                <!-- FINE SINISTRA ----------------------------------------------------------------------->
            </div>
            <div class="col-md-6">
                <div class="p-3 mb-2 bg-light rounded-3">
                <h6>Dati di Fatturazione</h6>
                <!-- DESTRA ------------------------------------------------------------------------------>
                <div class="mb-3">
                    <label for="CF_fiscale" class="form-label">Codice Fiscale Amministratore</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['CF_fiscale']); ?>" id="CF_fiscale" name="CF_fiscale" placeholder="Codice Fiscale">
                </div>
    
                <div class="mb-3">
                    <label for="via" class="form-label">Indirizzo Fiscale (via)</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['via']); ?>" id="via" name="via" placeholder="Indirizzo di residenza fiscale o di dove si svolge l'attività">
                </div>

                <div class="mb-3">
                    <label for="email_impresa" class="form-label">Email Impresa</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['email_impresa']); ?>" id="email_impresa" name="email_impresa" placeholder="Su quale mail i clienti devono contattare il negozio?">
                </div>
    
                <div class="mb-3">
                    <label for="telefono_impresa" class="form-label">Telefono Impresa</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['telefono_impresa']); ?>" id="telefono_impresa" name="telefono_impresa" placeholder="Su quale numero di telefono i clienti devono contattare il negozio?">
                </div>

                <div class="mb-3">
                    <label for="paese" class="form-label">Città</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['paese']); ?>" id="paese" name="paese" placeholder="Dove vivi? Milano? Como? Inserisci la città">
                </div>
    
                <div class="mb-3">
                    <label for="cap" class="form-label">Cap</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['cap']); ?>" id="cap" name="cap" placeholder="Inserisci il codice CAP">
                </div>
                <!-- FINE DESTRA ----------------------------------------------------------------------->
                </div>
            </div>
        </div>
    
        <!-- Elementi del form che vuoi mantenere al di fuori della griglia divisa -->
        <div class="p-3 mb-2 bg-light rounded-3">
        <h6>Dati Informativi</h6>

        <div class="mb-3">
            <label for="nome_negozio" class="form-label">Nome Negozio</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['nome_negozio']); ?>" id="nome_negozio" name="nome_negozio" placeholder="Che nome vuoi dare al tuo negozio?">
        </div>

        <div class="mb-3">
            <label for="sitoweb" class="form-label">Dominio</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sitoweb']); ?>" id="sitoweb" name="sitoweb" placeholder="Inserisci la url del tuo dominio">
        </div>

        <div class="mb-3">
            <label for="cosa_vuoi_vendere" class="form-label">Cosa Vuoi Vendere</label>
            <textarea class="form-control" id="cosa_vuoi_vendere" name="cosa_vuoi_vendere" rows="3" placeholder="Descrivi cosa vuoi vendere"><?php echo htmlspecialchars($row['cosa_vuoi_vendere']); ?></textarea>
        </div>
        </div>
        <div class="p-3 mb-2 bg-light rounded-3">
            <div class="mb-3">
                <label for="identificatore" class="form-label">ID Personale ID0124<?php echo htmlspecialchars($row['identificatore']); ?></label>
                <input type="hidden" class="form-control" value="<?php echo htmlspecialchars($row['identificatore']); ?>" id="identificatore" name="identificatore">
            </div>
        </div>
    </form>
    </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
