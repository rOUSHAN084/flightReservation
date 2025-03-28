<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: flight.html");
    exit();
}
echo "Welcome, " . $_SESSION['user'] . "!";
?>
