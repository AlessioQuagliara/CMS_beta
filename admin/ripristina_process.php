<?php 
if (!file_exists('../conn.php')) {
  header("Location: error");
  exit();
} else {
  include ('../app.php');
  $id_admin = $_GET['id_admin']; // Ottiene l'ID dall'URL
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Spotex Srl">
    <meta name="generator" content="Gestionale 2.0">
    <title>LinkBay - Ripristina Password</title>
    <link rel="shortcut icon" href="materials/favicon_link.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="materials/login.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="materials/dashboard.css" rel="stylesheet">
  </head>
  <body class="text-center">

  <video autoplay muted loop id="myVideo" style="position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%;">
    <source src="materials/video_background.mp4" type="video/mp4">
    Il tuo browser non supporta il tag video.
  </video>

  <div class="card">
    <main class="form-signin">
        <form method="POST" action="update_password.php"> 
            <!-- Form fields for password change -->
            <img class="mb-4" src="materials/linkbay_logo.png" alt="" width="50%">
            <h1 class="h3 mb-3 fw-normal">Scegli una nuova Password</h1>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="id_admin" name="id_admin" value="<?php echo $id_admin;?>"  placeholder="Inserisci il tuo id utente">
                <label for="id_admin">ID Utente</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nuova Password" required>
                <label for="new_password">Nuova Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Conferma Nuova Password" required>
                <label for="confirm_new_password">Conferma Nuova Password</label>
            </div>
            <button class="btn btn-outline-secondary" type="submit">Cambia Password</button>
            <?php
            if (!empty($errore)) {
                echo '<p class="text-danger">' . $errore . '</p>';
            }
            ?>
            <p class="mt-5 mb-3 text-muted">© <?php echo date('Y'); ?> Sviluppato da Spotex Srl <img src="materials/favicon.ico" width="20px"></p>
        </form>
    </main>
  </body>
</html>
