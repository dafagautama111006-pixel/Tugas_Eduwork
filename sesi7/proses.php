<?php
$nama = $_POST['nama'] ?? '';
$harga = $_POST['harga'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';

if (empty($nama) || empty($harga) || empty($deskripsi)) {
    echo "Data tidak boleh kosong!";
    exit;
}

// Jika semua terisi, tampilkan hasil
echo "<h2>Data Produk Berhasil Diproses</h2>";
echo "Nama Produk: $nama <br>";
echo "Harga: $harga <br>";
echo "Deskripsi: $deskripsi <br>";
?>
