<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fb;
    text-align: center;
    padding-top: 100px;
}
form {
    background: #fff;
    display: inline-block;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
input {
    display: block;
    width: 250px;
    margin: 10px auto;
    padding: 10px;
}
button {
    background: #ff69b4;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
}
</style>
</head>
<body>
<h2>Login Admin Kedai Melwaa ☕</h2>
<form action="proses_login_admin.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Masuk</button>
</form>
</body>
</html>
