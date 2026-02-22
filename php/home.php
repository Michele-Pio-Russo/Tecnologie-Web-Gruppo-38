<?php session_start(); ?>
<html>

<head>
    <title>Tera ➔ Home</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="homepage">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/home.css" />
    <script type="text/javascript" src="../js/index.js" defer></script>
</head>

<body class="">
    <div class="header">
        <div class="logo">
            <div class="immagine-logo"></div>
            <h1>TERA</h1>
        </div>
        <div class="login">
            <div class="pos" title="Informazioni sulla posizione">
    <button type="button" id="get-pos-btn" >
        <img src="../imgs/Altro/position.png" alt="Posizione" class="position-icon" />
    </button>
        </div>

<script>
document.getElementById('get-pos-btn').addEventListener('click', function() {
    const isLogged = <?php echo (isset($_SESSION['autorizzato']) && $_SESSION['autorizzato'] === true) ? 'true' : 'false'; ?>;

    if (!isLogged) {
        alert("Attenzione: Devi essere loggato per visualizzare la tua posizione.");
        return;
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Utilizziamo un servizio di Reverse Geocoding gratuito (BigDataCloud o Nominatim)
            // Questo trasforma le coordinate in Città e Paese reali
            const geoApiUrl = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=it`;

            fetch(geoApiUrl)
            .then(res => res.json())
            .then(data => {
                const citta = data.city || data.locality || "Sconosciuta";
                const regione = data.principalSubdivision || "Sconosciuta";
                const paese = data.countryName || "Scono    sciuto";

                const msg = `📍 La tua posizione attuale:\n` +
                            `   Città: ${citta}\n` +
                            `   Regione: ${regione}\n` +
                            `   Paese: ${paese}\n` +
                            `   Coordinate: ${lat.toFixed(4)}, ${lon.toFixed(4)}`;

                alert(msg);

                // Opzionale: invia al server per salvarlo in sessione
                fetch('../php/salva_posizione.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `lat=${lat}&lon=${lon}&city=${encodeURIComponent(citta)}`
                });
            })
            .catch(() => {
                alert("Errore nel recupero dei dettagli dell'indirizzo.");
            });

        }, function() {
            alert("Errore: Attiva il GPS o consenti l'accesso alla posizione.");
        });
    } else {
        alert("Il tuo browser non supporta la geolocalizzazione.");
    }
});
</script>
    <div class="theme-icon" title="Cambia al tema Chiaro">
        <button id="theme-button">
            <img src="../imgs/Tema/light_mode.png" alt="Immagine Tema Solare" />
            <img src="../imgs/Tema/dark_mode.png" alt="Immagine Tema Lunare" />
        </button>
    </div>
    <?php if (isset($_SESSION['autorizzato']) && $_SESSION['autorizzato'] === true): ?>
        <p><?php echo htmlspecialchars($_SESSION['nome_utente']); ?></p>
        <div class="pref-icon" title="Vai ai preferiti">
            <a href="preferiti.php">
                <img src="../imgs/Altro/preferiti.gif" alt="Preferiti" class="preferiti-icon" />
            </a>
        </div>
        <a href="../php/logout.php" title="Logout">
            <img src="../imgs/Login/logout.png" alt="User" class="login-icon" />
        </a>
    <?php else: ?>
        <p>Login</p>
        <a href="login.php" title="Vai alla pagina di accesso">
            <img src="../imgs/Login/login1.png"
                 alt="Immagine Login" class="login-icon" />
        </a>
    <?php endif; ?>
</div>
    </div>
    <div class="main-content">
        <div class="content">
            <h2>Chi siamo?</h2>
            <div class="element1">
                <img class="image1" src="../imgs/Home/home1.jpg" alt="Errore di caricamento immagine">
                <p>Siamo tre ragazzi con un’idea: creare una community per chi, come noi, va oltre la superficie.
                    Persone che non si accontentano di consumare contenuti in un periodo storico predominato da
                    passività,
                    ma vogliono capire il messaggio, l’intento e il valore artistico dietro ogni forma di espressione
                    e partecipare in modo attivo al progetto. Da questa necessità nasce Tera.</p>
            </div>
            <h2 style="text-align: right;">Perché dovresti prendere parte al nostro progetto?</h2>
            <div class="element2">
                <img class="image1" src="../imgs/Home/home2.jpg" alt="Errore di caricamento immagine">
                <p>Partecipare attivamente al nostro progetto vuol dire portare, proprio come abbiamo fatto noi,
                    la propria visione su ciò che più gli appassiona. Ognuno di noi ha una propria visione, e Tera è
                    fatto per concretizzarla.
                    Si tratta di raccontare perché qualcosa ti colpisce, di confrontarsi senza paura di essere giudicati
                    e di costruire un dialogo
                    autentico attorno alle proprie passioni.</p>
            </div>
            <h2>Cosa trovi su Tera.</h2>
            <div class="element1">
                <img class="image1" src="../imgs/Home/home3.jpg" alt="Errore di caricamento immagine">
                <p>Tera non è un semplice sito web: è un progetto che vuole crescere, creare community e far scoprire
                    nuove prospettive.
                    Qui puoi leggere analisi, scoprire contenuti, confrontarti con altri e approfondire tutto ciò che
                    riguarda arte,
                    cultura e creatività, in modo accessibile ma profondo.</p>
            </div>
            <h2 style="text-align: right;">Regolamento</h2>
            <div class="element2">
                <img class="image1" src="../imgs/Home/home4.jpg" alt="Errore di caricamento immagine">
                <ul>
                    <li>Essere rispettosi nei confronti dei creatori del sito e degli altri utenti.</li>
                    <li>Usare un linguaggio corretto e costruttivo.</li>
                    <li>Divertirsi e partecipare con entusiasmo.</li>
                </ul>
            </div>
        </div>
        <div class="sidebar">
            <nav class="menu">
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-home-100.png" alt="home icon">
                    <a href="home.php">HOME</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-pencil-100.png" alt="animazione">
                    <a href="animazione.php">ANIMAZIONE & DISEGNO</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-controller-100.png" alt="videogiochi">
                    <a href="videogiochi.php">VIDEOGIOCHI</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-headphones-100.png" alt="hip-hop">
                    <a href="hip-hop.php">HIP-HOP</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-clapperboard-100 (1).png" alt="cinema">
                    <a href="cinema.php">CINEMA</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-other-100.png" alt="menzioni">
                    <a href="menzioni.php">MENZIONI ONOREVOLI</a>
                </div>
                <div class="menu-itme">
                    <img src="../imgs/Home/Icone/icons8-forum-100.png" alt="forum">
                    <a href="forum.php">FORUM</a>
                </div>
            </nav>
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
        </div>
        <p>© <?php echo date('Y')?> TERA. All rights reserved.</p>
    </div>
</body>


</html>