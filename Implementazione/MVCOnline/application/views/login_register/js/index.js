//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile di controllo della mail, se esiste già è true;
var checkMailE = false;

//Variabile di controllo dei campi, se sono validi è true;
var checkInput = true;

/**
 * JQuery per far cambiare la classe
 * alle parti con i nomi specificati
 * dopo il click sul bottone "switch"
 */
$(function() {
	
	$('#switch').click(function() {
        $('#formContainer, #register, #switch, #login').toggleClass('toggle');
   });
   
})

//Espressioni regolari da controllare
var regMail = /\S+@\S+\.\S+/i;
var regLetters = /^[\u00c0-\u017E a-zA-Z\']+$/;
var regPhone = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;

/**
 * Variabile che controlla che un campo contenga i valori corretti in basse alle espressioni regolari.
 * @param value Valore da controllare.
 * @param id Id del campo da controllare.
 * @param regexp Espressione regolare da soddisfare.
 */
function convalidate(value, id, regexp) {

    //Variabile del campo
    var id = document.getElementById(id);

    //Se il campo è vuoto e non rispetta l'espressione regolare
    if (!regexp.test(value)) {

        //Colora il testo in rosso e segna l'errore.
        id.style.color = "red";
        checkInput = false;
    //Altrimenti
    } else {

        //Se si tratta della mail
        if(id.name == "emailR"){
            //Colora il testo di nero
            id.style.color = "black";
            checkInput = true;

            //Controlla la mail
            checkMail(value);

        //Altrimenti
        }else{
            //Colora il testo di nero
            id.style.color = "black";
            checkInput = true;
        }
    }
    confirm();
}

/**
 * Funzione che controlla che la mail non esista già
 * @param string mail Email da controllare se esiste.
 */
function checkMail(mail){
    //Prendo i ccampi da controlare
    var mailExists = document.getElementById('mailExists');
    var type = document.getElementById('type').value;

    //Se la richiesta Ajax risponde correttamente
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo tutti i valori passati dalla pagina
            var results = JSON.parse(xhttp.responseText);

            //Controllo che l'email inserità non esista già nel database
            for(var i = 0; i < results.length; i++){

                //Se la mail esiste già cambio la variabile di controllo e smetto di controllare segnalando il messaggio d'errore
                if(results[i]['email'] == mail){
                    mailExists.hidden = false;
                    checkMailE = false;
                    break;
                //Se la mail non esiste nascondo il messaggio d'erore e cambio la variabille di controllo.
                }else{
                    checkMailE = true;
                    mailExists.hidden = true;
                }
            }

            //Se la mail non esiste va avanti
            if(checkMailE){
                confirm();
            //se la mail esiste
            }else{

            }
        }
    }

    //Faccio una richiesta POST per controllare la mail con un dato in invio
    xhttp.open("POST", "/gestionevendita2018/registration/checkMail/", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("type="+ type);
}

//RegExp della password minima
var regPass = /^(?=.*[0-9])(?=.*[a-z]).{8,25}$/;
function checkPassword(str) {
    //Variabile che prende gli input su cui lavorare
    var confirm_password = document.getElementById('confirm-password');
    var invalid_pass = document.getElementById('invalid-pass');

    //Se viene scritto qualcosa
    if (!(str == "")) {

        //Se il campo non rispetta l'espressione regolare
        if(!regPass.test(str)){

            //mostro il testo di errore e disabilito il campo di conferma
            invalid_pass.hidden = false;
            confirm_password.disabled = true;

        //Altrimenti
        }else{

            //nascnodo il testo di errore e abilito il campo di conferma
            invalid_pass.hidden = true;
            confirm_password.disabled = false;
        }

    //Alrimenti
    } else {

        //disabilito il campo di conferma
        confirm_password.disabled = true;
    }

    //Apro la funzione per confermare tutti i campi
    confirm();
}

/**
 * Funzione che conferma e attiva o disattiva il bottone
 */
function confirm() {
    //Variabile che prende gli input su cui lavorare
    var confirm_password = document.getElementById('confirm-password');
    var pass = document.getElementById('password');
    var register_submit = document.getElementById('register-submit');
    var noPassMatch = document.getElementById('noPassMatch');
    var invalidInput = document.getElementById('invalidInput');

    //Se password e conferma son uguali e non vuoti ee tutti gli alri campi sono validi
    if (pass.value == confirm_password.value && pass.value != "" && !confirm_password.disabled && checkInput) {

        //Nascondo i messagi di errore e abilito il bottone
        invalidInput.hidden = true;
        noPassMatch.hidden = true;
        register_submit.disabled = false;

    //Se le password sono diverse e la conferma è abilitata
    }else if(pass != confirm_password.value && !confirm_password.disabled){

        //Mostro il messaggio di errore e disabilito il bottone
        noPassMatch.hidden = false;
        register_submit.disabled = true;

    //Se c'e un campo non valido
    }else if(!checkInput){

        //Mostro il messaggio di errore e disabilito il bottone
        invalidInput.hidden = false;
        register_submit.disabled = true;

    //Se i campi sono validi
    }else if(checkInput){

        //Nascondo il meessaggio di errore
        invalidInput.hidden = true;

    //Altrimenti
    }  else {

        //Nascondo il messaggio di errore e abilito il bottone
        noPassMatch.hidden = true;
        register_submit.disabled = true;
    }
}