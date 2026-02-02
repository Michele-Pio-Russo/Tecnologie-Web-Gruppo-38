//prendiamo l'oggetto div di classe "theme-icon"
let title = document.getElementsByClassName("theme-icon");
//prendiamo il valore della variabile "darkmode" dallo storage del browser
let darkMode = localStorage.getItem('darkMode');
//prendiamo il bottone che usiamo per triggerare il cambiamento tra tema chiaro e tema scuro
const themeToggleButton = document.getElementById('theme-button');
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
alert("Non puoi inserire @");
var a = new Array();
a = nome.split("@"); // restituisce un array splittato dalla @
nomep = a[0];
nomed = a[1];
nomeInput.value = nomep+nomed;
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

