<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ecommerce_samsung";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$category = $_GET['category'] ?? '';

if (!empty($category)) {
    $query = "SELECT * FROM products WHERE category = '$category'";
} else {
    $query = "SELECT * FROM products";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>E-Commerce Samsung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .product {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
            width: 250px;
            display: inline-block;
            vertical-align: top;
        }
    </style>
</head>
<body>

<h2>Produk Samsung</h2>

<!-- FILTER -->
<a href="index.php">Semua</a> |
<a href="index.php?category=Smartphone">Smartphone</a> |
<a href="index.php?category=Tablet">Tablet</a>

<hr>

<!-- LOOPING PRODUK -->
<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="product">
            <h3><?= $row['name']; ?></h3>
            <p><?= $row['description']; ?></p>
            <p><strong>Rp <?= number_format($row['price']); ?></strong></p>
            <p>Stok: <?= $row['stock']; ?></p>
            <small>Kategori: <?= $row['category']; ?></small>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Produk tidak ditemukan.</p>
<?php endif; ?>

</body>
</html>
