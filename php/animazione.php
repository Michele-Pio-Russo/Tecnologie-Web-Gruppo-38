<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Tera ➔ Animazione & Disegno</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="Analisi artistica e tecnica del mondo dell'animazione">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/animazione.css" />
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
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
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
                    <img src="../imgs/Login/login1.png" alt="Immagine Login" class="login-icon" />
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-content">
        <div class="content">
            <h2 style="text-align: center;">Animazione</h2>
            <div class="element3">
                <p>I cartoni animati ci hanno accompagnato fin da quando eravamo bambini, ovviamente i designer hanno sempre optato per scelte stilistiche importanti che ci tenevano incollati allo schermo, in questa sezione parliamo proprio di questo.</p>
            </div>
            <hr>

            <h2>Il Caos Cinetico Moderno</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/DANDADAN.jpg" alt="Dandadan Okarun">
                    <figcaption style="text-align: center;">
                        Dandadan: Okarun in azione
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/DANDADAN.jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>In <em>Dandadan</em>, il disegno rompe le regole della pulizia classica. L'autore utilizza linee "sporche" e un contrasto netto tra nero profondo e colori psichedelici per rappresentare il soprannaturale. A differenza degli anime tradizionali, qui il "line art" varia di spessore improvvisamente per accentuare la follia della scena, mescolando l'estetica horror con quella pop in un equilibrio visivo che ricorda i poster punk rock.</p>
            </div>

            <h2 style="text-align: right;">I Padri dello Slapstick</h2>
            <div class="element2">
                <figure>
                    <img class="image2" src="../imgs/Animazione/download (5).jpg" alt="Looney Tunes End Card">
                    <figcaption style="text-align: center;">
                        Looney Tunes: L'immortale "That's all Folks!"
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (5).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>Prima della computer grafica, c'erano loro. I <em>Looney Tunes</em> hanno inventato la "fisica dei cartoni": un personaggio non cade nel burrone finché non guarda giù. Artisti come Chuck Jones usavano i cosiddetti "Smear Frames" (fotogrammi sbavati) per simulare la velocità: disegnavano un personaggio con tre teste o dieci gambe in un singolo frame per ingannare l'occhio umano e creare un movimento fluidissimo.</p>
            </div>

            <h2>L'Immersività dei Fondali</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/download (4).jpg" alt="Studio Ghibli Mashup">
                    <figcaption style="text-align: center;">
                        L'arte dei fondali dello Studio Ghibli
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (4).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>L'immagine qui a fianco unisce i mondi dello Studio Ghibli, famosi per i fondali dipinti a mano. Mentre i personaggi hanno colori piatti (cell shading), il mondo attorno a loro è dipinto con una ricchezza di dettagli quasi impressionista. Hayao Miyazaki insiste sul concetto di "Ma" (spazio vuoto): scene contemplative fondamentali per dare un'anima al disegno.</p>
            </div>

            <h2 style="text-align: right;">Lo Stile "CalArts" e il Post-Apocalittico</h2>
            <div class="element2">
                <figure>
                    <img class="image2" src="../imgs/Animazione/download (3).jpg" alt="Adventure Time Campfire">
                    <figcaption style="text-align: center;">
                        Adventure Time: Un design semplice per storie profonde
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (3).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p><em>Adventure Time</em> ha sdoganato lo stile "Noodle Arms", privo di articolazioni rigide. Sembra infantile, ma permette animazioni espressive con budget ridotti. Il design colorato nasconde un background cupo e post-apocalittico, dimostrando che il disegno semplice può raccontare storie adulte.</p>
            </div>

            <h2>Graffiti e Tratto Sporco</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/download (6).jpg" alt="Gachiakuta Urban Style">
                    <figcaption style="text-align: center;">
                        Gachiakuta: L'estetica urban e ruvida
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (6).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>In <em>Gachiakuta</em>, l'animazione recupera il sapore del "bozzetto". I personaggi hanno contorni spessi, quasi disegnati con un pennarello indelebile. Questo stile "Urban" rifiuta la perfezione digitale, dando al disegno una consistenza ruvida e materica.</p>
            </div>

            <h2 style="text-align: right;">La Psicologia delle Forme</h2>
            <div class="element2">
                <figure>
                    <img class="image2" src="../imgs/Animazione/download (2).jpg" alt="Steven Universe Star Eyes">
                    <figcaption style="text-align: center;">
                        Steven Universe: Espressività e Shape Language
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (2).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>In <em>Steven Universe</em>, tutto si basa sulla "Shape Language". I personaggi buoni usano curve morbide, mentre i nemici hanno punte e triangoli. Gli "occhi a stella" sono un omaggio diretto agli anime anni '90, usati per un dettaglio iper-espressivo.</p>
            </div>

            <h2>Il Mixed Media</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/Gumball (The Wonderfully World of Gumball).jpg" alt="Gumball Watterson">
                    <figcaption style="text-align: center;">
                        Gumball: L'integrazione tra 2D e realtà
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/Gumball (The Wonderfully World of Gumball).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p><em>Gumball</em> è un miracolo tecnico: personaggi 2D piatti che si muovono su fondali fotografici reali. La sfida è far sì che la luce reale colpisca il disegno in modo credibile, creando uno stile ibrido unico al mondo.</p>
            </div>

            <h2 style="text-align: right;">Il Ritorno del Rubber Hose</h2>
            <div class="element2">
                <figure>
                    <img class="image2" src="../imgs/Animazione/onepiece.jpg" alt="Luffy Gear 5">
                    <figcaption style="text-align: center;">
                        Luffy Gear 5: La rottura della logica fisica
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/onepiece.jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>Con il Gear 5, <em>One Piece</em> recupera lo stile "Rubber Hose" degli anni '30. Il corpo diventa un tubo flessibile e la prospettiva viene distorta volutamente per trasmettere un senso di libertà assoluta.</p>
            </div>

            <h2>Storytelling Senza Parole</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/download (7).jpg" alt="Stickman Animation">
                    <figcaption style="text-align: center;">
                        Stickman: La potenza della Line of Action
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/download (7).jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>Questa immagine rappresenta la pura "Line of Action". Anche senza volto, capiamo l'emozione e il ruolo del personaggio solo dalla postura. È la prova che il design minimalista può essere epico quanto un film realistico.</p>
            </div>

            <h2 style="text-align: right;">Linee Sottili e Colori Saturi</h2>
            <div class="element2">
                <figure>
                    <img class="image2" src="../imgs/Animazione/hazbin.jpg" alt="Hazbin Hotel Cast">
                    <figcaption style="text-align: center;">
                        Hazbin Hotel: Uno stile denso e gotico
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/hazbin.jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>Lo stile di <em>Hazbin Hotel</em> è denso e dominato da linee verticali sottilissime. L'uso del rosso e del rosa saturo appiattisce la profondità, creando l'effetto di una rivista di moda gotica.</p>
            </div>

            <h2>Luce e Colore senza Contorni</h2>
            <div class="element1">
                <figure>
                    <img class="image1" src="../imgs/Animazione/Dreamy Pastel Paintings Capture the Lazy Lives of Leisurely Sunbathing Cats.jpg" alt="Digital Painting Cat">
                    <figcaption style="text-align: center;">
                        Lineless Art: Definire i volumi col colore
                        <button class="fav-btn" onclick="toggleFavorite('../imgs/Animazione/Dreamy Pastel Paintings Capture the Lazy Lives of Leisurely Sunbathing Cats.jpg')" title="Aggiungi/Rimuovi dai preferiti">
                            <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                        </button>
                    </figcaption>
                </figure>
                <p>In questa illustrazione "lineless", tutto è definito dalle forme di colore e dalla luce. È una tecnica pittorica fondamentale per i concept artist che devono creare l'atmosfera emotiva di un'opera.</p>
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
        <p>© <?php echo date('Y') ?> TERA. All rights reserved.</p>
    </div>
</body>

</html>