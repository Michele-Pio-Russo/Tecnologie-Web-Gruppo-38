<?php
//creiamo la sessione
session_start();
//diassociamo e sitruggiamo le variabili di sessione
session_unset();
session_destroy();
//ritorniamo alla home
header("Location: ../php/home.php");
exit;
?>