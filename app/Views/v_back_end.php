<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_kedai";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error){
  die("Koneksi database gagal:".
  $conn->connect_error);
}

//Ambil data makanan dan minuman dari tabel 'menu'
$makanan = $conn->query("SELECT*FROM tb_menu WHERE kategori='makanan'");
$minuman = $conn->query("SELECT*FROM tb_menu WHERE kategori='minuman'");
?>