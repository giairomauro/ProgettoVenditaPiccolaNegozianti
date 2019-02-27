//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile di controllo dei campi, se sono validi è true;
var checkInput = false;

/**
 * JQuery per far cambiare la classe
 * alle parti con i nomi specificati
 * dopo il click sul bottone "switch"
 */
$(function() {

    $('#switch').click(function() {
        window.location = 'http://samtinfo.ch/gestionevendita2018/dealer/add';
    });

})

var regLetters = /^[\u00c0-\u017E a-zA-Z 0-9\']+$/;
var regNumbers = /^[0-9\']+$/;
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
        //Colora il testo di nero
        id.style.color = "black";
        checkInput = true;
    }
    confirm();
}

/**
 * Funzione che conferma e attiva o disattiva il bottone
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
 * Funzione che riempie la lista delle categorie.
 */
function getCategories(list) {

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
                var ul = document.getElementsByClassName("list");
                ul[0].setAttribute("required", "true");

                //Inserisco tutte le categorie in optio e poi nel select.
                for(var i = 0; i < obj.length; i++){
                    var li = document.createElement("li");
                    li.setAttribute("class", "option selected focus");
                    li.setAttribute("data-value", obj[i]["nome"]);
                    li.appendChild(document.createTextNode(obj[i]["nome"]));
                    ul[0].appendChild(li);
                }
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/home/getCategories", true);
    xhttp.send();
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
 * Funzionee che inserisce i dati nella pagina che mostra i dettagli del prodotto per modificarli
 */
/*function DetailsProduct(obj) {

    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('sBody');

    //Creo la riga i cui inserire i campi e gli metto imposto la classe
    var div = document.createElement("div");
    div.setAttribute("class", "single_product_thumb clearfix");

    //Creo un immagine  imposto il source con il dato preso ee inserisco il div nel contenitore padre
    var label = document.createElement("label");
    label.setAttribute("for", "file-input");
    var img = document.createElement("img");
    var src = "http://samtinfo.ch/gestionevendita2018/application/img/blankImg.png;
    img.setAttribute("src", src);
    label.appendChild(img);
    div.appendChild(label);

    //Creo un nuovo div che contiene le informaazioni e lo metto nel padre
    var div = document.createElement("div");
    div.setAttribute("class", "single_product_desc clearfix");
    var span = document.createElement("span");
    span.appendChild(document.createTextNode(obj['nome']))
    var a = document.createElement("a");
    a.setAttribute("href", "#");
    var h6 = document.createElement("h6");
    h6.appendChild(document.createTextNode(obj['nome']));
    a.appendChild(h6);
    div.appendChild(a);
    divWrapper.appendChild(div);

    //Creo un paragrafo chee conterrà il prezzo
    var p = document.createElement("p");
    var prezzo = obj['prezzo'] +" Fr."
    p.appendChild(document.createTextNode(prezzo));
    divWrapper.appendChild(p);

    //aggiungo tutti i div a quello primario
    divContainer.appendChild(divWrapper);
    divbody.appendChild(divContainer);
}*/

/**
 * Funzione che imposta il select nascosto
 * @param id id del select.
 */
function setCategory(id){
    var category = document.getElementById(id);

    //Elimino l'ultimo valore se ce ne sono più di 2
    var length = category.length;
    if(length >= 2){
        category.remove(1);
    }
    //Creo una nuova option
    var option = document.createElement("option");

    //Inserisco all'interno della variabile il valore del paragrafo creato alla selezione della categoria
    option.setAttribute("value", document.getElementById("current").innerHTML);

    //Inserisco l'option creata e la seleziono
    category.appendChild(option);
    category.getElementsByTagName('option')[1].setAttribute("selected", true);
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
            //Modifico l'attributo src dell'immagine niserendo quelo del file selezionato
            $('#image')
                .attr('src', e.target.result)
        };

        //Setto i dati del file per l'URL
        reader.readAsDataURL(file.files[0]);
    }
}