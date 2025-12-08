<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Therapist Dashboard - Baan Khun Thai</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #6a0dad; /* Deep purple */
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
    .table th, .table td { vertical-align: middle; }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--primary-light); border-color: var(--primary-light); }
    .badge-primary { background-color: var(--primary-color); }
    .badge-warning { background-color: #b19cd9; color: #fff; }
    .badge-success { background-color: #7b3fb3; }
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
      <a href="#">My Appointments</a>
      <a href="#">Feedback</a>
      <a href="#">Profile</a>
    </nav>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto content">
      <h2>My Appointments</h2>
      <div class="card p-3 mt-3">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Customer</th>
              <th>Service</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>John Doe</td>
              <td>Massage</td>
              <td>2025-10-01</td>
              <td>10:00 AM</td>
              <td><span class="badge badge-primary">Pending</span></td>
              <td><button class="btn btn-primary btn-sm">Mark Completed</button></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Jane Smith</td>
              <td>Spa</td>
              <td>2025-10-03</td>
              <td>02:00 PM</td>
              <td><span class="badge badge-success">Completed</span></td>
              <td><button class="btn btn-secondary btn-sm" disabled>Completed</button></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Mike Lee</td>
              <td>Foot Massage</td>
              <td>2025-10-05</td>
              <td>11:00 AM</td>
              <td><span class="badge badge-warning">Upcoming</span></td>
              <td><button class="btn btn-primary btn-sm">Mark Completed</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
