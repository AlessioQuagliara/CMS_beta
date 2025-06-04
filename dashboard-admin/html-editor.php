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
  <title>Editor HTML Visivo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
  <style>
    header, main, footer {
      padding-left: 0px;
    }
    .blue.darken-3{
      background-color: #001f3f !important;
    }
    @media only screen and (max-width: 992px) {
      header, main, footer {
        padding-left: 0;
      }
    }
    #gjs {

      background-color: #ffffff;
    }
    .gjs-one-bg {
      background-color: #001f3f !important;
    }
    .gjs-pn-panel, .gjs-cv-canvas__frames, .gjs-frame-wrapper {
      background-color: #ffffff !important;
    }
    /* Nascondi gli elementi UI grigi originali di GrapesJS */
    .gjs-pn-panels,
    .gjs-pn-views-container {
      display: none !important;
    }
    /* Modifica lo stile del canvas GrapesJS */
    .gjs-cv-canvas {
      position: absolute;
      left: 95px;
      right: 90px;
      top: 0;
      z-index: 1;
  }
    /* Modal body scroll */
    .modal-content {
      overflow: auto;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <ul id="slide-out" class="sidenav sidenav-fixed d-none d-md-block">
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
        <ul class="right" style="display: flex; align-items: center; gap: 10px; margin-right: 20px;">
          <li>
            <a class="btn white blue-text text-darken-3 waves-effect waves-blue" style="margin-right: 8px;" onclick="savePage()">
              <i class="material-icons left">save</i>Salva
            </a>
          </li>
          <li>
            <a class="btn white blue-text text-darken-3 waves-effect waves-blue modal-trigger" href="#blockModal" style="margin-right: 8px;">
              <i class="material-icons left">view_module</i>Blocchi
            </a>
          </li>
          <li>
            <a class="btn white blue-text text-darken-3 waves-effect waves-blue modal-trigger" href="#pageModal" style="margin-right: 8px;">
              <i class="material-icons left">file_open</i>Pagine
            </a>
          </li>
          <li>
            <div style="display: flex; gap: 4px;">
              <a class="btn-flat waves-effect" title="Desktop" onclick="editor.setDevice('Desktop')">
              <i class="material-icons white-text">desktop_windows</i>
              </a>
              <a class="btn-flat waves-effect" title="Tablet" onclick="editor.setDevice('Tablet')">
              <i class="material-icons white-text">tablet_mac</i>
              </a>
              <a class="btn-flat waves-effect" title="Mobile" onclick="editor.setDevice('Mobile portrait')">
              <i class="material-icons white-text">smartphone</i>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Main -->
  <main class="container">
    <div class="content">
      <div id="gjs"></div>
    </div>
  </main>

  <!-- Block Modal -->
  <div id="blockModal" class="modal">
    <div class="modal-content" id="blocks-container">
      <h5>Blocchi personalizzati</h5>
      <div class="row" id="dynamic-blocks"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close btn-flat">Chiudi</a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://unpkg.com/grapesjs"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.sidenav');
      M.Sidenav.init(elems);
      var modals = document.querySelectorAll('.modal');
      M.Modal.init(modals);
    });

    const editor = grapesjs.init({
      container: '#gjs',
      fromElement: true,
      canvas: {
        styles: [
          'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
        ]
      },
      storageManager: false,
      deviceManager: {
        devices: [
          { name: 'Desktop', width: '' },
          { name: 'Tablet', width: '768px' },
          { name: 'Mobile portrait', width: '375px' }
        ]
      },
      panels: { defaults: [] },
      blockManager: {
        appendTo: '#blocks-container'
      },
      plugins: [],
      pluginsOpts: {},
    });

    function changePage(pageSlug) {
      fetch('../api/get_page.php?slug=' + encodeURIComponent(pageSlug))
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            editor.setComponents(data.content);
          } else {
            console.error('Errore: contenuto non trovato');
          }
        })
        .catch(error => {
          console.error('Errore nel caricamento della pagina:', error);
        });
    }

    // Carica dinamicamente i blocchi dal file blocks.json
    fetch('blocks.json')
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('dynamic-blocks');
        data.blocks.forEach(block => {
          const col = document.createElement('div');
          col.className = 'col s12 m4 l3';

          const card = document.createElement('div');
          card.className = 'card';

          const imageDiv = document.createElement('div');
          imageDiv.className = 'card-image';
          const img = document.createElement('img');
          img.src = block.image;
          img.alt = block.name;
          imageDiv.appendChild(img);

          const content = document.createElement('div');
          content.className = 'card-content';
          const title = document.createElement('span');
          title.className = 'card-title';
          title.textContent = block.name;
          content.appendChild(title);

          const action = document.createElement('div');
          action.className = 'card-action center-align';
          const btn = document.createElement('a');
          btn.href = '#!';
          btn.className = 'btn blue';
          btn.textContent = '+';
          btn.onclick = () => addBlock(block.html);
          action.appendChild(btn);

          card.appendChild(imageDiv);
          card.appendChild(content);
          card.appendChild(action);
          col.appendChild(card);
          container.appendChild(col);
        });
      })
      .catch(err => {
        console.error('Errore nel caricamento dei blocchi:', err);
      });


    // Rendi tutti i componenti ridimensionabili di default
    editor.on('load', () => {
      editor.DomComponents.getTypes().forEach(type => {
        const model = editor.DomComponents.getType(type.id).model;
        if (model.prototype.defaults) {
          model.prototype.defaults.resizable = {
            tl: 1, tc: 1, tr: 1,
            cl: 1, cr: 1,
            bl: 1, bc: 1, br: 1,
            keyWidth: 'width',
            keyHeight: 'height',
            currentUnit: 'px',
            minDim: 50,
            maxDim: 1000,
          };
        }
      });
    });

    function addBlock(html) {
      editor.getWrapper().append(html);
    }

    let selectedComponent = null;

    editor.on('component:selected', (component) => {
      selectedComponent = component;

      const updateInputs = () => {
        const styles = component.getStyle();
        document.getElementById('bg-color-input').value = rgb2hex(styles['background-color'] || '#ffffff');
        document.getElementById('text-color-input').value = rgb2hex(styles['color'] || '#000000');
        document.getElementById('padding-input').value = parseInt(styles['padding']) || 0;
        document.getElementById('margin-input').value = parseInt(styles['margin']) || 0;
        const linkAttr = component.getAttributes()['href'];
        document.getElementById('link-input').value = linkAttr || '';
        const videoAttr = component.getAttributes()['src'];
        document.getElementById('video-link-input').value = videoAttr || '';
      };

      updateInputs();

      const inputs = [
        { id: 'bg-color-input', styleKey: 'background-color' },
        { id: 'text-color-input', styleKey: 'color' },
      ];

      inputs.forEach(({ id, styleKey }) => {
        document.getElementById(id).oninput = function () {
          if (!selectedComponent) return;
          selectedComponent.addStyle({ [styleKey]: this.value });
        };
      });

      document.getElementById('padding-input').oninput = function () {
        if (!selectedComponent) return;
        selectedComponent.addStyle({ padding: this.value + 'px' });
      };

      document.getElementById('margin-input').oninput = function () {
        if (!selectedComponent) return;
        selectedComponent.addStyle({ margin: this.value + 'px' });
      };

      document.getElementById('link-input').oninput = function () {
        if (selectedComponent && selectedComponent.is('link')) {
          selectedComponent.addAttributes({ href: this.value });
        }
      };

      document.getElementById('video-link-input').oninput = function () {
        if (selectedComponent && selectedComponent.is('video')) {
          selectedComponent.addAttributes({ src: this.value });
        }
      };
    });

    // Funzione per convertire RGB a HEX
    function rgb2hex(rgb) {
      if (!rgb || rgb.indexOf('#') === 0) return rgb || '#ffffff';
      const result = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/.exec(rgb);
      return result
        ? "#" + result.slice(1).map(x => ('0' + parseInt(x).toString(16)).slice(-2)).join('')
        : rgb;
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var selects = document.querySelectorAll('select');
      M.FormSelect.init(selects);
    });

    document.getElementById('font-family-select').onchange = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ 'font-family': this.value });
    };

    document.getElementById('font-size-input').oninput = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ 'font-size': this.value + 'px' });
    };

    document.getElementById('toggle-visibility').onchange = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ display: this.checked ? 'none' : 'block' });
    };

    document.getElementById('remove-component').onclick = function () {
      if (selectedComponent) {
        selectedComponent.remove();
        selectedComponent = null;
      }
    };

    document.getElementById('border-radius-input').oninput = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ 'border-radius': this.value + 'px' });
    };

    document.getElementById('opacity-input').oninput = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ 'opacity': this.value });
    };

    document.getElementById('border-width-input').oninput = function () {
      if (!selectedComponent) return;
      selectedComponent.addStyle({ 'border-width': this.value + 'px', 'border-style': 'solid' });
    };
  </script>

  <!-- Floating Menu - Quadrato flottante a destra del canvas -->
  <div id="floating-menu" style="position: fixed; top: 70px; right: 20px; width: 220px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 8px; z-index: 9999; overflow-y: auto; max-height: 85vh;">
    <div class="p-2" style="padding: 10px;">
      <h6 class="center-align blue-text">Controlli Elemento</h6>
      <div class="input-field">
        <input type="text" id="link-input">
        <label for="link-input">Link</label>
      </div>
      <div class="input-field">
        <input type="text" id="video-link-input">
        <label for="video-link-input">Link Video (es. YouTube)</label>
      </div>
      <div class="input-field">
        <input type="color" id="bg-color-input" value="#ffffff">
        <label class="active">Colore Sfondo</label>
      </div>
      <div class="input-field">
        <input type="color" id="text-color-input" value="#000000">
        <label class="active">Colore Testo</label>
      </div>
      <div class="input-field">
        <label for="padding-input" class="active">Padding</label>
        <p class="range-field">
          <input type="range" id="padding-input" min="0" max="100" />
        </p>
      </div>
      <div class="input-field">
        <label for="margin-input" class="active">Margin</label>
        <p class="range-field">
          <input type="range" id="margin-input" min="0" max="100" />
        </p>
      </div>
      <div class="center-align">
        <button id="apply-style" class="btn-small blue white-text waves-effect">Applica</button>
      </div>

      <h6 class="center-align blue-text" style="margin-top: 24px;">Strumenti Avanzati</h6>
      
      <div class="input-field">
        <label for="border-radius-input" class="active">Border Radius</label>
        <p class="range-field">
          <input type="range" id="border-radius-input" min="0" max="100" />
        </p>
      </div>

      <div class="input-field">
        <label for="opacity-input" class="active">Opacità</label>
        <p class="range-field">
          <input type="range" id="opacity-input" min="0" max="1" step="0.01" />
        </p>
      </div>

      <div class="input-field">
        <label for="border-width-input" class="active">Spessore Bordo</label>
        <p class="range-field">
          <input type="range" id="border-width-input" min="0" max="20" />
        </p>
      </div>
    </div>
  </div>
  <div id="pageModal" class="modal">
    <div class="modal-content">
      <h5>Gestione Pagine</h5>
      <div class="input-field">
        <input id="new-page-title" type="text">
        <label for="new-page-title">Titolo Pagina</label>
      </div>
      <div class="input-field">
        <input id="new-page-slug" type="text">
        <label for="new-page-slug">Slug (es. chi-siamo)</label>
      </div>
      <button class="btn blue white-text" onclick="createPage()">Crea Pagina</button>
      <hr><br>
      <div class="input-field">
        <select id="existing-pages-select" class="browser-default" onchange="changePage(this.value)">
          <option value="" disabled selected>Seleziona una pagina esistente</option>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close btn-flat">Chiudi</a>
    </div>
  </div>

