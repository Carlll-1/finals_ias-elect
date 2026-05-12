<?php
session_start();
require_once 'config.php';

$message = "";

// Registration Logic 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1NF: Atomic values (hiniwalay ang First at Last Name)
    $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    $dept = mysqli_real_escape_string($conn, $_POST['department']);

    // Check kung registered na ang email
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $message = "Email already registered!";
    } else {
        // Updated SQL Query: Tugma sa bagong 1NF table structure
        $sql = "INSERT INTO users (firstname, lastname, email, password, role, department, face_id_status) 
                VALUES ('$fname', '$lname', '$email', '$password', 'user', '$dept', 'Inactive')";
        
        if ($conn->query($sql)) {
            $message = "Success! <a href='login.php' style='font-weight:bold; color:var(--pink);'>Login here</a>";
        } else {
            $message = "Registration failed: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up — FaceLock</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>" />
</head>
<body>
<div class="login-page">
  <div class="login-left">
    <div class="login-left-inner">
      <div style="font-size:3rem;margin-bottom:16px">🔐</div>
      <h2>Join FaceLock</h2>
      <p>Create an account to start managing your secure access points with next-gen face recognition.</p>
    </div>
  </div>

  <div class="login-right">
    <div class="login-card">
      <div class="login-logo">
        <div class="logo-icon">🔐</div>
        <h1>Create Account</h1>
        <p>Register as a new user</p>
      </div>

      <?php if($message): ?>
        <div class="alert alert-info" style="background:#E3F2FD; color:#0D47A1; padding:12px; border-radius:8px; margin-bottom:20px;">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <div class="alert alert-warning" style="font-size:0.75rem; background:#FFF8E1; border: 1px solid #FFE082; margin-bottom:20px; padding:12px; border-radius:8px;">
        ⚠️ By registering, you consent to the collection of facial data for access control under <strong>RA 10173 (Data Privacy Act)</strong>.
      </div>

      <form action="signup.php" method="POST">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
          <div class="form-group" style="margin:0">
            <label class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" placeholder="John" required />
          </div>
          <div class="form-group" style="margin:0">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" placeholder="Doe" required />
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="john@company.com" required />
        </div>

        <div class="form-group">
          <label class="form-label">Department/Role</label>
          <input type="text" name="department" class="form-control" placeholder="e.g., IT, HR, Resident" required />
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>
      </form>

      <div class="signup-row" style="margin-top: 20px; text-align: center;">
        <p>Already have an account? <a href="login.php" style="color:var(--pink); font-weight:600;">Login</a></p>
        <a href="index.php" style="font-size:0.85rem; color:var(--gray-500);">← Back to home</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>