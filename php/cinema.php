<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Tera ➔ Cinema</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="Cinema - TERA">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cinema.css" />
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
        <div class="content-wrapper">

            <div class="content">
                <div class="sectionlight">
                    <h2 style="text-align: center;">Cinema</h2>
                    <div class="element3">
                        <p>Il cinema è stato rivoluzionario: ha preso la fotografia e le ha dato movimento e parola. È quell'arte che riesce a farti vivere mille vite diverse stando seduto al buio, unendo immagini, musica e storie per farti emozionare come nient'altro sa fare.</p>
                    </div>
                    <hr>

                    <h2>Il Cinema come Linguaggio Totale</h2>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c1.jpg" alt="Cinema Linguaggio">
                            <figcaption style="text-align: center;">
                                L'esperienza sensoriale del cinema
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c1.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>Il cinema è una forma d’arte totale, capace di fondere narrazione, immagine, suono e performance in un’unica esperienza sensoriale. Ogni scelta formale, dalla luce al montaggio, contribuisce a guidare lo spettatore dentro una visione.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2 style="text-align: right;">Regia: La Visione che Tiene Insieme Tutto</h2>
                    <div class="element2">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c2.jpg" alt="Regia">
                            <figcaption style="text-align: center;">
                                Il tocco del regista
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c2.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>La regia è l’asse portante di un film. È la visione che coordina e armonizza tutti gli elementi, trasformando una storia scritta in un’esperienza emotiva concreta. Attraverso il controllo del ritmo, del punto di vista e della messa in scena, il regista decide non solo cosa raccontare, ma come farlo percepire.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2>Recitazione: Dare un Corpo all’Idea</h2>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c3.jpg" alt="Recitazione">
                            <figcaption style="text-align: center;">
                                L'incarnazione del personaggio
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c3.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>La recitazione è l’arte di incarnare il personaggio. Attraverso il corpo, la voce e lo sguardo, l’attore rende credibile ciò che sulla pagina è solo potenziale. È grazie alla performance che lo spettatore può identificarsi o entrare in conflitto con ciò che vede.</p>
                    </div>
                </div>
            </div>

            <div class="content2">
                <div class="sectiondark">
                    <h2 style="text-align: right;">Sceneggiatura: La Struttura Invisibile</h2>
                    <div class="element2">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c4.jpg" alt="Sceneggiatura">
                            <figcaption style="text-align: center;">
                                Lo scheletro del racconto
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c4.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>La sceneggiatura è lo scheletro nascosto del film. Trama, dialoghi e conflitti costruiscono l’ossatura su cui tutto il resto prende forma. Un buon script non si limita a raccontare eventi, ma organizza il tempo e la tensione narrativa.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2>Messaggi: L’Arte che Parla Senza Dire</h2>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c5.jpg" alt="Messaggi">
                            <figcaption style="text-align: center;">
                                Riflessione e sottotesto
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c5.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>Il cinema può essere strumento di riflessione sociale, politica ed esistenziale. Spesso il significato più profondo non è esplicito, ma suggerito attraverso immagini e silenzi, lasciando allo spettatore il compito di interpretare.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2 style="text-align: right;">Costumi: L’Abito come Narrazione</h2>
                    <div class="element2">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c6.jpg" alt="Costumi">
                            <figcaption style="text-align: center;">
                                Peaky Blinders: Identità visiva
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c6.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>I costumi definiscono l’identità dei personaggi e il loro status sociale. Un abito può comunicare appartenenza, ribellione o potere, diventando parte integrante del racconto cinematografico.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2>Illuminazione: Scrivere con la Luce</h2>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c7.jpg" alt="Illuminazione">
                            <figcaption style="text-align: center;">
                                Barry Lyndon: La luce naturale
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c7.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>L’illuminazione costruisce l’atmosfera emotiva. Luce e ombra guidano lo sguardo e influenzano la percezione, evocando tensione, intimità o malinconia.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h2 style="text-align: right;">Audio: Il Suono che Avvolge</h2>
                    <div class="element2">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/c8.jpg" alt="Audio">
                            <figcaption style="text-align: center;">
                                Dunkirk: L'immersione sonora
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/c8.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                        </figure>
                        <p>L’audio comprende musica ed effetti sonori. È fondamentale per l’immersione: può amplificare l’emozione e rendere un’immagine memorabile.</p>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="sectionlight">
                    <h2>Tre Film, Tre Visioni</h2>

                    <h3>Grand Budapest Hotel</h3>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/grandbudapest.jpg" alt="Grand Budapest">
                            <figcaption style="text-align: center;">
                                L’estetica come mondo chiuso
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/grandbudapest.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                            <a href="https://youtu.be/G1jG8HUY4zI" target="_blank">Guarda il Trailer</a>
                        </figure>
                        <p>Wes Anderson costruisce un universo visivo fatto di colori pastello e simmetrie ossessive. Ogni fotogramma è un quadro che trasforma la nostalgia in una fiaba elegante.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h3 style="text-align: right;">Seven</h3>
                    <div class="element2">
                        <figure>
                            <img class="image2" src="../imgs/Cinema/seven.jpg" alt="Seven">
                            <figcaption style="text-align: center;">
                                Il male come sistema logico
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/seven.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                            <a href="https://youtu.be/hKUABU9uPmw" target="_blank">Guarda il Trailer</a>
                        </figure>
                        <p>In Seven la violenza è un linguaggio simbolico sui sette peccati capitali. La performance del killer mostra come il male possa essere lucido e metodico.</p>
                    </div>

                    <br><br><br>
                    <hr><br><br><br>

                    <h3>Donnie Darko</h3>
                    <div class="element1">
                        <figure>
                            <img class="image1" src="../imgs/Cinema/donniedarko.jpg" alt="Donnie Darko">
                            <figcaption style="text-align: center;">
                                Identità e ambiguità
                                <button class="fav-btn" onclick="toggleFavorite('../imgs/Cinema/donniedarko.jpg')" title="Aggiungi ai preferiti">
                                    <img src="../imgs/Altro/preferiti.gif" class="fav-icon" alt="Preferiti">
                                </button>
                            </figcaption>
                            <a href="https://youtu.be/Uab7LYrAiqM" target="_blank">Guarda il Trailer</a>
                        </figure>
                        <p>Donnie Darko fonde fisica teorica e psicologia. L’arte risiede nel caos controllato e nel lasciare lo spettatore con più domande che risposte.</p>
                    </div>
                </div>
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