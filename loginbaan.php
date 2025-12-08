<?php
session_start();

if (isset($_SESSION['error'])) {
    $login_error = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $login_error = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — R & R</title>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700&display=swap');

  html, body {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
  }
  * { box-sizing: inherit; }

  body {
      background: url('Images/R&L_Background.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
  }

  body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 0;
  }

  .page-wrapper {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      z-index: 1;
  }

  .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 16px;
      background-color: #602f78;
      padding: 40px 32px 28px;
      border-radius: 18px;
      box-shadow: 0 20px 45px rgba(0,0,0,0.45);
      width: 100%;
      max-width: 460px;
      color: #fff;
  }

  .card {
      background-color: transparent;
      padding: 6px 0 10px;
      border-radius: 0;
      width: 100%;
      box-shadow: none;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
  }

  /* logo inside the card */
  .card-logo {
      width: 180px;
      max-width: 70%;
      height: auto;
      margin-bottom: 10px;
      object-fit: contain;
      filter: drop-shadow(0 4px 10px rgba(0,0,0,0.4));
  }

  .card h2 {
      text-align: center;
      margin-bottom: 18px;
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      color: #ffd700;
      letter-spacing: -0.5px;
  }

  form {
      width: 100%;
      background-color: transparent;
      padding: 0;
      border-radius: 0;
  }

  .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 12px;
  }

  .form-group label {
      font-size: 11px;
      font-weight: 600;
      margin-bottom: 4px;
      color: #ffd700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .form-group input {
      width: 100%;
      padding: 10px 12px;
      border-radius: 9px;
      border: 2px solid #ffd700;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      color: #fff;
      transition: 0.25s ease;
      background-color: rgba(255, 255, 255, 0.1);
  }

  .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.6);
  }

  .form-group input:focus {
      outline: none;
      border-color: #ffd700;
      background-color: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
  }

  .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 6px 0 4px;
      font-size: 13px;
      color: #f0e68c;
  }

  .remember-forgot label {
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      text-transform: none;
      letter-spacing: 0;
      font-weight: 500;
      color: #f0e68c;
      font-size: 13px;
  }

  .remember-forgot input[type="checkbox"] {
      width: 14px;
      height: 14px;
      border-radius: 4px;
      accent-color: #ffd700;
      cursor: pointer;
  }

  .remember-forgot a {
      color: #ffd700;
      text-decoration: none;
      font-weight: 500;
  }

  .remember-forgot a:hover {
      color: #fff;
      text-decoration: underline;
  }

  .btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #ffd700, #ffed4e);
      border: none;
      border-radius: 10px;
      color: #602f78;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: 0.25s ease;
      margin-top: 12px;
      letter-spacing: 0.5px;
      font-family: 'Poppins', sans-serif;
  }

  .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 22px rgba(255, 215, 0, 0.4);
  }

  .btn:active {
      transform: translateY(0);
      box-shadow: none;
  }

  .back-btn {
      position: fixed;
      top: 24px;
      left: 24px;
      padding: 9px 15px;
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
      border-radius: 10px;
      z-index: 3;
      font-weight: 600;
      transition: 0.25s ease;
      font-size: 13px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
  }

  .back-btn:hover {
      background-color: rgba(255, 255, 255, 0.32);
      transform: translateX(-2px);
  }

  .alert {
      margin-bottom: 14px;
      padding: 10px 12px;
      border-radius: 9px;
      font-size: 13px;
      font-weight: 500;
      width: 100%;
  }

  .alert-danger {
      background-color: rgba(255, 107, 107, 0.3);
      color: #ff6b6b;
      border-left: 4px solid #ff6b6b;
  }

  .form-footer {
      text-align: center;
      margin-top: 16px;
      font-size: 14px;
      color: #f0e68c;
  }

  .form-footer a {
      color: #ffd700;
      text-decoration: none;
      font-weight: 600;
      transition: 0.25s ease;
  }

  .form-footer a:hover {
      color: #fff;
      text-decoration: underline;
  }

  @media (max-width: 500px) {
      .page-wrapper { padding: 12px; }
      .container {
          padding: 32px 16px 20px;
          max-width: 100%;
          gap: 15px;
      }
      .card h2 { font-size: 24px; }
      .back-btn {
          top: 16px;
          left: 16px;
          padding: 7px 12px;
          font-size: 12px;
      }
      .card-logo {
          width: 150px;
      }
  }
</style>
</head>
<body>

<a href="index.php" class="back-btn">← Back</a>

<div class="page-wrapper">
  <div class="container">
    <section class="card">
      <!-- logo inside the card -->
      <img src="Images/BKT_logo_HD.png" alt="Baan Khun Thai Logo" class="card-logo">

      <h2>Login</h2>

      <?php if (!empty($login_error)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($login_error); ?>
        </div>
      <?php endif; ?>

      <form action="authenticate.php" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="remember-forgot">
          <label>
            <input type="checkbox" name="remember_me" value="1">
            Remember me
          </label>
          <a href="forgot-password.php">Forgot password?</a>
        </div>

        <button type="submit" class="btn">Login</button>
      </form>

      <div class="form-footer">
        Don't have an account?
        <a href="register.php">Register</a>
      </div>
    </section>
  </div>
</div>

</body>
</html>
