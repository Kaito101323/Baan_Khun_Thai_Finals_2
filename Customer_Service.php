<?php
session_start();

// Only allow logged-in customers
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header('Location: loginbaan.php');
    exit();
}

$displayName = $_SESSION['name'] ?? 'Customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services - Baan Khun Thai</title>
  <!-- shared CSS with dashboard -->
  <link rel="stylesheet" href="Customer_Dashboard_Designs.css">
</head>
<body class="services-page">

<header class="navbar">
  <img src="Images/BKT_logo_HD.png" class="nav-logo" alt="Logo">

  <nav class="navbar-links">
    <a href="Customers_Dashboard.php" class="nav-link">Home</a>
    <a href="Customer_appointment.php" class="nav-link">My Appointments</a>
    <a href="Customer_services.php" class="nav-link active">Services</a>
    <a href="Customer_therapists.php" class="nav-link">Therapist</a>
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
  <h2>Our Services</h2>
  <p>Choose from our wide range of relaxing massages</p>
</div>

<div class="services-panel">
  <div class="services-filter">
    <label for="serviceCategory">Category</label>
    <select id="serviceCategory">
      <option value="sauna">Massage Package (with Sauna)</option>
      <option value="regular">Regular Massage</option>
      <option value="thaiFoot">Massage Package (with Thai Foot)</option>
      <option value="scrub">Body Scrub Packages</option>
    </select>
  </div>

  <div id="servicesList" class="services-list">
    <!-- services rendered by JS -->
  </div>
</div>

