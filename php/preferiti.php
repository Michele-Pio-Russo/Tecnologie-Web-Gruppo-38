<?php 
session_start(); 
include "../php/connection.php"; 

// Protezione: se l'utente non è loggato, reindirizza alla login
if (!isset($_SESSION['autorizzato']) || $_SESSION['autorizzato'] !== true) {
    header("Location: login.php");
    exit;
}

$email_utente = $_SESSION['email'];

// Recupero tutti i preferiti dell'utente
$sql = "SELECT percorso_immagine FROM preferiti WHERE email_utente = $1 ORDER BY data_aggiunta DESC";
$res = pg_query_params($db, $sql, array($email_utente));
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Tera ➔ I Tuoi Preferiti</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/hip-hop.css" />
    <link rel="stylesheet" href="../css/preferiti.css" />
    <script type="text/javascript" src="../js/index.js" defer></script>
</head>
<body>

    <div class="header">
        <div class="logo">
            <div class="immagine-logo"></div>
            <h1>TERA</h1>
        </div>
        
        <div class="login">
            <div class="theme-icon" title="Cambia tema">
                <button id="theme-button">
                    <img src="../imgs/Tema/light_mode.png" alt="Light Mode" />
                    <img src="../imgs/Tema/dark_mode.png" alt="Dark Mode" />
                </button>
            </div>

            <p><?php echo htmlspecialchars($_SESSION['nome_utente']); ?></p>
            <a href="../php/logout.php" title="Logout">
                <img src="../imgs/Login/logout.png" alt="Logout" class="login-icon" />
            </a>
        </div>
    </div>

    <div style="padding: 20px;">
        <a href="home.php" class="back-link" style="color: white; font-weight: bold; text-decoration: none;">← Torna alla Home</a>
    </div>

    <div class="main-content" style="display: block;"> <div class="content">
            <h2 style="text-align: center;">I Tuoi Preferiti ❤️</h2>
            
            <div class="favorites-grid" id="grid">
                <?php 
                if (pg_num_rows($res) > 0): 
                    while ($row = pg_fetch_assoc($res)): 
                ?>
                    <div class="fav-item" id="fav-<?php echo md5($row['percorso_immagine']); ?>">
                        <img src="<?php echo $row['percorso_immagine']; ?>" alt="Immagine Preferita" class="image2">
                        <button class="remove-btn" onclick="removeFavorite('<?php echo $row['percorso_immagine']; ?>')">
                            Rimuovi dai preferiti
                        </button>
                    </div>
                <?php 
                    endwhile; 
                else: 
                ?>
                    <div class="no-favs">
                        <p style="width: 100%; text-align: center;">Non hai ancora salvato nessuna immagine nei preferiti.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="contacts">
            <div class="contact whatsapp">
                <img src="../imgs/Home/Footer/icons8-whatsapp-100 (1).png" alt="Whatsapp">
                <a href="https://chat.whatsapp.com/DgrzEMnL7RWJKGSAYlQZ47?mode=gi_t">Whatsapp</a>
            </div>
            <div class="contact instagram">
                <img src="../imgs/Home/Footer/icons8-instagram-100.png" alt="Instagram">
                <a href="https://www.instagram.com/teraartisticproject/">Instagram</a>
            </div>
            <div class="contact facebook">
                <img src="../imgs/Home/Footer/icons8-facebook-nuovo-100.png" alt="Facebook">
                <a href="https://www.facebook.com/groups/1338264634726723">Facebook</a>
            </div>
            <div class="contact telegram">
                <img src="../imgs/Home/Footer/icons8-telegramma-100.png" alt="Telegram">
                <a href="https://t.me/+Vgbv8NL50TQ5NDU0">Telegram</a>
            </div>
            <div class="contact discord">
                <img src="../imgs/Home/Footer/icons8-logo-discord-100.png" alt="Discord">
                <a href="https://discord.gg/TpwZh35J">Discord</a>
            </div>
        </div>
        <p>© <?php echo date('Y')?> TERA. All rights reserved.</p>
    </div>

    <script>
    function removeFavorite(path) {
        if (!confirm("Vuoi rimuovere questa immagine dai preferiti?")) return;

        const params = new URLSearchParams();
        params.append('img_path', path);

        fetch('../php/toggle_preferiti.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString()
        })
        .then(res => res.text())
        .then(result => {
            if (result === 'removed') {
                location.reload(); 
            }
        });
    }
    </script>
</body>
</html>