<?php
session_start();

if (isset($_POST['lat']) && isset($_POST['lon'])) {
    $_SESSION['user_lat'] = $_POST['lat'];
    $_SESSION['user_lon'] = $_POST['lon'];
    echo "OK";
}
?>