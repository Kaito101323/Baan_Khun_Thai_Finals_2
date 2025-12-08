<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Baan Khun Thai Spa</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700&display=swap');

/* RESET */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: 'Poppins', sans-serif;
  background: #fff;
  color: #333;
}

/* Center main content but keep 100% width */
.main-wrapper {
  width: 100%;
  max-width: 1600px;
  margin: 0 auto;
}

/* Header */
header {
  width: 100%;
  padding: 12px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #6e2c82;
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.header-left {
  display: flex;
  align-items: center;
  gap: 8px;
}

header img.nav-logo {
  height: 40px;
  object-fit: contain;
}

.nav-menu {
  display: flex;
  gap: 12px;
  align-items: center;
}

.nav-menu a {
  text-decoration: none;
  color: white;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 16px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.15);
  transition: 0.3s ease;
  cursor: pointer;
  letter-spacing: 0.3px;
}

.nav-menu a:hover {
  background: #ffd700;
  color: #6e2c82;
}

.primary-btn {
  background: #ffd700;
  color: #6e2c82;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  transition: 0.3s ease;
  padding: 8px 20px;
  font-weight: 600;
  font-size: 13px;
  text-decoration: none;
}

.primary-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
}

/* Hero Section */
#home {
  width: 100%;
  min-height: 700px;
  background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('Images/Baan_Background.jpg') center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  flex-direction: column;
  position: relative;
  text-align: left;
  color: white;
  gap: 20px;
  padding: 70px;
  padding-left: 20px;
}

.hero-content {
  position: absolute;
  left: 80px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.hero-logo {
  position: absolute;
  height: 260px;
  top: -200px;
  object-fit: contain;
  filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.3));
}

/* Hero button container */
.hero-actions {
  position: absolute;
  left: 80px;
  bottom: 90px;
  display: flex;
  gap: 14px;
  z-index: 2;
}

/* Main Book Now button */
.hero-btn {
  background: #ffd700;
  color: #6e2c82;
  padding: 14px 45px;
  font-size: 15px;
  border: none;
  border-radius: 30px;
  cursor: pointer;
  transition: 0.3s ease;
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  text-decoration: none;
}

.hero-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
}

/* Register & Login buttons */
.hero-secondary-btn {
  background: transparent;
  color: #ffd700;
  border-radius: 30px;
  border: 2px solid #ffd700;
  padding: 12px 26px;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
  display: inline-block;
  transition: 0.3s ease;
}

.hero-secondary-btn:hover {
  background: #ffd700;
  color: #6e2c82;
  transform: translateY(-2px);
}

/* Booking popup */
.booking-modal {
  display: none;
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.booking-content {
  background-color: #fff;
  color: #333;
  border-radius: 16px;
  max-width: 720px;
  width: 100%;
  padding: 24px 20px 20px;
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
  font-family: 'Poppins', sans-serif;
}

.booking-content h3 {
  margin-top: 0;
  margin-bottom: 12px;
  font-size: 22px;
  color: #602f78;
}

.booking-close {
  position: absolute;
  right: 14px;
  top: 10px;
  font-size: 22px;
  cursor: pointer;
  color: #888;
}

.booking-close:hover {
  color: #000;
}

.booking-group {
  margin-bottom: 14px;
}

.booking-group label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 4px;
  color: #602f78;
}

.booking-group select {
  width: 100%;
  padding: 8px 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
}

.service-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 12px;
  margin-top: 8px;
}

.service-card {
  background-color: #f9f5ff;
  border-radius: 12px;
  padding: 10px;
  display: flex;
  gap: 10px;
  align-items: center;
  border: 1px solid #e3d7ff;
}

.service-card img {
  width: 80px;
  height: 80px;
  border-radius: 10px;
  object-fit: cover;
}

.service-info {
  flex: 1;
}

.service-title {
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 2px;
  color: #4a2c63;
}

.service-meta {
  font-size: 13px;
  color: #666;
}

