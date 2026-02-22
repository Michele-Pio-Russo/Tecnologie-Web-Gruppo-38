<?php
session_start();
include "./connection.php"; // Verifica che il percorso sia corretto rispetto alla cartella php

// Debug degli errori (rimuovi in produzione)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email']) && isset($_POST['img_path'])) {
    
    $email = $_SESSION['email'];
    $path = trim($_POST['img_path']);

    // 1. Controllo se esiste già
    $sql_check = "SELECT 1 FROM preferiti WHERE email_utente = $1 AND percorso_immagine = $2";
    $res_check = pg_query_params($db, $sql_check, array($email, $path));

    if (!$res_check) {
        echo "Errore query check: " . pg_last_error($db);
        exit;
    }

    if (pg_num_rows($res_check) > 0) {
        // 2. RIMOZIONE
        $sql_del = "DELETE FROM preferiti WHERE email_utente = $1 AND percorso_immagine = $2";
        pg_query_params($db, $sql_del, array($email, $path));
        echo "removed";
    } else {
        // 3. AGGIUNTA (Usa INSERT, così crea una nuova riga)
        $sql_ins = "INSERT INTO preferiti (email_utente, percorso_immagine) VALUES ($1, $2)";
        $res_ins = pg_query_params($db, $sql_ins, array($email, $path));
        
        if ($res_ins) {
            echo "added";
        } else {
            echo "Errore insert: " . pg_last_error($db);
        }
    }
} else {
    echo "unauthorized";
}
?>