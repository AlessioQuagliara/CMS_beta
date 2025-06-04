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
  <title>Cookie Policy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
    header, main, footer { padding-left: 300px; }
    .blue.darken-3{ background-color: #001f3f !important; }
    @media only screen and (max-width: 992px) { header, main, footer { padding-left: 0; } }
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
      <h4>Cookie & Policy Tools</h4>
      <a class="btn waves-effect blue modal-trigger" href="#policyModal"><i class="material-icons left">add</i>New</a>
      <table class="striped" style="margin-top:20px;">
        <thead>
          <tr>
            <th>Provider</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="policyTable">
        </tbody>
      </table>
    </div>

    <!-- Modal Structure -->
    <div id="policyModal" class="modal">
      <div class="modal-content">
        <h5 id="modalTitle">New Policy</h5>
        <div class="row">
          <div class="input-field col s12">
            <input id="provider" type="text" required>
            <label for="provider">Provider</label>
          </div>
          <div class="input-field col s12">
            <textarea id="embed_code" class="materialize-textarea"></textarea>
            <label for="embed_code">Embed Code</label>
          </div>
          <div class="input-field col s12">
            <select id="status">
              <option value="enabled">enabled</option>
              <option value="disabled">disabled</option>
            </select>
            <label>Status</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
        <a href="#!" id="saveBtn" class="waves-effect waves-light btn">Save</a>
      </div>
    </div>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    let currentId = null;

    document.addEventListener('DOMContentLoaded', function() {
      M.Sidenav.init(document.querySelectorAll('.sidenav'));
      M.Modal.init(document.querySelectorAll('.modal'));
      M.FormSelect.init(document.querySelectorAll('select'));
      loadPolicies();
    });

    function loadPolicies() {
      fetch('../api/list_cookie_policy.php')
        .then(r => r.json())
        .then(data => {
          const tbody = document.getElementById('policyTable');
          tbody.innerHTML = '';
          data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${row.provider}</td><td>${row.status}</td>` +
              `<td><a href="#!" class="btn-small" onclick="editPolicy(${row.id})"><i class="material-icons">edit</i></a> ` +
              `<a href="#!" class="btn-small red" onclick="deletePolicy(${row.id})"><i class="material-icons">delete</i></a></td>`;
            tbody.appendChild(tr);
          });
        });
    }

    function editPolicy(id) {
      fetch('../api/list_cookie_policy.php')
        .then(r => r.json())
        .then(data => {
          const row = data.find(p => p.id == id);
          if (!row) return;
          currentId = row.id;
          document.getElementById('provider').value = row.provider;
          document.getElementById('embed_code').value = row.embed_code;
          document.getElementById('status').value = row.status;
          M.updateTextFields();
          M.FormSelect.init(document.querySelectorAll('select'));
          document.getElementById('modalTitle').textContent = 'Edit Policy';
          const modal = M.Modal.getInstance(document.getElementById('policyModal'));
          modal.open();
        });
    }

    document.getElementById('saveBtn').addEventListener('click', function() {
      const data = {
        id: currentId,
        provider: document.getElementById('provider').value,
        embed_code: document.getElementById('embed_code').value,
        status: document.getElementById('status').value
      };
      fetch('../api/save_cookie_policy.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
      })
      .then(r => r.json())
      .then(res => {
        if (res.success) {
          M.Modal.getInstance(document.getElementById('policyModal')).close();
          loadPolicies();
          currentId = null;
          document.getElementById('provider').value = '';
          document.getElementById('embed_code').value = '';
          document.getElementById('status').value = 'enabled';
          M.updateTextFields();
          M.FormSelect.init(document.querySelectorAll('select'));
        } else {
          alert(res.error || 'Error');
        }
      });
    });

    function deletePolicy(id) {
      if (!confirm('Delete this policy?')) return;
      fetch('../api/delete_cookie_policy.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id})
      })
      .then(r => r.json())
      .then(res => {
        if (res.success) loadPolicies(); else alert(res.error || 'Error');
      });
    }
  </script>
</body>
</html>
