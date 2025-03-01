<?php 
require ('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Brand Identity</title>
    <?php include '../materials/head_content.php'; ?>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'negozio'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
            <div class="card mb-4">
                <div class="card-header text-center bg-light">
                    <h4>Favicon e Immagine di condivisione</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Preview images -->
                        <div class="col-md-6 d-flex flex-column align-items-center">
                            <div class="mb-3">
                                <img src="../../src/media_system/favicon_site.ico" alt="Favicon" width="90px" class="img-thumbnail">
                                <span>Favicon</span>
                            </div>
                            <div class="mb-3">
                                <img src="../../src/media_system/logo_site.png" alt="Logo" width="150px" class="img-thumbnail">
                                <span>Immagine Condivisione</span>
                            </div>
                        </div>
                        <!-- Upload form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <form id="uploadForm" action="../ui-gestisci/brand_caricamento.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="favicon" class="form-label">Carica Favicon (.ico)</label>
                                            <input class="form-control" type="file" name="favicon" id="favicon" accept=".ico">
                                        </div>
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">Carica Immagine per Social Media (.png)</label>
                                            <input class="form-control" type="file" name="logo" id="logo" accept=".png">
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100">Carica Immagini</button>
                                    </form>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    Nota: Potrebbe richiedere del tempo prima che i motori di ricerca aggiornino le nuove immagini.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../materials/script.php'; ?>
    <!-- SweetAlert2 JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Mostra Swal2 al submit del form
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        Swal.fire({
            title: 'Caricamento in corso',
            html: 'Attendere prego...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
    </script>
</body>
</html>
