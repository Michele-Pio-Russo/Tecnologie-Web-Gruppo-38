<?php
session_start();
include "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['invia_questionario']) && isset($_SESSION['autorizzato'])) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['invia_feedback_sezioni']) && isset($_SESSION['autorizzato'])) {
        $testo_home = isset($_POST['commento_home']) ? htmlspecialchars(trim($_POST['commento_home'])) : '';
        $testo_animazione = isset($_POST['commento_animazione']) ? htmlspecialchars(trim($_POST['commento_animazione'])) : '';
        $testo_videogiochi = isset($_POST['commento_giochi']) ? htmlspecialchars(trim($_POST['commento_giochi'])) : '';
        $testo_musica = isset($_POST['commento_musica']) ? htmlspecialchars(trim($_POST['commento_musica'])) : '';
        $testo_cinema = isset($_POST['commento_cinema']) ? htmlspecialchars(trim($_POST['commento_cinema'])) : '';
        $testo_menzioni = isset($_POST['commento_menzioni']) ? htmlspecialchars(trim($_POST['commento_menzioni'])) : '';
        $testo_forum = isset($_POST['commento_forum']) ? htmlspecialchars(trim($_POST['commento_forum'])) : '';
        $data = date('Y-m-d H:i:s');

        if (!empty($testo_home) || !empty($testo_animazione) || !empty($testo_videogiochi) || !empty($testo_musica) || !empty($testo_cinema) || !empty($testo_menzioni) || !empty($testo_forum)) {
            $sql_insert = "INSERT INTO commenti_sezioni (home, animazione, videogiochi, musica, cinema, menzioni, forum, data_creazione) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
            pg_query_params($db, $sql_insert, array($testo_home, $testo_animazione, $testo_videogiochi, $testo_musica, $testo_cinema, $testo_menzioni, $testo_forum, $data));
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['testo_commento']) && isset($_SESSION['autorizzato'])) {
        if (!empty(trim($_POST['testo_commento']))) {
            $testo = htmlspecialchars(trim($_POST['testo_commento']));
            $utente = $_SESSION['nome_utente'];
            $data = date('Y-m-d H:i:s');

            $sql_insert = "INSERT INTO commenti (nome_utente, testo, data_creazione) VALUES ($1, $2, $3)";
            pg_query_params($db, $sql_insert, array($utente, $testo, $data));
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$sql = "SELECT nome_utente, testo, data_creazione FROM commenti ORDER BY data_creazione DESC";
$ret = pg_query($db, $sql);

if ($ret) {
    $commenti = pg_fetch_all($ret);
}

if (empty($commenti)) {
    $commenti = [];
}

$msg_geo = "Devi essere loggato per visualizzare la tua posizione.";
if (isset($_SESSION['autorizzato']) && $_SESSION['autorizzato'] === true) {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($ip === '::1' || $ip === '127.0.0.1') $ip = '8.8.8.8';

    $res = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
    if ($res && $res['status'] == 'success') {
        $msg_geo = "📍 Posizione rilevata:\\nCittà: " . addslashes($res['city']) . "\\nPaese: " . addslashes($res['country']) . "\\nCoord: {$res['lat']}, {$res['lon']}";
    } else {
        $msg_geo = "Dati posizione momentaneamente non disponibili.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Tera ➔ Forum</title>
    <link rel="icon" href="../imgs/Logo/T.png" type="image/x-icon">
    <meta name="description" content="Forum e discussioni di Tera">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/forum.css" />
    <script type="text/javascript" src="../js/forum.js" defer></script>
</head>

<body>
    <div class="header">
        <div class="logo">
            <div class="immagine-logo"></div>
            <h1>TERA</h1>
        </div>
        <div class="login">
            <div class="pos" title="Informazioni sulla posizione">
                <button type="button" id="get-pos-btn" style="background:none; border:none; cursor:pointer;">
                    <img src="../imgs/Altro/position.png" alt="Posizione" class="position-icon" />
                </button>
            </div>
            <div class="theme-icon" title="Cambia al tema Chiaro/Scuro">
                <button id="theme-button">
                    <img src="../imgs/Tema/light_mode.png" alt="Tema Solare" />
                    <img src="../imgs/Tema/dark_mode.png" alt="Tema Lunare" />
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
                    <img src="../imgs/Login/login1.png" alt="Login" class="login-icon" />
                </a>
            <?php endif; ?>
        </div>
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

    <div class="main-content">
        <div class="content">
            <h2 style="text-align: center;">Forum</h2>
            <div class="element3">
                <p>In questa sezione è presente una tabella che indica, per ogni categoria, l'innovazione
                    principale che ha segnato per sempre il loro sviluppo.</p>
            </div>
            <hr>

            <table class="tabella">
                <tr>
                    <th>Categoria</th>
                    <th>Rivoluzione Chiave</th>
                    <th>Impatto Nel Mondo</th>
                </tr>
                <tr>
                    <th>Animazione</th>
                    <td>L'era della CGI (Toy Story, 1995)</td>
                    <td>Ha segnato il passaggio dal disegno a mano alla modellazione 3D digitale, cambiando per sempre il cinema d'animazione.</td>
                </tr>
                <tr>
                    <th>Videogiochi</th>
                    <td>Il 3D e lo Z-Targeting (Ocarina of Time, 1998)</td>
                    <td>Ha definito lo standard per l'esplorazione e il combattimento negli spazi tridimensionali, influenzando ogni open-world moderno.</td>
                </tr>
                <tr>
                    <th>Cinema</th>
                    <td>L'avvento del Sonoro (1927)</td>
                    <td>Ha trasformato il cinema da un'arte puramente visiva e mimica in un'esperienza multisensoriale completa.</td>
                </tr>
                <tr>
                    <th>Hip-Hop</th>
                    <td>Il "Breakbeat" (DJ Kool Herc, 1973)</td>
                    <td>Isolando le parti ritmiche dei dischi per far ballare i "B-Boys", ha dato vita a una cultura globale che unisce musica, danza e arte.</td>
                </tr>
                <tr>
                    <th>Carte</th>
                    <td>Il formato TCG (Magic: The Gathering, 1993)</td>
                    <td>Ha inventato il concetto di "gioco di carte collezionabili", trasformando semplici mazzi di carte in asset di valore e mondi narrativi complessi.</td>
                </tr>
                <tr>
                    <th>Fotografia</th>
                    <td>La Digitalizzazione (Sensore CCD)</td>
                    <td>Ha reso la fotografia istantanea e accessibile a chiunque, eliminando la necessità dello sviluppo chimico e portando alla nascita dei social media visivi.</td>
                </tr>
                <tr>
                    <th>Cucina</th>
                    <td>La Brigata di Cucina (Auguste Escoffier)</td>
                    <td>Ha introdotto una gerarchia militare e una divisione dei compiti scientifica, permettendo alla ristorazione di diventare veloce, efficiente e professionale.</td>
                </tr>
            </table>

            <h2 style="text-align: center; margin-top:50px;">Questionario di Valutazione</h2>
            <div class="element3">
                <p>Chi ha fatto l'accesso al nostro sito può compilare un breve questionario, aiutandoci a capire quali sezioni migliorare.</p>
            </div>
            <hr>
            <h3>Lascia una valutazione alle sezioni</h3>
            <?php if (isset($_SESSION['autorizzato'])): ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <img src="../imgs/Form/Ringraziamenti.jpg" alt="Ringraziamenti" align="right" class="image1">

                    <h3>Quali sezioni hai preferito di più?</h3>
                    <p>Animazione e Disegno <input type="checkbox" name="sez_pref[]" value="Animazione" /></p>
                    <p>Videogiochi <input type="checkbox" name="sez_pref[]" value="Videogiochi" /></p>
                    <p>Hip-Hop <input type="checkbox" name="sez_pref[]" value="HipHop" /></p>
                    <p>Cinema <input type="checkbox" name="sez_pref[]" value="Cinema" /></p>
                    <p>Menzioni Onorevoli <input type="checkbox" name="sez_pref[]" value="Menzioni" /></p>

                    <br>
                    <h3>Sezione Preferita</h3>
                    <div class="container">
                        <div class="drop-zone" id="sezioni-disponibili">
                            <h3>Sezioni Disponibili</h3>
                            <div class="item" draggable="true" id="animazione">✏️ Animazione</div>
                            <div class="item" draggable="true" id="videogiochi">🎮 Videogiochi</div>
                            <div class="item" draggable="true" id="hip-hop">🎧 Hip-Hop</div>
                            <div class="item" draggable="true" id="cinema">📽️ Cinema</div>
                            <div class="item" draggable="true" id="menzioni-onorevoli">⭐ Menzioni Onorevoli</div>
                        </div>

                        <div class="drop-zone" id="sezione-preferita">
                            <h3>Trascina qui la tua sezione preferita</h3>
                        </div>
                    </div>


                    <br>
                    <h3>Dai un voto alle varie sezioni</h3>
                    <div class="domande">
                        <h4>Animazione e Disegno:</h4>
                        <p>1 <input type="radio" name="votoanimazione" value="1" /> 2 <input type="radio" name="votoanimazione" value="2" /> 3 <input type="radio" name="votoanimazione" value="3" /> 4 <input type="radio" name="votoanimazione" value="4" /> 5 <input type="radio" name="votoanimazione" value="5" /></p>

                        <h4>Videogiochi:</h4>
                        <p>1 <input type="radio" name="votogiochi" value="1" /> 2 <input type="radio" name="votogiochi" value="2" /> 3 <input type="radio" name="votogiochi" value="3" /> 4 <input type="radio" name="votogiochi" value="4" /> 5 <input type="radio" name="votogiochi" value="5" /></p>

                        <h4>Hip-Hop:</h4>
                        <p>1 <input type="radio" name="votohiphop" value="1" /> 2 <input type="radio" name="votohiphop" value="2" /> 3 <input type="radio" name="votohiphop" value="3" /> 4 <input type="radio" name="votohiphop" value="4" /> 5 <input type="radio" name="votohiphop" value="5" /></p>

                        <h4>Cinema:</h4>
                        <p>1 <input type="radio" name="votocinema" value="1" /> 2 <input type="radio" name="votocinema" value="2" /> 3 <input type="radio" name="votocinema" value="3" /> 4 <input type="radio" name="votocinema" value="4" /> 5 <input type="radio" name="votocinema" value="5" /></p>

                        <h4>Menzioni Onorevoli:</h4>
                        <p>1 <input type="radio" name="votomenzioni" value="1" /> 2 <input type="radio" name="votomenzioni" value="2" /> 3 <input type="radio" name="votomenzioni" value="3" /> 4 <input type="radio" name="votomenzioni" value="4" /> 5 <input type="radio" name="votomenzioni" value="5" /></p>
                    </div>

                    <div class="element1" style="margin-top:20px;">
                        <button type="submit" name="invia_questionario" id="submit">Conferma Voti</button>
                        <button type="reset" id="reset">Reimposta</button>
                    </div>
                </form>
            <?php else: ?>
                <p style="color: #ff4444; margin-bottom: 20px;"><b>Devi effettuare il login per poter dare una valutazione alle sezioni.</b></p>
            <?php endif; ?>

            <hr>

            <h3>Lascia un commento relativo ad ogni sezione</h3>
            <?php if (isset($_SESSION['autorizzato'])): ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="commento">
                    <div class="option">
                        <div class="tendina">Home</div>
                        <textarea name="commento_home" cols="30" rows="3" placeholder="Scrivi qui il tuo commento per la Home..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Animazione e Disegno</div>
                        <textarea name="commento_animazione" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Videogiochi</div>
                        <textarea name="commento_giochi" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Hip-Hop</div>
                        <textarea name="commento_musica" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Cinema</div>
                        <textarea name="commento_cinema" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Menzioni Onorevoli</div>
                        <textarea name="commento_menzioni" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="option">
                        <div class="tendina">Forum</div>
                        <textarea name="commento_forum" cols="30" rows="3" placeholder="Scrivi qui il tuo commento..."></textarea>
                    </div>
                    <div class="element1" style="margin-top:20px;">
                        <button type="submit" name="invia_feedback_sezioni">Invia Feedback Sezioni</button>
                    </div>
                </form>
            <?php else: ?>
                <p style="color: #ff4444; margin-bottom: 20px;"><b>Devi effettuare il login per poter fare commenti alle sezioni.</b></p>
            <?php endif; ?>

            <hr>

            <div class="sezione-commenti">
                <h3>Lascia un commento alla community</h3>

                <?php if (isset($_SESSION['autorizzato'])): ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="comment-form">
                        <textarea name="testo_commento" placeholder="Cosa ne pensi? Scrivi qui..." required></textarea>
                        <div class="element1">
                            <button type="submit">Pubblica Commento</button>
                        </div>
                    </form>
                <?php else: ?>
                    <p style="color: #ff4444; margin-bottom: 20px;"><b>Devi effettuare il login per poter scrivere nella bacheca.</b></p>
                <?php endif; ?>

                <hr>

                <h3>Discussioni della Community</h3>

                <div class="lista-commenti">
                    <?php if (!empty($commenti)): ?>
                        <?php foreach ($commenti as $comm): ?>
                            <div class="comment-card">
                                <div class="comment-header">
                                    <strong class="user-name">
                                        <img src="../imgs/Form/person_gen.png" alt="User" style="width:20px; vertical-align:middle; margin-right:5px;">
                                        <?php echo htmlspecialchars($comm['nome_utente']); ?>
                                    </strong>
                                    <span class="comment-date">
                                        <?php echo date('d/m/Y H:i', strtotime($comm['data_creazione'])); ?>
                                    </span>
                                </div>
                                <p class="comment-text">
                                    <?php echo nl2br(htmlspecialchars($comm['testo'])); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <strong class="user-name">
                                    <img src="../imgs/Form/person_gen.png" style="width:20px; vertical-align:middle; margin-right:5px;" alt="User">
                                    Staff Tera
                                </strong>
                                <span class="comment-date">
                                    <?php echo date('d/m/Y'); ?>
                                </span>
                            </div>
                            <p class="comment-text">
                                Ancora nessun commento. Rompi il ghiaccio e scrivi il primo messaggio!
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
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
                <a href="#">Instagram</a>
            </div>
            <div class="contact facebook">
                <img src="../imgs/Home/Footer/icons8-facebook-nuovo-100.png" alt="Facebook">
                <a href="https://www.facebook.com/groups/1338264634726723/">Facebook</a>
            </div>
            <div class="contact telegram">
                <img src="../imgs/Home/Footer/icons8-telegramma-100.png" alt="Telegram">
                <a href="#">Telegram</a>
            </div>
            <div class="contact discord">
                <img src="../imgs/Home/Footer/icons8-logo-discord-100.png" alt="Discord">
                <a href="#">Discord</a>
            </div>
        </div>
        <p>© <?php echo date('Y') ?> TERA. All rights reserved.</p>
    </div>
</body>

</html>