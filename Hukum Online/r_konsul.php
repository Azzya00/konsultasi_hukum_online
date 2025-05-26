<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['email'])) {
    header("Location: riwayat_konsultasi.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    } else {
        // Check if email exists and get user's consultation history
        $stmt = $conn->prepare("
            SELECT u.id 
            FROM users u
            JOIN riwayat_konsultasi r ON u.id = r.user_id
            WHERE u.email = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Email exists and has consultation history
            $_SESSION['email'] = $email;
            header("Location: riwayat_konsultasi.php");
            exit();
        } else {
            $error = "Email tidak memiliki riwayat konsultasi";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Justika - Masuk</title>
    <style>
        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar .logo img {
            height: 40px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar .nav-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar .nav-links .active a {
            color: #004aad;
        }

        /* Main Content */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .login-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .login-title {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #d39e00;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #b38a00;
        }

        .error-message {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Logo Justika">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="langkah_hukum.php">Langkah Hukum</a></li>
            <li class="active"><a href="r_konsul.php">Riwayat</a></li>
            <li><a href="#">Masuk</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <div class="login-container">
        <h1 class="login-title">Masuk dengan menggunakan email Anda untuk melihat riwayat konsultasi</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <input type="email" name="email" placeholder="nama_email@domain.com" required>
            </div>
            <button type="submit" class="login-button">Lanjut</button>
        </form>
    </div>
</body>
</html>