<script>
// Popola il select delle pagine esistenti nel modale
document.addEventListener('DOMContentLoaded', async function() {
  try {
    const response = await fetch('../api/list_pages.php');
    const data = await response.json();

    if (Array.isArray(data)) {
      const select = document.getElementById('existing-pages-select');
      data.forEach(page => {
        const opt = document.createElement('option');
        opt.value = page.slug;
        opt.textContent = page.title;
        select.appendChild(opt);
      });
    } else {
      M.toast({ html: 'Nessuna pagina trovata o errore nel caricamento' });
    }
  } catch (error) {
    console.error('Errore durante il fetch delle pagine:', error);
    M.toast({ html: 'Errore di rete nel caricamento pagine' });
  }
});

async function createPage() {
  const title = document.getElementById('new-page-title').value.trim();
  const slug = document.getElementById('new-page-slug').value.trim();

  if (!title || !slug) {
    M.toast({ html: 'Compila titolo e slug' });
    return;
  }

  try {
    const response = await fetch('../api/create_page.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title, slug })
    });

    const data = await response.json();

    if (response.ok && data.success) {
      M.toast({ html: 'Pagina creata con successo!' });
      const opt = document.createElement('option');
      opt.value = slug;
      opt.textContent = title;
      document.getElementById('existing-pages-select').appendChild(opt);
      document.getElementById('new-page-title').value = '';
      document.getElementById('new-page-slug').value = '';
    } else {
      M.toast({ html: 'Errore: ' + (data.error || 'Creazione fallita') });
    }
  } catch (error) {
    M.toast({ html: 'Errore di rete: ' + error.message });
  }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function savePage() {
    const html = editor.getHtml();
    const css = editor.getCss();
    const slug = document.getElementById('existing-pages-select').value;

    if (!slug) {
      Swal.fire({
        icon: 'warning',
        title: 'Attenzione',
        text: 'Seleziona una pagina prima di salvare.'
      });
      return;
    }

    Swal.fire({
      title: 'Salvataggio in corso...',
      text: 'Attendere prego',
      didOpen: () => {
        Swal.showLoading();
      },
      allowOutsideClick: false
    });

    fetch('../api/save_page.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        slug: slug,
        content: html
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Salvato!',
          text: data.message || 'Contenuto salvato correttamente.',
          timer: 2000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Errore!',
          text: data.error || 'Errore durante il salvataggio.'
        });
      }
    })
    .catch(() => {
      Swal.fire({
        icon: 'error',
        title: 'Errore!',
        text: 'Errore di connessione al server.'
      });
    });
  }
</script>
</body>
</html>