.service-price {
  font-weight: 600;
  color: #c28b00;
  margin-top: 3px;
}

/* About Section */
#about {
  background: #6e2c82;
  color: #ffffff;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 60px;
  padding: 160px 120px;
}

#about .text-left {
  flex: 1;
  min-width: 300px;
}

#about .text-left h2 {
  font-family: 'Playfair Display', serif;
  font-size: 48px;
  margin-bottom: 30px;
  color: #ffd700;
  letter-spacing: -1px;
  font-weight: 700;
}

#about .text-left p {
  font-size: 16px;
  line-height: 1.8;
  color: #f0e68c;
}

#about .img-right {
  flex: 1;
  min-width: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

#about .img-right img {
  width: 100%;
  max-width: 650px;
  height: auto;
  border-radius: 15px;
  object-fit: cover;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

/* Team Section */
#team {
  background: linear-gradient(135deg, #7d45a0 0%, #6e2c82 100%);
  color: white;
  display: flex;
  flex-wrap: wrap-reverse;
  gap: 60px;
  align-items: center;
  padding: 148px 90px;
}

#team .team-text {
  flex: 1;
  min-width: 300px;
}

#team .team-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: 48px;
  margin-bottom: 30px;
  letter-spacing: -1px;
  font-weight: 700;
  color: #ffd700;
}

#team .team-text p {
  font-size: 16px;
  line-height: 1.8;
  color: #f0e68c;
}

#team .team-img {
  flex: 1;
  min-width: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

#team .team-img img {
  width: 100%;
  max-width: 1000px;
  height: 400px;
  border-radius: 15px;
  object-fit: cover;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

/* Services Section */
#services {
  background: #fff;
  color: #333;
  text-align: center;
  padding: 80px 60px;
}

#services h2 {
  font-family: 'Playfair Display', serif;
  font-size: 48px;
  margin-bottom: 60px;
  color: #6e2c82;
  letter-spacing: -1px;
  font-weight: 700;
  border-bottom: 3px solid #6e2c82;
  display: inline-block;
  padding-bottom: 10px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  max-width: 1400px;
  margin: 0 auto;
}

.service-thumb {
  position: relative;
  border-radius: 15px;
  overflow: hidden;
  height: 450px;
  cursor: pointer;
  transition: 0.4s ease;
  box-shadow: 0 10px 30px rgba(110, 44, 130, 0.1);
}

.service-thumb:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 50px rgba(110, 44, 130, 0.2);
}

.service-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.service-thumb .overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(110, 44, 130, 0.85), rgba(125, 69, 160, 0.85));
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: white;
  opacity: 0;
  transition: 0.4s ease;
}

.service-thumb:hover .overlay {
  opacity: 1;
}

.service-thumb h3 {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  margin-bottom: 10px;
  letter-spacing: -0.5px;
  font-weight: 700;
}

.service-thumb p {
  font-size: 16px;
  font-weight: 300;
  letter-spacing: 0.5px;
}

/* Contact Section */
#contact {
  background: linear-gradient(135deg, #6e2c82 0%, #7d45a0 100%);
  color: white;
  padding: 80px 60px;
}

#contact h2 {
  font-family: 'Playfair Display', serif;
  font-size: 48px;
  margin-bottom: 60px;
  text-align: center;
  letter-spacing: -1px;
  font-weight: 700;
}

.contact-container {
  display: flex;
  gap: 60px;
  max-width: 1200px;
  margin: 0 auto;
  flex-wrap: wrap;
}

.contact-info {
  flex: 1;
  min-width: 300px;
  text-align: left;
}

.contact-info div {
  font-size: 16px;
  margin-bottom: 25px;
  display: flex;
  align-items: center;
  gap: 15px;
  letter-spacing: 0.5px;
}

.contact-info div span {
  font-size: 24px;
}

.contact-form {
  flex: 1;
  min-width: 300px;
}

.form-group {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 8px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  color: #ffd700;
}

