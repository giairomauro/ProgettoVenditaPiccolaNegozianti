//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile di controllo dei campi, se sono validi è true;
var checkInput = false;

//Variabile di controllo dei campi della modifica del prodotto
// se si cambia qualcosa diventa true
var checkModify = false;

//Array che conterrà i dati dei prodotti prima di essere modificati
var oldData = {
    src: "",
    category: "",
    shopName: "",
    shopAddress: "",
    shopCity: "",
    name: "",
    price: "",
    quantity: ""
}

//Variabile che prende tutte le liste dei select
var ul = document.getElementsByClassName("list");

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
        getCategories(false, ul[0]);
        setTimeout(function(){
            getShop(ul[1]);
        }, 500);
    });

    // When the user clicks on <span> (x), close the modal
    $('.close').click(function() {
        addmodal.style.display = "none";
        deleteCategoriesShop(ul[0], ul[1]);
        modifyModal.style.display = "none";
        deleteCategoriesShop(ul[2], ul[3]);
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {

        if (event.target == addmodal || event.target == modifyModal) {
            addmodal.style.display = "none";
            deleteCategoriesShop(ul[0], ul[1]);
            modifyModal.style.display = "none";
            deleteCategoriesShop(ul[2], ul[3]);
        }
    }
})

var regLetters = /^[\u00c0-\u017E a-zA-Z 0-9\']+$/;
var regNumbers = /^[0-9\']+$/;
function convalidate(value, id, regexp) {

    //Variabile del campo
    var obj = document.getElementById(id);

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
    //Richiamo le funzioni di conferma
    confirm();
    confirmMod();
}

/**
 * Funzione che conferma l'aggiunta e attiva o disattiva il bottone
 */
function confirm() {
    var submit = document.getElementById("insertProduct");

    if(checkInput){
        submit.disabled = false;
    }else{
        submit.disabled = true;
    }
}

/**
 * Funzione che conferma la modifica e attiva o disattiva il bottone
 */
function confirmMod() {
    var submit = document.getElementById("modifyProduct");

    if(checkModify){
        submit.disabled = false;
    }else{
        submit.disabled = true;
    }
}

/**
 * Funzione che riempie la lista delle categorie.
 */
function getCategories(list, ul) {

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            if(list) {
                //Prendo il corpo della tabella in cui inserire le righe
                var tbody = document.getElementById('menu-content2');

                //Creo la riga i cui inserire i campi e gli metto lee informazioni
                var li = document.createElement("li");
                li.setAttribute("data-toggle", "collapse");

                //Creo ina nuova colonna e inserisco ildato, per ogni informazioni richiesta
                var a = document.createElement("a");
                a.appendChild(document.createTextNode("Tutto"));
                a.setAttribute("href", "#");
                a.setAttribute("onclick", "getProducts()");
                li.appendChild(a);

                //Inserisco la riga nela tabella
                tbody.appendChild(li);
                //Inserisco tutti le righe con i relativi corsi.
                for (var i = 0; i < obj.length; i++) {
                    //Creo la riga i cui inserire i campi e gli metto lee informazioni
                    var li = document.createElement("li");
                    li.setAttribute("data-toggle", "collapse");

                    //Creo ina nuova colonna e inserisco ildato, per ogni informazioni richiesta
                    var a = document.createElement("a");
                    a.appendChild(document.createTextNode(obj[i]["nome"]));
                    a.setAttribute("href", "#");
                    a.setAttribute("value", obj[i]["nome"]);
                    a.setAttribute("onclick", "getProductsByCategory(this.text)");
                    li.appendChild(a);

                    //Inserisco la riga nela tabella
                    tbody.appendChild(li);
                }
                getProducts();
            }else{

                ul.setAttribute("required", "true");

                //Inserisco tutte le categorie in optio e poi nel select.
                for(var i = 0; i < obj.length; i++){
                    var li = document.createElement("li");
                    li.setAttribute("class", "option focus");
                    li.setAttribute("style", "z-index:0;");
                    li.setAttribute("data-value", obj[i]["nome"]);
                    li.appendChild(document.createTextNode(obj[i]["nome"]));
                    ul.appendChild(li);
                }
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/home/getCategories", true);
    xhttp.send();
}

/**
 * Funzione che riempie la select dei negozi.
 */
function getShop(ul) {
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Prendo i select ee li controllo
            var divUl = document.getElementsByClassName("nice-select");
            for (var i = 0; i < divUl.length; i++){
                //Se trovo il select del negozio imposto l'index
                if(divUl[i].childNodes[1].childNodes[0].getAttribute("data-value") == "Negozio"){
                    divUl[i].setAttribute("style", "z-index:0;");
                }
            }

            //Inserisco tutte le categorie in optio e poi nel select.
            for(var i = 0; i < obj.length; i++){
                var li = document.createElement("li");
                li.setAttribute("class", "option focus");
                li.setAttribute("style", "z-index:3;");
                li.setAttribute("data-value", obj[i]["nome"] +"."+ obj[i]["indirizzo"] +"."+ obj[i]["citta"]);
                li.setAttribute("id", obj[i]["nome"] +"."+ obj[i]["indirizzo"] +"."+ obj[i]["citta"]);
                li.appendChild(document.createTextNode(obj[i]["nome"]));
                ul.appendChild(li);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/dealer/getShopsByDealer", true);
    xhttp.send();
}

/**
 * Funzione che elimina i dati dei select alla chiusura dei popup
 */
function deleteCategoriesShop(ulC, ulS){

    //Faccio passare tutti i valori del select dall'ultimo e li cancello
    // lasciando il primo
    var ulClength = ulC.getElementsByTagName("li").length;
    for (var i = ulClength-1; i > 0; i--){
        ulC.removeChild(ulC.childNodes[i]);
    }

    var ulSlength = ulS.getElementsByTagName("li").length;
    for (var i = ulSlength-1; i > 0; i--){
        ulS.removeChild(ulS.childNodes[i]);
    }
}

/**
 * Funzione iniziale che inserisce tutt i prodotti
 */
function getProducts() {
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Richiamo la funzione per inserire i prodotti
            insertProducts(obj);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getDealerProducts", true);
    xhttp.send();
}

/**
 * Funzione iniziale che inserisce tutt i prodotti
 */
function getProductsByCategory(category) {
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Richiamo la funzione per inserire i prodotti
            insertProducts(obj);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getProductsByCategory", true);
    xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhttp.send("&category="+ category +"&dealer=true");
}

function insertProducts(obj){
    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('prodContainer');
    divbody.innerHTML = "";

    //Inserisco tutti le righe con i relativi dati.
    for (var i = 0; i < obj.length; i++) {

        //Prendo i div principale per i prodotti
        var divContainer = document.createElement("div");
        divContainer.setAttribute("class", "col-12 col-sm-6 col-lg-4");
        var divWrapper = document.createElement("div");
        divWrapper.setAttribute("class", "single-product-wrapper");

        //Creo la riga i cui inserire i campi e gli metto imposto la classe
        var div = document.createElement("div");
        div.setAttribute("class", "product-img");

        //Creo un immagine  imposto il source con il dato preso ee inserisco il div nel contenitore padre
        var img = document.createElement("img");
        var src = "http://samtinfo.ch/gestionevendita2018/"+obj[i]["img"] ;
        img.setAttribute("src", src);
        img.setAttribute("title", obj[i]['nome_prodotto']);
        img.setAttribute("alt", obj[i]['nome_prodotto']);
        div.appendChild(img);
        divWrapper.appendChild(div);

        //Creo un nuovo div che contiene le informaazioni e lo metto nel padre
        var div = document.createElement("div");
        div.setAttribute("class", "product-description");
        var a = document.createElement("a");
        a.setAttribute("href", "#");
        var h6 = document.createElement("h6");
        h6.style = "margin-left: 10px";
        h6.setAttribute("id", obj[i]['img'] +"."+ obj[i]['nome_categoria'] +"."+ obj[i]['nome_negozio']  +"."+ obj[i]['indirizzo_negozio']  +"."+ obj[i]['citta_negozio'] +"."+ obj[i]['nome_prodotto'] +"."+ obj[i]['prezzo_prodotto'] +"."+ obj[i]['quantita_prodotto']);
        h6.setAttribute("onclick", "detailsProduct(this)");
        h6.appendChild(document.createTextNode(obj[i]['nome_prodotto']));
        a.appendChild(h6);
        div.appendChild(a);

        //Creo un paragrafo chee conterrà il prezzo
        var p = document.createElement("p");
        var prezzo = obj[i]['prezzo'] +" Fr."
        p.style = "margin-left: 10px";
        p.appendChild(document.createTextNode(prezzo));
        div.appendChild(p);
        divWrapper.appendChild(div);

        //aggiungo tutti i div a quello primario
        divContainer.appendChild(divWrapper);
        divbody.appendChild(divContainer);
    }
}

/**
 * Funzione che inserisce i dati nella pagina che mostra i dettagli del prodotto per modificarli
 */
function detailsProduct(obj) {
    var data = obj.id.split(".");

    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('modSBody');

    //Creo la riga i cui inserire i campi e gli metto imposto la classe
    var div = document.createElement("div");
    div.setAttribute("class", "single_product_thumb clearfix");

    //Inserisco l'immagine del prodotto
    var img = document.getElementById("modImage");
    img.src = "http://samtinfo.ch/gestionevendita2018/"+ data[0] +"."+ data[1];

    //Imposto le liste di categoria e negozi
    getCategories(false, ul[2]);
    setTimeout(function(){
        getShop(window.ul[3]);
    }, 400);

    //Prendo i div e inserisco i valori li imposto come selected
    var divUl = document.getElementsByClassName("nice-select");
    divUl[2].childNodes[0].innerHTML = data[2];
    divUl[3].childNodes[0].innerHTML = data[3];
    setTimeout(function(){

        for(var i = 0; i < divUl[2].childNodes[1].childNodes.length; i++){
            if(divUl[2].childNodes[1].childNodes[i].innerHTML == data[2]){
                divUl[2].childNodes[1].childNodes[i].setAttribute("class", "option selected focus");
            }
        }
        setCategory("modCategory");
    }, 200);
    setTimeout(function(){

        for(var i = 0; i < divUl[3].childNodes[1].childNodes.length; i++){
            if(divUl[3].childNodes[1].childNodes[i].innerHTML == data[3]){
                divUl[3].childNodes[1].childNodes[i].setAttribute("class", "option selected focus");
            }
        }
        setShop("modShop");
    }, 600);
    //Inserisco il nome del prodotto
    var name = document.getElementById("modTitle");
    name.setAttribute("value", data[6]);

    //Inserisco il prezzo del prodotto
    var price = document.getElementById("modPrice");
    price.setAttribute("value", data[7]);

    //Inserisco il prezzo del prodotto
    var quantity = document.getElementById("modQuantity");
    quantity.setAttribute("value", data[8]);

    document.getElementById('modifyModal').style.display = "block";

    //Inserisco i dati nell'array dei vecchi dati
    oldData['src'] = img.src;
    oldData['category'] = data[2];
    oldData['shopName'] = data[3];
    oldData['shopAddress'] = data[4];
    oldData['shopCity'] = data[5];
    oldData['name'] = data[6];
    oldData['price'] = data[7];
    oldData['quantity'] = data[8];
    document.getElementById('oldData').value = img.src +"."+ data[2] +"."+ data[3] +"."+ data[4]  +"."+ data[5]  +"."+ data[6] +"."+ data[7] +"."+ data[8];
}

/**
 * Funzione che imposta il select nascosto per la categoria.
 * @param id id del select.
 */
function setCategory(id){
    var category = document.getElementById(id);

    //Se è un campo della modifica imposto la variabile di controllo
    if(id.substr(0, 3) == "mod"){
        checkModify = true;
    }

    //Elimino l'ultimo valore se ce ne sono più di 2
    var length = category.length;
    if(length >= 2){
        category.remove(1);
    }
    //Creo una nuova option
    var option = document.createElement("option");

    //prendo il tag del negozio selezionato
    var li = document.getElementsByClassName("selected")[0];

    //Inserisco all'interno della variabile il valore del paragrafo creato alla selezione della categoria
    option.setAttribute("value", li.innerHTML);

    //Inserisco l'option creata e la seleziono
    category.appendChild(option);
    category.getElementsByTagName('option')[1].setAttribute("selected", true);

    confirmMod();
}

/**
 * Funzione che imposta il select nascosto per il negozio.
 * @param id id del select.
 */
function setShop(id){
    var category = document.getElementById(id);

    //Se è un campo della modifica imposto la variabile di controllo
    if(id.substr(0, 3) == "mod"){
        checkModify = true;
    }

    //Elimino l'ultimo valore se ce ne sono più di 2
    var length = category.length;
    if(length >= 2){
        category.remove(1);
    }
    //Creo una nuova option
    var option = document.createElement("option");

    //prendo il tag del negozio selezionato
    var li = document.getElementsByClassName("selected")[document.getElementsByClassName("selected").length - 1];

    //Inserisco all'interno della variabile il valore del paragrafo creato alla selezione della categoria
    option.setAttribute("value", li.id);

    //Inserisco l'option creata e la seleziono
    category.appendChild(option);
    category.getElementsByTagName('option')[1].setAttribute("selected", true);

    confirmMod();
}

/**
 * Funzione che mostra l'immagine selezionata
 * @param file Input dell'immagine
 */
function setImage(file){
    //Controlo che abbia selezionato un file
    if (file.files && file.files[0]) {

        //creo un lettore di file
        var reader = new FileReader();

        //Quando viene caricato un file
        reader.onload = function (e) {

            //Se è un campo della modifica imposto la variabile di controllo
            //Modifico l'attributo src dell'immagine inserendo quelo del file selezionato
            if(file.id.substr(0, 3) == "mod"){
                $('#modImage')
                    .attr('src', e.target.result)
            }else{
                $('#image')
                    .attr('src', e.target.result)
            }
        };

        //Setto i dati del file per l'URL
        reader.readAsDataURL(file.files[0]);
    }
}