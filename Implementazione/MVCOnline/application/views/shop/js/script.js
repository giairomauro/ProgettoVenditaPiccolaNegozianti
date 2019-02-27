//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile per segnalare la ricerca tramite categoria
var searchCategory = false;

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
                a.setAttribute("class", "categories");
                a.setAttribute("style", "color:#0315FF;");
                a.setAttribute("onclick", "getProducts(this)");
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
                    a.setAttribute("class", "categories");
                    a.setAttribute("value", obj[i]["nome"]);
                    a.setAttribute("onclick", "getProductsByCategory(this.text, this)");
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
 * Funzione che riempie la lista delle categorie nella agina principale.
 */
function getCategoriesHome() {

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Prendo il corpo della tabella in cui inserire le righe
            var divbody = document.getElementById('divContainer');

            //Inserisco tutti le righe con i relativi corsi.
            for (var i = 0; i < obj.length; i++) {

                //Creo i div e la riga finale e inserisco tutto
                var div = document.createElement("div");
                div.setAttribute("class", "col-12 col-sm-6 col-md-4");
                var divIntern = document.createElement("div");
                divdivIntern.setAttribute("class", "single_catagory_area d-flex align-items-center justify-content-center bg-img");
                var divFinal = document.createElement("div");
                divdivFinal.setAttribute("class", "catagory-content");
                var a = document.createElement("a");
                a.setAttribute("href", "<?php echo URL ?>home/shop");
                a.appendChild(document.createTextNode(obj[i]["nome"]));

                divFinal.appendChild(a);
                divIntern.appendChild(divFinal);
                div.appendChild(divIntern);
                divbody.appendChild(div);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/home/getCategories", true);
    xhttp.send();
}

/**
 * Funzione iniziale che inserisce tutt i prodotti
 */
function getProducts(link = null) {
    //Se viene inserito l'del link
    if(link != null) {
        //Modifico la selezione del link cliccato e resetto gli altri
        link.setAttribute("style", "color:#0315FF;");

        //Controllo tutti gli elementi
        for (i = 0; i < document.getElementsByClassName("categories").length; i++) {
            //Se l'elemento è diverso da quello cliccato allora lo coloro di nero
            if (link != document.getElementsByClassName("categories")[i]) {
                document.getElementsByClassName("categories")[i].setAttribute("style", "color:FFFFFF;");
            }
        }
    }
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            searchCategory = false;

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Richiamo la funzione per inserire i prodotti
            insertProducts(obj);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getProducts", true);
    xhttp.send();
}

/**
 * Funzione iniziale che inserisce tutt i prodotti
 */
function getProductsByCategory(category, link = null) {
    //Se viene inserito l'del link
    if(link != null) {
        //Modifico la selezione del link cliccato e resetto gli altri
        link.setAttribute("style", "color:#0315FF;");

        //Controllo tutti gli elementi
        for (i = 0; i < document.getElementsByClassName("categories").length; i++) {

            //Se l'elemento è diverso da quello cliccato allora lo coloro di nero
            if (link != document.getElementsByClassName("categories")[i]) {
                document.getElementsByClassName("categories")[i].setAttribute("style", "color:FFFFFF;");
            }
        }
    }


    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            searchCategory = category;

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Richiamo la funzione per inserire i prodotti
            insertProducts(obj);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getProductsByCategory", true);
    xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhttp.send("&category="+ category);
}

/**
 * Funzione che ricerca i prodotti in base ad un valore
 * @param value Valore da ricercare nei prodotti
 */
function searchProduct(value){
    if(value != ""){
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                //Prendo i valori passati dal server e li metto in un array
                var obj = JSON.parse(xhttp.responseText);

                //Richiamo la funzione per inserire i prodotti
                insertProducts(obj);
            }
        }
        xhttp.open("POST", "/gestionevendita2018/product/searchProducts", true);
        xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhttp.send("category="+ searchCategory +"&value="+ value);
    }else{
        if(!searchCategory){
            getProducts();
        }else{
            getProductsByCategory(searchCategory);
        }

    }
}

/**
 * Funzione che va a impostare tutti i prodotti nella struttura adeguata
 * @param obj Array contenente i dati dei prodotti da mostrare.
 */
