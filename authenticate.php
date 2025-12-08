<?php
session_start();
include 'registerdatabase.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email    = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $remember = isset($_POST['remember_me']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password needed.";
        header("Location: loginbaan.php");
        exit();
    }

    // ---- STAFF LOGINS (direct checks) ----
    if ($email === 'admin@baan.com' && $password === '123456789') {

        $_SESSION['id']    = null;
        $_SESSION['email'] = $email;
        $_SESSION['name']  = 'Admin';
        $_SESSION['role']  = 'admin';

        if ($remember) {
            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
        }

        header("Location: Admin_Dashboard.php");
        exit();
    }

    if ($email === 'reception@baan.com' && $password === '123456789') {

        $_SESSION['id']    = null;
        $_SESSION['email'] = $email;
        $_SESSION['name']  = 'Receptionist';
        $_SESSION['role']  = 'receptionist';

        if ($remember) {
            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
        }

        header("Location: Receptionist_Dashboard.php");
        exit();
    }

    if ($email === 'therapist@baan.com' && $password === '123456789') {

        $_SESSION['id']    = null;
        $_SESSION['email'] = $email;
        $_SESSION['name']  = 'Therapist';
        $_SESSION['role']  = 'therapist';

        if ($remember) {
            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
        }

        header("Location: Therapist_Dashboard.php");
        exit();
    }

    // ---- CUSTOMER LOGIN FROM DATABASE ----
    $sql  = "SELECT id, first_name, last_name, email, password FROM users WHERE LOWER(email) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            $_SESSION['id']    = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name']  = $row['first_name'] . " " . $row['last_name'];
            $_SESSION['role']  = 'customer';

            if ($remember) {
                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
            }

            header("Location: Customers_Dashboard.php");
            exit();

        } else {
            $_SESSION['error'] = "Wrong password.";
        }

    } else {
        $_SESSION['error'] = "Email not found.";
    }

    header("Location: loginbaan.php");
    exit();
}

$conn->close();
?>
