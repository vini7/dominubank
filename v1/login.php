<?php

session_start();

// Lidhja me databazën
$host = "localhost";
$user = "bankuser";
$pass = "bankpass";
$db   = "dominusoft_bank";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Autentikimi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // $stmt = mysqli_prepare(
    //     $conn, "SELECT id, username FROM users WHERE username = ? AND password = ? LIMIT 1" );

    // if ($stmt) { 
    //     mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);
    // }
   
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $_SESSION['login_message'] = "<span style='color:green;'>Login i suksesshëm – Mirësevini!</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['login_message'] = "<span style='color:red;'>Kredenciale të pasakta</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
$message = isset($_SESSION['login_message']) ? $_SESSION['login_message'] : '';
unset($_SESSION['login_message']); 
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login – Banka Dominusoft</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="images/dominusoft_logo.png" alt="Dominusoft Bank Logo" />
    </div>
    <nav>
        <a href="index.html">Kreu</a>
        <a href="login.php">Login</a>
        <a href="#">Kush jemi</a>
        <a href="#">Suporti</a>
    </nav>
</header>

<div class="container">
    <div class="login-box">
        <h2>Hyrje në Sistem</h2>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Përdoruesi" required />
            <input type="password" name="password" placeholder="Fjalëkalimi" required />
            <button type="submit" name="login_submit">Hyr</button>
        </form>

        <div class="warning">
            Ambient trajnimi – Mos përdorni kredenciale reale
        </div>
    </div>
</div>

<footer>
    © 2025 Dominusoft Bank — Ambient Trajnimi
</footer>

</body>
</html>
