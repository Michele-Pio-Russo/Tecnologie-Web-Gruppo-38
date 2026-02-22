//prendiamo l'oggetto div di classe "theme-icon"
let title = document.getElementsByClassName("theme-icon");
//prendiamo il valore della variabile "darkmode" dallo storage del browser
let darkMode = localStorage.getItem('darkMode'); 
//prendiamo il bottone che usiamo per triggerare il cambiamento tra tema chiaro e tema scuro
const themeToggleButton = document.getElementById('theme-button');
//prendiamo le form relative ai questionari per ogni pagina del sito
const questionari = document.getElementsByClassName("questionario");
//prendiamo il bottone che usiamo per resettare le scelte relative alle form
const reset = document.getElementById("reset");
//prendiamo il bottone che usiamo per resettare le scelte relative alle form e segnalare che queste sono state salvate, anche se solo figuralmente
const submit = document.getElementById("submit");

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

//associamo al bottone la funzione per triggerare il reset delle scelte della form
reset.addEventListener('click', () => {
    for(let i = 0; i < questionari.length; i++) {
        questionari[i].reset();
    }
});

//associamo al bottone la funzione per triggerare il reset delle scelte della form e segnalare che queste sono state salvate, anche se solo figuralmente
submit.addEventListener('click', () => {
    for(let i = 0; i < questionari.length; i++) {
        questionari[i].reset();
    }
    alert("Le risposte sono state inviate");
});

//associamo al bottone la funzione per triggerare il cambiamento tra tema chiaro e tema scuro
themeToggleButton.addEventListener('click', () => {
    darkMode = localStorage.getItem('darkMode'); 
    if (darkMode !== 'active') {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
});

//script per la sezione Draggable
const items = document.querySelectorAll('.item');
const zones = document.querySelectorAll('.drop-zone');

// Gestione degli elementi trascinabili
items.forEach(item => {
  item.addEventListener('dragstart', (e) => {
    // Salviamo l'ID dell'elemento che stiamo trascinando
    e.dataTransfer.setData('text/plain', e.target.id);
    // Effetto visivo durante il trascinamento
    setTimeout(() => e.target.classList.add('hide'), 0);
  });

  item.addEventListener('dragend', (e) => {
    e.target.classList.remove('hide');
  });
});

// Gestione delle zone di rilascio
zones.forEach(zone => {
  // Necessario per consentire il "drop" (per default i browser lo bloccano)
  zone.addEventListener('dragover', (e) => {
    e.preventDefault(); 
  });

  zone.addEventListener('drop', (e) => {
    e.preventDefault();
    
    // Recuperiamo l'ID dell'elemento trascinato
    const id = e.dataTransfer.getData('text/plain');
    const draggable = document.getElementById(id);
    
    // Assicuriamoci di appendere l'elemento alla drop-zone corretta
    if (e.target.classList.contains('drop-zone')) {
      e.target.appendChild(draggable);
    } else {
      // Se l'utente rilascia sopra un altro elemento già presente, 
      // lo agganciamo comunque al contenitore padre
      e.target.closest('.drop-zone').appendChild(draggable);
    }
  });
});