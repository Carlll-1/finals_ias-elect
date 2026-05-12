<?php
session_start();
require_once('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$initials = strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1));

// Logic para sa pag-save ng changes
if(isset($_POST['update_profile'])) {
    $fname = mysqli_real_escape_with_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_with_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_with_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_with_string($conn, $_POST['phone']);
    
    $update = "UPDATE users SET firstname='$fname', lastname='$lname', email='$email', phone='$phone' WHERE id='$user_id'";
    
    if(mysqli_query($conn, $update)) {
        header("Location: profile.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile — FaceLock</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👤</text></svg>" />
</head>
<body>

<div class="app-layout">
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><div class="sidebar-logo"><div class="logo-box">🔐</div><span>FaceLock</span></div><button class="sidebar-toggle" id="sidebarToggle">◀</button></div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">My Portal</div>
      <a class="nav-item" href="dashboard.php"><span class="nav-icon">🏠</span><span>My Dashboard</span></a>
      <a class="nav-item active" href="profile.php"><span class="nav-icon">👤</span><span>My Profile</span></a>
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
          <div class="u-name"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></div>
          <div class="u-role"><?php echo htmlspecialchars($user['role']); ?></div>
        </div>
      </div>
    </div>
  </aside>

  <main class="app-main" id="appMain">
    <form action="profile.php" method="POST">
      <div class="topbar">
        <div style="display:flex;align-items:center;gap:12px">
          <button type="button" class="mobile-sidebar-toggle" id="mobileSidebarToggle">☰</button>
          <div class="topbar-left"><h2>My Profile</h2><p>Manage your personal information and Face ID</p></div>
        </div>
        <div class="topbar-right">
          <button type="button" class="topbar-btn" id="notifBtn">🔔<span class="notif-dot"></span></button>
          <button type="submit" name="update_profile" class="btn btn-primary btn-sm">💾 Save Changes</button>
        </div>
      </div>

      <div class="page-content">
        <?php if(isset($_GET['success'])): ?>
          <div class="alert alert-success mb-16">✅ Profile updated successfully!</div>
        <?php endif; ?>

        <div class="breadcrumb">
          <a href="dashboard.php">🏠 Home</a><span class="sep">›</span>
          <span>My Profile</span>
        </div>

        <div class="profile-header">
          <div class="profile-avatar"><?php echo $initials; ?></div>
          <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h2>
            <p>📧 <?php echo htmlspecialchars($user['email']); ?> · 📞 <?php echo htmlspecialchars($user['phone'] ?? '+63 000 000 0000'); ?></p>
            <div class="profile-badges">
              <span class="profile-badge">👔 <?php echo htmlspecialchars($user['role']); ?></span>
              <span class="profile-badge">🏢 HR &amp; Admin</span>
              <span class="profile-badge">✅ Face ID Active</span>
              <span class="profile-badge">🔐 6 Zones</span>
            </div>
          </div>
        </div>

        <div class="content-grid">
          <div style="display:flex;flex-direction:column;gap:24px">
            <div class="card">
              <div class="card-header"><h3>👤 Personal Information</h3></div>
              <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                  <div class="form-group" style="margin:0"><label class="form-label">First Name</label><input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($user['firstname']); ?>" /></div>
                  <div class="form-group" style="margin:0"><label class="form-label">Last Name</label><input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($user['lastname']); ?>" /></div>
                </div>
                <div class="form-group mt-16"><label class="form-label">Email Address</label><div class="input-icon-wrap"><span class="input-icon">📧</span><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" /></div></div>
                <div class="form-group"><label class="form-label">Phone Number</label><div class="input-icon-wrap"><span class="input-icon">📞</span><input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" /></div></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                  <div class="form-group" style="margin:0"><label class="form-label">Department</label><input type="text" class="form-control" value="HR &amp; Admin" readonly style="background:var(--gray-100);color:var(--gray-500)" /></div>
                  <div class="form-group" style="margin:0"><label class="form-label">Role</label><input type="text" class="form-control" value="<?php echo htmlspecialchars($user['role']); ?>" readonly style="background:var(--gray-100);color:var(--gray-500)" /></div>
                </div>
                <p style="font-size:.78rem;color:var(--gray-500);margin-top:8px">Department and role can only be changed by an administrator.</p>
              </div>
            </div>
    </form> <div class="card">
            <div class="card-header"><h3>🔒 Change Password</h3></div>
            <div class="card-body">
              <form action="change_password.php" method="POST">
                <div class="form-group"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" placeholder="••••••••" /></div>
                <div class="form-group"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" placeholder="Min. 8 characters" /></div>
                <div class="form-group"><label class="form-label">Confirm New Password</label><input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" /></div>
                <button type="submit" class="btn btn-outline">🔒 Update Password</button>
              </form>
            </div>
          </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:24px">
          <div class="card">
            <div class="card-header"><h3>📷 Face ID Registration</h3><span class="badge badge-success badge-dot">Registered</span></div>
            <div class="card-body">
              <div class="alert alert-success mb-16">
                <span class="alert-icon">✅</span>
                <span>Your Face ID is registered and active. Last updated Jan 15, 2025.</span>
              </div>
              <div class="face-reg-box" id="faceRegBox">
                <div class="face-reg-icon">📷</div>
                <h4>Re-register Face ID</h4>
                <p>Click to capture a new face photo. This will replace your current Face ID.</p>
              </div>
              <p style="font-size:.78rem;color:var(--gray-500);margin-top:12px">⚠️ Re-registering will temporarily disable access until the new Face ID is verified by an admin.</p>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3>🔑 Access Overview</h3>
              <a href="my-permissions.php" class="btn btn-ghost btn-sm">See all →</a>
            </div>
            <div class="card-body">
              <div style="display:flex;flex-direction:column;gap:10px">
                <div class="zone-card"><div class="zone-icon">🚪</div><div class="zone-info"><div class="z-name">Main Entrance</div><div class="z-sub">All hours</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🔬</div><div class="zone-info"><div class="z-name">Lab A &amp; B</div><div class="z-sub">06:00 – 22:00</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🏢</div><div class="zone-info"><div class="z-name">Office Floors</div><div class="z-sub">Weekdays</div></div><span class="badge badge-success badge-dot">Active</span></div>
                <div class="zone-card"><div class="zone-icon">🚗</div><div class="zone-info"><div class="z-name">Parking</div><div class="z-sub">All hours</div></div><span class="badge badge-success badge-dot">Active</span></div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header"><h3>📊 My Stats</h3></div>
            <div class="card-body">
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div style="text-align:center;padding:16px;background:var(--pink-ghost);border-radius:var(--radius-sm)">
                  <div style="font-size:1.8rem;font-weight:800;color:var(--pink)">58</div>
                  <div style="font-size:.8rem;color:var(--gray-500)">This Month</div>
                </div>
                <div style="text-align:center;padding:16px;background:#E8F5E9;border-radius:var(--radius-sm)">
                  <div style="font-size:1.8rem;font-weight:800;color:#2E7D32">100%</div>
                  <div style="font-size:.8rem;color:var(--gray-500)">Success Rate</div>
                </div>
                <div style="text-align:center;padding:16px;background:#E3F2FD;border-radius:var(--radius-sm)">
                  <div style="font-size:1.8rem;font-weight:800;color:#1565C0">0.28s</div>
                  <div style="font-size:.8rem;color:var(--gray-500)">Avg Scan Time</div>
                </div>
                <div style="text-align:center;padding:16px;background:#FFF3E0;border-radius:var(--radius-sm)">
                  <div style="font-size:1.8rem;font-weight:800;color:#E65100">6</div>
                  <div style="font-size:.8rem;color:var(--gray-500)">Zones Access</div>
                </div>
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