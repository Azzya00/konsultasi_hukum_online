<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <style>
    body { font-family: Arial; background: #f9f9f9; padding: 50px; }
    .box {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #1d2f9f;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>Ganti Password</h2>
  <form action="reset_password_process.php" method="POST">
    <input type="email" name="email" placeholder="Email Anda..." required>
    <input type="password" name="new_password" placeholder="Password baru..." required>
    <button type="submit">Reset Password</button>
  </form>
</div>

</body>
</html>
