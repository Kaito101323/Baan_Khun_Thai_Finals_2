<?php
session_start();
require_once 'registerdatabase.php'; // change if different

$customerId = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0;

$error   = '';
$success = false;
$step    = isset($_GET['step']) ? (int)$_GET['step'] : 1;
if ($step < 1 || $step > 5) $step = 1;

/* --------------------------- LOAD STATIC DATA --------------------------- */
// Services
$services = [];
$res = $conn->query("SELECT id, name, category, duration_label, price FROM services WHERE is_active=1 ORDER BY category, name");
if ($res) while ($row = $res->fetch_assoc()) $services[] = $row;

// Therapists
$therapists = [];
$res = $conn->query("SELECT id, first_name, middle_name, last_name, nickname FROM therapists ORDER BY first_name");
if ($res) while ($row = $res->fetch_assoc()) $therapists[] = $row;

// Timeslots
$timeslots = [];
$res = $conn->query("SELECT id, label, start_time FROM timeslots WHERE is_active=1 ORDER BY start_time");
if ($res) while ($row = $res->fetch_assoc()) $timeslots[] = $row;

/* --------------------------- SESSION VALUES ---------------------------- */
$pax = $_SESSION['pax'] ?? 1;
$serviceCategory  = $_SESSION['service_category']  ?? '';
$serviceId        = $_SESSION['service_id']        ?? 0;
$therapistId      = $_SESSION['therapist_id']      ?? 0;
$servicePrice     = $_SESSION['service_price']     ?? 0;

$appointmentDate  = $_SESSION['appointment_date']  ?? '';
$timeslotId       = $_SESSION['appointment_timeslot_id'] ?? 0;

$details          = $_SESSION['appointment_details'] ?? [];
$paymentMethod    = $_SESSION['appointment_payment_method'] ?? '';
$notes            = $_SESSION['appointment_notes'] ?? '';
$totalAmount      = $_SESSION['appointment_total'] ?? 0;
$gcashFile        = $_SESSION['appointment_gcash_file'] ?? '';

