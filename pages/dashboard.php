<?php

require_once '../config/session_config.php';

if (
    !isset($_SESSION['logged_in']) ||
    $_SESSION['logged_in'] !== true
) {

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Dashboard</title>

</head>

<body>

    <h1>
        Welcome,
        <?php echo $_SESSION['name']; ?>
    </h1>

    <p>
        Role:
        <?php echo $_SESSION['role']; ?>
    </p>

    <a href="../auth/logout.php">
        Logout
    </a>

</body>

</html>