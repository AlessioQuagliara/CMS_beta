<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione LinkBay</title>
    <link rel="shortcut icon" href="../admin/materials/favicon_link.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="card bg-light text-dark w-25">
        <div class="card-header text-center">
            <img src="../admin/materials/linkbay_logo.png" width="150px" alt="">
            <br>
            <h2>Si è verificato un errore</h2>
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
