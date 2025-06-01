<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

    <div class="login-box z-depth-2">
        <div class="center-align" style="margin-bottom: 24px;">
            <img src="../img/spotex_logo1.png" alt="Spotex Logo" class="responsive-img" style="max-width: 100px;">
        </div>
        <h5 class="center-align">Admin Login</h5>
        <form id="adminLoginForm">
            <div class="input-field">
                <input id="username" type="text" name="username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="password" required>
                <label for="password">Password</label>
            </div>
            <div class="center-align">
                <button class="btn waves-effect waves-light" style="background-color: #002040;" type="submit">Login
                    <i class="material-icons right">login</i>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('adminLoginForm');

        form.addEventListener('submit', async function(e) {
          e.preventDefault();

          const username = document.getElementById('username').value.trim();
          const password = document.getElementById('password').value;

          if (!username || !password) {
            Swal.fire('Errore', 'Inserisci username e password.', 'warning');
            return;
          }

          Swal.fire({
            title: 'Accesso in corso...',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          try {
            const res = await fetch('login.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ username, password, role: 'admin' })
            });

            const result = await res.json();

            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Login effettuato!',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.href = '../dashboard-admin/home.php';
              });
            } else {
              Swal.fire('Errore', result.error || 'Credenziali non valide.', 'error');
            }
          } catch (error) {
            Swal.fire('Errore di rete', 'Si è verificato un problema di connessione.', 'error');
          }
        });
      });
    </script>
</body>
</html>