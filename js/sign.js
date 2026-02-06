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
if (nomeModulo.nome.value == "") {
alert("Devi inserire un nome");
nomeModulo.nome.focus();
return false;
}
if (nomeModulo.password.value == "") {
alert("Devi inserire una password");
nomeModulo.password.focus();
return false;
}
return true
}
function verifica(nomeInput) {
nome = nomeInput.value;
atPos = nome.indexOf("@",0);
if(atPos > -1) {
alert("Il campo dell'username non accetta la @");
var a = new Array();
a = nome.split("@"); // restituisce un array splittato dalla @
nomep = a[0];
nomed = a[1];
nomeInput.value = nomep+nomed;
}
}

//funzione che usiamo per controllare la validità della password che inserisce l'utente
function controllaPass(inputPassword) {
    const password = inputPassword.value;
    let errore = "";

    if (password.length < 4) {
        errore = "La password deve essere di almeno 4 caratteri.";
    } else if (!/[a-z]/.test(password)) {
        errore = "La password deve contenere almeno una lettera minuscola.";
    } else if (!/[A-Z]/.test(password)) {
        errore = "La password deve contenere almeno una lettera maiuscola.";
    } else if (!/\d/.test(password)) {
        errore = "La password deve contenere almeno un numero.";
    } else if (!/[\W_]/.test(password)) {
        errore = "La password deve contenere almeno un carattere speciale (! @ # $ % _).";
    }
    //segnialiamo con una alert box l'errore relativo alla validità della password
    if (errore !== "") {
        alert(errore);
        inputPassword.focus();
        return false;
    }

    return true;
}

//funzione che usiamo per controllare la validità dell'inidirizzo email inserito dall'utente
function controllaEmail(inputEmail)
{
    let email = inputEmail.value;
    if (!email.includes("@")) {
    alert("L'indirizzo email deve contenere una @\nNon ti preoccupare, l'ho aggiunta io :)");
    inputEmail.value = email + "@";
    return;
    }
    const dominiComuni = ["gmail.com", "outlook.com", "yahoo.com", "hotmail.com", "libero.it"];
    const dominioUtente = email.split('@')[1];

    if (!dominiComuni.includes(dominioUtente)) {
         alert("Dominio della main non valido => Inserire uno dei seguenti domini:\n- gmail.com\n- outlook.com\n- yahoo.com\n- hotmail.com\n- libero.it")
         rerurn
     }
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