/* ---------------------------- FORM HANDLERS ---------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formStep = (int)($_POST['form_step'] ?? 1);

    // STEP 1: category -> service -> therapist
    if ($formStep === 1) {

        $cat = $_POST['category'] ?? '';
        $sid = (int)($_POST['service_id'] ?? 0);
        $tid = (int)($_POST['therapist_id'] ?? 0);

        // pax
        $pax = (int)($_POST['pax'] ?? 1);
        if ($pax < 1) $pax = 1;
        if ($pax > 3) $pax = 3;
        $_SESSION['pax'] = $pax;

        if ($cat === '' || $sid <= 0) {
            $error = 'Please choose a category and a service.';
            $step  = 1;
        } else {
            $price = 0;
            foreach ($services as $s) {
                if ((int)$s['id'] === $sid) { $price = (float)$s['price']; break; }
            }
            $_SESSION['service_category'] = $cat;
            $_SESSION['service_id']       = $sid;
            $_SESSION['therapist_id']     = $tid;
            $_SESSION['service_price']    = $price;

            $serviceCategory = $cat;
            $serviceId       = $sid;
            $therapistId     = $tid;
            $servicePrice    = $price;

            $step = 2;
        }
    }

    // STEP 2: date & time
    elseif ($formStep === 2) {
        $date = trim($_POST['appointment_date'] ?? '');
        $tsId = (int)($_POST['timeslot_id'] ?? 0);

        // today in the same format as the input
        $today = date('Y-m-d');

        if ($date === '' || $tsId <= 0) {
            $error = 'Please pick a date and time.';
            $step  = 2;
        } elseif ($date < $today) {
            $error = 'You cannot book a date in the past.';
            $step  = 2;
        } else {
            $_SESSION['appointment_date']        = $date;
            $_SESSION['appointment_timeslot_id'] = $tsId;
            $appointmentDate = $date;
            $timeslotId      = $tsId;
            $step = 3;
        }
    }

    // STEP 3: health details
    elseif ($formStep === 3) {
        $boolFields = [
            'is_pregnant',
            'has_injuries',
            'is_senior',
            'has_high_bp',
            'aware_no_bath_after_ventosa',
            'cond_hypertension',
            'cond_skin_inflammation',
            'cond_heart',
            'cond_clots',
            'cond_gout',
            'cond_edema',
            'cond_diabetes',
            'cond_sunburn',
            'cond_fever',
            'cond_pregnant'
        ];
        $d = [];
        foreach ($boolFields as $f) {
            $d[$f] = !empty($_POST[$f]) ? 1 : 0;
        }
        $_SESSION['appointment_details'] = $d;
        $details = $d;
        $step = 4;
    }

    // STEP 4: payment & notes (+ GCash upload)
    elseif ($formStep === 4) {
        $method = 'gcash'; // only GCash
        $n      = trim($_POST['notes'] ?? '');

        // total = service price + 100 booking fee
        $total = (float)$servicePrice + 100;

        $uploadedName = '';
        if (isset($_FILES['gcash_receipt']) && $_FILES['gcash_receipt']['error'] === UPLOAD_ERR_OK) {
            $tmp  = $_FILES['gcash_receipt']['tmp_name'];
            $name = basename($_FILES['gcash_receipt']['name']);
            $ext  = pathinfo($name, PATHINFO_EXTENSION);
            $newName = 'gcash_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
            $dest = __DIR__ . '/uploads/' . $newName;
            if (!is_dir(__DIR__ . '/uploads')) {
                mkdir(__DIR__ . '/uploads', 0775, true);
            }
            if (move_uploaded_file($tmp, $dest)) {
                $uploadedName = $newName;
            }
        }

        if ($uploadedName === '') {
            $error = 'Please upload your GCash payment screenshot.';
            $step  = 4;
        } else {
            $_SESSION['appointment_payment_method'] = $method;
            $_SESSION['appointment_notes']          = $n;
            $_SESSION['appointment_total']          = $total;
            $_SESSION['appointment_gcash_file']     = $uploadedName;

            $paymentMethod = $method;
            $notes         = $n;
            $totalAmount   = $total;
            $gcashFile     = $uploadedName;

            $step = 5;
        }
    }

    // STEP 5: final insert
    elseif ($formStep === 5) {

        $sid   = (int)($_SESSION['service_id']       ?? 0);
        $tid   = (int)($_SESSION['therapist_id']     ?? 0);
        $date  = $_SESSION['appointment_date']       ?? '';
        $tsId  = (int)($_SESSION['appointment_timeslot_id'] ?? 0);
        $d     = $_SESSION['appointment_details']    ?? [];
        $pm    = $_SESSION['appointment_payment_method'] ?? '';
        $n     = $_SESSION['appointment_notes']      ?? '';
        $total = (float)($_SESSION['appointment_total'] ?? 0);
        $gcashFile = $_SESSION['appointment_gcash_file'] ?? '';

        if ($customerId <= 0 || $sid <= 0 || $date === '' || $tsId <= 0 || empty($d) || $pm === '' || $total <= 0) {
            $error = 'Missing required appointment data, please start again.';
            $step  = 1;
        } else {
            $conn->begin_transaction();
            try {
                // appointments
                $stmt = $conn->prepare("
                    INSERT INTO appointments
                    (customer_id, therapist_id, service_id, timeslot_id, appointment_date, notes, status)
                    VALUES (?, ?, ?, ?, ?, ?, 'pending')
                ");
                if (!$stmt) throw new Exception('Prepare failed (appointments): '.$conn->error);

                $tidNull = $tid > 0 ? $tid : null;
                $stmt->bind_param(
                    'iiiiss',
                    $customerId,
                    $tidNull,
                    $sid,
                    $tsId,
                    $date,
                    $n
                );
                if (!$stmt->execute()) throw new Exception('Execute failed (appointments): '.$stmt->error);

                $appointmentId = $stmt->insert_id;
                $stmt->close();

                // details
                $b = function($key) use ($d) { return !empty($d[$key]) ? 1 : 0; };
                $is_pregnant   = $b('is_pregnant');
                $has_injuries  = $b('has_injuries');
                $is_senior     = $b('is_senior');
                $has_high_bp   = $b('has_high_bp');
                $aware_ventosa = $b('aware_no_bath_after_ventosa');
                $cond_hypertension      = $b('cond_hypertension');
                $cond_skin_inflammation = $b('cond_skin_inflammation');
                $cond_heart   = $b('cond_heart');
                $cond_clots   = $b('cond_clots');
                $cond_gout    = $b('cond_gout');
                $cond_edema   = $b('cond_edema');
                $cond_diabetes= $b('cond_diabetes');
                $cond_sunburn = $b('cond_sunburn');
                $cond_fever   = $b('cond_fever');
                $cond_pregnant= $b('cond_pregnant');

                $stmt = $conn->prepare("
                    INSERT INTO details
                    (appointment_id, is_pregnant, has_injuries, is_senior, has_high_bp,
                     aware_no_bath_after_ventosa, cond_hypertension, cond_skin_inflammation,
                     cond_heart, cond_clots, cond_gout, cond_edema, cond_diabetes,
                     cond_sunburn, cond_fever, cond_pregnant)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                ");
                if (!$stmt) throw new Exception('Prepare failed (details): '.$conn->error);

                $stmt->bind_param(
                    'iiiiiiiiiiiiiiii',
                    $appointmentId,
                    $is_pregnant,
                    $has_injuries,
                    $is_senior,
                    $has_high_bp,
                    $aware_ventosa,
                    $cond_hypertension,
                    $cond_skin_inflammation,
                    $cond_heart,
                    $cond_clots,
                    $cond_gout,
                    $cond_edema,
                    $cond_diabetes,
                    $cond_sunburn,
                    $cond_fever,
                    $cond_pregnant
                );
                if (!$stmt->execute()) throw new Exception('Execute failed (details): '.$stmt->error);
                $stmt->close();

                // payments
                $stmt = $conn->prepare("
                    INSERT INTO payments
                    (appointment_id, customer_id, payment_method, amount_total, status, receipt_file)
                    VALUES (?, ?, ?, ?, 'pending', ?)
                ");
                if (!$stmt) throw new Exception('Prepare failed (payments): '.$conn->error);

                $stmt->bind_param(
                    'iisds',
                    $appointmentId,
                    $customerId,
                    $pm,
                    $total,
                    $gcashFile
                );
                if (!$stmt->execute()) throw new Exception('Execute failed (payments): '.$stmt->error);
                $stmt->close();

                $conn->commit();
                $success = true;

                // clear session data
                unset(
                    $_SESSION['service_category'],
                    $_SESSION['service_id'],
                    $_SESSION['therapist_id'],
                    $_SESSION['service_price'],
                    $_SESSION['appointment_date'],
                    $_SESSION['appointment_timeslot_id'],
                    $_SESSION['appointment_details'],
                    $_SESSION['appointment_payment_method'],
                    $_SESSION['appointment_notes'],
                    $_SESSION['appointment_total'],
                    $_SESSION['appointment_gcash_file']
                );

            } catch (Exception $e) {
                $conn->rollback();
                $error = $e->getMessage();
                $step  = 1;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

/* RESET */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* BODY */
body {
  font-family: 'Inter', sans-serif;
  background-color: #55468E;
  color: #333;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* HEADER */
header {
  background-color: #602f78;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 1rem;
  color: white;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 100;
}

/* clickable logo image */
.logo-link {
  display: flex;
  align-items: center;
  text-decoration: none;
}

.logo-img {
  height: 40px;
  width: auto;
  display: block;
}

header .logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  font-size: 1.125rem;
  color: #FACC15;
  user-select: none;
}

