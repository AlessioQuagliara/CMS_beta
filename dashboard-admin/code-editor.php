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
  <title>Editor Codice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/codemirror.min.css">
  <style>
    header, main, footer { padding-left: 0px; }
    .blue.darken-3{ background-color: #001f3f !important; }
    @media only screen and (max-width: 992px) {
      header, main, footer { padding-left: 0; }
    }
    .CodeMirror { height: 70vh; border: 1px solid #ddd; }
  </style>
</head>
<body>
  <ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
      <div class="user-view center-align" style="padding: 24px;">
        <img src="../img/spotex_logo1.png" alt="Spotex Logo" class="responsive-img" style="max-width: 120px;">
        <h6><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></h6>
        <p><?= htmlspecialchars($admin['email']) ?></p>
      </div>
    </li>
    <li><a href="home.php" class="waves-effect"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><a href="html-editor.php" class="waves-effect"><i class="material-icons">view_module</i>Editor Visivo</a></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">code</i>Editor Codice</a></li>
    <li><a href="logout.php" class="waves-effect red-text"><i class="material-icons">exit_to_app</i>Logout</a></li>
  </ul>

  <header>
    <nav class="blue darken-3">
      <div class="nav-wrapper">
        <a href="#" data-target="slide-out" class="sidenav-trigger show-on-medium-and-down"><i class="material-icons">menu</i></a>
        <ul class="right" style="margin-right: 20px;">
          <li>
            <a class="btn white blue-text text-darken-3 waves-effect waves-blue" onclick="savePage()">
              <i class="material-icons left">save</i>Salva
            </a>
          </li>
          <li>
            <a class="btn white blue-text text-darken-3 waves-effect waves-blue modal-trigger" href="#crudModal">
              <i class="material-icons left">edit</i>Pagine
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <main class="container">
    <div class="section">
      <textarea id="code"></textarea>
    </div>
  </main>

  <div id="crudModal" class="modal">
    <div class="modal-content">
      <h5>Gestione Pagine</h5>
      <div class="input-field">
        <input id="page-title" type="text">
        <label for="page-title">Titolo Pagina</label>
      </div>
      <div class="input-field">
        <input id="page-slug" type="text">
        <label for="page-slug">Slug</label>
      </div>
      <button class="btn blue" onclick="createPage()">Crea Pagina</button>
      <hr><br>
      <div class="input-field">
        <select id="pages-select" class="browser-default" onchange="loadPage(this.value)">
          <option value="" disabled selected>Seleziona una pagina</option>
        </select>
      </div>
      <button class="btn red" onclick="deletePage()">Elimina Pagina</button>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close btn-flat">Chiudi</a>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/codemirror.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/xml/xml.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.15/mode/htmlmixed/htmlmixed.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      M.Sidenav.init(document.querySelectorAll('.sidenav'));
      M.Modal.init(document.querySelectorAll('.modal'));
      fetchPages();
    });

    const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
      lineNumbers: true,
      mode: 'htmlmixed',
      theme: 'default'
    });

    let currentPageId = null;
    let currentSlug = '';

    function fetchPages() {
      fetch('../api/list_pages.php')
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('pages-select');
          select.innerHTML = '<option value="" disabled selected>Seleziona una pagina</option>';
          data.forEach(page => {
            const opt = document.createElement('option');
            opt.value = page.id + '|' + page.slug;
            opt.textContent = page.title;
            select.appendChild(opt);
          });
        });
    }

    function loadPage(value) {
      if (!value) return;
      const parts = value.split('|');
      currentPageId = parts[0];
      currentSlug = parts[1];
      fetch('../api/get_page.php?slug=' + encodeURIComponent(currentSlug))
        .then(res => res.json())
        .then(data => {
          editor.setValue(data.content || '');
        });
    }

    function savePage() {
      if (!currentPageId) {
        M.toast({ html: 'Seleziona una pagina prima di salvare' });
        return;
      }
      fetch('../api/save_page.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ page_id: currentPageId, content: editor.getValue() })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            M.toast({ html: 'Pagina salvata' });
          } else {
            M.toast({ html: data.error || 'Errore' });
          }
        })
        .catch(() => M.toast({ html: 'Errore di rete' }));
    }

    function createPage() {
      const title = document.getElementById('page-title').value.trim();
      const slug = document.getElementById('page-slug').value.trim();
      if (!title || !slug) {
        M.toast({ html: 'Titolo e slug obbligatori' });
        return;
      }
      fetch('../api/create_page.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title: title, slug: slug })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            M.toast({ html: 'Pagina creata' });
            document.getElementById('page-title').value = '';
            document.getElementById('page-slug').value = '';
            fetchPages();
          } else {
            M.toast({ html: data.error || 'Errore' });
          }
        })
        .catch(() => M.toast({ html: 'Errore di rete' }));
    }

    function deletePage() {
      if (!currentPageId) {
        M.toast({ html: 'Seleziona una pagina da eliminare' });
        return;
      }
      fetch('../api/delete_page.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ page_id: currentPageId })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            M.toast({ html: 'Pagina eliminata' });
            editor.setValue('');
            currentPageId = null;
            currentSlug = '';
            fetchPages();
          } else {
            M.toast({ html: data.error || 'Errore' });
          }
        })
        .catch(() => M.toast({ html: 'Errore di rete' }));
    }
  </script>
</body>
</html>
