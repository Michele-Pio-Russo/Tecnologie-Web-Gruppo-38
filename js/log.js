//prendiamo l'oggetto div di classe "theme-icon"
let title = document.getElementsByClassName("theme-icon");
//prendiamo il valore della variabile "darkmode" dallo storage del browser
let darkMode = localStorage.getItem('darkMode');
//prendiamo il bottone che usiamo per triggerare il cambiamento tra tema chiaro e tema scuro
const themeToggleButton = document.getElementById('theme-button');
//prendiamo l'icona del campo password
const passIco = document.getElementById("PassIcon");
//prendiamo l'input field della nostra form
const passFiled = document.getElementById("password");



//funzione per abilitare il tema scuro
const enableDarkMode = () => {
    title.item(0).setAttribute("title", "Cambia al tema Scuro");
    document.body.classList.add('dark-mode');
    localStorage.setItem('darkMode', 'active');
}
//funzione per disabilitare il tema scuro
const disableDarkMode = () => {
    title.item(0).setAttribute("title", "Cambia al tema Chiaro");
    document.body.classList.remove('dark-mode');
    localStorage.setItem('darkMode', null);
}
if (darkMode === 'active') {
    enableDarkMode();
}
//funzione per controllare le informazioni inserite nella form
function valida(nomeModulo)
{
if (nomeModulo.email.value == "") {
alert("Devi inserire una mail");
nomeModulo.email.focus();
return false;
}
if (nomeModulo.password.value == "") {
alert("Devi inserire una password");
nomeModulo.password.focus();
return false;
}
return true
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


//associamo all'immagine per cambiare l'icona della password, per renderela visibile o meno
passIco.addEventListener('click', () => {
     if (passIco.src.includes("pass_yes.png")) {
        passIco.src = "../imgs/Login/pass_no.png";
    } else {
        passIco.src = "../imgs/Login/pass_yes.png";
    }
    if(passFiled.type=="password")
        passFiled.type="text"
    else
        passFiled.type="password"
});


