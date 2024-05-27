<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione LinkBay</title>
    <link rel="shortcut icon" href="../admin/materials/favicon_link.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin/materials/login.css">
    <style>
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('../admin/materials/background.webp') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="card bg-light text-dark w-25">
        <div class="card-header text-center">
            <img src="../admin/materials/linkbay_logo.png" width="150px" alt="">
            <br><br>
            <h2 class="h3 mb-3 fw-normal" >Si è verificato un errore</h2>
        </div>
        <div class="card-body">
            <p>
                <?php
                if (isset($_GET['msg'])) {
                    echo htmlspecialchars($_GET['msg']);
                } else {
                    echo "Errore sconosciuto.";
                }
                ?>
            </p>
            <a class="btn btn-danger" href="index.php">Torna indietro</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
