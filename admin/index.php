<?php 
include ('../app.php');
$login_error = login(); // Assegna il valore restituito dalla funzione a $login_error
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Spotex Srl">
    <meta name="generator" content="Gestionale 2.0">
    <title>LinkBay - Accedi</title>
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
          <form method="POST" action="">
              <p class="btn text-success">
                <?php
                    if (isset($_GET['messaggio'])) {
                      echo htmlspecialchars($_GET['messaggio']);
                  }            
                ?>
              </p>
              <img class="mb-4" src="materials/linkbay_logo.png" alt="" width="50%">
              <h1 class="h3 mb-3 fw-normal">Accedi</h1>
              <p>Continua sul tuo CMS</p>
              
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" validate>
                <label for="email">Email</label>
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" validate>
                <label for="password">Password</label>
              </div>
              
              <?php
                if (!empty($login_error)) {
                    echo '<p class="text-danger">' . $login_error . '</p>';
                  }
              ?>

              <button class="btn btn-outline-secondary" type="submit">Accedi</button>
              <br><br>
              <p>Password dimenticata? <strong><a href="ripristina.php" class="text-decoration-none text-dark">Ripristina</a></strong></p>
              <p class="mt-5 mb-3 text-muted">© <?php echo date('Y'); echo ' Sviluppato da ';?> Spotex Srl <img src="materials/favicon.ico" width="20px"> <br> <strong> Versione Beta 2.1 </strong></p>
            </form>
          </main>
        </div>
      </div>

    
  </body>
</html>

