<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Baan Khun Thai</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #6a0dad;
      --primary-light: #8a2be2;
    }
    body { background-color: #f3f0f8; }
    .sidebar {
      height: 100vh;
      background-color: var(--primary-color);
      color: white;
      padding-top: 1rem;
      text-align: center;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 0.75rem 1rem;
      margin-bottom: 0.25rem;
      border-radius: 0.25rem;
    }
    .sidebar a:hover { background-color: var(--primary-light); }
    .content { padding: 2rem; }
    .card { border: 1px solid var(--primary-light); }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--primary-light); border-color: var(--primary-light); }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 d-none d-md-block sidebar">
      <!-- Logo Image -->
      <img src="Images/BKT_logo_HD.png" alt="Baan Khun Thai Logo" style="width:120px; margin: 1rem 0;">

      <a href="#">Home</a>
      <a href="#">Customers</a>
      <a href="#">Appointments</a>
      <a href="#">Reports</a>
      <a href="#">Feedback</a>
      <a href="#">Settings</a>
    </nav>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto content">
      <!-- Hero Section -->
      <div class="p-4 bg-purple-600 mb-4 rounded" style="background-color: var(--primary-color); color: white;">
        <h1>Admin Dashboard</h1>
        <p>Overview of all business operations and reports.</p>
      </div>

      <!-- Summary Cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card text-center p-3">
            <h5>Total Customers</h5>
            <h2>150</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3">
            <h5>Total Appointments</h5>
            <h2>320</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3">
            <h5>Revenue</h5>
            <h2>$12,500</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center p-3">
            <h5>Feedback Received</h5>
            <h2>87</h2>
          </div>
        </div>
      </div>

      <!-- Reports Section -->
      <div class="card p-3">
        <h4>Reports</h4>
        <div class="mt-3">
          <h5>Financial Data</h5>
          <table class="table table-hover">
            <thead class="table-light">
              <tr><th>Month</th><th>Revenue</th><th>Expenses</th><th>Profit</th></tr>
            </thead>
            <tbody>
              <tr><td>September</td><td>$5,000</td><td>$2,000</td><td>$3,000</td></tr>
              <tr><td>October</td><td>$7,500</td><td>$3,000</td><td>$4,500</td></tr>
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          <h5>User Activity Reports</h5>
          <table class="table table-hover">
            <thead class="table-light">
              <tr><th>User</th><th>Last Login</th><th>Appointments Made</th></tr>
            </thead>
            <tbody>
              <tr><td>John Doe</td><td>2025-09-28</td><td>5</td></tr>
              <tr><td>Jane Smith</td><td>2025-09-29</td><td>3</td></tr>
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          <h5>Appointments Overview</h5>
          <table class="table table-hover">
            <thead class="table-light">
              <tr><th>Period</th><th>Completed</th><th>Pending</th><th>Cancelled</th></tr>
            </thead>
            <tbody>
              <tr><td>Daily</td><td>15</td><td>5</td><td>1</td></tr>
              <tr><td>Monthly</td><td>320</td><td>30</td><td>5</td></tr>
              <tr><td>Yearly</td><td>3,500</td><td>200</td><td>12</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
