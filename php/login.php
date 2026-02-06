<?php
//creiamo la sessione
session_start();
//ci colleghiamo al database
include "./connection.php";

//prendiamo le informazioni che provengono dall form di signin
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
//prepariamo le query per accedere al database
    $sql = "SELECT password, username FROM utente WHERE email=$1;";
    $prep = pg_prepare($db, "checkLogin", $sql); 
    $ret = pg_execute($db, "checkLogin", array($email));
//prendiamo la riga associata all'utente che sta facendo il login (se presente)
    if ($row = pg_fetch_assoc($ret)) {
        $hash = $row['password'];
        $username = $row['username'];
//impostiamo la sessione come attiva e prendiamo il nome dell'utente che faremo vedere nelle pagine del sito
        if (password_verify($password, $hash)) {
            $_SESSION['autorizzato'] = true;
            $_SESSION['nome_utente'] = $username; 
            header("Location: ../php/home.php"); 
            exit;
        } else {
            $errore = "Password errata. <a href='login.html'>Riprova</a>";
        }
    } else {
        $errore = "Account inesistente. <a href='login.html'>Riprova</a>";
    }
} else {
    //torniamo alla home
    header("Location: ../html/login.html");
    exit;
}