header .logo span.emoji {
  font-size: 1.5rem;
  line-height: 1;
}

header button.menu {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  border: 1px solid white;
  border-radius: 9999px;
  padding: 0.25rem 0.75rem;
  font-size: 0.875rem;
  background: transparent;
  color: white;
  cursor: pointer;
  font-weight: 600;
}

header button.contact {
  background-color: white;
  color: black;
  border-radius: 9999px;
  padding: 0.25rem 1.25rem;
  font-size: 0.875rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
}

/* MAIN LAYOUT */
main {
  flex: 1;
  max-width: 80rem;
  margin: 6rem auto 2rem;
  background-color: #f3f4f6;
  border-radius: 0.375rem;
  box-shadow:
    0 10px 15px -3px rgb(0 0 0 / 0.1),
    0 4px 6px -4px rgb(0 0 0 / 0.1);
  display: flex;
  overflow: hidden;
  min-height: 550px;
}

/* LEFT PANEL */
section.left {
  flex: 1;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

section.left h1 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #111827;
}

section.left h2 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  color: #1f2937;
}

/* PAGE TRANSITIONS */
.page {
  display: none;
  animation: fadeIn 0.25s ease;
}

.page.active {
  display: flex;
  flex-direction: column;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* STEPPER */
.steps {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
  position: relative;
}

.steps::before {
  content: "";
  position: absolute;
  top: 19px;
  left: 10%;
  right: 10%;
  height: 3px;
  background: #ddd;
  z-index: 0;
}

.step {
  flex: 1;
  text-align: center;
  position: relative;
  z-index: 1;
  cursor: default;
}

.circle {
  background: #fff;
  border: 3px solid #6a4ba5;
  color: #6a4ba5;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 14px;
  font-weight: bold;
  margin: 0 auto;
  transition: all 0.3s;
}

.step.active .circle {
  background: #6a4ba5;
  color: #fff;
  box-shadow: 0 0 10px #6a4ba5;
}

.step.done .circle {
  background: #6a4ba5;
  color: #fff;
}

.step p {
  margin: 8px 0 0;
  font-size: 13px;
}

.progress-line {
  position: absolute;
  top: 19px;
  left: 10%;
  height: 3px;
  background: #6a4ba5;
  width: 20%;
  z-index: 0;
  transition: width 0.4s ease;
}

/* FORM ELEMENTS */
.q {
  margin-bottom: 20px;
}

label,
.q p {
  display: block;
  margin: 6px 0;
  font-weight: 600;
  font-size: 0.9rem;
  color: #374151;
}

select,
input[type="text"],
input[type="number"],
input[type="date"],
input[type="time"],
input[type="file"],
textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  background-color: #f3f4f6;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  font-size: 0.95rem;
  font-family: inherit;
}