.form-group input,
.form-group textarea {
  padding: 12px 14px;
  border: none;
  border-radius: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  background: rgba(255, 255, 255, 0.95);
  color: #333;
  transition: 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  background: #fff;
  box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
}

.form-submit {
  background: #ffd700;
  color: #6e2c82;
  border: none;
  padding: 12px 40px;
  border-radius: 30px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s ease;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  margin-top: 10px;
}

.form-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
}

/* Footer */
footer {
  background: #3b1a53;
  color: white;
  padding: 40px 60px;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  align-items: center;
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

footer img.footer-logo {
  height: 50px;
  object-fit: contain;
}

.footer-info {
  flex: 1;
  min-width: 250px;
}

.footer-info p {
  margin-bottom: 8px;
  font-size: 15px;
  letter-spacing: 0.5px;
}

.social-links {
  display: flex;
  gap: 15px;
}

.social-links a {
  width: 45px;
  height: 45px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  text-decoration: none;
  font-size: 20px;
  transition: 0.3s ease;
}

.social-links a:hover {
  background: #ffd700;
  color: #6e2c82;
  transform: translateY(-3px);
}

.footer-bottom {
  text-align: center;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 13px;
  opacity: 0.8;
  letter-spacing: 0.5px;
}
</style>
</head>
<body>

<header>
  <div class="header-left">
    <img src="Images/BKT_logo_HD.png" alt="Baan Khun Thai Logo" class="nav-logo">
  </div>
  <nav class="nav-menu">
    <a href="#home">Home</a>
    <a href="#about">About Us</a>
    <a href="#team">Team</a>
    <a href="#services">Services</a>
    <a href="#contact">Contact Us</a>
  </nav>
  <a href="loginbaan.php" class="primary-btn">Login</a>
</header>

<div class="main-wrapper">
  <section id="home">
    <div class="hero-content">
      <img src="Images/Final_Baan_Logo.png" alt="Baan Khun Thai Logo" class="hero-logo">
    </div>

   <div class="hero-actions">
  <button type="button" class="hero-btn" id="openBookingBtn">Book Now</button>
</div>


    <!-- Booking Popup -->
    <div class="booking-modal" id="bookingModal">
      <div class="booking-content">
        <span class="booking-close" id="closeBookingBtn">&times;</span>
        <h3>Select a Service</h3>

        <div class="booking-group">
          <label for="serviceCategory">Category</label>
          <select id="serviceCategory">
            <option value="regular">Regular Massage</option>
            <option value="sauna">Massage Package (with Sauna)</option>
            <option value="thaiFoot">Massage Package (with Thai Foot)</option>
            <option value="scrub">Body Scrub Packages</option>
          </select>
        </div>

        <div id="serviceList" class="service-list"></div>

        <!-- Always-visible register/login row -->
        <div style="margin-top:16px; padding-top:12px; border-top:1px solid #e3d7ff;">
          <div style="font-size:14px; margin-bottom:8px; color:#444;">
            Register now, or login to continue your booking.
          </div>
          <div style="display:flex; flex-wrap:wrap; gap:10px;">
            <a href="registration.php" class="hero-secondary-btn">Register Now</a>
            <a href="loginbaan.php" class="hero-secondary-btn">Login</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section id="about">
    <div class="text-left">
      <h2>About Us</h2>
      <p>
        Welcome to Baan Khun Thai - House of Traditional Massage. Experience a wide range of rejuvenating treatments that combine ancient Thai wellness with modern spa expertise. Our therapists are experienced and dedicated to your wellness. Our parlor offers authentic traditional massage and more. Join us and become a regular and let us take care of your relaxation needs.
      </p>
    </div>
    <div class="img-right">
      <img src="Images/massage.png" alt="Massage Image">
    </div>
  </section>

  <section id="team">
    <div class="team-img">
      <img src="Images/Therapists.png" alt="Our Team">
    </div>
    <div class="team-text">
      <h2>Our Team</h2>
      <p>Our team is composed of skilled, licensed therapists who specialize in traditional Thai massage and modern spa treatments. Every team member is committed to providing a warm, professional, and relaxing experience tailored to each guest’s needs.</p>
    </div>
  </section>

  <section id="services">
    <h2>Our Services</h2>
    <div class="services-grid">
      <div class="service-thumb">
        <img src="Images/Hot_stone.jpg" alt="Hot Stone">
        <div class="overlay">
          <h3>Hot Stone</h3>
          <p>Deep tissue relaxation</p>
        </div>
      </div>
      <div class="service-thumb">
        <img src="Images/Foot_massage.jpg" alt="Foot Massage">
        <div class="overlay">
          <h3>Foot Massage</h3>
          <p>Relaxing foot therapy</p>
        </div>
      </div>
      <div class="service-thumb">
        <img src="Images/Ventosa.jpg" alt="Ventosa">
        <div class="overlay">
          <h3>Ventosa</h3>
          <p>Traditional cupping therapy</p>
        </div>
      </div>
      <div class="service-thumb">
        <img src="Images/Herbal_balls.jpg" alt="Herbal Balls">
        <div class="overlay">
          <h3>Herbal Balls</h3>
          <p>Warm herbal compress</p>
        </div>
      </div>
    </div>
  </section>

  <section id="contact">
    <h2>Contact Us</h2>
    <div class="contact-container">
      <div class="contact-info">
        <div><span>📍</span> Blk 24 lot 53 Saranay Homes Bagumbong Caloocan City</div>
        <div><span>📞</span> 0910-227-8860</div>
        <div><span>✉️</span> info@baankhunthai.com</div>
      </div>
      <div class="contact-form">
        <form onsubmit="handleFormSubmit(event)">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone">
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
          </div>
          <button type="submit" class="form-submit">Send Message</button>
        </form>
      </div>
    </div>
  </section>
</div>

<footer>
  <div class="footer-content">
    <img src="Images/Final_Baan_logo.png" alt="Baan Khun Thai Logo" class="footer-logo">
    <div class="footer-info">
      <p>Baan Khun Thai - House of Traditional Massage</p>
      <p>Blk 24 lot 53 Saranay Homes Bagumbong Caloocan City </p>
      <p>0910-227-8860</p>
    </div>
    <div class="social-links">
      <a href="#" title="Facebook">f</a>
      <a href="#" title="Instagram">📷</a>
      <a href="#" title="Twitter">𝕏</a>
    </div>
  </div>
  <div class="footer-bottom">© 2024 Baan Khun Thai. All rights reserved.</div>
</footer>

<script>
/* smooth scroll for header links */
document.querySelectorAll('.nav-menu a').forEach(a => {
  a.addEventListener('click', e => {
    e.preventDefault();
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      target.scrollIntoView({behavior: 'smooth'});
    }
  });
});

