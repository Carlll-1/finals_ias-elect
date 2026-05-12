<?php
session_start();
require_once 'config.php';

$error = "";

// Login Logic 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    $role_input = $_POST['role'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND role = '$role_input' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Plain text check for prototype; use password_verify() for real security [cite: 16]
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: " . ($user['role'] == 'admin' ? "admin/dashboard.php" : "user/dashboard.php"));
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Account not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — FaceLock</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>" />
</head>
<body>
<div class="login-page">
  <div class="login-left">
    <div class="login-left-inner">
      <div style="font-size:3rem;margin-bottom:16px">🔐</div>
      <h2>FaceLock Access Control</h2>
      <p>Secure, intelligent door management powered by face recognition technology.</p>
      <ul class="login-features">
        <li><div class="feat-icon">🧠</div> AI face recognition accuracy (99.7%)</li>
        <li><div class="feat-icon">📊</div> Real-time activity monitoring</li>
        <li><div class="feat-icon">🛡️</div> Bank-grade encryption & privacy</li>
      </ul>
    </div>
  </div>

  <div class="login-right">
    <div class="login-card">
      <div class="login-logo">
        <div class="logo-icon">🔐</div>
        <h1>Welcome Back</h1>
        <p>Sign in to your account</p>
      </div>

      <div class="role-tabs">
        <button class="role-tab active" id="adminBtn" onclick="setRole('admin')">🛡️ Admin</button>
        <button class="role-tab" id="userBtn" onclick="setRole('user')">👤 User</button>
      </div>

      <div class="alert alert-info" style="font-size: 0.85rem; background: #E3F2FD; color: #0D47A1; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        <span id="demoText">Demo admin: <strong>admin@facelock.com</strong> / <strong>admin123</strong></span>
      </div>

      <?php if($error): ?>
        <div class="alert alert-danger" style="background:#FFEBEE; color:#C62828; padding:10px; border-radius:8px; margin-bottom:15px;"><?php echo $error; ?></div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <input type="hidden" name="role" id="roleInput" value="admin">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="you@company.com" required />
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
      </form>
      
      <div id="faceLoginSection" style="display:none; margin-top:20px; text-align:center;">
          <p style="font-size:.8rem; color:var(--gray-500); margin-bottom:10px;">Or sign in with Face ID</p>
          <div class="face-reg-box" onclick="alert('Face ID simulation activated...')">📷 Use Face ID</div>
      </div>

      <div class="signup-row" style="margin-top: 20px; text-align: center;">
        <p>Don't have an account? <a href="signup.php" style="color:var(--pink); font-weight:600;">Sign Up</a></p>
        <a href="index.php">← Back to home</a>
      </div>
    </div>
  </div>
</div>

<script>
  function setRole(role) {
    document.getElementById('roleInput').value = role;
    document.getElementById('adminBtn').classList.toggle('active', role === 'admin');
    document.getElementById('userBtn').classList.toggle('active', role === 'user');
    document.getElementById('demoText').innerHTML = (role === 'admin') ? "Demo admin: <strong>admin@facelock.com</strong> / <strong>admin123</strong>" : "Demo user: <strong>user@facelock.com</strong> / <strong>user123</strong>";
    document.getElementById('faceLoginSection').style.display = (role === 'user') ? 'block' : 'none';
  }
</script>
</body>
</html>