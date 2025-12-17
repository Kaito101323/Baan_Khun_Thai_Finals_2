<?php
session_start();
require_once "registerdatabase.php";

$errors = array();

if (isset($_POST['submit'])) {
    $firstName      = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middleName     = mysqli_real_escape_string($conn, $_POST['middle_name'] ?? '');
    $lastName       = mysqli_real_escape_string($conn, $_POST['last_name']);
    $suffix         = mysqli_real_escape_string($conn, $_POST['suffix'] ?? '');
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $password       = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];

    // Basic required checks (no birthdate, no sex, middle name optional)
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        array_push($errors, "All fields are required");
    }

    // Name validation
    if (!preg_match("/^[A-Za-z\s'-]{2,50}$/", $firstName)) {
        array_push($errors, "First name is not valid");
    }
    if (!empty($middleName) && !preg_match("/^[A-Za-z\s'-]{0,50}$/", $middleName)) {
        array_push($errors, "Middle name is not valid");
    }
    if (!preg_match("/^[A-Za-z\s'-]{2,50}$/", $lastName)) {
        array_push($errors, "Last name is not valid");
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }

    // Password checks
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $repeatPassword) {
        array_push($errors, "Passwords do not match");
    }

    // Email uniqueness
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);
    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "Email already exists!");
    }

    if (count($errors) == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, middle_name, last_name, suffix, email, password) 
                VALUES ('$firstName', '$middleName', '$lastName', '$suffix', '$email', '$passwordHash')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Registration successful! You can now login.";
            header("Location: loginbaan.php");
            exit();
        } else {
            array_push($errors, "Error: " . mysqli_error($conn));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — Baan Khun Thai</title>
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

  * {
      box-sizing: inherit;
  }

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

  .page-logo {
      position: fixed;
      top: 40px;
      left: 50%;
      transform: translateX(-50%);
      width: 220px;
      height: auto;
      z-index: 3;
      object-fit: contain;
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

  .form-row {
      display: flex;
      gap: 10px;
      margin-bottom: 12px;
      flex-wrap: wrap;
  }

  .form-row.full {
      flex-wrap: nowrap;
  }

  .form-group {
      flex: 1;
      min-width: 100px;
      display: flex;
      flex-direction: column;
  }

  .form-group label {
      font-size: 11px;
      font-weight: 600;
      margin-bottom: 4px;
      color: #ffd700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .form-group input,
  .form-group select {
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

  .form-group input:focus,
  .form-group select:focus {
      outline: none;
      border-color: #ffd700;
      background-color: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
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
      margin-top: 10px;
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

  .alert-success {
      background-color: rgba(76, 175, 80, 0.3);
      color: #4caf50;
      border-left: 4px solid #4caf50;
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
      .page-wrapper {
          padding: 12px;
      }

      .container {
          padding: 32px 16px 20px;
          max-width: 100%;
          gap: 15px;
      }

      .card h2 {
          font-size: 24px;
      }

      .form-row {
          flex-direction: column;
          gap: 8px;
      }

      .back-btn {
          top: 16px;
          left: 16px;
          padding: 7px 12px;
          font-size: 12px;
      }

      .page-logo {
          top: 24px;
          width: 170px;
      }
  }
</style>
</head>
<body>

<a href="index.php" class="back-btn">← Back</a>

<img src="Images/BKT_logo_HD.png" alt="Logo" class="page-logo">

<div class="page-wrapper">
  <div class="container">
    <section class="card">
        <h2>Create Account</h2>

        <form method="POST" action="" autocomplete="off">
            <?php if (count($errors) > 0): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        placeholder="First Name"
                        required
                        pattern="^[A-Za-z\s'-]{2,50}$"
                        title="Name should only contain letters, spaces, apostrophes, or hyphens."
                        autocomplete="off"
                    >
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input
                        type="text"
                        id="middle_name"
                        name="middle_name"
                        placeholder="Middle Name (optional)"
                        pattern="^[A-Za-z\s'-]{0,50}$"
                        title="Name should only contain letters, spaces, apostrophes, or hyphens."
                        autocomplete="off"
                    >
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        placeholder="Last Name"
                        required
                        pattern="^[A-Za-z\s'-]{2,50}$"
                        title="Name should only contain letters, spaces, apostrophes, or hyphens."
                        autocomplete="off"
                    >
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Email"
                        required
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        spellcheck="false"
                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                        title="Please enter a valid email address."
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                </div>
                <div class="form-group">
                    <label for="repeat_password">Confirm Password</label>
                    <input
                        type="password"
                        id="repeat_password"
                        name="repeat_password"
                        placeholder="Confirm Password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <button type="submit" name="submit" class="btn">Register Account</button>

            <div class="form-footer">
                Already have an account? <a href="loginbaan.php">Login here</a>
            </div>
        </form>
    </section>
  </div>
</div>

</body>
</html>