/* contact form */
function handleFormSubmit(event) {
  event.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const message = document.getElementById('message').value;

  console.log('Form submitted:', { name, email, phone, message });
  alert('Thank you for your message! We will get back to you soon.');
  event.target.reset();
}

/* booking popup data */
const servicesData = {
  regular: [
    { title: 'Thai Body Massage', time: '1 HR', price: '₱400', img: 'Body_massage.jpg' },
    { title: 'Thai Foot Massage (with Foot Lotion)', time: '1 HR', price: '₱300', img: 'Foot_massage.jpg' },
    { title: 'Swedish Massage (with Aromatherapy Oil)', time: '1 HR', price: '₱400', img: 'Body_massage.jpg' },
    { title: 'Swedish + Thai Body Combination', time: '1.5 HRS', price: '₱600', img: 'Body_massage.jpg' },
    { title: 'Aroma Therapy Massage (Hot Pad & Herbal Ball, Aromatherapy Oil)', time: '1.5 HRS', price: '₱600', img: 'Herbal_balls.jpg' },
    { title: 'Ventosa & Swedish Massage (with Aromatherapy Oil)', time: '1.5 HRS', price: '₱600', img: 'Ventosa.jpg' },
    { title: 'Hot Stone with Swedish Massage (with Aromatherapy Oil)', time: '1.5 HRS', price: '₱600', img: 'Hot_stone.jpg' }
  ],
  sauna: [
    { title: 'Ventosa & Swedish Massage', time: '1.5 HR', price: '₱700', img: 'Ventosa.jpg' },
    { title: 'Hot Stone & Swedish Massage', time: '1.5 HR', price: '₱700', img: 'Hot_stone.jpg' },
    { title: 'Swedish & Thai Foot Massage', time: '1.5 HR', price: '₱700', img: 'Foot_massage.jpg' },
    { title: 'Swedish & Thai Body Massage', time: '1.5 HR', price: '₱700', img: 'Body_massage.jpg' },
    { title: 'Swedish Massage with Hot Pad & Herbal Balls', time: '1.5 HR', price: '₱700', img: 'Herbal_balls.jpg' }
  ],
  thaiFoot: [
    { title: 'Swedish Massage (with Hot Stone)', time: '1.5 HR', price: '₱650', img: 'Hot_stone.jpg' },
    { title: 'Swedish Massage (with Ventosa)', time: '1.5 HR', price: '₱650', img: 'Ventosa.jpg' },
    { title: 'Aroma Massage (with Hot Pad & Herbal Ball)', time: '1.5 HR', price: '₱650', img: 'Herbal_balls.jpg' },
    { title: 'Thai Body Massage', time: '1.5 HR', price: '₱550', img: 'Body_massage.jpg' },
    { title: 'Swedish Massage', time: '1.5 HR', price: '₱550', img: 'Body_massage.jpg' }
  ],
  scrub: [
    { title: 'Body Scrub Regular', time: '1 HR', price: '₱650', img: 'Body_massage.jpg' },
    { title: 'Body Scrub + Thai Body Massage', time: '2 HRS', price: '₱850', img: 'Body_massage.jpg' },
    { title: 'Body Scrub + Swedish Massage', time: '2 HRS', price: '₱900', img: 'Body_massage.jpg' },
    { title: 'Body Scrub + Aromatherapy Massage', time: '2.5 HRS', price: '₁,100', img: 'Herbal_balls.jpg' },
    { title: 'Body Scrub + Hot Oil Massage', time: '2.5 HRS', price: '₱1,100', img: 'Body_massage.jpg' },
    { title: 'Body Scrub + Hot Stone Massage', time: '2.5 HRS', price: '₱1,200', img: 'Hot_stone.jpg' },
    { title: 'Body Scrub + Ventosa Massage', time: '2.5 HRS', price: '₱1,300', img: 'Ventosa.jpg' }
  ]
};

const openBtn = document.getElementById('openBookingBtn');
const modal = document.getElementById('bookingModal');
const closeBtn = document.getElementById('closeBookingBtn');
const categorySelect = document.getElementById('serviceCategory');
const serviceList = document.getElementById('serviceList');

/* render service cards */
function renderServices(category) {
  serviceList.innerHTML = '';

  servicesData[category].forEach(service => {
    const card = document.createElement('div');
    card.className = 'service-card';
    card.innerHTML = `
      <img src="Images/${service.img}" alt="${service.title}">
      <div class="service-info">
        <div class="service-title">${service.title}</div>
        <div class="service-meta">${service.time}</div>
        <div class="service-price">${service.price}</div>
      </div>
    `;
    serviceList.appendChild(card);
  });
}

/* open popup */
openBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
  renderServices(categorySelect.value);
});

/* close popup */
closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === modal) {
    modal.style.display = 'none';
  }
});

/* change category */
categorySelect.addEventListener('change', () => {
  renderServices(categorySelect.value);
});
</script>

</body>
</html>
