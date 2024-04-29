<?php 
require ('../app.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metodo di Pagamento</title>
    <?php include '../admin/materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">  

<!--LOGO E SCRITTA-->
<div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-4" src="../admin/materials/linkbay_logo.png" alt="logo" width="150px">
            <h6>Ordine Confermato!</h6>
        </div>
<!--CONTENUTO FORM-->
<div class="p-3 mb-2 bg-light rounded-3">
    <main style="padding: 20px;">
        <div class="row g-5">
        <!--CARRELLO IN SESSIONE-->
          <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-primary">Il Tuo Carrello</span>
              <span class="badge bg-primary rounded-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                  <h6 class="my-0">Product name</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$12</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                  <h6 class="my-0">Second product</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$8</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                  <h6 class="my-0">Third item</h6>
                  <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$5</span>
              </li>
              <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Promo code</h6>
                  <small>EXAMPLECODE</small>
                </div>
                <span class="text-success">−$5</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
              </li>
            </ul>
    
            <form class="card p-2">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Codice Sconto">
                <button type="submit" class="btn btn-secondary">Aggiungi</button>
              </div>
            </form>
          </div>

          <!--INPUT DI TESTO-->

          <div class="col-md-7 col-lg-8">
            <h2 class="mb-3"><i class="fa-solid fa-square-check text-success"></i>&nbsp;&nbsp;Ordine Confermato!</h2>
            <form class="needs-validation" novalidate>
              <br>
              <div class="row g-3">

                <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-md-8">
                          <div class="p-4 mb-4 bg-light border rounded-3">
                              <h3 class="mb-3">Grazie per il tuo acquisto!</h3>
                              <p>Gentile cliente, il tuo ordine è stato confermato con successo. Riceverai una email di conferma con tutti i dettagli del tuo ordine.</p>
                              <p><strong>Prossimi passi:</strong></p>
                              <ul>
                                  <li>Se non hai ancora un account, creane uno per monitorare i tuoi ordini.</li>
                                  <li>Arriveranno notifiche sullo stato dell'ordine via email.</li>
                              </ul>
                              <p>Per qualsiasi domanda o chiarimento, non esitare a contattarci. Siamo qui per aiutarti!</p>
                          </div>
                      </div>
                  </div>
              </div>

              </div>

              <hr class="my-4">

              <a href="../index.php" class="w-50 btn btn-primary btn-lg" type="submit">Torna al Negozio</a>
            </form>
          </div>
        </div>
    </main>
</div>
<!--FINE FORM E FOOTER-->
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; LinkBay</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>

<?php include '../admin/materials/script.php'; ?>
</body>
</html>
