//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile di controllo dei campi, se sono validi è true;
var checkInput = true;

//Variabile di controllo dei campi della modifica del prodotto
// se si cambia qualcosa diventa true
var checkModify = false;

//Imposto le variabili delle vecchie chiavi di negozio  gestore
var oldMail = "";
var oldName = "";
var oldAddress = "";
var oldCity = "";
/**
 * JQuery per far cambiare la classe
 * alle parti con i nomi specificati
 * dopo il click sul bottone "switch"
 */
$(function() {
    // Get the modal
    var addmodal = document.getElementById('addModal');
    var modifyModal = document.getElementById('modifyModal');

    $('#switch').click(function() {
        addmodal.style.display = "block";
    });

    // When the user clicks on <span> (x), close the modal
    $('.close').click(function() {
        addmodal.style.display = "none";
        modifyModal.style.display = "none";
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {

        if (event.target == addmodal || event.target == modifyModal) {
            addmodal.style.display = "none";
            modifyModal.style.display = "none";
        }
    }
})

//Espressioni regolari da controllare
var regMail = /\S+@\S+\.\S+/i;
var regLetters = /^[\u00c0-\u017E a-zA-Z\']+$/;
var regPhone = /^[+]{0,1}[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;
var regVia = /^[a-z 0-9]+$/i;

/**
 * Variabile che controlla che un campo contenga i valori corretti in basse alle espressioni regolari.
 * @param value Valore da controllare.
 * @param id Id del campo da controllare.
 * @param regexp Espressione regolare da soddisfare.
 */
function convalidate(value, id, regexp) {

    //Variabile del campo
    var obj = document.getElementById(id);
console.log(id);
    //Se il campo è vuoto e non rispetta l'espressione regolare
    if (!regexp.test(value)) {
        //Colora il testo in rosso e segna l'errore.
        obj.style.color = "red";

        //A dipendenza di che campo si tratta imposto la variabile di controllo
        if(id.substring(0, 3) == "mod"){
            checkModify = false;
        }else{
            checkInput = false;
        }

        //Altrimenti
    } else {
        //Colora il testo di nero
        obj.style.color = "black";

        //A dipendenza di che campo si tratta imposto la variabile di controllo
        if(id.substring(0, 3) == "mod"){
            checkModify = true;
        }else{
            checkInput = true;
        }
    }
    confirm();
    confirmMod();
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
    }else if(pass.value != confirm_password.value && !confirm_password.disabled){

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

/**
 * Funzione che conferma la modifica e attiva o disattiva il bottone
 */
function confirmMod() {
    var submit = document.getElementById("modifyShop");

    if(checkModify){
        submit.disabled = false;
    }else{
        submit.disabled = true;
    }
}

function getData(){
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Prendo il corpo del div in cui inserire i campi
            var divbody = document.getElementById('shopContainer');
            divbody.innerHTML = "";

            //Inserisco tutti le righe con i relativi dati.
            for (var i = 0; i < obj.length; i++) {

                //Prendo i div principale per i prodotti
                var divContainer = document.createElement("div");
                divContainer.setAttribute("class", "col-12 col-sm-6 col-lg-4");
                var divWrapper = document.createElement("div");
                divWrapper.setAttribute("class", "single-product-wrapper");

                //Creo un nuovo div che contiene le informaazioni e lo metto nel padre
                var div = document.createElement("div");
                div.setAttribute("class", "product-description");
                // noinspection JSDuplicatedDeclaration
                var a = document.createElement("a");
                a.setAttribute("href", "#");
                var h6 = document.createElement("h6");
                h6.style = "margin-left: 10px";
                h6.setAttribute("id", obj[i]['nome'] +"."+ obj[i]['indirizzo'] +"."+ obj[i]['citta']);
                h6.setAttribute("onclick", "shopDetails(this)");
                h6.appendChild(document.createTextNode(obj[i]['nome']));
                a.appendChild(h6);
                div.appendChild(a);

                //Creo un paragrafo che conterrà il prezzo
                // noinspection JSDuplicatedDeclaration
                var a = document.createElement("a");
                a.setAttribute("href", "#");
                var prezzo = obj[i]['prezzo'] + " Fr.";
                a.style = "margin-left: 10px; font-size: 15px;";
                a.setAttribute("id", obj[i]['nome'] +"."+ obj[i]['indirizzo'] +"."+ obj[i]['citta']);
                a.setAttribute("onclick", "fileShop(this.id)");
                a.appendChild(document.createTextNode("archivia"));
                div.appendChild(a);
                divWrapper.appendChild(div);

                //aggiungo tutti i div a quello primario
                divContainer.appendChild(divWrapper);
                divbody.appendChild(divContainer);
            }
        }
    };
    xhttp.open("POST", "/gestionevendita2018/admin/getShops", true);
    xhttp.send();
}

/**
 * Funzione che inserisce i dati nella pagina che mostra i dettagli del negozio per modificarli
 */
function shopDetails(tag) {
    var data = tag.id.split(".");

    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('modSBody');
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Cambio i dati del negozio
            var shopName = document.getElementById("modShopName");
            shopName.setAttribute("value", obj[0][0]);
            var shopAdress = document.getElementById("modShopAddress");
            shopAdress.setAttribute("value", obj[0]['indirizzo']);
            var shopCity = document.getElementById("modShopCity");
            shopCity.setAttribute("value", obj[0]['citta']);
            var shopPhone = document.getElementById("modShopPhone");
            shopPhone.setAttribute("value", obj[0][3]);

            //Cambio i dati del gestore
            var name = document.getElementById("modName");
            name.setAttribute("value", obj[0]['nome']);
            var surname = document.getElementById("modSurname");
            surname.setAttribute("value", obj[0]['cognome']);
            var phone = document.getElementById("modPhone");
            phone.setAttribute("value", obj[0]['telefono']);
            var mail = document.getElementById("modMail");
            mail.setAttribute("value", obj[0]['email']);

            document.getElementById('modifyModal').style.display = "block";

            //Imposto i vecchi valori delle chiavi
            document.getElementById('oldMail').value = obj['email'];
            document.getElementById('oldShopName').value = obj[0][0];
            document.getElementById('oldShopAddress').value = obj[0]['indirizzo'];
            document.getElementById('oldShopCity').value = obj[0]['citta'];
        }
    }
    xhttp.open("POST", "/gestionevendita2018/admin/getShopDealer", true);
    xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhttp.send("&name="+ data[0] +"&address="+ data[1] +"&city="+ data[2]);
}

/**
 * Funzione che archivia il negozio
 * @param id chiave composta del negozio concatenata.
 */
function fileShop(id){
    var id = id.split(".");
    console.log(id);
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            location.reload();
        }
    }
    xhttp.open("POST", "/gestionevendita2018/admin/fileShop", true);
    xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhttp.send("&name="+ id[0] +"&address="+ id[1] +"&city="+ id[2]);
}