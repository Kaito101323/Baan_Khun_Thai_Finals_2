<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Appointment - Multi-Step</title>
  <link rel="stylesheet" href="appointment.css">
</head>
<body>

<header>
  <button class="menu">Menu</button>

  <a href="Customers_Dashboard.php" class="logo-link">
    <img src="Images/BKT_logo_HD.png" alt="Baan Khun Thai" class="logo-img">
  </a>

  <button class="contact">Contact</button>
</header>

<main>
  <section class="left">

    <!-- PAGE 1: Guests & Services (slider) -->
    <div class="page active" data-page="1">
      <h2>Guests & Services</h2>

      <!-- TOP STEPPER -->
      <div class="steps">
        <div class="progress-line" id="progressLine"></div>
        <div class="step active" onclick="goToPage(1)"><div class="circle">1</div><p>Guests</p></div>
        <div class="step" onclick="goToPage(2)"><div class="circle">2</div><p>Time</p></div>
        <div class="step" onclick="goToPage(3)"><div class="circle">3</div><p>Details</p></div>
        <div class="step" onclick="goToPage(4)"><div class="circle">4</div><p>Payment</p></div>
        <div class="step" onclick="goToPage(5)"><div class="circle">5</div><p>Done</p></div>
      </div>

      <div class="q">
        <label for="paxSelect">Number of Guests</label>
        <select id="paxSelect" onchange="handlePaxChange()">
          <option value="1">1 Guest</option>
          <option value="2">2 Guests</option>
          <option value="3">3 Guests</option>
          <option value="4">4 Guests</option>
          <option value="5">5 Guests</option>
          <option value="6">6 Guests</option>
          <option value="7">7 Guests</option>
          <option value="8">8 Guests</option>
          <option value="9">9 Guests</option>
          <option value="10">10 Guests</option>
          <option value="11">11 Guests</option>
        </select>
      </div>

      <div class="guest-slider-wrapper">
        <div class="guest-slider-header">
          <div>
            <div class="guest-slider-header-title">Configure Guest</div>
            <div class="guest-slider-count" id="guestSliderLabel">Guest 1 of 1</div>
          </div>
        </div>

        <div class="guest-slider-inner" id="guestSliderInner">
          <!-- slides injected by JS -->
        </div>

        <div class="guest-slider-controls">
          <button class="guest-slider-btn" id="guestPrevBtn" onclick="prevGuest()">
            ‹ Prev Guest
          </button>
          <div class="guest-slider-dots" id="guestDots">
            <!-- dots injected by JS -->
          </div>
          <button class="guest-slider-btn" id="guestNextBtn" onclick="nextGuest()">
            Next Guest ›
          </button>
        </div>
      </div>

      <div class="buttons">
        <button class="next" onclick="validateAndNextPage()">Next</button>
      </div>
    </div>

    <!-- PAGE 2: Date & Time -->
    <div class="page" data-page="2">
      <h2>Select Date & Time</h2>

      <!-- TOP STEPPER -->
      <div class="steps">
        <div class="progress-line" id="progressLine"></div>
        <div class="step done" onclick="goToPage(1)"><div class="circle">1</div><p>Guests</p></div>
        <div class="step active" onclick="goToPage(2)"><div class="circle">2</div><p>Time</p></div>
        <div class="step" onclick="goToPage(3)"><div class="circle">3</div><p>Details</p></div>
        <div class="step" onclick="goToPage(4)"><div class="circle">4</div><p>Payment</p></div>
        <div class="step" onclick="goToPage(5)"><div class="circle">5</div><p>Done</p></div>
      </div>

      <div class="calendar-booking-ui">
        <div class="cb-calendar">
          <div class="cb-header">
            <button type="button" class="cb-nav" id="cbPrevMonth">&lt;</button>
            <span class="cb-month-year" id="cbMonthYear">Month 2025</span>
            <button type="button" class="cb-nav" id="cbNextMonth">&gt;</button>
          </div>
          <div class="cb-weekdays">
            <div>Sun</div><div>Mon</div><div>Tue</div>
            <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
          </div>
          <div class="cb-days" id="cbDays">
            <!-- days injected by JS -->
          </div>
        </div>

        <div class="cb-timeslots" id="cbTimeSlots">
          <!-- time buttons injected by JS -->
        </div>

        <input type="hidden" id="dateInput" name="appointment_date">
        <input type="hidden" id="timeInput" name="appointment_time">
      </div>

      <div class="buttons">
        <button class="prev" onclick="goToPage(1)">Previous</button>
        <button class="next" onclick="validateAndNextPage()">Next</button>
      </div>
    </div>

    <!-- PAGE 3: Additional details -->
    <div class="page" data-page="3">
      <h2>Additional Details</h2>

      <!-- TOP STEPPER -->
      <div class="steps">
        <div class="progress-line" id="progressLine"></div>
        <div class="step done" onclick="goToPage(1)"><div class="circle">1</div><p>Guests</p></div>
        <div class="step done" onclick="goToPage(2)"><div class="circle">2</div><p>Time</p></div>
        <div class="step active" onclick="goToPage(3)"><div class="circle">3</div><p>Details</p></div>
        <div class="step" onclick="goToPage(4)"><div class="circle">4</div><p>Payment</p></div>
        <div class="step" onclick="goToPage(5)"><div class="circle">5</div><p>Done</p></div>
      </div>

      <div class="q">
        <p>Special Requests / Notes</p>
        <textarea id="notes" placeholder="Any allergies, special requests, or instructions?"></textarea>
      </div>

      <div class="buttons">
        <button class="prev" onclick="goToPage(2)">Previous</button>
        <button class="next" onclick="validateAndNextPage()">Next</button>
      </div>
    </div>

    <!-- PAGE 4: Payment & Review -->
    <div class="page" data-page="4">
      <h2>Payment & Review</h2>

      <!-- TOP STEPPER -->
      <div class="steps">
        <div class="progress-line" id="progressLine"></div>
        <div class="step done" onclick="goToPage(1)"><div class="circle">1</div><p>Guests</p></div>
        <div class="step done" onclick="goToPage(2)"><div class="circle">2</div><p>Time</p></div>
        <div class="step done" onclick="goToPage(3)"><div class="circle">3</div><p>Details</p></div>
        <div class="step active" onclick="goToPage(4)"><div class="circle">4</div><p>Payment</p></div>
        <div class="step" onclick="goToPage(5)"><div class="circle">5</div><p>Done</p></div>
      </div>

      <div class="payment-section">
        <div class="qr">
          <img src="Images/GCash.png" alt="GCash QR">
          <p>Scan and Pay<br>Lea*** P****bar</p>
        </div>
        <div class="details">
          <label>Guests & Services</label>
          <textarea id="guestsDisplay" rows="3" readonly></textarea>

          <label>Date & Time</label>
          <input type="text" id="datetimeDisplay" readonly>

          <label>Notes</label>
          <textarea id="notesDisplay" rows="3" readonly></textarea>

          <label>Total</label>
          <input type="text" id="totalDisplay" readonly>
        </div>
      </div>

      <div class="buttons">
        <button class="prev" onclick="goToPage(3)">Previous</button>
        <button class="next" onclick="validateAndNextPage()">Next</button>
      </div>
    </div>

    <!-- PAGE 5: Invoice -->
    <div class="page" data-page="5">
      <!-- TOP STEPPER -->
      <div class="steps">
        <div class="progress-line" id="progressLine"></div>
        <div class="step done" onclick="goToPage(1)"><div class="circle">1</div><p>Guests</p></div>
        <div class="step done" onclick="goToPage(2)"><div class="circle">2</div><p>Time</p></div>
        <div class="step done" onclick="goToPage(3)"><div class="circle">3</div><p>Details</p></div>
        <div class="step done" onclick="goToPage(4)"><div class="circle">4</div><p>Payment</p></div>
        <div class="step active" onclick="goToPage(5)"><div class="circle">5</div><p>Done</p></div>
      </div>

      <div class="invoice-box">
        <div class="invoice-header">
          <h3>Invoice</h3>
          <p id="invoiceDate"></p>
        </div>

        <div style="margin-bottom:18px; padding:0.75rem 0.9rem; border-radius:0.6rem; background:#e8f5e9; border-left:4px solid #2e7d32; text-align:center; font-size:0.95rem;">
          <strong>Your appointment request has been sent!</strong><br>
          Please arrive on time. If you are more than <strong>10 minutes late</strong>, your booking may be
          <strong>automatically cancelled or rescheduled</strong> to accommodate other guests.
        </div>

        <table id="invoiceTable">
          <tr>
            <th>Description</th>
            <th>Amount</th>
          </tr>
        </table>

        <div class="total" id="invoiceTotal"></div>

        <div style="margin: 1.8rem 0 0.4rem;">
          <label for="gcashReceipt" style="font-weight:600; color:#6a4ba5; font-size:0.95rem;">
            Upload GCash Receipt (optional)
          </label>
          <input
            type="file"
            id="gcashReceipt"
            name="gcash_receipt"
            accept="image/*,application/pdf"
            style="display:block;margin-top:0.6rem;font-size:0.9rem;">
          <span style="font-size: 0.85rem; color: #6b7280;">
            Accepted formats: JPG, PNG, or PDF. Max size ~5MB. Please upload a screenshot or PDF of your GCash transaction
            if you paid in advance.
          </span>
        </div>

        <p class="note" style="margin-top:1.2rem;">
          Payment can also be completed at the spa upon arrival. Please present this invoice and your GCash receipt (if any)
          to the receptionist for verification.
        </p>

        <div class="buttons" style="margin-top:1.4rem;">
          <button class="prev" onclick="goToPage(4)">Previous</button>
          <button class="next" onclick="completeBooking()">Confirm & Home</button>
        </div>
      </div>
    </div>

  </section>

  <section class="right">
    <img id="rightImage" src="Images/Hot_stone.jpg" alt="Spa image">
  </section>