select:focus,
input:focus,
textarea:focus {
  outline: none;
  border-color: #6a4ba5;
  box-shadow: 0 0 0 2px rgba(106, 75, 165, 0.4);
  background-color: white;
}

textarea {
  resize: vertical;
  min-height: 80px;
}

/* GENERIC BUTTONS */
.buttons,
.btn-row {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}

button.cancel,
.btn-secondary {
  border: 1px solid #9ca3af;
  border-radius: 9999px;
  padding: 0.5rem 1.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  background-color: white;
  color: #374151;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

button.cancel:hover,
.btn-secondary:hover {
  background-color: #e5e7eb;
}

button.prev,
button.next,
.btn-primary {
  background-color: #6a4ba5;
  color: white;
  border-radius: 9999px;
  padding: 0.5rem 1.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

button.prev:hover,
button.next:hover,
.btn-primary:hover {
  background-color: #533c9a;
}

button.prev:active,
button.next:active,
.btn-primary:active {
  transform: scale(0.98);
}

button.prev:disabled,
button.next:disabled,
.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* RIGHT PANEL */
section.right {
  flex: 1;
  overflow: hidden;
}

section.right img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  user-select: none;
}

/* CARD-LIKE BOXES */
.card,
.invoice-box {
  background: linear-gradient(to bottom, #fff, #f9f9f9);
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  width: 100%;
  margin: 0.5rem 0 1rem;
  border: 1px solid #e5e7eb;
}

/* TIME GRID styled like cb-timeslots */
.time-grid {
  display: flex;
  flex-direction: column;
  padding-top: 0.35rem;
  max-height: 17rem;
  overflow-y: auto;
  gap: 0.13rem;
}

.time-slot {
  width: 120px;
  border: 2px solid #d6d7e0;
  background: #f9f8fe;
  color: #262b3a;
  border-radius: 2rem;
  font-size: 1rem;
  font-weight: 500;
  margin-bottom: 0.7rem;
  padding: 0.55rem 0;
  text-align: center;
  cursor: pointer;
  transition: border .18s, background .18s, color .18s;
  display: block;
}

.time-slot input {
  display: none;
}

.time-slot.selected {
  background: #3653f8;
  color: #fff;
  border-color: #3653f8;
}

/* ERROR / SUCCESS */
.error {
  color: #b91c1c;
  background: #fee2e2;
  border: 1px solid #fecaca;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  font-size: 0.9rem;
}

.success {
  color: #166534;
  background: #dcfce7;
  border: 1px solid #bbf7d0;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  font-size: 0.9rem;
}

/* PAYMENT QR + DETAILS LAYOUT */
.payment-section {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
}

.qr {
  width: 200px;
  text-align: center;
}

.qr img {
  width: 100%;
  border-radius: 0.5rem;
  border: 2px solid #e5e7eb;
}

.qr p {
  font-size: 0.875rem;
  color: #4b5563;
  margin-top: 0.5rem;
}

/* GUEST SLIDER */
.guest-slider-wrapper {
  background: #ffffff;
  border-radius: 0.75rem;
  padding: 1rem 1.25rem 1.25rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  border: 1px solid #e5e7eb;
  margin-bottom: 1rem;
}

.guest-slider-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.75rem;
}

.guest-slider-header-title {
  font-size: 0.95rem;
  font-weight: 600;
  color: #111827;
}

.guest-slider-count {
  font-size: 0.8rem;
  color: #6b7280;
}

.guest-slider-inner {
  position: relative;
  overflow: hidden;
  min-height: 150px;
}

.guest-slide {
  display: none;
  animation: fadeIn 0.25s ease;
}

.guest-slide.active {
  display: block;
}

.guest-card {
  padding: 0.5rem 0;
}

.guest-card-title {
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
  color: #4b5563;
}

.guest-slider-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 0.75rem;
}

