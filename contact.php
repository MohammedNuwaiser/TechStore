<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 24px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-size: 15px; }
        .nav-links a:hover { color: #e94560; }
        .container { max-width: 800px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); padding: 40px; }
        h2 { color: #1a1a2e; margin-bottom: 25px; font-size: 26px; }
        .info-row { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 14px; font-size: 15px; color: #444; }
        .info-row strong { min-width: 100px; color: #1a1a2e; }
        .map-wrap { margin-top: 30px; border-radius: 8px; overflow: hidden; }
        iframe { display: block; width: 100%; height: 400px; border: 0; }
    </style>
</head>
<body>

<header>
    <h1>TechStore</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="cart.php">View Cart</a>
        <a href="contact.php">Contact Us</a>
    </div>
</header>

<div class="container">
    <h2>Contact Us</h2>
    <div class="info-row"><strong>Location:</strong> Saihat, Eastern Province, Saudi Arabia</div>
    <div class="info-row"><strong>Email:</strong> support@techstore.sa</div>
    <div class="info-row"><strong>Phone:</strong> +966 13 000 0000</div>
    <div class="info-row"><strong>Hours:</strong> Sun - Thu, 9:00 AM - 6:00 PM</div>

    <div class="map-wrap">
        <iframe src="https://maps.google.com/maps?q=Saihat,Saudi+Arabia&output=embed" allowfullscreen loading="lazy"></iframe>
    </div>
</div>

</body>
</html>
