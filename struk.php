<?php
session_start();
if(!isset($_SESSION['pesanan'])) {
    echo "Tidak ada pesanan.";
    exit;
}

$pesanan = $_SESSION['pesanan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Pesanan - Kedai Melwaa 💕</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins', sans-serif; background:#fff9fc; margin:0; padding:20px;}
h1 { text-align:center; color:#ff4b9d; }
h2 { text-align:center; color:#333; }
.struk { max-width:600px; margin:20px auto; background:#fff; padding:25px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,0.1); font-family:monospace;}
.struk table { width:100%; border-collapse: collapse; margin-top:20px;}
.struk table th, .struk table td { border:1px solid #ddd; padding:10px; text-align:center;}
.struk table th { background:#ff69b4; color:#fff;}
.total { text-align:right; font-weight:bold; margin-top:15px; }
.back-btn, .print-btn { display:block; text-align:center; margin:20px auto; text-decoration:none; background:#00
