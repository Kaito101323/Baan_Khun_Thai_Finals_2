<?php
session_start();

// Optional: only allow logged-in customers
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header('Location: loginbaan.php');
    exit();
}

// Name comes from authenticate.php: $_SESSION['name'] = first_name . " " . last_name
$displayName = $_SESSION['name'] ?? 'Guest';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Customer Dashboard - Baan Khun Thai</title>
  <link rel="stylesheet" href="Customer_Dashboard_Designs.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <img src="Images/BKT_logo_HD.png" class="nav-logo" alt="Logo">

  <nav class="navbar-links">
    <a href="Customers_Dashboard.php" class="nav-link active">Home</a>
    <a href="Customer_appointment.php" class="nav-link">My Appointments</a>
    <a href="Customer_Service.php" class="nav-link">Services</a>
    <a href="Customer_therapists.php" class="nav-link">Therapist</a>
    <a href="history.html" class="nav-link">History</a>
    <a href="Appointment_page1.php" class="book-btn">Book Appointment</a>
  </nav>

  <div class="navbar-profile">
    <button class="profile-toggle" id="profileToggle">
      <img src="Images/Man.jpg" class="profile-pic" alt="Profile">
      <span class="profile-name">
        <?php echo htmlspecialchars($displayName); ?>
      </span>
      <span class="profile-caret">▼</span>
    </button>

    <div class="profile-menu" id="profileMenu">
      <a href="Customer_profile.php">Edit Profile</a>
      <!-- add more items here if needed -->
    </div>
  </div>
</header>

<!-- MAIN CONTENT -->
<main class="dashboard-main">

  <!-- HERO SLIDER -->
  <section class="hero-slider">
    <button class="hero-arrow hero-arrow-left" id="heroPrev">&#10094;</button>

    <div class="hero-slide">
      <img id="heroImg" src="Images/Hot_Stone.jpg" alt="Hot Stone Therapy">
      <div class="hero-overlay">
        <h2 id="heroTitle">Hot Stone</h2>
        <p id="heroDesc">Relax and relieve tension with our hot stone therapy.</p>
      </div>
    </div>

    <button class="hero-arrow hero-arrow-right" id="heroNext">&#10095;</button>

    <div class="hero-dots" id="heroDots">
      <!-- dots added by JS -->
    </div>
  </section>

  <!-- RECOMMENDATIONS SECTION -->
  <section class="reco-section">
    <h2 class="reco-title">Recommendations</h2>

    <div class="reco-cards">
      <article class="reco-card">
        <img src="Images/Body_Massage.jpg" alt="Swedish Massage">
        <h3>Swedish Massage</h3>
        <p>Gentle, relaxing massage to improve circulation and reduce stress.</p>
        <a href="Customer_services.php" class="reco-btn">See Details</a>
      </article>

      <article class="reco-card">
        <img src="Images/Hot_Stone.jpg" alt="Thai Body Massage">
        <h3>Thai Body Massage</h3>
        <p>Stretching and pressure techniques to restore flexibility and balance.</p>
        <a href="Customer_services.php" class="reco-btn">See Details</a>
      </article>

      <article class="reco-card">
        <img src="Images/Foot_Massage.jpg" alt="Foot Massage">
        <h3>Foot Massage</h3>
        <p>Foot-focused relaxing session to target key reflex points.</p>
        <a href="Customer_services.php" class="reco-btn">See Details</a>
      </article>
    </div>
  </section>

</main>

<script>
  const services = [
    {
      img: 'Images/Hot_Stone.jpg',
      title: 'Hot Stone',
      desc: 'Relax and relieve tension with our hot stone therapy.'
    },
    {
      img: 'Images/Herbal_Balls.jpg',
      title: 'Herbal Balls',
      desc: 'Traditional herbal treatment for deep relaxation.'
    },
    {
      img: 'Images/Foot_Massage.jpg',
      title: 'Foot Massage',
      desc: 'Stimulate reflex points for better overall wellness.'
    },
    {
      img: 'Images/Body_Massage.jpg',
      title: 'Body Massage',
      desc: 'Full-body massage to ease muscles and stress.'
    }
  ];

  let currentService = 0;

  const heroImg   = document.getElementById('heroImg');
  const heroTitle = document.getElementById('heroTitle');
  const heroDesc  = document.getElementById('heroDesc');
  const heroPrev  = document.getElementById('heroPrev');
  const heroNext  = document.getElementById('heroNext');
  const heroDots  = document.getElementById('heroDots');

  function renderDots() {
    heroDots.innerHTML = '';
    services.forEach((_, index) => {
      const dot = document.createElement('span');
      dot.className = 'hero-dot' + (index === currentService ? ' active' : '');
      dot.addEventListener('click', () => {
        currentService = index;
        showService(currentService);
      });
      heroDots.appendChild(dot);
    });
  }

  function showService(index) {
    const s = services[index];
    heroImg.src = s.img;
    heroImg.alt = s.title;
    heroTitle.textContent = s.title;
    heroDesc.textContent = s.desc;
    renderDots();
  }

  heroNext.addEventListener('click', () => {
    currentService = (currentService + 1) % services.length;
    showService(currentService);
  });

  heroPrev.addEventListener('click', () => {
    currentService = (currentService - 1 + services.length) % services.length;
    showService(currentService);
  });

  setInterval(() => {
    currentService = (currentService + 1) % services.length;
    showService(currentService);
  }, 7000);

  showService(currentService);
</script>

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
