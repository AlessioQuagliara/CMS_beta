<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Crea Pagina</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<form action="creazione_pagina.php" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Visualizza Dettagli Cliente</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Crea Pagina</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <label for="editor_page" class="form-label">Stato Pagina</label>
            <select class="form-control" id="editor_page" name="editor_page" required>
                <option value="online">Online 🟩</option>
                <option value="offline">Offline 🟥</option>
            </select>
        </div>
        <div class="card-body">
            <label for="page_name" class="form-label">Nome Della Pagina</label>
            <input type="text" class="form-control" id="page_name" name="page_name" required oninput="generateSlug()">
        </div>
        <div class="card-body">
            <label for="slug" class="form-label">Slug per ottimizzazione SEO</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>
    </div>
</form>
<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 999;"></div>

<script>
function generateSlug() {
    var pageName = document.getElementById('page_name').value;
    var slug = pageName.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    document.getElementById('slug').value = slug;
}
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Se esci ora, tutte le modifiche non salvate andranno perse. Vuoi continuare?",
        icon: "warning",
        buttons: ["Annulla", "Uscire"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            closeAndRefresh();
        }
    });
}
function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/editor_negozio'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
</script>


<?php include '../materials/script.php'; ?>
<script src="../materials/main_editor.js"></script>
</body>
</html>