<script>
  const allServices = {
    regular: [
      {
        img: 'Images/Body_massage.jpg',
        name: 'Thai Body Massage',
        duration: '1 HR',
        price: '₱400',
        desc: 'Traditional full-body massage to relieve stress and tension.'
      },
      {
        img: 'Images/Foot_massage.jpg',
        name: 'Thai Foot Massage (with Foot Lotion)',
        duration: '1 HR',
        price: '₱300',
        desc: 'Relaxing foot massage with lotion focusing on reflex points.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Swedish Massage (with Aromatherapy Oil)',
        duration: '1 HR',
        price: '₱400',
        desc: 'Gentle Swedish strokes combined with soothing aromatherapy oil.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Swedish + Thai Body Combination',
        duration: '1.5 HRS',
        price: '₱600',
        desc: 'Blend of Swedish oil massage and Thai stretching techniques.'
      },
      {
        img: 'Images/Herbal_balls.jpg',
        name: 'Aroma Therapy Massage (Hot Pad & Herbal Ball, Aromatherapy Oil)',
        duration: '1.5 HRS',
        price: '₱600',
        desc: 'Warm herbal compress with aromatherapy for deep relaxation.'
      },
      {
        img: 'Images/Ventosa.jpg',
        name: 'Ventosa & Swedish Massage (with Aromatherapy Oil)',
        duration: '1.5 HRS',
        price: '₱600',
        desc: 'Cupping therapy combined with Swedish massage to ease muscles.'
      },
      {
        img: 'Images/Hot_stone.jpg',
        name: 'Hot Stone with Swedish Massage (with Aromatherapy Oil)',
        duration: '1.5 HRS',
        price: '₱600',
        desc: 'Heated stones and Swedish strokes to melt away tightness.'
      }
    ],
    sauna: [
      {
        img: 'Images/Ventosa.jpg',
        name: 'Ventosa & Swedish Massage (With Sauna)',
        duration: '1.5 HR',
        price: '₱700',
        desc: 'Combines cupping, Swedish massage, and a relaxing sauna session.'
      },
      {
        img: 'Images/Hot_stone.jpg',
        name: 'Hot Stone & Swedish Massage (With Sauna)',
        duration: '1.5 HR',
        price: '₱700',
        desc: 'Hot stones plus Swedish massage followed by sauna relaxation.'
      },
      {
        img: 'Images/Foot_massage.jpg',
        name: 'Swedish & Thai Foot Massage (With Sauna)',
        duration: '1.5 HR',
        price: '₱700',
        desc: 'Foot-focused Swedish and Thai combo with a sauna finish.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Swedish & Thai Body Massage (With Sauna)',
        duration: '1.5 HR',
        price: '₱700',
        desc: 'Oil strokes and Thai stretching plus sauna to complete the session.'
      },
      {
        img: 'Images/Herbal_balls.jpg',
        name: 'Swedish Massage w/ Hot Pad & Herbal Balls (With Sauna)',
        duration: '1.5 HR',
        price: '₱700',
        desc: 'Swedish massage with heat therapy and sauna for full relief.'
      }
    ],
    thaiFoot: [
      {
        img: 'Images/Hot_stone.jpg',
        name: 'Swedish Massage (with Hot Stone)',
        duration: '1.5 HR',
        price: '₱650',
        desc: 'Swedish massage enhanced with heated stones.'
      },
      {
        img: 'Images/Ventosa.jpg',
        name: 'Swedish Massage (with Ventosa)',
        duration: '1.5 HR',
        price: '₱650',
        desc: 'Cupping therapy and Swedish strokes for deep muscle work.'
      },
      {
        img: 'Images/Herbal_balls.jpg',
        name: 'Aroma Massage (with Hot Pad & Herbal Ball)',
        duration: '1.5 HR',
        price: '₱650',
        desc: 'Heated herbal compress and aromatherapy massage.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Thai Body Massage',
        duration: '1.5 HR',
        price: '₱550',
        desc: 'Traditional Thai bodywork focusing on stretching and pressure.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Swedish Massage',
        duration: '1.5 HR',
        price: '₱550',
        desc: 'Classic Swedish full-body relaxation massage.'
      }
    ],
    scrub: [
      {
        img: 'Images/Body_massage.jpg',
        name: 'Body Scrub Regular',
        duration: '1 HR',
        price: '₱650',
        desc: 'Gentle exfoliating scrub to leave your skin smooth and fresh.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Body Scrub + Thai Body Massage',
        duration: '2 HRS',
        price: '₱850',
        desc: 'Full body scrub followed by relaxing Thai body massage.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Body Scrub + Swedish Massage',
        duration: '2 HRS',
        price: '₱900',
        desc: 'Scrub plus Swedish massage for soft skin and relaxed muscles.'
      },
      {
        img: 'Images/Herbal_balls.jpg',
        name: 'Body Scrub + Aromatherapy Massage',
        duration: '2.5 HRS',
        price: '₱1,100',
        desc: 'Body exfoliation and aromatic massage for total pampering.'
      },
      {
        img: 'Images/Body_massage.jpg',
        name: 'Body Scrub + Hot Oil Massage',
        duration: '2.5 HRS',
        price: '₱1,100',
        desc: 'Moisturizing hot oil massage after a full body scrub.'
      },
      {
        img: 'Images/Hot_stone.jpg',
        name: 'Body Scrub + Hot Stone Massage',
        duration: '2.5 HRS',
        price: '₱1,200',
        desc: 'Exfoliation plus hot stone therapy for deep relaxation.'
      },
      {
        img: 'Images/Ventosa.jpg',
        name: 'Body Scrub + Ventosa Massage',
        duration: '2.5 HRS',
        price: '₱1,300',
        desc: 'Body scrub and ventosa treatment to ease stubborn tension.'
      }
    ]
  };

  const categorySelect = document.getElementById('serviceCategory');
  const servicesList = document.getElementById('servicesList');

  function renderCategory(cat) {
    servicesList.innerHTML = '';
    allServices[cat].forEach(s => {
      const div = document.createElement('div');
      div.className = 'service-item';
      div.innerHTML = `
        <img src="${s.img}" alt="${s.name}">
        <div class="service-info">
          <h3>${s.name}</h3>
          <p>${s.desc}</p>
          <div class="service-meta">
            <span>${s.duration}</span>
            <span>${s.price}</span>
          </div>
        </div>
      `;
      servicesList.appendChild(div);
    });
  }

  categorySelect.addEventListener('change', () => {
    renderCategory(categorySelect.value);
  });

  // initial load
  renderCategory(categorySelect.value);
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
