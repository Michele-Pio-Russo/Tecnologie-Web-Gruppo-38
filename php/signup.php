<?php
//creiamo la sessione
session_start();
//ci colleghiamo al database
include "./connection.php";
//prendiamo le informazioni che provengono dall form di signup
$username = $_POST['nome'];
$email    = $_POST['email'];
$password = $_POST['password'];
//controlliamo le informazioni
if (!$username || !$email || !$password) {
    die("Errore: Tutti i campi sono obbligatori.");
}

//controlliamo se l'email è già presente nel database
$check_sql = "SELECT email FROM utente WHERE email = $1";
$check = pg_query_params($db, $check_sql, array($email));

if ($check && pg_num_rows($check) > 0) {
    echo "<script>
            alert('Questa email è già registrata!');
            window.location.href = '../html/signup.html';
          </script>";
    exit;
}

//funzione per inserire gli utenti nel database
function register($u, $e, $p, $db) {
    $hash = password_hash($p, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO utente(username, email, password) VALUES($1, $2, $3)";
    $prep = pg_prepare($db, "insertUser", $sql); 
    
    if (!$prep) return false;

    $ret = pg_execute($db, "insertUser", array($u, $e, $hash));
    return $ret;
}

//registriamo l'utente nel database
if (register($username, $email, $password, $db)) {
    header("Location: ../php/login.php?success=1");
    exit;
} else {
    echo "Errore durante la registrazione: " . pg_last_error($db);
}
?>