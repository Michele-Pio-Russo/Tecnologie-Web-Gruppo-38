//prendiamo l'oggetto div di classe "theme-icon"
let title = document.getElementsByClassName("theme-icon");
//prendiamo il valore della variabile "darkmode" dallo storage del browser
let darkMode = localStorage.getItem('darkMode'); 
//prendiamo il bottone che usiamo per triggerare il cambiamento tra tema chiaro e tema scuro
const themeToggleButton = document.getElementById('theme-button');

//funzione per abilitare il tema scuro
const enableDarkMode = () => {
    title.item(0).setAttribute("title", "Cambia al tema Lunare");
    document.body.classList.add('dark-mode');
    localStorage.setItem('darkMode', 'active');
}

//funzione per disabilitare il tema scuro
const disableDarkMode = () => {
    title.item(0).setAttribute("title", "Cambia al tema Solare");
    document.body.classList.remove('dark-mode');
    localStorage.setItem('darkMode', null);
}
if (darkMode === 'active') {
    enableDarkMode();
}

//associamo al bottone la funzione per triggerare il cambiamento tra tema chiaro e tema scuro
themeToggleButton.addEventListener('click', () => {
    darkMode = localStorage.getItem('darkMode'); 
    if (darkMode !== 'active') {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
});

//gestione preferiti

document.addEventListener('click', function (event) {
    // Cerchiamo se il click è avvenuto su un bottone preferiti (o su un suo figlio come l'icona)
    const btn = event.target.closest('.fav-btn');
    
    if (btn) {
        event.preventDefault();
        const imgPath = btn.getAttribute('data-path');
        
        // Debug: controlla se il percorso viene letto
        console.log("Cliccato su:", imgPath);

        if (!imgPath) {
            alert("Errore: Percorso immagine non trovato!");
            return;
        }

        const params = new URLSearchParams();
        params.append('img_path', imgPath);

        fetch('../php/toggle_preferiti.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString()
        })
        .then(res => res.text())
        .then(result => {
            const status = result.trim();
            if (status === 'added') {
                alert("Immagine aggiunta ai preferiti! ❤️");
            } else if (status === 'removed') {
                alert("Immagine rimossa dai preferiti.");
            } else if (status === 'unauthorized') {
                alert("Devi effettuare il login!");
            } else {
                alert("Errore del server: " + status);
            }
        })
        .catch(err => {
            console.error("Errore Fetch:", err);
            alert("Errore di connessione.");
        });
    }
});