function insertProducts(obj){
    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('prodContainer');
    divbody.innerHTML = "";

    //Inserisco tutti le righe con i relativi dati.
    for (var i = 0; i < obj.length; i++) {
        //Se c'è ancora il prodotto
        if(obj[i]['quantita'] > 0) {

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
            var src = "http://samtinfo.ch/gestionevendita2018/" + obj[i]["img"];
            img.setAttribute("src", src);
            img.setAttribute("title", obj[i]['nome']);
            img.setAttribute("alt", obj[i]['nome']);
            div.appendChild(img);
            divWrapper.appendChild(div);

            //Creo un nuovo div che contiene le informaazioni e lo metto nel padre
            var div = document.createElement("div");
            div.setAttribute("class", "product-description");
            var a = document.createElement("a");
            a.setAttribute("href", "#");
            var h6 = document.createElement("h6");
            h6.style = "margin-left: 10px";
            h6.appendChild(document.createTextNode(obj[i]['nome']));
            a.appendChild(h6);
            div.appendChild(a);

            //Creo un paragrafo chee conterrà il prezzo
            var p = document.createElement("p");
            var prezzo = obj[i]['prezzo'] + " Fr."
            p.style = "margin-left: 10px";
            p.appendChild(document.createTextNode(prezzo));
            div.appendChild(p);

            //Inserisco l'aggiunta al cart se si va sull'immagine
            var divHover = document.createElement("div");
            divHover.setAttribute("class", "hover-content");
            var divCart = document.createElement("div");
            divCart.setAttribute("class", "add-to-cart");
            var a = document.createElement("a");
            a.setAttribute("id", "addToCart");
            a.setAttribute("class", "btn essence-btn");
            a.setAttribute("style", "color:white;");
            a.setAttribute("name", obj[i]['nome'] + "." + obj[i]['prezzo'] + "." + obj[i]['quantita']);
            a.setAttribute("onclick", "addToCart(this)");
            a.appendChild(document.createTextNode("Carrello"));
            divCart.appendChild(a);
            divHover.appendChild(divCart);
            div.appendChild(divHover);
            divWrapper.appendChild(div);

            //aggiungo tutti i div a quello primario
            divContainer.appendChild(divWrapper);
            divbody.appendChild(divContainer);
        }
    }
}

/**
 * Funzione che disabilità l'evento di submit della ricerca
 */
function disableForm(){

    document.getElementById('buttonSearch').addEventListener("click", function(event){
        event.preventDefault()});
}

/**
 * Funzione che decodifica il valore passato
 * @param value Valore da decodificare
 * @returns {never|string[]} Array contenente i valori divisi.
 */
function encode(nome, price, quantity){
    return nome +"."+ price +"."+ quantity;
}

/**
 * Funzione che decodifica il valore passato
 * @param value Valore da decodificare
 * @returns {never|string[]} Array contenente i valori divisi.
 */
function decode(value){
    return value.split(".");
}

/**
 * Funzione che richiam la funzione che aggiunge il valore al carrello
 * @param codedKeys chiave codificata.
 */
function addToCart(link){
    //Divido la chiave composta nei valori
    var keys = decode(link.name);

    //Se il prodotto è disponibile
    if(keys[2] > 0) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                //Diminuisco di uno il valore della quantità del prodotto nel nome
                keys[2]--;
                link.name = encode(keys[0], keys[1], keys[2]);

                //Prendo i valori che vanno mostrati nel carrello
                getCart();
            }
        }
        xhttp.open("POST", "/gestionevendita2018/customer/addToCart", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("&name=" + keys[0] + "&price=" + keys[1] + "&quantity=" + keys[2]);
    }
}

/**
 * Funzione che prende i prodotti presenti nel carello
 * @param codedKeys chiave codificata.
 */
function getCart(){
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            if(typeof (obj[0]) == "object"){
                for(var i = 0; i < obj.length; i++){
                    var codedKeys = encode(obj[i]['nome_prodotto'], obj[i]['prezzo_prodotto'], obj[i]['quantita_prodotto']);

                    //richiamo la funzione che inserisce i prodotti
                    modifyCart(codedKeys);
                }
            }else{
                var codedKeys = encode(obj['nome_prodotto'], obj['prezzo_prdotto'], obj['quantita_prodotto']);

                //richiamo la funzione che inserisce i prodotti
                modifyCart(codedKeys);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/customer/getCart", true);
    xhttp.send();
}

/**
 * Funzione che va a impostare il carello nella struttura adeguata
 * @param obj Array contenente i dati dei prodotti da inserire.
 */
function modifyCart(codedKeys){
    var keys = decode(codedKeys);
    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('cart-list');
    divbody.innerHTML = "";

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(xhttp.responseText);
            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);
            console.log(obj);

            var divBody = document.createElement("div");
            divBody.setAttribute("class", "cart-list");
            //Inserisco tutti le righe con i relativi dati.
            for (var i = 0; i < obj.length; i++) {

                //Prendo i div principale per i prodotti
                var divContainer = document.createElement("div");
                divContainer.setAttribute("class", "single-cart-item");

                var a = document.createElement("a");
                a.setAttribute("class", "product-image");
                var img = document.createElement("img");
                img.setAttribute("class", "cart-thumb");
                a.appendChild(img);

                var div = document.createElement("div");
                div.setAttribute("class", "cart-item-desc");
                var span = document.createElement("span");
                span.setAttribute("class", "product-remove");
                var i = document.createElement("i");
                i.setAttribute("class", "fa fa-close");
                i.setAttribute("aria-hidden", "ture");
                span.appendChild(i);
                div.appendChild(span);

                var span = document.createElement("span");
                span.setAttribute("class", "badge");
                span.appendChild(document.createTextNode("Prodotto"));
                div.appendChild(span);

                var h6  = document.createElement("h6");
                h6.appendChild(document.createTextNode(obj['nome_prodotto']));
                div.appendChild(h6);

                divBody(div);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getProduct", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&name=" + keys[0] + "&price=" + keys[1] + "&quantity=" + keys[2]);
}