.guest-slider-btn {
  background-color: #e5e7eb;
  border-radius: 9999px;
  border: none;
  padding: 0.35rem 0.9rem;
  font-size: 0.8rem;
  font-weight: 600;
  color: #374151;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

.guest-slider-btn:hover {
  background-color: #d1d5db;
}

.guest-slider-btn:active {
  transform: scale(0.97);
}

.guest-slider-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.guest-slider-dots {
  display: flex;
  gap: 0.35rem;
  justify-content: center;
  align-items: center;
}

.guest-dot {
  width: 8px;
  height: 8px;
  border-radius: 9999px;
  background-color: #d1d5db;
  transition: all 0.2s ease;
}

.guest-dot.active {
  width: 18px;
  background-color: #6a4ba5;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  main {
    flex-direction: column;
    height: auto;
  }

  section.left,
  section.right {
    width: 100%;
    height: auto;
  }

  section.right {
    height: 200px;
  }

  .payment-section {
    flex-direction: column;
    gap: 1rem;
  }

  .qr {
    width: 100%;
  }
}

@media (max-width: 600px) {
  .time-grid {
    flex-direction: row;
    flex-wrap: wrap;
  }

  .time-slot {
    margin-right: 0.65rem;
  }
}
    </style>
</head>
<body>
<header>
    <a href="Customers_Dashboard.php" class="logo-link">
        <img src="Images/BKT_logo_HD.png" class="logo-img" alt="BKT Logo">
    </a>
    <div class="logo">
        <span class="emoji">💆</span>
        <span>BKT Booking</span>
    </div>
    <button class="contact" type="button" onclick="window.location.href='Customers_Dashboard.php'">
        Dashboard
    </button>
</header>

