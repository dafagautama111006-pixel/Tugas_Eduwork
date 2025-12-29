<?php
// ================= KONEKSI DATABASE =================
$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) die("Koneksi gagal");

// ================= TAMBAH DATA =================
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "images/" . $gambar);

    mysqli_query($conn, "INSERT INTO products VALUES(
        NULL, '$nama', '$deskripsi', '$gambar', '$kategori', '$harga', '$stok'
    )");
    header("Location: dashboard_products.php");
}

// ================= HAPUS DATA =================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: dashboard_products.php");
}

// ================= AMBIL DATA EDIT =================
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $dataEdit = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $rowEdit = mysqli_fetch_assoc($dataEdit);
}

// ================= UPDATE DATA =================
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "UPDATE products SET
        nama_produk='$nama',
        deskripsi='$deskripsi',
        kategori='$kategori',
        harga='$harga',
        stok='$stok'
        WHERE id=$id
    ");
    header("Location: dashboard_products.php");
}

// ================= DATA PRODUK =================
$data = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Dashboard Produk</h2>

    <!-- FORM TAMBAH / EDIT -->
    <div class="card mb-4">
        <div class="card-header">
            <?= $edit ? "Edit Produk" : "Tambah Produk"; ?>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $edit ? $rowEdit['id'] : '' ?>">

                <input type="text" name="nama_produk" class="form-control mb-2"
                       placeholder="Nama Produk"
                       value="<?= $edit ? $rowEdit['nama_produk'] : '' ?>" required>

                <textarea name="deskripsi" class="form-control mb-2"
                          placeholder="Deskripsi"><?= $edit ? $rowEdit['deskripsi'] : '' ?></textarea>

                <input type="text" name="kategori" class="form-control mb-2"
                       placeholder="Kategori"
                       value="<?= $edit ? $rowEdit['kategori'] : '' ?>">

                <input type="number" name="harga" class="form-control mb-2"
                       placeholder="Harga"
                       value="<?= $edit ? $rowEdit['harga'] : '' ?>">

                <input type="number" name="stok" class="form-control mb-2"
                       placeholder="Stok"
                       value="<?= $edit ? $rowEdit['stok'] : '' ?>">

                <?php if (!$edit): ?>
                    <input type="file" name="gambar" class="form-control mb-3">
                <?php endif; ?>

                <button class="btn btn-success"
                        name="<?= $edit ? 'update' : 'tambah' ?>">
                    <?= $edit ? 'Update' : 'Tambah' ?>
                </button>
                <?php if ($edit): ?>
                    <a href="dashboard_products.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- TABEL PRODUK -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td>
                    <img src="images/<?= $row['gambar']; ?>" width="60">
                </td>
                <td><?= $row['kategori']; ?></td>
                <td>Rp <?= number_format($row['harga']); ?></td>
                <td><?= $row['stok']; ?></td>
                <td>
                    <a href="?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?hapus=<?= $row['id']; ?>"
                       onclick="return confirm('Yakin hapus?')"
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>
