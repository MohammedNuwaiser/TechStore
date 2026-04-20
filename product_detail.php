<?php
include 'db.php';
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM product WHERE id=$id");
$product = $result->fetch_assoc();

if(!$product) {
    header("Location: index.php");
    exit;
}

setcookie("last_viewed", $product['name'], time() + (86400 * 30), "/");

if(isset($_POST['add_to_cart'])) {
    $qty = intval($_POST['quantity']);
    if($qty < 1) $qty = 1;
    $_SESSION['cart'][$id] = $qty;
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 24px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-size: 15px; }
        .nav-links a:hover { color: #e94560; }
        .container { max-width: 900px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); display: flex; gap: 0; overflow: hidden; }
        .product-img { width: 45%; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; }
        .product-info { padding: 40px; flex: 1; }
        .product-info h1 { font-size: 28px; margin-bottom: 15px; color: #1a1a2e; }
        .product-info .price { font-size: 26px; color: #e94560; font-weight: bold; margin-bottom: 15px; }
        .product-info .stock { color: #555; margin-bottom: 10px; font-size: 15px; }
        .product-info .desc { color: #666; margin-bottom: 25px; line-height: 1.6; font-size: 15px; }
        .product-info label { display: block; margin-bottom: 6px; font-weight: bold; color: #333; }
        .product-info input[type="number"] { width: 80px; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px; margin-bottom: 15px; }
        .btn-cart { background: #e94560; color: white; border: none; padding: 12px 30px; border-radius: 6px; font-size: 16px; cursor: pointer; }
        .btn-cart:hover { background: #c73652; }
        .btn-back { display: inline-block; margin-top: 12px; color: #1a1a2e; text-decoration: none; font-size: 14px; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

<header>
    <h1>TechStore</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="contact.php">Contact Us</a>
        <a href="cart.php">
            <img src="cart_icon.png" alt="Cart" width="28">
            View Cart
        </a>
    </div>
</header>

<div class="container">
    <div class="product-img">
        <img src="uploads/<?php echo htmlspecialchars($product['image_filename']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="price">SAR <?php echo number_format($product['price'], 2); ?></p>
        <p class="stock">Available Quantity: <?php echo $product['quantity']; ?></p>
        <p class="desc">Help / Info: <?php echo htmlspecialchars($product['description']); ?></p>

        <form method="POST">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
            <br>
            <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
        </form>
        <a href="index.php" class="btn-back">&larr; Back to Products</a>
    </div>
</div>

</body>
</html>
