<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Tera ➔ Menzioni Onorevoli</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="Menzioni Onorevoli - Altre forme d'arte">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menzioni.css" />
    <script type="text/javascript" src="../js/index.js" defer></script>
</head>

<body>
    <div class="header">
        <div class="logo">
            <div class="immagine-logo"></div>
            <h1>TERA</h1>
        </div>
        <div class="login">
            <div class="pos" title="Informazioni sulla posizione">
                <button type="button" id="get-pos-btn">
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
                            const geoApiUrl = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=it`;

                            fetch(geoApiUrl)
                                .then(res => res.json())
                                .then(data => {
                                    const citta = data.city || data.locality || "Sconosciuta";
                                    const regione = data.principalSubdivision || "Sconosciuta";
                                    const paese = data.countryName || "Sconosciuto";

                                    const msg = `📍 La tua posizione attuale:\n` +
                                        `   Città: ${citta}\n` +
                                        `   Regione: ${regione}\n` +
                                        `   Paese: ${paese}\n` +
                                        `   Coordinate: ${lat.toFixed(4)}, ${lon.toFixed(4)}`;

                                    alert(msg);

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
                    <img src="../imgs/Tema/light_mode.png" alt="Tema Chiaro" />
                    <img src="../imgs/Tema/dark_mode.png" alt="Tema Scuro" />
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
                <a href="login.php" title="Accedi">
                    <img src="../imgs/Login/login1.png" alt="Login" class="login-icon" />
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-content">
        <div class="content">
            <h2 style="text-align: center;">Menzioni Onorevoli</h2>
            <div class="element3">
                <p>In questa sezione presentiamo altre forme d'arte che vale la pena raccontare. Sebbene diffuse, spesso non vengono considerate "arte" nel senso tradizionale, ma la verità è che la componente creativa e comunicativa è qui estremamente accentuata.</p>
            </div>
            <hr>

            <h2>Fotografia: fermare un istante</h2>
            <div class="element1">
                <figure>
                    <img class="image2" src="../imgs/Menzioni Onorevoli/Fotografia.jpg" alt="fotografia">
                    <figcaption>
                        L'arte dello scatto consapevole
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/Fotografia.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Scattare una foto non significa soltanto premere un pulsante. È una scelta consapevole: decidere cosa includere e cosa escludere. Si gioca con la luce e il contrasto per esprimere una visione personale. La post-produzione è poi l'atto finale per rendere l'immagine esattamente come l'avevi immaginata.</p>
            </div>

            <h2>Street photography: la città senza filtri</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/StreetPhotograpy.jpg" alt="street photography">
                    <figcaption>
                        La vita che accade in strada
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/StreetPhotograpy.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Nella street photography non c'è trucco. È un esercizio di pazienza e osservazione, dove il caos urbano trova un ordine geometrico o narrativo per un solo secondo dentro l'obiettivo, trasformando il banale in racconto.</p>
            </div>

            <hr>

            <h2 style="text-align: right;">Carte: quando l'arte si tiene in mano</h2>
            <div class="element2">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/carte.jpg" alt="carte">
                    <figcaption>
                        Design e collezionismo
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/carte.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Una carta deve funzionare su due livelli: l'estetica e la meccanica di gioco. È un oggetto fisico che deve essere iconico e utile alla strategia, dalle classiche napoletane ai mondi complessi dei TCG moderni.</p>
            </div>

            <h2 style="text-align: right;">Pokémon: riconoscersi in un istante</h2>
            <div class="element2">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/pokemon.jpg" alt="pokemon">
                    <figcaption>
                        L'immediatezza del Character Design
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/pokemon.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Il successo dei Pokémon risiede in un design pulito e amichevole. La forza visiva di queste creature crea un legame duraturo, dove l'estetica si sposa con un set preciso di regole, abilità ed evoluzioni.</p>
            </div>

            <h2>Exploding Kittens: ridere del caos</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/Exploding kittens.jpg" alt="exploding kittens">
                    <figcaption>
                        Ironia e stile diretto
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/Exploding kittens.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Questo gioco dimostra che non serve un'arte raffinata per divertire; basta lo stile giusto per creare l'atmosfera. Disegni assurdi e situazioni comiche creano una tensione ludica immediata.</p>
            </div>

            <h2>Magic: The Gathering: un mondo in un mazzo</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/magic.jpg" alt="magic">
                    <figcaption>
                        L'apice dell'illustrazione fantasy
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/magic.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Magic bilancia perfettamente l'aspetto artistico con la competizione. Ogni carta è un'opera d'arte che contribuisce a una narrazione fantasy profonda e a strategie di gioco incredibilmente stimolanti.</p>
            </div>

            <h2 style="text-align: right;">Disney Lorcana: nostalgia e strategia</h2>
            <div class="element2">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/Lorcana.jpg" alt="lorcana">
                    <figcaption>
                        Reinterpretazione dei classici
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/Lorcana.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Lorcana prende i personaggi Disney e li reinterpreta con illustrazioni fantastiche. Sotto la superficie nostalgica si cela una sfida tattica seria per giocatori di ogni età.</p>
            </div>

            <h2 style="text-align: right;">Tarocchi: guardarsi dentro</h2>
            <div class="element2">
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/Tarocchi.jpg" alt="tarocchi">
                    <figcaption>
                        Simbologia e introspezione
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/Tarocchi.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
                <p>Qui non si vince contro nessuno: ogni carta è un simbolo antico che funge da specchio per la propria narrazione interiore. Un'interazione continua tra l'immagine e chi la osserva.</p>
            </div>

            <hr>

            <h2 style="text-align: center;">Cucina: l'arte che si mangia</h2>
            <div class="element3">
                <p>La cucina è un'arte sensoriale totale. Ogni piatto comunica identità tramite il bilanciamento di sapori, colori e consistenze. È memoria e condivisione, capace di trasformare il nutrimento quotidiano in un'esperienza estetica coinvolgente.</p>
                <br>
                <figure>
                    <img class="image1" src="../imgs/Menzioni Onorevoli/Cucina.jpg" alt="cucina">
                    <figcaption>
                        L'estetica del gusto
                        <button type="button" class="fav-btn" data-path="../imgs/Menzioni Onorevoli/Cucina.jpg" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon">
                        </button>
                    </figcaption>
                </figure>
            </div>
        </div>

        <div class="sidebar">
            <nav class="menu">
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-home-100.png" alt="home"><a href="home.php">HOME</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-pencil-100.png" alt="animazione"><a href="animazione.php">ANIMAZIONE</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-controller-100.png" alt="videogiochi"><a href="videogiochi.php">VIDEOGIOCHI</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-headphones-100.png" alt="hip-hop"><a href="hip-hop.php">HIP-HOP</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-clapperboard-100 (1).png" alt="cinema"><a href="cinema.php">CINEMA</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-other-100.png" alt="menzioni"><a href="menzioni.php">MENZIONI</a></div>
                <div class="menu-itme"><img src="../imgs/Home/Icone/icons8-forum-100.png" alt="forum"><a href="forum.php">FORUM</a></div>
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
        <p>© <?php echo date('Y') ?> TERA. All rights reserved.</p>
    </div>
</body>

</html>