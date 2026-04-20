<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechStore - Home</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 24px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-size: 15px; }
        .nav-links a:hover { color: #e94560; }
        .cart-link { display: flex; align-items: center; gap: 6px; }
        .hero { background: linear-gradient(135deg, #1a1a2e, #16213e); color: white; text-align: center; padding: 50px 20px; }
        .hero h2 { font-size: 36px; margin-bottom: 10px; }
        .hero p { font-size: 16px; color: #ccc; }
        .products { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; padding: 40px 30px; }
        .item { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 240px; overflow: hidden; transition: transform 0.2s; }
        .item:hover { transform: translateY(-5px); }
        .item img { width: 100%; height: 180px; object-fit: cover; }
        .item-body { padding: 15px; }
        .item-body h3 { font-size: 18px; margin-bottom: 6px; }
        .item-body .price { color: #e94560; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .item-body a { display: block; text-align: center; background: #1a1a2e; color: white; padding: 8px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .item-body a:hover { background: #e94560; }
        footer { background: #1a1a2e; color: #aaa; text-align: center; padding: 20px; font-size: 13px; margin-top: 20px; }
        .last-viewed { background: #fff3cd; border: 1px solid #ffc107; padding: 10px 30px; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <h1>TechStore</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="contact.php">Contact Us</a>
        <a href="cart.php" class="cart-link">
            <img src="cart_icon.png" alt="Cart" width="28">
            View Cart
            <?php if(!empty($_SESSION['cart'])): ?>
                <span style="background:#e94560;border-radius:50%;padding:2px 7px;font-size:12px;"><?php echo count($_SESSION['cart']); ?></span>
            <?php endif; ?>
        </a>
    </div>
</header>

<?php if(isset($_COOKIE['last_viewed'])): ?>
<div class="last-viewed">
    Last viewed product: <strong><?php echo htmlspecialchars($_COOKIE['last_viewed']); ?></strong>
</div>
<?php endif; ?>

<div class="hero">
    <h2>Welcome to TechStore</h2>
    <p>Discover the latest technology products at the best prices.</p>
</div>

<div class="products">
    <?php
    $result = $conn->query("SELECT * FROM product");
    while($row = $result->fetch_assoc()):
    ?>
    <div class="item">
        <img src="uploads/<?php echo htmlspecialchars($row['image_filename']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <div class="item-body">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="price">SAR <?php echo number_format($row['price'], 2); ?></p>
            <a href="product_detail.php?id=<?php echo $row['id']; ?>">View Details</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<footer>
    &copy; 2026 TechStore. All rights reserved.
</footer>

</body>
</html>
