<?php 
require '../../app.php';
loggato();
require '../../conn.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_ordine = $_GET['id'];
} else {
    $result = 'Id ordine non trovato';
    exit;
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiungi Tracking </title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">
<form action="" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Aggiunta Tracking ID</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva</button>
                <a href="ordine_modifica?id=<?php echo $id_ordine; ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-chevron-left"></i>&nbsp; Torna Indietro</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-3" hidden>
                <div class="card-body">
                    <h5 class="card-title">Dati</h5>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">ID Pagina</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo $id; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nome Pagina</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo htmlspecialchars($page_name); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Editor Pagina</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo htmlspecialchars($editor_page); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETTAGLI SEO -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Modifica SEO</h5>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nome nella URL</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" value="<?php echo htmlspecialchars($slug); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Titolo Pagina</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Descrizione Pagina</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($description); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Keywords</label>
                        <div class="col-sm-10">
                            <input type="text" name="keywords" class="form-control" value="<?php echo htmlspecialchars($keywords); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Se esci ora, le modifiche non verranno salvate.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.close(); // Chiude la finestra corrente
        }
    });
}

function saveAndRefresh() {
    if (window.opener && !window.opener.closed) {
        window.opener.location.href = '../ui/editor_negozio';
    }
}
</script>

<?php include '../materials/script.php'; ?>
</body>
</html>
