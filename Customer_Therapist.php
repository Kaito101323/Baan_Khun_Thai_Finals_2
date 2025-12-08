<?php
session_start();
require_once 'registerdatabase.php';

// Only allow logged-in customers
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header('Location: loginbaan.php');
    exit();
}

$displayName = $_SESSION['name'] ?? 'Customer';

// Fetch therapists from DB
$therapists = [];
$sql = "SELECT id, first_name, middle_name, last_name, suffix, nickname, email
        FROM therapists
        ORDER BY id ASC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $therapists[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Therapists - Baan Khun Thai</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="Customer_Dashboard_Designs.css">
  <style>
    /* Layout to match your reference screenshot */

    .therapists-page-main {
      max-width: 1200px;
      margin: 32px auto 40px auto;
      padding: 0 24px 40px;
    }

    .therapist-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 32px 40px;
      justify-items: center;
    }

    .therapist-card {
      width: 220px;
      background: #47206a;
      border-radius: 0 0 4px 4px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
      display: flex;
      flex-direction: column;
    }

    .therapist-card img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      display: block;
    }

    .therapist-info {
      padding: 10px 12px 12px;
      color: #ffffff;
      font-size: 0.9rem;
    }

    .therapist-fullname {
      margin: 0 0 4px 0;
      font-weight: 600;
      line-height: 1.3;
    }

    .therapist-role-label {
      font-size: 0.8rem;
      color: #f4d27a;
      margin-top: 6px;
    }

    @media (max-width: 600px) {
      .therapists-page-main {
        padding: 0 12px 24px;
      }
      .therapist-card {
        width: 100%;
        max-width: 260px;
      }
    }
  </style>
</head>
<body class="services-page">

<header class="navbar">
  <img src="Images/BKT_logo_HD.png" class="nav-logo" alt="Logo">

  <nav class="navbar-links">
    <a href="Customers_Dashboard.php" class="nav-link">Home</a>
    <a href="Customer_appointment.php" class="nav-link">My Appointments</a>
    <a href="Customer_services.php" class="nav-link">Services</a>
    <a href="Customer_therapists.php" class="nav-link active">Therapist</a>
    <a href="history.html" class="nav-link">History</a>
    <a href="Appointment_page1.php" class="book-btn">Book Appointment</a>
  </nav>

  <div class="navbar-profile">
    <button class="profile-toggle" id="profileToggle">
      <img src="Images/Man.jpg" alt="Profile" class="profile-pic">
      <span class="profile-name"><?php echo htmlspecialchars($displayName); ?></span>
      <span class="profile-caret">▼</span>
    </button>

    <div class="profile-menu" id="profileMenu">
      <a href="Customer_profile.php">Edit Profile</a>
    </div>
  </div>
</header>

<div class="page-header">
  <h2>Therapist</h2>
  <p>Choose from our experienced massage therapists</p>
</div>

<main class="therapists-page-main">
  <section class="therapist-grid">
    <?php foreach ($therapists as $t): ?>
      <?php
        // Build full name: "First [Middle] Last [Suffix] (Nickname)"
        $full = $t['first_name'];
        if (!empty($t['middle_name'])) {
            $full .= ' ' . $t['middle_name'];
        }
        $full .= ' ' . $t['last_name'];
        if (!empty($t['suffix'])) {
            $full .= ' ' . $t['suffix'];
        }

        $displayNameTherapist = $full;
        if (!empty($t['nickname'])) {
            $displayNameTherapist .= ' (' . $t['nickname'] . ')';
        }

        // Photo mapping: Images/Therapists/{Nickname}.jpg
        $baseNickname = !empty($t['nickname']) ? $t['nickname'] : $t['first_name'];
        $photoPath = 'Images/Therapists/' . $baseNickname . '.jpg';
      ?>
      <article class="therapist-card">
        <img src="<?php echo htmlspecialchars($photoPath); ?>"
             alt="<?php echo htmlspecialchars($displayNameTherapist); ?>">
        <div class="therapist-info">
          <p class="therapist-fullname">
            <?php echo htmlspecialchars($displayNameTherapist); ?>
          </p>
          <div class="therapist-role-label">Therapist</div>
        </div>
      </article>
    <?php endforeach; ?>
  </section>
</main>

<script>
  const profileToggle = document.getElementById('profileToggle');
  const profileMenu = document.getElementById('profileMenu');

  if (profileToggle && profileMenu) {
    profileToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      profileMenu.style.display =
        profileMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', () => {
      profileMenu.style.display = 'none';
    });
  }
</script>

</body>
</html>
