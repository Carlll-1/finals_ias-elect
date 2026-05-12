<?php
session_start();
require_once('../config.php');

// Check kung naka-login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kunin ang data ng logged-in user para sa Sidebar
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$initials = strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1));

// Kunin ang logs ng specific user na 'to
$log_query = "SELECT * FROM access_logs WHERE user_id = '$user_id' ORDER BY timestamp DESC";
$logs = mysqli_query($conn, $log_query);
$total_logs = mysqli_num_rows($logs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Access History — FaceLock</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📋</text></svg>" />
</head>
<body>
<div class="app-layout">
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><div class="sidebar-logo"><div class="logo-box">🔐</div><span>FaceLock</span></div><button class="sidebar-toggle" id="sidebarToggle">◀</button></div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">My Portal</div>
      <a class="nav-item" href="dashboard.php"><span class="nav-icon">🏠</span><span>My Dashboard</span></a>
      <a class="nav-item" href="profile.php"><span class="nav-icon">👤</span><span>My Profile</span></a>
      <a class="nav-item active" href="access-history.php"><span class="nav-icon">📋</span><span>Access History</span></a>
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
        <div class="topbar-left"><h2>Access History</h2><p>Your complete door access log</p></div>
      </div>
      <div class="topbar-right">
        <button class="topbar-btn" id="notifBtn">🔔<span class="notif-dot"></span></button>
        <button class="btn btn-outline btn-sm">📥 Export PDF</button>
      </div>
    </div>
    <div class="page-content">
      <div class="breadcrumb"><a href="dashboard.php">🏠 Home</a><span class="sep">›</span><span>Access History</span></div>
      <div class="stat-cards">
        <div class="stat-card"><div class="stat-info"><span class="stat-label">Today</span><span class="stat-val">3</span><span class="stat-change up">▲ All granted</span></div><div class="stat-icon-wrap si-green">✅</div></div>
        <div class="stat-card"><div class="stat-info"><span class="stat-label">This Week</span><span class="stat-val">18</span><span class="stat-change up">▲ Normal activity</span></div><div class="stat-icon-wrap si-blue">📊</div></div>
        <div class="stat-card"><div class="stat-info"><span class="stat-label">This Month</span><span class="stat-val">58</span><span class="stat-change up">▲ 58 granted</span></div><div class="stat-icon-wrap si-pink">📅</div></div>
        <div class="stat-card"><div class="stat-info"><span class="stat-label">Total Events</span><span class="stat-val"><?php echo $total_logs; ?></span><span class="stat-change up">▲ Recorded</span></div><div class="stat-icon-wrap si-orange">🔐</div></div>
      </div>
      <div class="card">
        <div class="card-header"><h3>📋 My Access Log</h3><span class="badge badge-success"><?php echo $total_logs; ?> total events</span></div>
        <div class="card-body">
          <div class="toolbar">
            <div class="search-wrap"><span class="search-icon">🔍</span><input type="text" id="tableSearch" placeholder="Search zone or date…" /></div>
            <select class="form-control" id="statusFilter" style="width:auto;min-width:130px"><option value="">All Events</option><option value="granted">Granted</option><option value="denied">Denied</option></select>
            <input type="month" class="form-control" style="width:auto" value="<?php echo date('Y-m'); ?>" />
          </div>
          <div class="table-responsive">
            <table class="data-table">
              <thead><tr><th>#</th><th>Zone / Door</th><th>Status</th><th>Scan Time</th><th>Date &amp; Time</th></tr></thead>
              <tbody>
                <?php 
                if (mysqli_num_rows($logs) > 0):
                  while($row = mysqli_fetch_assoc($logs)): 
                ?>
                  <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td>🚪 <?php echo htmlspecialchars($row['zone_name']); ?></td>
                    <td>
                      <?php 
                        $statusClass = (strtolower($row['status']) == 'granted') ? 'badge-success' : 'badge-danger';
                      ?>
                      <span class="badge <?php echo $statusClass; ?> badge-dot"><?php echo htmlspecialchars($row['status']); ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($row['scan_time']); ?>s</td>
                    <td><?php echo date('M d, Y h:i A', strtotime($row['timestamp'])); ?></td>
                  </tr>
                <?php 
                  endwhile;
                else:
                ?>
                  <tr><td colspan="5" style="text-align:center; padding: 20px;">No access records found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;flex-wrap:wrap;gap:10px">
            <span style="font-size:.82rem;color:var(--gray-500)">Showing <?php echo mysqli_num_rows($logs); ?> of <?php echo $total_logs; ?> events</span>
            <div style="display:flex;gap:6px">
              <button class="btn btn-ghost btn-sm">← Prev</button>
              <button class="btn btn-primary btn-sm">1</button>
              <button class="btn btn-ghost btn-sm">Next →</button>
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