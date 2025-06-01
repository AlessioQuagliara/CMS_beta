

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
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
    <h5 class="center-align">Admin Registration</h5>
    <form id="adminRegisterForm">
      <div class="input-field">
        <input id="first_name" type="text" name="first_name" required>
        <label for="first_name">First Name</label>
      </div>
      <div class="input-field">
        <input id="last_name" type="text" name="last_name" required>
        <label for="last_name">Last Name</label>
      </div>
      <div class="input-field">
        <input id="email" type="email" name="email" required>
        <label for="email">Email</label>
      </div>
      <div class="input-field">
        <input id="username" type="text" name="username" required>
        <label for="username">Username</label>
      </div>
      <div class="input-field">
        <input id="password" type="password" name="password" required>
        <label for="password">Password</label>
      </div>
      <div class="center-align">
        <button class="btn waves-effect waves-light" style="background-color: #002040;" type="submit">
          Register <i class="material-icons right">person_add</i>
        </button>
      </div>
    </form>
  </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('adminRegisterForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const code = Math.floor(100000 + Math.random() * 900000);
      const data = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        username: document.getElementById('username').value,
        password: document.getElementById('password').value,
        role: 'admin'
      };

      Swal.fire({
        title: 'Registrazione in corso...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      const res = await fetch('registration_process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      const result = await res.json();

      if (result.success) {
        await fetch('send-confirmation.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email: data.email, code: code })
        });

        localStorage.setItem('confirmation_email', data.email);
        localStorage.setItem('confirmation_code', code);

        Swal.fire({
          title: 'Verifica email',
          text: 'Inserisci il codice che ti abbiamo inviato via email',
          input: 'text',
          inputPlaceholder: 'Es. 123456',
          confirmButtonText: 'Conferma',
          showCancelButton: true,
          preConfirm: (val) => {
            if (val != code) {
              Swal.showValidationMessage('Codice errato. Riprova.');
              return false;
            }
          }
        }).then((res) => {
          if (res.isConfirmed) {
            Swal.fire('Registrazione confermata!', 'Benvenuto nel sistema.', 'success')
              .then(() => {
                window.location.href = '../login/admin-login.php';
              });
          }
        });

      } else {
        Swal.fire('Errore', result.error || 'Registrazione fallita', 'error');
      }
    });
  });
</script>
</body>
</html>