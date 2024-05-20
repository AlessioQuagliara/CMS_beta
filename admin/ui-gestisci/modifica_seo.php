<?php 
require '../../app.php';
loggato();
require '../../conn.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $result = 'Id pagina non trovato';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];

    $stmt = $conn->prepare("UPDATE seo SET title = ?, description = ?, keywords = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $keywords, $id);

    if ($stmt->execute()) {
        $result = 'SEO aggiornata con successo';
    } else {
        $result = 'Errore durante l\'aggiornamento della SEO';
    }

    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM seo WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $page_name = $row['page_name'];
    $editor_page = $row['editor_page'];
    $slug = $row['slug'];
    $title = $row['title'];
    $description = $row['description'];
    $keywords = $row['keywords'];
} else {
    $result = 'Pagina non trovata';
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - SEO Pagine </title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">
<form action="" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;<?php echo htmlspecialchars($page_name); ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="submit" onclick="saveAndRefresh();" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Salva</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
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
