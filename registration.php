<?php
session_start();
require_once "registerdatabase.php";

$errors = array();

if (isset($_POST['submit'])) {
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $suffix = mysqli_real_escape_string($conn, $_POST['suffix'] ?? '');
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($birthdate) || empty($sex)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $repeatPassword) {
        array_push($errors, "Passwords do not match");
    }

    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);
    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "Email already exists!");
    }

    if (count($errors) == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, middle_name, last_name, suffix, birthdate, sex, email, password) 
                VALUES ('$firstName', '$middleName', '$lastName', '$suffix', '$birthdate', '$sex', '$email', '$passwordHash')";
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

/* lock page to viewport, no scroll */
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

/* dark overlay */
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

/* fixed bigger logo, outside the card */
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

/* full-screen flex wrapper */
.page-wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    position: relative;
    z-index: 1;
}

/* SMALLER floating purple card */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    background-color: #602f78;
    padding: 40px 32px 28px;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.45); /* floating effect */
    width: 100%;
    max-width: 460px; /* adjust size here if you want smaller/bigger */
}

/* form content */
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

.sex-selector {
    display: flex;
    gap: 10px;
    margin-top: 2px;
    margin-bottom: 12px;
    justify-content: flex-start;
}

.sex-btn {
    flex: 1;
    max-width: 90px;
    padding: 7px 0 4px 0;
    border: 2px solid #ffd700;
    border-radius: 9px;
    background-color: rgba(255, 255, 255, 0.1);
    cursor: pointer;
    transition: 0.25s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    font-size: 11px;
    font-weight: 600;
    color: #ffd700;
    font-family: 'Poppins', sans-serif;
}

.sex-btn svg {
    width: 22px;
    height: 22px;
    stroke: #ffd700;
    stroke-width: 2;
    fill: none;
}

.sex-btn:hover {
    border-color: #fff;
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(255, 215, 0, 0.3);
}

.sex-btn.active {
    background: rgba(255, 215, 0, 0.25);
    color: #fff;
    border-color: #ffd700;
}

.sex-btn.active svg {
    stroke: #fff;
}

input[name="sex"] {
    display: none;
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

/* small-screen tweaks */
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

    .sex-selector {
        justify-content: flex-start;
    }

    .sex-btn {
        max-width: 80px;
        font-size: 10px;
        padding: 6px 0 3px 0;
    }

    .sex-btn svg {
        width: 20px;
        height: 20px;
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

<!-- big logo, outside container -->
<img src="Images/BKT_logo_HD.png" alt="Logo" class="page-logo">

<div class="page-wrapper">
  <div class="container">
    <section class="card">
        <h2>Create Account</h2>

        <form method="POST" action="">
            <?php if (count($errors) > 0): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
            </div>

            <div id="age-error" style="color: #c62828; font-size: 12px; margin-bottom: 12px; display: none;">
                You must be at least 18 years old to register.
            </div>

            <div class="form-group">
                <label>Sex</label>
                <div class="sex-selector">
                    <button type="button" class="sex-btn" data-value="Male" onclick="selectSex(this, 'Male')">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="6" r="4"></circle>
                            <path d="M12 11v8"></path>
                            <path d="M8 15h8"></path>
                            <path d="M10 22h4"></path>
                        </svg>
                        Male
                    </button>
                    <button type="button" class="sex-btn" data-value="Female" onclick="selectSex(this, 'Female')">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="6" r="4"></circle>
                            <path d="M12 11v8"></path>
                            <path d="M8 15h8"></path>
                            <path d="M9 22c0-1.657 1.343-3 3-3s3 1.343 3 3"></path>
                        </svg>
                        Female
                    </button>
                </div>
                <input type="hidden" name="sex" id="sex-hidden" required>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="repeat_password">Confirm Password</label>
                    <input type="password" id="repeat_password" name="repeat_password" placeholder="Confirm Password" required>
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

<script>
    function setMaxDate() {
        const today = new Date();
        const maxDate = today.toISOString().split('T')[0];
        document.getElementById('birthdate').setAttribute('max', maxDate);
        const minDate = new Date();
        minDate.setFullYear(minDate.getFullYear() - 120);
        const minDateStr = minDate.toISOString().split('T')[0];
        document.getElementById('birthdate').setAttribute('min', minDateStr);
    }

    function validateAge() {
        const birthdateInput = document.getElementById('birthdate').value;
        const ageErrorDiv = document.getElementById('age-error');
        const sexHidden = document.getElementById('sex-hidden');
        
        if (!birthdateInput) {
            ageErrorDiv.style.display = 'none';
            return true;
        }

        const birthDate = new Date(birthdateInput);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 18) {
            ageErrorDiv.style.display = 'block';
            sexHidden.required = false;
            return false;
        } else {
            ageErrorDiv.style.display = 'none';
            sexHidden.required = true;
            return true;
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateAge()) {
            e.preventDefault();
            alert('You must be at least 18 years old to register.');
        }
    });

    document.getElementById('birthdate').addEventListener('change', validateAge);

    window.addEventListener('DOMContentLoaded', setMaxDate);

    function selectSex(button, value) {
        document.querySelectorAll('.sex-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        document.getElementById('sex-hidden').value = value;
    }
</script>

</body>
</html>
