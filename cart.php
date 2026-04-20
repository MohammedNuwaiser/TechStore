<?php
include 'db.php';

if(isset($_POST['update'])) {
    $pid = intval($_POST['id']);
    $qty = intval($_POST['qty']);
    if($qty > 0) $_SESSION['cart'][$pid] = $qty;
}

if(isset($_GET['delete'])) {
    $pid = intval($_GET['delete']);
    unset($_SESSION['cart'][$pid]);
    header("Location: cart.php");
    exit;
}

if(isset($_GET['delete_all'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

$purchase_success = false;
if(isset($_POST['buy'])) {
    unset($_SESSION['cart']);
    $purchase_success = true;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 24px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-size: 15px; }
        .nav-links a:hover { color: #e94560; }
        .container { max-width: 850px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); padding: 35px; }
        h2 { color: #1a1a2e; margin-bottom: 25px; font-size: 24px; }
        .cart-item { display: flex; align-items: center; gap: 20px; border-bottom: 1px solid #eee; padding: 15px 0; }
        .cart-item img { width: 80px; height: 70px; object-fit: cover; border-radius: 6px; }
        .item-name { flex: 1; font-size: 16px; font-weight: bold; color: #333; }
        .item-price { color: #e94560; font-weight: bold; font-size: 15px; width: 110px; }
        .qty-input { width: 60px; padding: 6px; border: 1px solid #ccc; border-radius: 4px; text-align: center; }
        .btn-update { background: #1a1a2e; color: white; border: none; padding: 7px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .btn-update:hover { background: #e94560; }
        .btn-delete { color: #e94560; text-decoration: none; font-size: 13px; margin-left: 8px; }
        .btn-delete:hover { text-decoration: underline; }
        .cart-footer { margin-top: 25px; display: flex; justify-content: space-between; align-items: center; }
        .total { font-size: 20px; font-weight: bold; color: #1a1a2e; }
        .btn-buy { background: #e94560; color: white; border: none; padding: 12px 35px; border-radius: 6px; font-size: 16px; cursor: pointer; }
        .btn-buy:hover { background: #c73652; }
        .btn-empty { color: #555; text-decoration: none; font-size: 14px; border: 1px solid #ccc; padding: 8px 16px; border-radius: 5px; }
        .btn-empty:hover { background: #f0f0f0; }
        .empty-msg { text-align: center; padding: 50px 0; color: #888; font-size: 16px; }
        .success-box { background: #d4edda; border: 1px solid #28a745; color: #155724; padding: 18px 25px; border-radius: 8px; font-size: 16px; margin-bottom: 20px; }
        .btn-back { display: inline-block; margin-top: 15px; color: #1a1a2e; text-decoration: none; font-size: 14px; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

<header>
    <h1>TechStore</h1>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="contact.php">Contact Us</a>
        <a href="cart.php">View Cart</a>
    </div>
</header>

<div class="container">
    <h2>Shopping Cart</h2>

    <?php if($purchase_success): ?>
        <div class="success-box">&#10003; Purchase Successful! Thank you for your order.</div>
        <a href="index.php" class="btn-back">&larr; Continue Shopping</a>
    <?php elseif(empty($_SESSION['cart'])): ?>
        <div class="empty-msg">Your cart is empty. <a href="index.php">Browse products</a></div>
    <?php else: ?>

    <form method="POST">
        <?php foreach($_SESSION['cart'] as $id => $qty):
            $id = intval($id);
            $prod = $conn->query("SELECT * FROM product WHERE id=$id")->fetch_assoc();
            if(!$prod) continue;
            $subtotal = $prod['price'] * $qty;
            $total += $subtotal;
        ?>
        <div class="cart-item">
            <img src="uploads/<?php echo htmlspecialchars($prod['image_filename']); ?>" alt="">
            <span class="item-name"><?php echo htmlspecialchars($prod['name']); ?></span>
            <span class="item-price">SAR <?php echo number_format($prod['price'], 2); ?></span>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" max="<?php echo $prod['quantity']; ?>" class="qty-input">
            <button type="submit" name="update" class="btn-update">Update</button>
            <a href="?delete=<?php echo $id; ?>" class="btn-delete">Remove</a>
        </div>
        <?php endforeach; ?>

        <div class="cart-footer">
            <a href="?delete_all=1" class="btn-empty">Empty Cart</a>
            <span class="total">Total: SAR <?php echo number_format($total, 2); ?></span>
            <button type="submit" name="buy" class="btn-buy">Buy Now</button>
        </div>
    </form>

    <?php endif; ?>
</div>

</body>
</html>
