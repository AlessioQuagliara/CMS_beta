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
    <title>Dati di Fatturazione</title>
    <link rel="shortcut icon" href="../src/media_system/favicon_site.ico" type="image/x-icon">
    <?php include '../admin/materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">  

<!--LOGO E SCRITTA-->
<div class="container">
    <div class="py-3 text-center">
        <img class="d-block mx-auto mb-4" src="../admin/materials/linkbay_logo.png" alt="Il tuo logo" width="150px">
        <h6>Completa l'Acquisto</h6>
        <br><br>
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
                                $itemTotal = $item['quantita'] * 20; // Supponendo che il prezzo sia $20 per articolo
                                $total += $itemTotal;
                                echo '<li class="list-group-item d-flex justify-content-between lh-sm">';
                                echo '    <div>';
                                echo '        <h6 class="my-0">' . htmlspecialchars($item['titolo']) . '</h6>';
                                echo '        <small class="text-muted">Quantità: ' . htmlspecialchars($item['quantita']) . '</small>';
                                echo '    </div>';
                                echo '    <span class="text-muted">$' . $itemTotal . '</span>';
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
                                <h6 class="my-0">Promo code</h6>
                                <small>EXAMPLECODE</small>
                            </div>
                            <span class="text-success">−$5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$<?php echo $total - 5; // Supponendo che il codice promo tolga $5 ?></strong>
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
                    <h4 class="mb-3">Indirizzo di Fatturazione</h4>
                    <form class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Inserire un Nome valido.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Cognome</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Inserire un Cognome valido.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="latuaemail@esempio.it">
                                <div class="invalid-feedback">
                                    Usa un indirizzo di email valido.
                                </div>
                            </div>

                            <div class="col-9">
                                <label for="address" class="form-label">Indirizzo</label>
                                <input type="text" class="form-control" id="address" placeholder="Via Cristoforo Colombo, 3" required>
                                <div class="invalid-feedback">
                                    Inserisci un indirizzo valido.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="provincia" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="provincia" placeholder="" required>
                                <div class="invalid-feedback">
                                    Inserisci la tua Provincia.
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label for="country" class="form-label">Paese</label>
                                <select class="form-select" id="country" required>
                                    <option value="">Scegli...</option>
                                    <option>Italia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Inserisci un paese valido.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="zip" class="form-label">CAP</label>
                                <input type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Inserisci il tuo CAP.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">Città</label>
                                <input type="text" class="form-control" id="city" placeholder="" required>
                                <div class="invalid-feedback">
                                    Inserisci una città valida.
                                </div>
                            </div>

                        </div>

                        <hr class="my-4">

                        <button class="w-50 btn btn-primary btn-lg" type="submit">Vai a Spedizione </button>
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