</main>

<script>
  let currentPage = 1;
  const totalPages = 5;

  let guests = [];
  let paxCount = 1;
  let currentGuestIndex = 0;

  const pageImages = {
    1: 'Images/Hot_stone.jpg',
    2: 'Images/ventosa.jpg',
    3: 'Images/Herbal_balls.jpg',
    4: 'Images/Body_massage.jpg',
    5: 'Images/Body_massage.jpg'
  };

  const SERVICE_CATALOG = [
    { id: 'thai_body_1h', category: 'regular', name: 'Thai Body Massage', duration: '1 HR', price: 400, image: 'Images/Body_massage.jpg' },
    { id: 'thai_foot_lotion_1h', category: 'regular', name: 'Thai Foot Massage (with Foot Lotion)', duration: '1 HR', price: 300, image: 'Images/Foot_massage.jpg' },
    { id: 'swedish_aroma_1h', category: 'regular', name: 'Swedish Massage (with Aromatherapy Oil)', duration: '1 HR', price: 400, image: 'Images/Body_massage.jpg' },
    { id: 'swedish_thai_body_1_5h', category: 'regular', name: 'Swedish + Thai Body Combination', duration: '1.5 HRS', price: 600, image: 'Images/Body_massage.jpg' },
    { id: 'aroma_hotpad_herbal_1_5h', category: 'regular', name: 'Aroma Therapy Massage (with Hot Pad & Herbal Ball, with Aromatherapy Oil)', duration: '1.5 HRS', price: 600, image: 'Images/Herbal_balls.jpg' },
    { id: 'ventosa_swedish_1_5h', category: 'regular', name: 'Ventosa & Swedish Massage (with Aromatherapy Oil)', duration: '1.5 HRS', price: 600, image: 'Images/Ventosa.jpg' },
    { id: 'hotstone_swedish_1_5h', category: 'regular', name: 'Hot Stone with Swedish Massage (with Aromatherapy Oil)', duration: '1.5 HRS', price: 600, image: 'Images/Hot_Stone.jpg' },

    { id: 'ventosa_swedish_sauna_1_5h', category: 'with_sauna', name: 'Ventosa & Swedish Massage (with sauna)', duration: '1.5 HR', price: 700, image: 'Images/Ventosa.jpg' },
    { id: 'hotstone_swedish_sauna_1_5h', category: 'with_sauna', name: 'Hot Stone & Swedish Massage (with sauna)', duration: '1.5 HR', price: 700, image: 'Images/Hot_Stone.jpg' },
    { id: 'swedish_thai_foot_sauna_1_5h', category: 'with_sauna', name: 'Swedish & Thai Foot Massage (with sauna)', duration: '1.5 HR', price: 700, image: 'Images/Foot_massage.jpg' },
    { id: 'swedish_thai_body_sauna_1_5h', category: 'with_sauna', name: 'Swedish & Thai Body Massage (with sauna)', duration: '1.5 HR', price: 700, image: 'Images/Body_massage.jpg' },
    { id: 'swedish_hotpad_herbal_sauna_1_5h', category: 'with_sauna', name: 'Swedish Massage with Hot Pad & Herbal Balls (with sauna)', duration: '1.5 HR', price: 700, image: 'Images/Herbal_balls.jpg' },

    { id: 'swedish_hotstone_thai_foot_1_5h', category: 'with_thai_foot', name: 'Swedish Massage (with Hot Stone) + Thai Foot Massage', duration: '1.5 HR', price: 650, image: 'Images/Hot_Stone.jpg' },
    { id: 'swedish_ventosa_thai_foot_1_5h', category: 'with_thai_foot', name: 'Swedish Massage (with Ventosa) + Thai Foot Massage', duration: '1.5 HR', price: 650, image: 'Images/Ventosa.jpg' },
    { id: 'aroma_hotpad_herbal_thai_foot_1_5h', category: 'with_thai_foot', name: 'Aroma Massage (with Hot Pad & Herbal Ball) + Thai Foot Massage', duration: '1.5 HR', price: 650, image: 'Images/Herbal_balls.jpg' },
    { id: 'thai_body_1_5h', category: 'with_thai_foot', name: 'Thai Body Massage – 1.5 HR', duration: '1.5 HR', price: 550, image: 'Images/Body_massage.jpg' },
    { id: 'swedish_1_5h', category: 'with_thai_foot', name: 'Swedish Massage – 1.5 HR', duration: '1.5 HR', price: 550, image: 'Images/Body_massage.jpg' },

    { id: 'scrub_regular_1h', category: 'body_scrub', name: 'Body Scrub Regular', duration: '1 HR', price: 650, image: 'Images/Body_massage.jpg' },
    { id: 'scrub_thai_body_2h', category: 'body_scrub', name: 'Body Scrub + Thai Body Massage', duration: '2 HRS', price: 850, image: 'Images/Body_massage.jpg' },
    { id: 'scrub_swedish_2h', category: 'body_scrub', name: 'Body Scrub + Swedish Massage', duration: '2 HRS', price: 900, image: 'Images/Body_massage.jpg' },
    { id: 'scrub_aroma_2_5h', category: 'body_scrub', name: 'Body Scrub + Aromatherapy Massage', duration: '2.5 HRS', price: 1100, image: 'Images/Herbal_balls.jpg' },
    { id: 'scrub_hot_oil_2_5h', category: 'body_scrub', name: 'Body Scrub + Hot Oil Massage', duration: '2.5 HRS', price: 1100, image: 'Images/Body_massage.jpg' },
    { id: 'scrub_hot_stone_2_5h', category: 'body_scrub', name: 'Body Scrub + Hot Stone Massage', duration: '2.5 HRS', price: 1200, image: 'Images/Hot_Stone.jpg' },
    { id: 'scrub_ventosa_2_5h', category: 'body_scrub', name: 'Body Scrub + Ventosa Massage', duration: '2.5 HRS', price: 1300, image: 'Images/Ventosa.jpg' }
  ];

  function initGuests(count) {
    paxCount = count;
    guests = [];
    for (let i = 0; i < count; i++) {
      guests.push({
        id: i + 1,
        category: '',
        serviceId: '',
        service: '',
        duration: '',
        price: 0,
        therapist: 'Any'
      });
    }
    currentGuestIndex = 0;
    renderGuestSlides();
    updateGuestSliderUI();
  }

  function handlePaxChange() {
    const select = document.getElementById('paxSelect');
    const count = parseInt(select.value, 10);
    initGuests(count);
  }

  function renderGuestSlides() {
    const inner = document.getElementById('guestSliderInner');
    const dots = document.getElementById('guestDots');
    inner.innerHTML = '';
    dots.innerHTML = '';

    guests.forEach((guest, index) => {
      const slide = document.createElement('div');
      slide.className = 'guest-slide';
      slide.setAttribute('data-guest-index', index);
      slide.innerHTML = `
        <div class="guest-card">
          <div class="guest-card-title">Guest ${guest.id}</div>

          <div class="q">
            <label>Service Category</label>
            <select onchange="updateServiceCategory(${index}, this.value)">
              <option value="">Choose Category</option>
              <option value="regular">Regular massage menu</option>
              <option value="with_sauna">Massage package (with sauna)</option>
              <option value="with_thai_foot">Massage package (with Thai foot massage)</option>
              <option value="body_scrub">Body scrub packages</option>
            </select>
          </div>

          <div class="q">
            <label>Service</label>
            <select id="serviceSelect-${index}" onchange="updateServiceFromDropdown(${index}, this.value)">
              <option value="">Choose Service</option>
            </select>
          </div>

          <div class="q">
            <label>Preferred Therapist</label>
            <select onchange="updateGuestTherapist(${index}, this.value)">
              <option value="Any">No Preference</option>
              <option value="Therapist 1">Therapist 1</option>
              <option value="Therapist 2">Therapist 2</option>
              <option value="Therapist 3">Therapist 3</option>
              <option value="Therapist 4">Therapist 4</option>
              <option value="Therapist 5">Therapist 5</option>
              <option value="Therapist 6">Therapist 6</option>
              <option value="Therapist 7">Therapist 7</option>
              <option value="Therapist 8">Therapist 8</option>
              <option value="Therapist 9">Therapist 9</option>
              <option value="Therapist 10">Therapist 10</option>
              <option value="Therapist 11">Therapist 11</option>
            </select>
          </div>
        </div>
      `;
      inner.appendChild(slide);

      const dot = document.createElement('div');
      dot.className = 'guest-dot';
      dot.setAttribute('data-dot-index', index);
      dots.appendChild(dot);

      if (guest.category) {
        populateServiceDropdown(index, guest.category);
        if (guest.serviceId) {
          const sel = document.getElementById(`serviceSelect-${index}`);
          if (sel) sel.value = guest.serviceId;
        }
      }
    });
  }

  function populateServiceDropdown(guestIndex, category) {
    const selectEl = document.getElementById(`serviceSelect-${guestIndex}`);
    if (!selectEl) return;
    selectEl.innerHTML = '<option value="">Choose Service</option>';

    const filtered = SERVICE_CATALOG.filter(s => s.category === category);
    filtered.forEach(service => {
      const opt = document.createElement('option');
      opt.value = service.id;
      opt.textContent = `${service.name} – ${service.duration} – ₱${service.price}`;
      selectEl.appendChild(opt);
    });
  }

  function updateServiceCategory(guestIndex, category) {
    guests[guestIndex].category = category;
    guests[guestIndex].serviceId = '';
    guests[guestIndex].service = '';
    guests[guestIndex].duration = '';
    guests[guestIndex].price = 0;
    populateServiceDropdown(guestIndex, category);
  }

  function updateServiceFromDropdown(guestIndex, serviceId) {
    const service = SERVICE_CATALOG.find(s => s.id === serviceId);
    if (!service) {
      guests[guestIndex].serviceId = '';
      guests[guestIndex].service = '';
      guests[guestIndex].duration = '';
      guests[guestIndex].price = 0;
      return;
    }
    guests[guestIndex].serviceId = service.id;
    guests[guestIndex].service = service.name;
    guests[guestIndex].duration = service.duration;
    guests[guestIndex].price = service.price;
  }

  function updateGuestTherapist(index, value) {
    guests[index].therapist = value;
  }

  function updateGuestSliderUI() {
    const slides = document.querySelectorAll('.guest-slide');
    const dots = document.querySelectorAll('.guest-dot');
    const label = document.getElementById('guestSliderLabel');

    slides.forEach((slide, index) => {
      slide.classList.toggle('active', index === currentGuestIndex);
    });

    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === currentGuestIndex);
    });

    label.textContent = `Guest ${currentGuestIndex + 1} of ${paxCount}`;

    document.getElementById('guestPrevBtn').disabled = currentGuestIndex === 0;
    document.getElementById('guestNextBtn').disabled = currentGuestIndex === paxCount - 1;
  }

  function nextGuest() {
    if (currentGuestIndex < paxCount - 1) {
      currentGuestIndex++;
      updateGuestSliderUI();
    }
  }

  function prevGuest() {
    if (currentGuestIndex > 0) {
      currentGuestIndex--;
      updateGuestSliderUI();
    }
  }

  const cbMonthYear = document.getElementById('cbMonthYear');
  const cbDays = document.getElementById('cbDays');
  const cbTimeSlots = document.getElementById('cbTimeSlots');
  const dateInput = document.getElementById('dateInput');
  const timeInput = document.getElementById('timeInput');
  const today = new Date();
  let calMonth = today.getMonth();
  let calYear = today.getFullYear();

  function getAvailableTimesFor(dateStr) {
    return [
      "01:00 PM","01:30 PM","02:00 PM","02:30 PM",
      "03:00 PM","03:30 PM","04:00 PM","04:30 PM",
      "05:00 PM","05:30 PM","06:00 PM","06:30 PM",
      "07:00 PM","07:30 PM","08:00 PM","08:30 PM",
      "09:00 PM","09:30 PM","10:00 PM","10:30 PM",
      "11:00 PM","11:30 PM","12:00 AM","12:30 AM","01:00 AM"
    ];
  }

  function renderCalendar(year, month) {
    cbDays.innerHTML = '';

    const monthNames = [
      'January','February','March','April','May','June',
      'July','August','September','October','November','December'
    ];
    cbMonthYear.textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
      const empty = document.createElement('div');
      empty.className = 'cb-day empty';
      cbDays.appendChild(empty);
    }

    const todayMid = new Date(today.getFullYear(), today.getMonth(), today.getDate());

    for (let d = 1; d <= daysInMonth; d++) {
      const cellDate = new Date(year, month, d);
      const cell = document.createElement('button');
      cell.type = 'button';
      cell.className = 'cb-day';
      cell.textContent = d;

      if (
        cellDate.getDate() === today.getDate() &&
        cellDate.getMonth() === today.getMonth() &&
        cellDate.getFullYear() === today.getFullYear()
      ) {
        cell.classList.add('today');
      }

      if (cellDate < todayMid) {
        cell.classList.add('cb-day-disabled');
        cell.disabled = true;
      }

      cell.addEventListener('click', () => {
        document.querySelectorAll('.cb-day.selected').forEach(el => el.classList.remove('selected'));
        cell.classList.add('selected');
        const yyyy = year.toString();
        const mm = String(month + 1).padStart(2, '0');
        const dd = String(d).padStart(2, '0');
        const isoDate = `${yyyy}-${mm}-${dd}`;
        dateInput.value = isoDate;
        renderTimeSlots(isoDate);
      });

      cbDays.appendChild(cell);
    }
  }

  function renderTimeSlots(dateStr) {
    cbTimeSlots.innerHTML = '';
    const times = getAvailableTimesFor(dateStr);
    times.forEach(ts => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'cb-time-btn';
      btn.textContent = ts;
      btn.onclick = () => {
        document.querySelectorAll('.cb-time-btn.selected').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        timeInput.value = ts;
      };
      cbTimeSlots.appendChild(btn);
    });
  }

  document.getElementById('cbPrevMonth').onclick = function() {
    calMonth--;
    if (calMonth < 0) {
      calMonth = 11;
      calYear--;
    }
    renderCalendar(calYear, calMonth);
  };

  document.getElementById('cbNextMonth').onclick = function() {
    calMonth++;
    if (calMonth > 11) {
      calMonth = 0;
      calYear++;
    }
    renderCalendar(calYear, calMonth);
  };

  function goToPage(pageNum) {
    if (pageNum < 1 || pageNum > totalPages) return;

    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelector(`.page[data-page="${pageNum}"]`).classList.add('active');

    currentPage = pageNum;
    updateImage();
    updateTopSteppers();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function updateImage() {
    document.getElementById('rightImage').src = pageImages[currentPage];
  }

  function updateTopSteppers() {
    document.querySelectorAll('.steps').forEach(stepsEl => {
      const circles = stepsEl.querySelectorAll('.step');
      circles.forEach((stepEl, idx) => {
        const stepNum = idx + 1;
        stepEl.classList.toggle('active', stepNum === currentPage);
        stepEl.classList.toggle('done', stepNum < currentPage);
      });
      const line = stepsEl.querySelector('#progressLine');
      if (line) {
        const percent = (currentPage - 1) / (totalPages - 1) * 100;
        line.style.width = percent + '%';
      }
    });
  }

  function validateAndNextPage() {
    switch (currentPage) {
      case 1:
        for (let g of guests) {
          if (!g.service || g.service.trim() === '') {
            alert(`Please choose a category and service for Guest ${g.id}`);
            return;
          }
        }
        savePageData();
        goToPage(2);
        break;

      case 2:
        if (!dateInput.value) {
          alert('Please select a date.');
          return;
        }
        if (!timeInput.value) {
          alert('Please select a time.');
          return;
        }
        savePageData();
        goToPage(3);
        break;

      case 3:
        savePageData();
        updatePaymentReview();
        goToPage(4);
        break;

      case 4:
        generateInvoice();
        goToPage(5);
        break;
    }
  }

  function savePageData() {
    const data = {
      paxCount: paxCount,
      guests: guests,
      date: dateInput.value,
      time: timeInput.value,
      notes: document.getElementById('notes').value
    };
    sessionStorage.setItem('appointmentData', JSON.stringify(data));
  }

  function getPageData() {
    const data = sessionStorage.getItem('appointmentData');
    return data ? JSON.parse(data) : {};
  }

  function updatePaymentReview() {
    const data = getPageData();
    const lines = (data.guests || []).map(
      g => `Guest ${g.id}: ${g.service} - ${g.duration} (${g.therapist || 'Any therapist'}) – ₱${(g.price || 0).toFixed(2)}`
    );
    document.getElementById('guestsDisplay').value = lines.join('\n');
    document.getElementById('datetimeDisplay').value =
      (data.date || '') + ' ' + (data.time || '');
    document.getElementById('notesDisplay').value = data.notes || '';

    let total = 0;
    (data.guests || []).forEach(g => {
      total += g.price || 0;
    });
    document.getElementById('totalDisplay').value = '₱' + total.toFixed(2);
  }

  function generateInvoice() {
    const data = getPageData();
    document.getElementById('invoiceDate').textContent =
      `Issued on ${new Date().toLocaleDateString('en-GB')}`;

    const table = document.getElementById('invoiceTable');
    while (table.rows.length > 1) table.deleteRow(1);

    let totalAmount = 0;
    (data.guests || []).forEach(g => {
      const row = table.insertRow();
      const desc = row.insertCell(0);
      const price = row.insertCell(1);
      desc.textContent = `Guest ${g.id}: ${g.service} - ${g.duration}`;
      const itemPrice = g.price || 0;
      price.textContent = '₱' + itemPrice.toFixed(2);
      totalAmount += itemPrice;
    });

    document.getElementById('invoiceTotal').textContent =
      'Total: ₱' + totalAmount.toFixed(2);
  }

  function completeBooking() {
    alert('Your booking has been confirmed on this front-end.\nNext step is to send it (plus the receipt file) to PHP.');
    sessionStorage.removeItem('appointmentData');
  }

  window.addEventListener('DOMContentLoaded', () => {
    initGuests(1);
    renderCalendar(calYear, calMonth);
    updateImage();
    updateTopSteppers();
  });
</script>

</body>
</html>
