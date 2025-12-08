<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receptionist Dashboard - Baan Khun Thai</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #6a0dad; /* Deep purple */
      --primary-light: #8a2be2;
    }

    body {
      background-color: #f3f0f8;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: var(--primary-color);
      color: white;
      padding-top: 1rem;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 0.75rem 1rem;
      margin-bottom: 0.25rem;
      border-radius: 0.25rem;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: var(--primary-light);
    }

    .sidebar img {
      width: 140px;
      margin: 1rem 0 2rem 0;
    }

    .content {
      padding: 2rem;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 d-none d-md-block sidebar text-center">
      <img src="Images/BKT_logo_HD.png" alt="Baan Khun Thai Logo">
      <a href="#">Home</a>
      <a href="Receptionist_Appointments.php">Appointments</a>
      <a href="#">Customers</a>
      <a href="#">Feedback</a>
      <a href="#">Reports</a>
      <a href="#">Settings</a>
    </nav>

    <!-- Main Content (clean slate) -->
    <main class="col-md-10 ms-sm-auto content">
      <!-- Add your content here -->
    </main>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
