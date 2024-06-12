<?php 
require ('../app.php');
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metodo di Spedizione</title>
    <link rel="shortcut icon" href="../src/media_system/favicon_site.ico" type="image/x-icon">
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
                        <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION['carrello']); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                            $total = 0;
                            if (isset($_SESSION['carrello']) && !empty($_SESSION['carrello'])) {
                                foreach ($_SESSION['carrello'] as $item) {
                                    $itemTotal = $item['quantita'] * $item['prezzo'];
                                    $total += $itemTotal;
                                    echo '<li class="list-group-item d-flex justify-content-between lh-sm">';
                                    echo '    <div>';
                                    echo '        <h6 class="my-0">' . htmlspecialchars($item['titolo']) . '</h6>';
                                    echo '        <small class="text-muted">Quantità: ' . htmlspecialchars($item['quantita']) . '</small>';
                                    echo '    </div>';
                                    echo '    <span class="text-muted">€' . $itemTotal . '</span>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="list-group-item d-flex justify-content-between lh-sm">';
                                echo '    <div>';
                                echo '        <h6 class="my-0">Il carrello è vuoto</h6>';
                                echo '    </div>';
                                echo '</li>';
                            }
                        ?>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Codice Promozione</h6>
                                <small>EXAMPLECODE</small>
                            </div>
                            <span class="text-success">−€5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Totale (EUR)</span>
                            <strong>€<?php echo $total - 5; ?></strong>
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
            <h4 class="mb-3">Metodo di Spedizione</h4>
            <form class="needs-validation" novalidate>
              <br>
              <div class="row g-3">


              <div class="form-check d-flex align-items-center">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" style="margin-bottom: 10px;">
                <label class="form-check-label w-100 ms-4" for="flexRadioDefault1">
                  <div class='p-3 mb-2 bg-light border rounded-3 d-flex justify-content-between align-items-center'>
                    <i class="fas fa-truck fa-3x"></i> <!-- ms-4 adds margin to the left of the icon -->
                    <p class="mb-0">24/48h</p>
                    <span>12€</span>
                  </div>
                </label>
              </div>

              <div class="form-check d-flex align-items-center">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" style="margin-bottom: 10px;">
                <label class="form-check-label w-100 ms-4" for="flexRadioDefault1">
                  <div class='p-3 mb-2 bg-light border rounded-3 d-flex justify-content-between align-items-center'>
                    <i class="fa-brands fa-ups fa-3x"></i> <!-- ms-4 adds margin to the left of the icon -->
                    <p class="mb-0">24/48h</p>
                    <span>12€</span>
                  </div>
                </label>
              </div>

              <div class="form-check d-flex align-items-center">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" style="margin-bottom: 10px;">
                <label class="form-check-label w-100 ms-4" for="flexRadioDefault1">
                  <div class='p-3 mb-2 bg-light border rounded-3 d-flex justify-content-between align-items-center'>
                    <i class="fa-brands fa-dhl fa-3x"></i> <!-- ms-4 adds margin to the left of the icon -->
                    <p class="mb-0">24/48h</p>
                    <span>12€</span>
                  </div>
                </label>
              </div>


    
              </div>

              <hr class="my-4">

              <button class="w-50 btn btn-primary btn-lg" type="submit">Vai a Pagamento</button>
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
