<?php
include('../../app.php');
include('../../conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal form
    $editor_page = $_POST['editor_page'];
    $page_name = $_POST['page_name'];
    $slug = $_POST['slug'];
    $title = $page_name;
    $description = "Descrizione di " . $page_name;
    $keywords = "keyword di " . $page_name;

    // Prepara e esegue la query SQL
    $sql = "INSERT INTO seo (editor_page, page_name, slug, title, description, keywords) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $editor_page, $page_name, $slug, $title, $description, $keywords);

    if ($stmt->execute()) {
        echo "Nuovo record creato con successo<br>";
    } else {
        header("Location: form_page.php?error=Errore+durante+la+creazione+della+pagina");
    }

    $stmt->close();
    $conn->close();

    header("Location: crea_pagina.php?success=La+pagina+$page_name.php+è+stata+creata+con+successo.");
}
?>