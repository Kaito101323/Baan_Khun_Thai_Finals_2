<?php
session_start();
require_once 'registerdatabase.php'; // DB connection ($conn)

// Only allow logged-in customers
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header('Location: loginbaan.php');
    exit();
}

$userId = $_SESSION['id'];

// Get user data from `users` table based on registration
$stmt = $conn->prepare("
    SELECT first_name, middle_name, last_name, email, birthdate, sex
    FROM users
    WHERE id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

$first  = $user['first_name']  ?? '';
$middle = $user['middle_name'] ?? '';
$last   = $user['last_name']   ?? '';
$fullName = trim($first . ' ' . $last);
$email    = $user['email'] ?? '';
$birth    = $user['birthdate'] ?? '';
$sex      = $user['sex'] ?? '';

// compute age & “member since”
$ageText = '';
$memberSince = '2024';
if ($birth) {
    $birthDate = new DateTime($birth);
    $today     = new DateTime();
    $age       = $today->diff($birthDate)->y;
    $ageText   = $age . ' years old';
    $memberSince = $birthDate->format('F Y');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Profile - Baan Khun Thai</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="Customer_Dashboard_Designs.css">
</head>
<body>

<header class="navbar">
  <img src="Images/BKT_logo_HD.png" class="nav-logo" alt="Logo">

  <nav class="navbar-links">
    <a href="Customers_Dashboard.php" class="nav-link">Home</a>
    <a href="Customer_appointment.php" class="nav-link">My Appointments</a>
    <a href="Customer_services.php" class="nav-link">Services</a>
    <a href="Customer_therapists.php" class="nav-link">Therapist</a>
    <a href="history.html" class="nav-link">History</a>
    <a href="Appointment_page1.php" class="book-btn">Book Appointment</a>
  </nav>

  <a href="Customer_profile.php" class="navbar-profile">
    <img src="Images/Man.jpg" class="profile-pic" alt="Profile">
    <span class="profile-name" id="navProfileName">
      <?php echo htmlspecialchars($fullName ?: 'Customer'); ?>
    </span>
  </a>
</header>

<div class="page-header">
  <h2>My Profile</h2>
  <p>View and update your personal information</p>
</div>

<main class="profile-main">
  <!-- Left card: basic info -->
  <section class="profile-card">
    <h3>Account Details</h3>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Sex:</strong> <?php echo htmlspecialchars($sex); ?></p>
    <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($birth); ?></p>
    <?php if ($ageText): ?>
      <p><strong>Age:</strong> <?php echo htmlspecialchars($ageText); ?></p>
    <?php endif; ?>
    <p><strong>Member since:</strong> <?php echo htmlspecialchars($memberSince); ?></p>
  </section>

  <!-- Right card: simple edit form (you can expand later) -->
  <section class="profile-card">
    <h3>Edit Profile</h3>
    <form method="post" action="Customer_profile_update.php">
      <div style="margin-bottom: 8px;">
        <label for="first_name">First Name</label><br>
        <input type="text" id="first_name" name="first_name"
               value="<?php echo htmlspecialchars($first); ?>"
               style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
      </div>

      <div style="margin-bottom: 8px;">
        <label for="middle_name">Middle Name</label><br>
        <input type="text" id="middle_name" name="middle_name"
               value="<?php echo htmlspecialchars($middle); ?>"
               style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
      </div>

      <div style="margin-bottom: 8px;">
        <label for="last_name">Last Name</label><br>
        <input type="text" id="last_name" name="last_name"
               value="<?php echo htmlspecialchars($last); ?>"
               style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
      </div>

      <div style="margin-bottom: 8px;">
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($email); ?>"
               style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
      </div>

      <div style="margin-bottom: 8px;">
        <label for="birthdate">Birthdate</label><br>
        <input type="date" id="birthdate" name="birthdate"
               value="<?php echo htmlspecialchars($birth); ?>"
               style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
      </div>

      <div style="margin-bottom: 12px;">
        <label for="sex">Sex</label><br>
        <select id="sex" name="sex"
                style="width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ddd;">
          <option value="">Select</option>
          <option value="Male"   <?php echo ($sex === 'Male')   ? 'selected' : ''; ?>>Male</option>
          <option value="Female" <?php echo ($sex === 'Female') ? 'selected' : ''; ?>>Female</option>
          <option value="Other"  <?php echo ($sex === 'Other')  ? 'selected' : ''; ?>>Other</option>
        </select>
      </div>

      <button type="submit"
              style="background:#602f78;color:#fff;border:none;border-radius:6px;padding:8px 16px;cursor:pointer;">
        Save Changes
      </button>
    </form>
  </section>
</main>

</body>
</html>
