<?php
//creiamo la sessione
session_start();
//ci colleghiamo al database
include "./connection.php";

$email = ""; // Inizializziamo per rendere la form sticky

//prendiamo le informazioni che provengono dall form di signin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                echo "<script>
                        alert('Benvenuto $username, ci sei mancato :)');
                        window.location.href = '../php/home.php';
                     </script>";
                exit;
            } else {
                //Creiamo un alert javascript per notificare all'utente che la password che ha inserito è errata
                echo "<script>alert('Password errata. Riprova.');</script>";
            }
        } else {
                //Creiamo un alert javascript per notificare all'utente che le credenziali che ha inserito, non corrispondono a nessuno degli account presenti nel database
            echo "<script>alert('Account inesistente. Riprova.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Tera ➔ Login</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="Pagina di accesso per utenti registrati">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/log.css" />
    <script type="text/javascript" src="../js/log.js" defer></script>
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="immagine-logo"></div>
            <h1>TERA</h1>
        </div>
        <div class="login">
            <div class="theme-icon" title="Cambia al tema Scuro">
                <button id="theme-button">
                    <img src="../imgs/Tema/light_mode.png" alt="Immagine Tema Chiaro"/>
                    <img src="../imgs/Tema/dark_mode.png" alt="Immagine Tema Scuro"/>
                </button>
        </div>
            <a href="../php/home.php" title="Vai alla pagina principale">
            <img src="../imgs/Home/Icone/icons8-home-100.png"
                alt="Immagine Home" class="home-icon" /></a>
        </div>
    </div>
    <div class="login-form">
        <h2>LOGIN</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="login-form" onsubmit="return valida(this)">
            <div class="input">
                <input type="email" id="email" name="email" placeholder="Email" 
                       value="<?php echo htmlspecialchars($email); ?>">
                <img src="../imgs/Login/person.png" alt="email">
            </div>
            <div class="input">
                <input type="password" id="password" name="password" placeholder="Password" >
                <img src="../imgs/Login/pass_yes.png" alt="password" id="PassIcon">
            </div>  
            <button type="submit">Accedi</button>
            <div class="forget">
                <a href="#">Hai dimenticato la password?</a>
            </div>
            <div class="question">
                <p>Non sei registrato? <a href="../html/signup.html">Registrati qui</a></p>
            </div>
        </form>
    </div>
</body>
</html>