<main>
    <section class="left">
        <h1>Book an Appointment</h1>

        <!-- Stepper -->
        <div class="steps">
            <div class="step <?php if($step>=1) echo 'done'; if($step===1) echo ' active'; ?>">
                <div class="circle">1</div>
                <p>Service</p>
            </div>
            <div class="step <?php if($step>=2) echo 'done'; if($step===2) echo ' active'; ?>">
                <div class="circle">2</div>
                <p>Date &amp; Time</p>
            </div>
            <div class="step <?php if($step>=3) echo 'done'; if($step===3) echo ' active'; ?>">
                <div class="circle">3</div>
                <p>Health</p>
            </div>
            <div class="step <?php if($step>=4) echo 'done'; if($step===4) echo ' active'; ?>">
                <div class="circle">4</div>
                <p>Payment</p>
            </div>
            <div class="step <?php if($step===5) echo 'active'; ?>">
                <div class="circle">5</div>
                <p>Confirm</p>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success">
                ✓ Appointment submitted and pending confirmation.
            </div>
            <script>
                setTimeout(function(){
                    window.location.href = 'Customers_Dashboard.php';
                }, 3000);
            </script>
        <?php endif; ?>

        <?php if (!$success): ?>

        <!-- STEP 1: SERVICE with pax slider -->
        <div class="page <?php if($step===1) echo 'active'; ?>">
        <?php if ($step===1): ?>
            <form method="post" id="step1Form">
                <input type="hidden" name="form_step" value="1">
                <input type="hidden" id="activeGuestIndex" value="1">

                <h2>Step 1: Choose Service</h2>

                <div class="q">
                    <label>Number of guests (pax)</label>
                    <input type="number"
                           id="paxInput"
                           name="pax"
                           min="1"
                           max="3"
                           value="<?= (int)$pax; ?>">
                </div>

                <div class="guest-slider-wrapper" id="guestSliderWrapper">
                    <div class="guest-slider-header">
                        <div class="guest-slider-header-title">Guest selections</div>
                        <div class="guest-slider-count" id="guestSliderCount">Guest 1 of <?= (int)$pax; ?></div>
                    </div>

                    <div class="guest-slider-inner" id="guestSliderInner">
                        <?php for ($i = 1; $i <= (int)$pax; $i++): ?>
                            <div class="guest-slide <?= $i === 1 ? 'active' : ''; ?>" data-guest="<?= $i; ?>">
                                <div class="guest-card">
                                    <div class="guest-card-title">Guest <?= $i; ?></div>

                                    <div class="q">
                                        <label>Category</label>
                                        <select class="guest-category"
                                                data-guest="<?= $i; ?>">
                                            <option value="">-- Select Category --</option>
                                            <option value="regular">Regular</option>
                                            <option value="with_sauna">With Sauna</option>
                                            <option value="with_thai_foot">With Thai Foot</option>
                                            <option value="body_scrub">Body Scrub</option>
                                        </select>
                                    </div>

                                    <div class="q">
                                        <label>Service</label>
                                        <select class="guest-service"
                                                data-guest="<?= $i; ?>">
                                            <option value="">-- Select Service --</option>
                                            <?php foreach ($services as $s): ?>
                                                <option value="<?= (int)$s['id']; ?>"
                                                        data-category="<?= htmlspecialchars($s['category']); ?>"
                                                        data-price="<?= htmlspecialchars($s['price']); ?>">
                                                    <?= htmlspecialchars($s['name'].' ('.$s['duration_label'].') - ₱'.$s['price']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="q">
                                        <label>Preferred Therapist (optional)</label>
                                        <select class="guest-therapist"
                                                data-guest="<?= $i; ?>">
                                            <option value="0">-- Any Therapist --</option>
                                            <?php foreach ($therapists as $t):
                                                $name = trim($t['first_name'].' '.$t['last_name'].($t['nickname']?' ('.$t['nickname'].')':'')); ?>
                                                <option value="<?= (int)$t['id']; ?>">
                                                    <?= htmlspecialchars($name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="guest-slider-controls">
                        <button type="button" class="guest-slider-btn" id="guestPrevBtn">
                            ◀ Prev
                        </button>
                        <div class="guest-slider-dots" id="guestDots"></div>
                        <button type="button" class="guest-slider-btn" id="guestNextBtn">
                            Next ▶
                        </button>
                    </div>
                </div>

                <!-- Real fields used by PHP backend -->
                <input type="hidden" name="category" id="realCategory" value="<?= htmlspecialchars($serviceCategory); ?>">
                <input type="hidden" name="service_id" id="realServiceId" value="<?= (int)$serviceId; ?>">
                <input type="hidden" name="therapist_id" id="realTherapistId" value="<?= (int)$therapistId; ?>">

                <div class="btn-row">
                    <span></span>
                    <button type="submit" class="btn-primary">Next</button>
                </div>
            </form>

            <script>
// build dots
function rebuildDots(pax, active) {
    const dots = document.getElementById('guestDots');
    dots.innerHTML = '';
    for (let i = 1; i <= pax; i++) {
        const d = document.createElement('div');
        d.className = 'guest-dot' + (i === active ? ' active' : '');
        d.dataset.guest = i;
        d.addEventListener('click', () => setActiveGuest(i, pax));
        dots.appendChild(d);
    }
}

// set active slide
function setActiveGuest(index, pax) {
    const inner = document.getElementById('guestSliderInner');
    inner.querySelectorAll('.guest-slide').forEach(slide => {
        slide.classList.toggle('active', parseInt(slide.dataset.guest) === index);
    });
    document.getElementById('activeGuestIndex').value = index;
    document.getElementById('guestSliderCount').textContent = 'Guest ' + index + ' of ' + pax;
    const dots = document.querySelectorAll('#guestDots .guest-dot');
    dots.forEach(d => d.classList.toggle('active', parseInt(d.dataset.guest) === index));
}

function rebuildSlides() {
    const paxInput = document.getElementById('paxInput');
    let pax = parseInt(paxInput.value || '1', 10);
    if (pax < 1) pax = 1;
    if (pax > 3) pax = 3;
    paxInput.value = pax;

    const inner = document.getElementById('guestSliderInner');
    inner.innerHTML = '';
    for (let i = 1; i <= pax; i++) {
        const slide = document.createElement('div');
        slide.className = 'guest-slide' + (i === 1 ? ' active' : '');
        slide.dataset.guest = i;
        slide.innerHTML = `
            <div class="guest-card">
                <div class="guest-card-title">Guest ${i}</div>

                <div class="q">
                    <label>Category</label>
                    <select class="guest-category" data-guest="${i}">
                        <option value="">-- Select Category --</option>
                        <option value="regular">Regular</option>
                        <option value="with_sauna">With Sauna</option>
                        <option value="with_thai_foot">With Thai Foot</option>
                        <option value="body_scrub">Body Scrub</option>
                    </select>
                </div>

                <div class="q">
                    <label>Service</label>
                    <select class="guest-service" data-guest="${i}">
                        <option value="">-- Select Service --</option>
                        <?php foreach ($services as $s): ?>
                        <option value="<?= (int)$s['id']; ?>"
                                data-category="<?= htmlspecialchars($s['category']); ?>"
                                data-price="<?= htmlspecialchars($s['price']); ?>">
                            <?= htmlspecialchars($s['name'].' ('.$s['duration_label'].') - ₱'.$s['price']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="q">
                    <label>Preferred Therapist (optional)</label>
                    <select class="guest-therapist" data-guest="${i}">
                        <option value="0">-- Any Therapist --</option>
                        <?php foreach ($therapists as $t):
                            $name = trim($t['first_name'].' '.$t['last_name'].($t['nickname']?' ('.$t['nickname'].')':'')); ?>
                        <option value="<?= (int)$t['id']; ?>">
                            <?= htmlspecialchars($name); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        `;
        inner.appendChild(slide);
    }
    document.getElementById('guestSliderCount').textContent = 'Guest 1 of ' + pax;
    document.getElementById('activeGuestIndex').value = 1;
    rebuildDots(pax, 1);
}

document.getElementById('paxInput').addEventListener('change', rebuildSlides);

// prev/next
document.getElementById('guestPrevBtn').addEventListener('click', function () {
    const pax = parseInt(document.getElementById('paxInput').value || '1', 10);
    let current = parseInt(document.getElementById('activeGuestIndex').value || '1', 10);
    if (current > 1) current--;
    setActiveGuest(current, pax);
});

document.getElementById('guestNextBtn').addEventListener('click', function () {
    const pax = parseInt(document.getElementById('paxInput').value || '1', 10);
    let current = parseInt(document.getElementById('activeGuestIndex').value || '1', 10);
    if (current < pax) current++;
    setActiveGuest(current, pax);
});

// category -> filter services per slide
document.addEventListener('change', function (e) {
    if (!e.target.classList.contains('guest-category')) return;
    const guest = e.target.dataset.guest;
    const cat = e.target.value;
    const serviceSelect = document.querySelector('.guest-service[data-guest="'+guest+'"]');
    if (!serviceSelect) return;
    for (const opt of serviceSelect.options) {
        if (!opt.value) continue;
        const c = opt.getAttribute('data-category');
        opt.style.display = (!cat || c === cat) ? '' : 'none';
    }
});

// before submit: copy active guest values into real fields
document.getElementById('step1Form').addEventListener('submit', function (e) {
    const active = parseInt(document.getElementById('activeGuestIndex').value || '1', 10);
    const slideCategory = document.querySelector('.guest-category[data-guest="'+active+'"]');
    const slideService  = document.querySelector('.guest-service[data-guest="'+active+'"]');
    const slideThera    = document.querySelector('.guest-therapist[data-guest="'+active+'"]');

    if (slideCategory) document.getElementById('realCategory').value = slideCategory.value;
    if (slideService)  document.getElementById('realServiceId').value = slideService.value || '';
    if (slideThera)    document.getElementById('realTherapistId').value = slideThera.value || '0';
});

// initial dots/slides state
rebuildSlides();
            </script>
        <?php endif; ?>
        </div>

        <!-- STEP 2: DATE & TIME -->
        <div class="page <?php if($step===2) echo 'active'; ?>">
        <?php if ($step===2): ?>
            <form method="post">
                <input type="hidden" name="form_step" value="2">

                <h2>Step 2: Date &amp; Time</h2>

                <div class="card">
                    <div class="q">
                        <label for="appointment_date">Select Date</label>
                        <input
                            type="date"
                            id="appointment_date"
                            name="appointment_date"
                            value="<?= htmlspecialchars($appointmentDate); ?>"
                            min="<?= date('Y-m-d'); ?>"
                        >
                    </div>

                    <div class="q">
                        <label>Choose Time</label>
                        <div class="time-grid" id="timeGrid">
                            <?php foreach ($timeslots as $ts): ?>
                                <label class="time-slot <?= (int)$timeslotId===(int)$ts['id']?'selected':''; ?>">
                                    <input
                                        type="radio"
                                        name="timeslot_id"
                                        value="<?= (int)$ts['id']; ?>"
                                        <?= (int)$timeslotId===(int)$ts['id']?'checked':''; ?>
                                    >
                                    <?= htmlspecialchars($ts['label']); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-secondary"
                            onclick="window.location.href='appointment.php?step=1'">Back</button>
                    <button type="submit" class="btn-primary">Next</button>
                </div>
            </form>

            <script>
            const grid = document.getElementById('timeGrid');
            grid.addEventListener('click', function(e){
                const label = e.target.closest('.time-slot');
                if (!label) return;
                for (const el of grid.querySelectorAll('.time-slot')) el.classList.remove('selected');
                label.classList.add('selected');
                const input = label.querySelector('input[type=radio]');
                if (input) input.checked = true;
            });
            </script>
        <?php endif; ?>
        </div>

        <!-- STEP 3: HEALTH -->
        <div class="page <?php if($step===3) echo 'active'; ?>">
        <?php if ($step===3): ?>
            <form method="post">
                <input type="hidden" name="form_step" value="3">
                <h2>Step 3: Health Details</h2>

                <div class="card">
                    <h3>General</h3>
                    <label><input type="checkbox" name="is_pregnant" value="1" <?= !empty($details['is_pregnant'])?'checked':''; ?>> Pregnant</label>
                    <label><input type="checkbox" name="has_injuries" value="1" <?= !empty($details['has_injuries'])?'checked':''; ?>> Recent injury / surgery</label>
                    <label><input type="checkbox" name="has_high_bp" value="1" <?= !empty($details['has_high_bp'])?'checked':''; ?>> High blood pressure / heart condition</label>

                    <h3 style="margin-top:1rem;">Other conditions</h3>
                    <label><input type="checkbox" name="cond_diabetes" value="1" <?= !empty($details['cond_diabetes'])?'checked':''; ?>> Diabetes</label>
                    <label><input type="checkbox" name="cond_clots" value="1" <?= !empty($details['cond_clots'])?'checked':''; ?>> Blood clotting issues</label>
                    <label><input type="checkbox" name="cond_skin_inflammation" value="1" <?= !empty($details['cond_skin_inflammation'])?'checked':''; ?>> Skin inflammation / allergy</label>

                    <h3 style="margin-top:1rem;">Special Care</h3>
                    <label>
                        <input type="checkbox" name="aware_no_bath_after_ventosa" value="1"
                            <?= !empty($details['aware_no_bath_after_ventosa'])?'checked':''; ?>>
                        I understand no bath after ventosa treatment.
                    </label>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-secondary"
                            onclick="window.location.href='appointment.php?step=2'">Back</button>
                    <button type="submit" class="btn-primary">Next</button>
                </div>
            </form>
        <?php endif; ?>
        </div>

        <!-- STEP 4: PAYMENT -->
        <div class="page <?php if($step===4) echo 'active'; ?>">
        <?php if ($step===4): ?>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="form_step" value="4">

                <h2>Step 4: Payment &amp; Notes</h2>

                <div class="card">
                    <strong>Service Total:</strong>
                    <p>₱ <?= htmlspecialchars(number_format((float)$servicePrice, 2)); ?></p>
                    <p><strong>Booking fee:</strong> ₱100<br>
                       <strong>Total to pay now:</strong> ₱<?= htmlspecialchars(number_format((float)$servicePrice + 100, 2)); ?></p>
                </div>

                <p><strong>Important:</strong> Bookings require a ₱100 booking fee or full online payment. No on-site payment option.</p>
                <p><strong>Late Policy:</strong> If you are more than 10 minutes late, your booking may be automatically cancelled or rescheduled.</p>

                <div class="payment-section" style="margin-top:1rem;">
                    <div class="qr">
                        <label>Scan to pay with GCash</label>
                        <img src="Images/Gcash.jpg" alt="GCash QR">
                        <p>Use your GCash app to scan this QR code and pay your booking fee or full amount.</p>
                    </div>
                    <div class="details" style="flex:1;">
                        <label>Upload GCash Payment Screenshot (required)</label>
                        <input type="file" name="gcash_receipt" accept="image/*">

                        <label style="margin-top:1rem;">Notes / Special Requests</label>
                        <textarea name="notes"><?= htmlspecialchars($notes); ?></textarea>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-secondary"
                            onclick="window.location.href='appointment.php?step=3'">Back</button>
                    <button type="submit" class="btn-primary">Next</button>
                </div>
            </form>
        <?php endif; ?>
        </div>

        <!-- STEP 5: CONFIRM -->
        <div class="page <?php if($step===5) echo 'active'; ?>">
        <?php if ($step===5): ?>
            <form method="post">
                <input type="hidden" name="form_step" value="5">
                <h2>Step 5: Review &amp; Confirm</h2>

                <div class="card">
                    <strong>Date &amp; Time</strong><br>
                    Date: <?= htmlspecialchars($appointmentDate); ?><br>
                    Timeslot ID: <?= (int)$timeslotId; ?><br><br>

                    <strong>Service</strong><br>
                    Service ID: <?= (int)$serviceId; ?><br>
                    Category: <?= htmlspecialchars($serviceCategory); ?><br><br>

                    <strong>Payment</strong><br>
                    Method: <?= htmlspecialchars($paymentMethod); ?><br>
                    Total: ₱ <?= htmlspecialchars(number_format((float)$servicePrice + 100, 2)); ?><br>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-secondary"
                            onclick="window.location.href='appointment.php?step=4'">Back</button>
                    <button type="submit" class="btn-primary">Confirm Booking</button>
                </div>
            </form>
        <?php endif; ?>
        </div>

        <?php endif; ?>
    </section>

    <section class="right">
        <img src="Images/Wood.jpg" alt="Spa ambience">
    </section>
</main>
</body>
</html>
