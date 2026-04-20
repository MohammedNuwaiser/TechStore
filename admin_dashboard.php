<?php
include 'db.php';
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$msg = "";

if(isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $qty = intval($_POST['qty']);
    $desc = $conn->real_escape_string($_POST['description']);
    $img = $conn->real_escape_string($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
    $conn->query("INSERT INTO product (name, price, quantity, description, image_filename) VALUES ('$name', '$price', '$qty', '$desc', '$img')");
    $msg = "Product added successfully.";
}

if(isset($_GET['delete'])) {
    $pid = intval($_GET['delete']);
    $conn->query("DELETE FROM product WHERE id=$pid");
    header("Location: admin_dashboard.php");
    exit;
}

$searchQuery = "";
if(isset($_POST['search']) && !empty($_POST['search_term'])) {
    $term = $conn->real_escape_string($_POST['search_term']);
    $searchQuery = "WHERE name LIKE '%$term%'";
}

$products = $conn->query("SELECT * FROM product $searchQuery");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - TechStore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        header { background: #1a1a2e; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; }
        header a { color: #e94560; text-decoration: none; font-size: 14px; border: 1px solid #e94560; padding: 6px 14px; border-radius: 5px; }
        header a:hover { background: #e94560; color: white; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .section { background: white; border-radius: 10px; padding: 28px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        h2 { color: #1a1a2e; margin-bottom: 18px; font-size: 20px; border-bottom: 2px solid #e94560; padding-bottom: 8px; }
        .form-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 13px; color: #555; font-weight: bold; }
        .form-group input, .form-group textarea { padding: 9px 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #e94560; }
        .btn { padding: 9px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .btn-primary { background: #1a1a2e; color: white; }
        .btn-primary:hover { background: #e94560; }
        .btn-danger { background: #e94560; color: white; }
        .btn-danger:hover { background: #c73652; }
        .btn-edit { background: #0f3460; color: white; text-decoration: none; padding: 6px 14px; border-radius: 4px; font-size: 13px; }
        .btn-edit:hover { background: #e94560; }
        .success { background: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px 15px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        table th { background: #1a1a2e; color: white; padding: 12px 10px; text-align: left; font-size: 14px; }
        table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; color: #333; vertical-align: middle; }
        table tr:hover td { background: #f9f9f9; }
        table img { width: 55px; height: 50px; object-fit: cover; border-radius: 5px; }
        .search-bar { display: flex; gap: 10px; }
        .search-bar input { flex: 1; padding: 9px 14px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <a href="admin_login.php?logout=1">Logout</a>
</header>

<div class="container">

    <?php if($msg): ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="section">
        <h2>Add New Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" placeholder="Product name" required>
                </div>
                <div class="form-group">
                    <label>Price (SAR)</label>
                    <input type="number" step="0.01" name="price" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="qty" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" placeholder="Product description">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="form-group" style="justify-content:flex-end;">
                    <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </form>
    </div>

    <div class="section">
        <h2>Search Products</h2>
        <form method="POST">
            <div class="search-bar">
                <input type="text" name="search_term" placeholder="Search by product name...">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
                <a href="admin_dashboard.php" class="btn btn-primary" style="text-decoration:none;">Clear</a>
            </div>
        </form>
    </div>

    <div class="section">
        <h2>Manage Products</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $products->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="uploads/<?php echo htmlspecialchars($row['image_filename']); ?>" alt=""></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>SAR <?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>
                    <a href="admin_modify.php?id=<?php echo $row['id']; ?>" class="btn-edit">Modify</a>
                    &nbsp;
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
