<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f5f5f5;
    }
    .form-box {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }
  </style>
</head>
<body>

  <div class="form-box z-depth-2">
    <h5 class="center-align">User Registration</h5>
    <form id="userRegisterForm">
      <div class="row">
        <div class="input-field col s6">
          <input id="first_name" type="text" required>
          <label for="first_name">First Name</label>
        </div>
        <div class="input-field col s6">
          <input id="last_name" type="text" required>
          <label for="last_name">Last Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" required>
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="username" type="text" required>
          <label for="username">Username</label>
        </div>
        <div class="input-field col s6">
          <input id="password" type="password" required>
          <label for="password">Password</label>
        </div>
      </div>
      <h6>Billing Information</h6>
      <div class="row">
        <div class="input-field col s12">
          <input id="billing_name" type="text">
          <label for="billing_name">Billing Name</label>
        </div>
        <div class="input-field col s12">
          <input id="billing_address" type="text">
          <label for="billing_address">Billing Address</label>
        </div>
        <div class="input-field col s6">
          <input id="billing_city" type="text">
          <label for="billing_city">City</label>
        </div>
        <div class="input-field col s6">
          <input id="billing_postal_code" type="text">
          <label for="billing_postal_code">Postal Code</label>
        </div>
        <div class="input-field col s6">
          <input id="billing_country" type="text">
          <label for="billing_country">Country</label>
        </div>
        <div class="input-field col s6">
          <input id="billing_vat" type="text">
          <label for="billing_vat">VAT Number</label>
        </div>
      </div>
      <div class="center-align">
        <button class="btn waves-effect waves-light teal" type="submit">
          Register <i class="material-icons right">person_add</i>
        </button>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.getElementById('userRegisterForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const data = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        username: document.getElementById('username').value,
        password: document.getElementById('password').value,
        billing_name: document.getElementById('billing_name').value,
        billing_address: document.getElementById('billing_address').value,
        billing_city: document.getElementById('billing_city').value,
        billing_postal_code: document.getElementById('billing_postal_code').value,
        billing_country: document.getElementById('billing_country').value,
        billing_vat: document.getElementById('billing_vat').value,
        role: 'user'
      };

      const res = await fetch('../registration-process.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });

      const result = await res.json();
      if (result.success) {
        M.toast({html: 'Registration successful!', classes: 'green'});
        setTimeout(() => location.href = 'user-login.php', 1000);
      } else {
        M.toast({html: result.error || 'Registration failed', classes: 'red'});
      }
    });
  </script>
</body>
</html>