<?php
include 'db.php';
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM product WHERE id=$id");
$product = $res->fetch_assoc();

if(!$product) {
    header("Location: admin_dashboard.php");
    exit;
}

$msg = "";
if(isset($_POST['update_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $qty = intval($_POST['qty']);
    $desc = $conn->real_escape_string($_POST['description']);

    if(!empty($_FILES['image']['name'])) {
        $img = $conn->real_escape_string($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
    } else {
        $img = $conn->real_escape_string($product['image_filename']);
    }

    $conn->query("UPDATE product SET name='$name', price='$price', quantity='$qty', description='$desc', image_filename='$img' WHERE id=$id");
    $msg = "Product updated successfully.";
    $res2 = $conn->query("SELECT * FROM product WHERE id=$id");
    $product = $res2->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Product - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; }
        header a { color: #e94560; text-decoration: none; font-size: 14px; border: 1px solid #e94560; padding: 6px 14px; border-radius: 5px; }
        header a:hover { background: #e94560; color: white; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 10px; padding: 35px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #1a1a2e; margin-bottom: 22px; font-size: 22px; border-bottom: 2px solid #e94560; padding-bottom: 8px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; color: #555; font-weight: bold; margin-bottom: 6px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #e94560; }
        .current-img { margin-bottom: 8px; }
        .current-img img { width: 100px; height: 85px; object-fit: cover; border-radius: 5px; border: 1px solid #eee; }
        .btn-save { background: #e94560; color: white; border: none; padding: 12px 30px; border-radius: 6px; font-size: 15px; cursor: pointer; }
        .btn-save:hover { background: #c73652; }
        .btn-back { display: inline-block; margin-left: 12px; color: #1a1a2e; text-decoration: none; font-size: 14px; }
        .btn-back:hover { text-decoration: underline; }
        .success { background: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px 15px; border-radius: 5px; margin-bottom: 18px; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <h1>Modify Product</h1>
    <a href="admin_dashboard.php">&larr; Back to Dashboard</a>
</header>

<div class="container">
    <h2>Edit Product #<?php echo $id; ?></h2>

    <?php if($msg): ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Price (SAR)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="qty" value="<?php echo $product['quantity']; ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Current Image</label>
            <div class="current-img">
                <img src="uploads/<?php echo htmlspecialchars($product['image_filename']); ?>" alt="">
            </div>
            <label>Upload New Image (optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" name="update_product" class="btn-save">Save Changes</button>
        <a href="admin_dashboard.php" class="btn-back">Cancel</a>
    </form>
</div>

</body>
</html>
