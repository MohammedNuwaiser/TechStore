<?php
include 'db.php';

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit;
}

$error = "";
if(isset($_POST['login'])) {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    $res = $conn->query("SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if($res->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #1a1a2e; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 45px 40px; border-radius: 12px; width: 360px; box-shadow: 0 5px 30px rgba(0,0,0,0.4); }
        .login-box h2 { text-align: center; color: #1a1a2e; margin-bottom: 8px; font-size: 24px; }
        .login-box p.sub { text-align: center; color: #888; font-size: 13px; margin-bottom: 28px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 6px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        .form-group input:focus { outline: none; border-color: #e94560; }
        .btn-login { width: 100%; background: #e94560; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 5px; }
        .btn-login:hover { background: #c73652; }
        .error { background: #fde8ec; border: 1px solid #e94560; color: #c73652; padding: 10px 14px; border-radius: 5px; font-size: 13px; margin-bottom: 15px; text-align: center; }
        .back-link { display: block; text-align: center; margin-top: 18px; color: #888; font-size: 13px; text-decoration: none; }
        .back-link:hover { color: #1a1a2e; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Portal</h2>
    <p class="sub">Sign in to manage the store</p>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>
    <a href="index.php" class="back-link">&larr; Back to Store</a>
</div>
</body>
</html>
