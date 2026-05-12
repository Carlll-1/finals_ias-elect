<?php
session_start();
require_once('../config.php');

// Check kung naka-login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Kunin ang data ng logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Para sa initials sa avatar (e.g., "AV")
$initials = strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Dashboard — FaceLock</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👤</text></svg>" />
</head>
<body>

<div class="app-layout">
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo"><div class="logo-box">🔐</div><span>FaceLock</span></div>
      <button class="sidebar-toggle" id="sidebarToggle">◀</button>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">My Portal</div>
      <a class="nav-item active" href="dashboard.php"><span class="nav-icon">🏠</span><span>My Dashboard</span></a>
      <a class="nav-item" href="profile.php"><span class="nav-icon">👤</span><span>My Profile</span></a>
      <a class="nav-item" href="access-history.php"><span class="nav-icon">📋</span><span>Access History</span></a>
      <div class="nav-section-label" style="margin-top:12px">Information</div>
      <a class="nav-item" href="my-permissions.php"><span class="nav-icon">🔑</span><span>My Permissions</span></a>
      <a class="nav-item" href="#"><span class="nav-icon">🔔</span><span>Notifications</span></a>
      <div class="nav-section-label" style="margin-top:12px">Account</div>
      <a class="nav-item" href="profile.php"><span class="nav-icon">⚙️</span><span>Account Settings</span></a>
      <a class="nav-item" href="../logout.php"><span class="nav-icon">🚪</span><span>Logout</span></a>
    </nav>
    <div class="sidebar-footer">
      <div class="user-card">
        <div class="user-avatar"><?php echo $initials; ?></div>
        <div class="user-info">
          <div class="u-name"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></div>
          <div class="u-role"><?php echo $user['role']; ?></div>
        </div>
      </div>
    </div>
  </aside>

  <main class="app-main" id="appMain">
    <div class="topbar">
      <div style="display:flex;align-items:center;gap:12px">
        <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">☰</button>
        <div class="topbar-left">
          <h2>Good morning, <?php echo $user['firstname']; ?>! 👋</h2>
          <p>Here's your access summary for today</p>
        </div>
      </div>
      <div class="topbar-right">
        <div class="dropdown-wrap">
          <button class="topbar-btn" id="notifBtn">🔔<span class="notif-dot"></span></button>
          <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-header"><h4>Notifications</h4><span class="notif-clear">Mark all read</span></div>
            <div class="notif-item unread">
              <div class="notif-dot-small"></div>
              <div class="notif-item-info"><div class="n-title">✅ Access granted – Main Entrance</div><div class="n-time">Today at 09:42 AM</div></div>
            </div>
            <div class="notif-item unread">
              <div class="notif-dot-small"></div>
              <div class="notif-item-info"><div class="n-title">🔑 Your Lab A access renewed</div><div class="n-time">Yesterday</div></div>
            </div>
            <div class="notif-item">
              <div class="notif-dot-small read"></div>
              <div class="notif-item-info"><div class="n-title">⚙️ Profile updated by Admin</div><div class="n-time">2 days ago</div></div>
            </div>
          </div>
        </div>
        <div class="topbar-user" onclick="window.location='profile.php'">
          <div class="user-avatar" style="width:36px;height:36px;font-size:.82rem"><?php echo $initials; ?></div>
          <div><div class="u-name"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></div><div class="u-role"><?php echo $user['role']; ?></div></div>
        </div>
      </div>
    </div>

    <div class="page-content">
      <div class="breadcrumb">
        <a href="dashboard.php">🏠 Home</a><span class="sep">›</span>
        <span>Dashboard</span>
      </div>

      <div class="door-status-card" style="margin-bottom:24px;text-align:left;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;padding:28px 32px">
        <div style="position:relative;z-index:1">
          <div style="font-size:.85rem;opacity:.8;margin-bottom:6px">Your Face ID Status</div>
          <div style="font-size:1.6rem;font-weight:800;margin-bottom:8px">✅ Face ID Registered &amp; Active</div>
          <div style="font-size:.9rem;opacity:.85">Last verified: Today at 09:42 AM · Main Entrance</div>
        </div>
        <a href="profile.php" class="door-toggle-btn" style="text-decoration:none">Manage Profile →</a>
      </div>

      <div class="stat-cards">
        <div class="stat-card">
          <div class="stat-info"><span class="stat-label">Accesses Today</span><span class="stat-val">3</span><span class="stat-change up">▲ All granted</span></div>
          <div class="stat-icon-wrap si-green">✅</div>
        </div>
        <div class="stat-card">
          <div class="stat-info"><span class="stat-label">This Month</span><span class="stat-val">58</span><span class="stat-change up">▲ +5 vs last month</span></div>
          <div class="stat-icon-wrap si-blue">📊</div>
        </div>
        <div class="stat-card">
          <div class="stat-info"><span class="stat-label">Zones Accessible</span><span class="stat-val">6</span><span class="stat-change up">▲ Active permissions</span></div>
          <div class="stat-icon-wrap si-pink">🔑</div>
        </div>
        <div class="stat-card">
          <div class="stat-info"><span class="stat-label">Denied Events</span><span class="stat-val">0</span><span class="stat-change up">▲ Clean record</span></div>
          <div class="stat-icon-wrap si-orange">🚫</div>
        </div>
      </div>

      <div class="content-grid">
        <div class="card">
          <div class="card-header">
            <h3>📋 Today's Access Activity</h3>
            <a href="access-history.php" class="btn btn-ghost btn-sm">Full History →</a>
          </div>
          <div class="card-body" style="padding:20px 24px">
            <div class="timeline">
              <div class="timeline-item">
                <div class="tl-icon">✅</div>
                <div class="tl-info">
                  <div class="tl-title">Main Entrance — Granted</div>
                  <div class="tl-sub">Face ID verified in 0.28s</div>
                </div>
                <div class="tl-time">09:42 AM</div>
              </div>
              <div class="timeline-item">
                <div class="tl-icon">✅</div>
                <div class="tl-info">
                  <div class="tl-title">Lab A — Granted</div>
                  <div class="tl-sub">Face ID verified in 0.31s</div>
                </div>
                <div class="tl-time">09:35 AM</div>
              </div>
              <div class="timeline-item">
                <div class="tl-icon">✅</div>
                <div class="tl-info">
                  <div class="tl-title">Office Floor 3 — Granted</div>
                  <div class="tl-sub">Face ID verified in 0.25s</div>
                </div>
                <div class="tl-time">09:10 AM</div>
              </div>
            </div>
            <div style="text-align:center;padding:16px 0;color:var(--gray-500);font-size:.85rem">
              🎉 No denied access today — great record!
            </div>
          </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:20px">
          <div class="card">
            <div class="card-header">
              <h3>🔑 My Access Zones</h3>
              <a href="my-permissions.php" class="btn btn-ghost btn-sm">Details →</a>
            </div>
            <div class="card-body">
              <div style="display:flex;flex-direction:column;gap:8px">
                <div class="zone-card"><div class="zone-icon">🚪</div><div class="zone-info"><div class="z-name">Main Entrance</div><div class="z-sub">All hours</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🔬</div><div class="zone-info"><div class="z-name">Lab A &amp; B</div><div class="z-sub">06:00–22:00</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🏢</div><div class="zone-info"><div class="z-name">Office Floors</div><div class="z-sub">Mon–Fri</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🚗</div><div class="zone-info"><div class="z-name">Parking</div><div class="z-sub">All hours</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🖥️</div><div class="zone-info"><div class="z-name">Server Room</div><div class="z-sub">No access</div></div><span class="badge badge-danger badge-dot">Restricted</span></div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header"><h3>⚡ Quick Links</h3></div>
            <div class="card-body">
              <div class="quick-grid">
                <a href="profile.php"        class="quick-item"><div class="quick-item-icon">👤</div><div class="quick-item-text"><div class="q-label">My Profile</div><div class="q-sub">Update info</div></div></a>
                <a href="my-permissions.php"  class="quick-item"><div class="quick-item-icon">🔑</div><div class="quick-item-text"><div class="q-label">Permissions</div><div class="q-sub">View access</div></div></a>
                <a href="access-history.php"  class="quick-item"><div class="quick-item-icon">📋</div><div class="quick-item-text"><div class="q-label">History</div><div class="q-sub">All events</div></div></a>
                <a href="../logout.php"         class="quick-item"><div class="quick-item-icon">🚪</div><div class="quick-item-text"><div class="q-label">Logout</div><div class="q-sub">Sign out</div></div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script src="../js/main.js"></script>
</body>
</html>