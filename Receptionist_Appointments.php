<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receptionist Appointments - Baan Khun Thai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #6a0dad;
      --primary-light: #8a2be2;
    }

    body {
      background-color: #f3f0f8;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Sidebar */
    .sidebar {
      height: 100vh;
      width: 200px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: var(--primary-color);
      color: white;
      padding-top: 1rem;
      text-align: center;
    }

    .sidebar img {
      width: 140px;
      margin: 1rem 0 2rem 0;
    }

    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 0.75rem 1rem;
      margin-bottom: 0.25rem;
      border-radius: 0.25rem;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: var(--primary-light);
    }

    /* Main content */
    .main-content {
      margin-left: 200px; /* leave space for sidebar */
      padding: 2rem;
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: var(--primary-color);
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      padding: 1.5rem;
    }

    table {
      font-size: 1rem;
    }

    table th, table td {
      vertical-align: middle;
      text-align: center;
      padding: 0.6rem;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 0.3rem;
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      font-size: 0.85rem;
    }

    .btn-primary:hover {
      background-color: var(--primary-light);
      border-color: var(--primary-light);
    }

    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      font-size: 0.85rem;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }

    .table-responsive {
      max-height: 70vh;
      overflow-y: auto;
    }

    .badge {
      font-size: 0.85rem;
      padding: 0.4em 0.6em;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <img src="Baan_Khun_Thai.png" alt="Logo">
  <a href="#">Home</a>
  <a href="#">Appointments</a>
  <a href="#">Customers</a>
  <a href="#">Feedback</a>
  <a href="#">Reports</a>
  <a href="#">Settings</a>
</div>

<div class="main-content">
  <h2>Upcoming Appointments</h2>
  <div class="card table-responsive">
    <table class="table table-hover table-bordered">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Service</th>
          <th>Therapist</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample rows -->
        <tr>
          <td>1</td>
          <td><img src="Images/Man.jpg" class="profile-pic" alt=""> John Doe</td>
          <td>Massage</td>
          <td>Therapist A</td>
          <td>2025-10-01</td>
          <td>10:00 AM</td>
          <td><span class="badge bg-primary">Pending</span></td>
          <td>
            <button class="btn btn-primary btn-sm">Edit</button>
            <button class="btn btn-secondary btn-sm">Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td><img src="Images/Man.jpg" class="profile-pic" alt=""> Jane Smith</td>
          <td>Spa</td>
          <td>Therapist B</td>
          <td>2025-10-03</td>
          <td>02:00 PM</td>
          <td><span class="badge bg-success">Completed</span></td>
          <td>
            <button class="btn btn-primary btn-sm">Edit</button>
            <button class="btn btn-secondary btn-sm">Delete</button>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td><img src="Images/Man.jpg" class="profile-pic" alt=""> Michael Lee</td>
          <td>Facial</td>
          <td>Therapist C</td>
          <td>2025-10-04</td>
          <td>11:00 AM</td>
          <td><span class="badge bg-primary">Pending</span></td>
          <td>
            <button class="btn btn-primary btn-sm">Edit</button>
            <button class="btn btn-secondary btn-sm">Delete</button>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td><img src="Images/Man.jpg" class="profile-pic" alt=""> Sarah Johnson</td>
          <td>Massage</td>
          <td>Therapist D</td>
          <td>2025-10-05</td>
          <td>01:00 PM</td>
          <td><span class="badge bg-primary">Pending</span></td>
          <td>
            <button class="btn btn-primary btn-sm">Edit</button>
            <button class="btn btn-secondary btn-sm">Delete</button>
          </td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
