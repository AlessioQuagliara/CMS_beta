<?php 
require ('../app.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paga con Carta</title>
    <?php include '../admin/materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">  

<!--LOGO E SCRITTA-->
<div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-4" src="../admin/materials/linkbay_logo.png" alt="logo" width="150px">
            <h6>Completa l'Acquisto</h6>
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
            <h4 class="mb-3">Paga con Carta</h4>
            <form class="needs-validation" novalidate>
              <br>
              <div class="row g-3">


              <div class="d-flex flex-column align-items-start">
                  <i class="fa-brands fa-stripe fa-3x mb-2"></i> <!-- Icona con margin-bottom -->
                  <p class="fw-bold">Pagamenti sicuri grazie a Stripe</p> <!-- Testo in grassetto -->
                  <div class="d-flex justify-content-start">
                    <i class="fa-brands fa-cc-amex fa-lg me-2"></i> <!-- Prima icona con margine a destra -->
                    <i class="fa-brands fa-cc-visa fa-lg me-2"></i> <!-- Seconda icona con margine a destra -->
                    <i class="fa-brands fa-cc-mastercard fa-lg me-2"></i>
                    <i class="fa-brands fa-cc-apple-pay fa-lg me-2"></i> <!-- Quarta icona con margine a destra -->
                    <i class="fa-brands fa-google-pay fa-lg"></i> <!-- Quinta icona senza margine a destra -->
                  </div>
                </div>


              <div class="row gy-3">
                <div class="col-md-6">
                  <label for="cc-name" class="form-label">Nome sulla Carta</label>
                  <input type="text" class="form-control" id="cc-name" placeholder="" required>
                  <small class="text-muted">Il nome per intero come sulla carta</small>
                  <div class="invalid-feedback">
                    Il nome è obbligatorio.
                  </div>
                </div>
    
                <div class="col-md-6">
                  <label for="cc-number" class="form-label">Numero Carta di Credito</label>
                  <input type="text" class="form-control" id="cc-number" placeholder="" required>
                  <div class="invalid-feedback">
                    Credit card number is required
                  </div>
                </div>
    
                <div class="col-md-3">
                  <label for="cc-expiration" class="form-label">Data Scadenza</label>
                  <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                  <div class="invalid-feedback">
                    Expiration date required
                  </div>
                </div>
    
                <div class="col-md-3">
                  <label for="cc-cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                  <div class="invalid-feedback">
                    Security code required
                  </div>
                </div>
              </div>
    
              </div>

              <hr class="my-4">

              <button class="w-50 btn btn-primary btn-lg" type="submit">Paga</button>
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
