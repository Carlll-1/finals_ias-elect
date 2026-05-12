<?php
session_start();
// Check if already logged in to redirect to dashboard 
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['role'] == 'admin' ? "admin/dashboard.php" : "user/dashboard.php"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FaceLock — Smart Face Recognition Door Security</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>" />
</head>
<body>

<nav class="navbar" id="navbar">
  <a href="index.php" class="nav-brand">
    <div class="brand-icon">🔐</div>
    FaceLock
  </a>
  <ul class="nav-links">
    <li><a href="#features" class="active">Features</a></li>
    <li><a href="#how-it-works">How It Works</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <div class="nav-actions">
    <a href="login.php" class="btn btn-outline btn-sm">Log In</a>
    <a href="signup.php" class="btn btn-primary btn-sm">Get Started</a>
  </div>
  <div class="hamburger" id="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="#features">Features</a>
  <a href="#how-it-works">How It Works</a>
  <a href="#about">About</a>
  <a href="#contact">Contact</a>
  <a href="login.php" class="btn btn-primary" style="margin-top:8px;text-align:center">Get Started</a>
</div>

<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <div class="hero-tag">🔐 Next-Gen Door Security</div>
        <h1>
          Secure Access with<br>
          <span class="gradient-text">Face Recognition</span><br>
          Technology
        </h1>
        <p>
          FaceLock provides intelligent, contactless door access control. Manage users,
          set granular permissions, and monitor activity — all from one elegant dashboard.
        </p>
        <div class="hero-btns">
          <a href="login.php" class="btn btn-primary">🛡️ Admin Dashboard</a>
          <a href="login.php" class="btn btn-outline">👤 User Portal</a>
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="num" data-count="99" data-suffix="%">0%</span>
            <span>Accuracy Rate</span>
          </div>
          <div class="hero-stat">
            <span class="num" data-count="500" data-suffix="+">0+</span>
            <span>Users Managed</span>
          </div>
          <div class="hero-stat">
            <span class="num" data-count="24" data-suffix="/7">0</span>
            <span>Monitoring</span>
          </div>
        </div>
      </div>

      <div class="hero-visual">
        <div class="face-scanner">
          <div class="face-scanner-inner">
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>
            <div class="scan-line"></div>
            <div class="face-icon">👤</div>
          </div>
        </div>
        <div class="floating-badge fb-1">
          <div class="badge-icon">✅</div>
          <div>
            <div style="font-size:.8rem;color:#2E7D32;font-weight:700">Identity Verified</div>
            <div style="font-size:.72rem;color:#666">0.3s response</div>
          </div>
        </div>
        <div class="floating-badge fb-2">
          <div class="badge-icon">🔓</div>
          <div>
            <div style="font-size:.8rem;color:var(--pink);font-weight:700">Door Unlocked</div>
            <div style="font-size:.72rem;color:#666">Main Entrance</div>
          </div>
        </div>
        <div class="floating-badge fb-3">
          <div class="badge-icon">👥</div>
          <div>
            <div style="font-size:.8rem;font-weight:700">12 Active Users</div>
            <div style="font-size:.72rem;color:#666">Online now</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="features">
  <div class="container">
    <div class="section-header">
      <div class="label">Core Features</div>
      <h2>Everything You Need for Smart Access</h2>
      <p>A complete suite of tools to manage your facility's access control with precision and ease.</p>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">🧠</div>
        <h3>AI Face Recognition</h3>
        [cite_start]<p>Advanced deep-learning model recognizes faces in under 0.3 seconds with 99.7% accuracy. [cite: 19]</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">👥</div>
        <h3>User Management</h3>
        [cite_start]<p>Organize users into departments, assign roles, and manage their profiles centrally. [cite: 9, 46]</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔑</div>
        <h3>Permission Control</h3>
        [cite_start]<p>Set fine-grained permissions per user or group — control zones and time windows. [cite: 47]</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Real-time Monitoring</h3>
        [cite_start]<p>Live dashboard shows who entered, when, and from which door. [cite: 8, 20]</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3>Mobile Responsive</h3>
        <p>Manage everything from any device — desktop, tablet, or phone.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🛡️</div>
        <h3>Secure & Encrypted</h3>
        [cite_start]<p>All face data is encrypted at rest and in transit (RA 10173). [cite: 16, 56]</p>
      </div>
    </div>
  </div>
</section>

<section class="section how-it-works" id="how-it-works">
  <div class="container">
    <div class="section-header">
      <div class="label">Process</div>
      <h2>How FaceLock Works</h2>
      <p>Four simple steps from registration to seamless access.</p>
    </div>
    <div class="steps-grid">
      <div class="step">
        <div class="step-num">1</div>
        <h4>Register Face</h4>
        <p>Admin registers facial biometrics securely into the system.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h4>Set Permissions</h4>
        [cite_start]<p>Assign access zones, time schedules, and roles to users. [cite: 46, 47]</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h4>Face Scan</h4>
        <p>User approaches the door camera. The system matches the face in real time.</p>
      </div>
      <div class="step">
        <div class="step-num">4</div>
        <h4>Access Granted</h4>
        <p>If authorized, the door unlocks instantly. [cite_start]Every event is logged (RA 10175). [cite: 20]</p>
      </div>
    </div>
  </div>
</section>

<section class="stats-banner observe" id="about">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item">
        <span class="big-num" data-count="99" data-suffix=".7%">—</span>
        <span>Recognition Accuracy</span>
      </div>
      <div class="stat-item">
        <span class="big-num" data-count="2500" data-suffix="+">—</span>
        <span>Doors Secured</span>
      </div>
      <div class="stat-item">
        <span class="big-num" data-count="50000" data-suffix="+">—</span>
        <span>Daily Access Events</span>
      </div>
      <div class="stat-item">
        <span class="big-num" data-count="0" data-suffix=".3s">—</span>
        <span>Avg. Recognition Time</span>
      </div>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="nav-brand" style="color:#fff;margin-bottom:14px">
          <div class="brand-icon">🔐</div> FaceLock
        </div>
        [cite_start]<p>Intelligent access control compliant with RA 10173 and RA 10175. [cite: 5]</p>
      </div>
      <div>
        <h4>Product</h4>
        <ul>
          <li><a href="#features">Features</a></li>
          <li><a href="#how-it-works">How It Works</a></li>
        </ul>
      </div>
      <div>
        <h4>Access</h4>
        <ul>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 FaceLock. Built with ❤️ for secure access.</span>
    </div>
  </div>
</footer>

<script>
  /* Trigger counter animation on page load for hero stats */
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.querySelectorAll('.hero-stat .num').forEach(el => {
        const target = parseInt(el.dataset.count, 10);
        const suffix = el.dataset.suffix || '';
        let cur = 0;
        const step = Math.ceil(target / 50) || 1;
        const timer = setInterval(() => {
          cur = Math.min(cur + step, target);
          el.textContent = cur + suffix;
          if (cur >= target) clearInterval(timer);
        }, 30);
      });
    }, 400);
  });
</script>
</body>
</html>