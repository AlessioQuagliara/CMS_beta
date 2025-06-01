<?php
require_once '../session/session.php';
$session = new SessionManager();
$admin = $session->getAdminSession();

if (!$admin) {
    header('Location: admin-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
    header, main, footer {
      padding-left: 300px;
    }
    .blue.darken-3{
      background-color: #001f3f !important;
    }
    @media only screen and (max-width: 992px) {
      header, main, footer {
        padding-left: 0;
      }
    }
    .brand-logo img {
      height: 48px;
      margin-top: 8px; 
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
      <div class="user-view center-align" style="padding: 24px;">
        <img src="../img/spotex_logo1.png" alt="Spotex Logo" class="responsive-img" style="max-width: 120px;">
        <h6><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></h6>
        <p><?= htmlspecialchars($admin['email']) ?></p>
      </div>
    </li>
    <li><a href="home.php" class="waves-effect"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">description</i>Pages</a></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">settings</i>Settings</a></li>
    <li><a href="logout.php" class="waves-effect red-text"><i class="material-icons">exit_to_app</i>Logout</a></li>
  </ul>

  <!-- Top Navbar -->
  <header>
    <nav class="blue darken-3">
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo center hide-on-med-and-up"><img src="../img/spotex_logo1.png" alt="Spotex Logo" style="height: 40px;"></a>
        <a href="#" data-target="slide-out" class="sidenav-trigger show-on-medium-and-down"><i class="material-icons">menu</i></a>
      </div>
    </nav>
  </header>

  <!-- Main content -->
  <main class="container">
    <div class="section">
      <h4>Benvenuto, <?= htmlspecialchars($admin['first_name']) ?>!</h4>
      <p>Questa è la tua dashboard di amministrazione. Da qui puoi gestire contenuti, configurazioni e monitoraggio del sito.</p>
      <div class="row">
        <div class="col s12 m6">
          <div class="card blue lighten-1">
            <div class="card-content white-text center-align">
              <span class="card-title">Utenti registrati oggi</span>
              <h4 id="usersToday">...</h4>
            </div>
          </div>
        </div>
        <div class="col s12 m6">
          <div class="card teal lighten-1">
            <div class="card-content white-text center-align">
              <span class="card-title">Visualizzazioni oggi</span>
              <h4 id="viewsToday">...</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
  <div class="col s12 m6">
    <div class="card white z-depth-2">
      <div class="card-content">
        <span class="card-title"><i class="material-icons left">visibility</i>Editor HTML</span>
        <p>Visualizza o modifica il sito utilizzando l'editor visivo HTML. Ideale per contenuti statici e pagine personalizzate.</p>
      </div>
      <div class="card-action right-align">
        <a href="html-editor.php" class="btn waves-effect blue darken-2">
          Apri Editor HTML <i class="material-icons right">arrow_forward</i>
        </a>
      </div>
    </div>
  </div>
  <div class="col s12 m6">
    <div class="card white z-depth-2">
      <div class="card-content">
        <span class="card-title"><i class="material-icons left">code</i>Editor Codice</span>
        <p>Accedi all'editor di codice per modifiche avanzate. Solo per utenti esperti.</p>
      </div>
      <div class="card-action right-align">
        <a href="code-editor.php" class="btn waves-effect deep-purple darken-2">
          Modifica Codice <i class="material-icons right">arrow_forward</i>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col s12 m6">
    <div class="card white z-depth-2">
      <div class="card-content">
        <span class="card-title"><i class="material-icons left">gavel</i>Cookie & Policy</span>
        <p>Configura o integra una soluzione esterna per la gestione della cookie policy, come Iubenda o CookieBot.</p>
      </div>
      <div class="card-action right-align">
        <a href="cookie-policy.php" class="btn waves-effect orange darken-2">
          Gestisci Cookie Policy <i class="material-icons right">arrow_forward</i>
        </a>
      </div>
    </div>
  </div>

  <div class="col s12 m6">
    <div class="card white z-depth-2">
      <div class="card-content">
        <span class="card-title"><i class="material-icons left">track_changes</i>Tracking Marketing</span>
        <p>Inserisci o modifica i codici di monitoraggio di Google (GA4/UA) e Facebook Pixel per tracciare le conversioni.</p>
      </div>
      <div class="card-action right-align">
        <a href="marketing-tools.php" class="btn waves-effect green darken-2">
          Modifica Codici <i class="material-icons right">arrow_forward</i>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <div class="card white z-depth-2">
      <div class="card-content">
        <span class="card-title"><i class="material-icons left">link</i>Sitemap del sito</span>
        <p>Puoi utilizzare questo link per registrare la sitemap su Google Search Console e altri motori di ricerca.</p>
        <div class="input-field">
          <input type="text" id="sitemapLink" value="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/sitemap.php' ?>" readonly>
          <label for="sitemapLink">Link sitemap</label>
        </div>
      </div>
      <div class="card-action right-align">
        <button class="btn waves-effect blue" onclick="copySitemap()">Copia Link <i class="material-icons right">content_copy</i></button>
      </div>
    </div>
  </div>
</div>

<script>
  function copySitemap() {
    const copyText = document.getElementById("sitemapLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); 
    document.execCommand("copy");
    M.toast({html: 'Link copiato negli appunti!', classes: 'green'});
  }
</script>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      M.Sidenav.init(elems);
    });
  </script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    fetch('/function/admin-dashboard-stats.php')
      .then(res => res.json())
      .then(data => {
        document.getElementById('usersToday').textContent = data.usersToday;
        document.getElementById('viewsToday').textContent = data.viewsToday;
      })
      .catch(err => {
        const loadingSpinner = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
        document.getElementById('usersToday').innerHTML = loadingSpinner;
        document.getElementById('viewsToday').innerHTML = loadingSpinner;
      });
  });
</script>
</body>
</html>