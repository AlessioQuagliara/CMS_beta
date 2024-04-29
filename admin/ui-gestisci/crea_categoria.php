<?php
// Controlla se è stato fornito il nome della collezione
if (isset($_GET['nome_c'])) {
    $nome_collezione = $_GET['nome_c']; // Assicurati di sanificare questo input per prevenire vulnerabilità XSS
} else {
    // Se il nome della collezione manca o non è valido, reindirizza l'utente
    header("Location: collezione_modifica.php");
    exit;
}

// Controlla se è stato fornito l'ID della collezione
if (isset($_GET['id_collezione']) && is_numeric($_GET['id_collezione'])) {
    $id_collezione = intval($_GET['id_collezione']);
} else {
    // Se l'ID della collezione manca o non è valido, reindirizza l'utente
    header("Location: collezioni_modifica.php"); // Assicurati che il percorso sia corretto
    exit;
}

// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crea_categoria'])) {
    // Assicurati che il nome della categoria non sia vuoto e che il nome della collezione sia presente
    if (!empty($_POST['nome_categoria']) && !empty($_POST['nome_collezione'])) {
        $nome_categoria = $_POST['nome_categoria'];
        $nome_collezione = $_POST['nome_collezione']; // Assumi che questo sia già stato passato e validato

        require '../../conn.php'; // Assicurati che il percorso sia corretto

        $query = "INSERT INTO categorie (nome_cat, associazione) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $nome_categoria, $nome_collezione);

        if ($stmt->execute()) {
            // Categoria creata con successo, reindirizza l'utente con un messaggio di successo
            $stmt->close();
            $conn->close();
            header("Location: collezione_modifica.php?id=" . urlencode($id_collezione) . "&success=1");
            exit;
        } else {
            // Errore durante l'inserimento della categoria
            $error_message = "Errore durante l'inserimento della categoria: " . $stmt->error;
            $stmt->close();
            $conn->close();
        }
    } else {
        // Se il nome della categoria o il nome della collezione è vuoto
        $error_message = "Il nome della categoria e il nome della collezione non possono essere vuoti.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Crea Categoria</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
<div class="container mt-5  bg-dark text-light rounded-2" style="padding: 30px;">
    <h1>Crea Nuova Categoria</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="nome_collezione" value="<?php echo htmlspecialchars($nome_collezione); ?>">
        <div class="mb-3">
            <label for="nome_categoria" class="form-label">Nome Categoria:</label>
            <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" required>
        </div>
        <button type="submit" name="crea_categoria" class="btn btn-light">Crea Categoria</button>
    </form>
</div>
<?php include '../materials/script.php'; ?>
</body>
</html>
