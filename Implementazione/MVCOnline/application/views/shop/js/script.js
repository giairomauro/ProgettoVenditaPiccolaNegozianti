//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

//Variabile per segnalare la ricerca tramite categoria
var searchCategory = false;

//Variabile che controlla il mnumero di prodotti nel carrello
var cartObjects = 0;

//Variabile del prezzo totale
var totPrice = 0;

/**
 * JQuery per far chiudere il modal deidettagli al click del bottone apposito
 * o all'esterno di esso.
 */
$(function() {
    // Get the modal
    var detailsModal = document.getElementById('detailsModal');

    // When the user clicks on <span> (x), close the modal
    $('.close').click(function() {
        detailsModal.style.display = "none";
        deleteDetails();
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {

        if (event.target == detailsModal) {
            detailsModal.style.display = "none";
            deleteDetails();
        }
    }
})

/**
 * Funzione che elimina i dettagli del prodotto dopo che si chiude il popup
 */
function deleteDetails(){

    //Prendo tutti gli elementi dello shop  li elimino
    var shops =  document.getElementsByClassName("shop");
    for (var i = 0; i < shops.length; i++){
        shops[i].parentNode.removeChild(shops[i]);
    }

    //Svuoto la categoria del prodotto
    document.getElementById("category").innerHTML = "";

    //Svuoto la categoria del prodotto
    document.getElementById("title").innerHTML = "";

    //Svuoto la categoria del prodotto
    document.getElementById("price").innerHTML = "";

    //Svuoto la categoria del prodotto
    document.getElementById("quantity").innerHTML = "";
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
                divIntern.setAttribute("class", "single_catagory_area d-flex align-items-center justify-content-center bg-img");
                var divFinal = document.createElement("div");
                divFinal.setAttribute("class", "catagory-content");
                var a = document.createElement("a");
                a.setAttribute("href", "<?php echo URL ?>home/shop");
                a.appendChild(document.createTextNode(obj[i]["nome"]));

                divFinal.appendChild(a);
                divIntern.appendChild(divFinal);
                div.appendChild(divIntern);
                divbody.appendChild(div);
            }
            getCart();
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

            //Inserisco i dati già esistenti nel carrello
            getCart();
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
            h6.setAttribute("id", obj[i]['nome'] +"."+ obj[i]['prezzo'] +"."+ obj[i]['quantita']);
            h6.setAttribute("onclick", "detailsProduct(this)");
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
function addToCart(obj){

    //Divido la chiave composta nei valori
    var keys = decode(obj.name);

    //Se il prodotto è disponibile
    if(keys[2] > 0) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                //Diminuisco di uno il valore delle quantità a tutti i nomi richiesti
                var name = encode(keys[0], keys[1], keys[2]);
                var x = document.getElementsByName(name);
                keys[2]--;
                for(var i = x.length - 1; i >= 0; i--) {
                    x[i].name = encode(keys[0], keys[1], keys[2]);
                }

                if (document.getElementById("cart" + keys[0])) {
                    //Modifico la variabile del numero di oggetti
                    cartObjects++;
                    totPrice += parseInt(keys[1]);
                    String(keys[1]);
                }

                //Prendo i valori che vanno mostrati nel carrello
                getCartProduct(keys[0], keys[1], keys[2]);
            }
        }
        xhttp.open("POST", "/gestionevendita2018/customer/modifyCart", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("&name=" + keys[0] + "&price=" + keys[1] + "&quantity=" + keys[2] + "&action=add");
    }
}

/**
 * Funzione che richiama la funzione che toglie un valore dal carrello
 * @param codedKeys chiave codificata.
 */
function delOneFromCart(obj){

    //Divido la chiave composta nei valori
    var keys = decode(obj.name);

    //Se il prodotto è disponibile
    if(keys[2] > 0) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                //Diminuisco di uno il valore delle quantità a tutti i nomi richiesti
                var name = encode(keys[0], keys[1], keys[2]);
                var x = document.getElementsByName(name);
                keys[2]++;
                for(var i = x.length - 1; i >= 0; i--) {
                    x[i].name = encode(keys[0], keys[1], keys[2]);
                }

                //Modifico la variabile del numero di oggetti
                cartObjects--;
                totPrice -= parseInt(keys[1]);
                String(keys[1]);

                //Prendo i valori che vanno mostrati nel carrello
                getCartProduct(keys[0], keys[1], keys[2]);
            }
        }
        xhttp.open("POST", "/gestionevendita2018/customer/modifyCart", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("&name=" + keys[0] + "&price=" + keys[1] + "&quantity=" + keys[2] + "&action=delOne");
    }
}

/**
 * Funzione che richiama la funzione che toglie il prodotto dal carrello
 * @param codedKeys chiave codificata.
 */
/*function delFromCart(obj){

    //Divido la chiave composta nei valori
    var keys = decode(obj.name);

    //Se il prodotto è disponibile
    if(keys[2] > 0) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                //Diminuisco di uno il valore della quantità del prodotto nel nome
                keys[2]++;
                obj.name = encode(keys[0], keys[1], keys[2]);

                //Modifico la variabile del numero di oggetti
                cartObjects--;
                totPrice -= parseInt(keys[1]);
                String(keys[1]);
                totPrice -= parseInt(keys[1]) * cartObjects;
                cartObjects = 0;
                String(keys[1]);

                //Prendo i valori che vanno mostrati nel carrello
                getCartProduct(keys[0], keys[1], keys[2]);
            }
        }
        xhttp.open("POST", "/gestionevendita2018/customer/modifyCart", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("&name=" + keys[0] + "&price=" + keys[1] + "&quantity=" + keys[2] + "&action=del");
    }
}*/

/**
 * Funzione che prende il prodotto che si aggiunge alla funzione
 * @param name
 * @param price
 * @param quantity
 */
function getCartProduct(name, price, quantity){
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //richiamo la funzione che inserisce i prodotti
            modifyCart(obj[0][0]);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/customer/getCartProduct", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&name=" + name + "&price=" + price + "&quantity=" + quantity);
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

            //variabile che contiene tutte le chiavi
            var codedKeys = new Array();

            if(typeof (obj[0]) == "object"){
                for(var i = 0; i < obj.length; i++){
                    //richiamo la funzione che inserisce i prodotti
                    modifyCart(obj[i]);
                }
            }else{
                //richiamo la funzione che inserisce i prodotti
                modifyCart(obj);
            }
            setPickupShop();
        }
    }
    xhttp.open("POST", "/gestionevendita2018/customer/getCart", true);
    xhttp.send();
}

/**
 * Funzione che inserisce tutti i
 */
function setPickupShop(){
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Prendo la lista in cui inserire i dati
            var ul = document.getElementsByClassName("list")[0];
            while (ul.childNodes.length > 1) {
                ul.removeChild(ul.lastChild);
            }
            //Inserisco tutte le categorie in option e poi nel select.
            for(var i = 0; i < obj.length; i++){
                var li = document.createElement("li");
                li.setAttribute("class", "option focus");
                li.setAttribute("id", obj[i]['nome'] +"."+ obj[i]['indirizzo'] +"."+ obj[i]['citta'] +"."+ obj[i]['email'] +"."+ obj[i]['telefono']);
                li.setAttribute("style", "z-index:0;");
                li.setAttribute("data-value", obj[i]["nome"]);
                li.appendChild(document.createTextNode(obj[i]["nome"]));
                ul.appendChild(li);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/customer/getPickupShop", true);
    xhttp.send();
}

/**
 * Funzione che va a impostare il carello nella struttura adeguata
 * @param obj Array contenente i dati dei prodotti da inserire.
 */
function modifyCart(obj){

    //Prendo il corpo del div in cui inserire i campi
    var divBody = document.getElementById('cart-list');

    if(obj['quantita_richiesta'] > 0) {
        //Controllo se il prodotto è già nel carrello
        if (!document.getElementById("cart" + obj['nome_prodotto'])) {
            //Modifico la variabile del numero di oggetti e del prezzo
            cartObjects += parseInt(obj['quantita_richiesta']);
            totPrice += parseInt(obj['quantita_richiesta'] * obj['prezzo_prodotto']);

            //Prendo i div principale per i prodotti
            var divContainer = document.createElement("div");
            divContainer.setAttribute("class", "single-cart-item");
            divContainer.setAttribute("id", "cart" + obj['nome_prodotto']);

            //Inserisco il link che conterrà tutto
            var a = document.createElement("a");
            a.setAttribute("class", "product-image");
            a.setAttribute("style", "height: 200px;");

            //Inserisco l'immagine
            var img = document.createElement("img");
            var src = "http://samtinfo.ch/gestionevendita2018/" + obj["img"];
            img.setAttribute("class", "cart-thumb");
            img.setAttribute("src", src);
            img.setAttribute("alt", obj['nome_prodotto']);
            img.setAttribute("title", obj['nome_prodotto']);
            img.setAttribute("id", "img" + obj['nome_prodotto']);
            a.appendChild(img);

            //Creo il contenitore dei testi
            var div = document.createElement("div");
            div.setAttribute("class", "cart-item-desc");

            //Inserisco il bottone di aggiunta
            var aProd = document.createElement("a");
            aProd.setAttribute("name", obj['nome_prodotto'] + "." + obj['prezzo_prodotto'] + "." + obj['quantita_prodotto']);
            aProd.setAttribute("onclick", "addToCart(this)");
            var span = document.createElement("span");
            span.setAttribute("class", "product-remove mr-5");
            var i = document.createElement("i");
            i.setAttribute("class", "fa fa-plus");
            i.setAttribute("aria-hidden", "ture");
            span.appendChild(i);
            aProd.appendChild(span);
            div.appendChild(aProd);

            //Inserisco il bottone di diminunzione
            var aProd = document.createElement("a");
            aProd.setAttribute("name", obj['nome_prodotto'] + "." + obj['prezzo_prodotto'] + "." + obj['quantita_prodotto']);
            aProd.setAttribute("onclick", "delOneFromCart(this)");
            var span = document.createElement("span");
            span.setAttribute("class", "product-remove mr-4");
            var i = document.createElement("i");
            i.setAttribute("class", "fa fa-minus");
            i.setAttribute("aria-hidden", "ture");
            span.appendChild(i);
            aProd.appendChild(span);
            div.appendChild(aProd);

            //Inserisco il bottone di eliminazione
            /*var aProd = document.createElement("a");
            aProd.setAttribute("name", obj['nome_prodotto'] + "." + obj['prezzo_prodotto'] + "." + obj['quantita_prodotto']);
            aProd.setAttribute("onclick", "delFromCart(this)");
            var span = document.createElement("span");
            span.setAttribute("class", "product-remove");
            var i = document.createElement("i");
            i.setAttribute("class", "fa fa-close");
            i.setAttribute("aria-hidden", "ture");
            span.appendChild(i);
            aProd.appendChild(span);
            div.appendChild(aProd);*/

            //Inserisco la categoria
            // noinspection JSDuplicatedDeclaration
            var span = document.createElement("span");
            span.setAttribute("class", "badge");
            span.appendChild(document.createTextNode(obj['nome_categoria']));
            div.appendChild(span);

            var h6 = document.createElement("h6");
            h6.appendChild(document.createTextNode(obj['nome_prodotto']));
            var input = document.createElement("input");
            input.setAttribute("type", "text");
            input.setAttribute("style", "display: none;");
            input.setAttribute("name", "name[]");
            input.setAttribute("value", obj['nome_prodotto']);
            div.appendChild(input);
            div.appendChild(h6);

            var p = document.createElement("p");
            var prezzo = obj['prezzo_prodotto'] + " Fr";
            p.setAttribute("class", "price");
            p.appendChild(document.createTextNode("prezzo: " + prezzo));
            var input = document.createElement("input");
            input.setAttribute("type", "text");
            input.setAttribute("style", "display: none;");
            input.setAttribute("name", "price[]");
            input.setAttribute("value", obj['prezzo_prodotto']);
            div.appendChild(input);
            div.appendChild(p);

            var p = document.createElement("p");
            p.setAttribute("class", "price");
            p.setAttribute("id", "quantity" + obj['nome_prodotto']);
            p.appendChild(document.createTextNode("quantità: " + obj['quantita_richiesta']));
            // noinspection JSDuplicatedDeclaration
            var input = document.createElement("input");
            input.setAttribute("type", "text");
            input.setAttribute("style", "display: none;");
            input.setAttribute("name", "quantity[]");
            input.setAttribute("value", obj['quantita_richiesta']);
            div.appendChild(input);
            div.appendChild(p);

            a.appendChild(div);
            divContainer.appendChild(a);
            divBody.appendChild(divContainer);
            //Altrimenti
        } else {

            //Cerco il valore da aggiungere e lo incremento
            // noinspection JSDuplicatedDeclaration
            for(var i = 0; i < document.getElementsByName('name[]').length; i++){
                if(document.getElementsByName('name[]')[i].value === obj['nome_prodotto']){

                    document.getElementsByName('quantity[]')[i].value = obj['quantita_richiesta'];
                    document.getElementsByName('price[]')[i].value = obj['prezzo_prodotto'] * obj['quantita_richiesta'];
                }
            }

            //Modifico la quantità del prodotto richiesto
            document.getElementById("quantity" + obj['nome_prodotto']).innerHTML = "";
            document.getElementById("quantity" + obj['nome_prodotto']).appendChild(
                document.createTextNode("quantità: " + obj['quantita_richiesta']));
        }

        //Scrivo il numero di oggetti
        for (var i = 0; i < document.getElementsByClassName("cartObjects").length; i++) {
            document.getElementsByClassName("cartObjects")[i].innerHTML = "";
            document.getElementsByClassName("cartObjects")[i].appendChild(document.createTextNode(cartObjects));
        }

        //Scrivo il prezzo totale nel sommario
        document.getElementById('totPrice').innerHTML = totPrice + "Fr.";
        document.getElementById('totQuantity').innerHTML = cartObjects;
        var input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("style", "display: none;");
        input.setAttribute("name", "totPrice");
        input.setAttribute("value", totPrice);
        divBody.appendChild(input);
        var input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("style", "display: none;");
        input.setAttribute("name", "cartObjects");
        input.setAttribute("value", cartObjects);
        divBody.appendChild(input);
    }else{
        var element = document.getElementById("cart" + obj['nome_prodotto']);
        element.parentNode.removeChild(element);

        //Scrivo il prezzo totale nel sommario
        document.getElementById('totPrice').innerHTML = totPrice + "Fr.";
        document.getElementById('totQuantity').innerHTML = cartObjects;

        //Cancello il numero di oggetti
        for (var i = 0; i < document.getElementsByClassName("cartObjects").length; i++) {
            document.getElementsByClassName("cartObjects")[i].innerHTML = "";
            document.getElementsByClassName("cartObjects")[i].appendChild(document.createTextNode(cartObjects));
        }
    }

    setPickupShop();
}

/**
 * Funzione che inserisce i dati nella pagina che mostra i dettagli del prodotto per modificarli
 */
function detailsProduct(obj) {
    var prodKey = obj.id.split(".");
    var data;

    //Prendo il corpo del div in cui inserire i campi
    var divbody = document.getElementById('modSBody');

    //Richiedo i dati del prodotto richiesto
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);
            data = obj;

            //Creo la riga i cui inserire i campi e gli metto imposto la classe
            var div = document.createElement("div");
            div.setAttribute("class", "single_product_thumb clearfix");

            //Inserisco l'immagine del prodotto
            var img = document.getElementById("image");
            img.src = "http://samtinfo.ch/gestionevendita2018/"+ data[0]['img'];

            //Inserisco la categoria del prodotto
            var category = document.getElementById("category");
            category.appendChild(document.createTextNode("Categoria: "+ data[0]['nome_categoria']));

            //Inserisco il nome del prodotto
            var name = document.getElementById("title");
            name.appendChild(document.createTextNode("Prodotto: "+ data[0]['nome_prodotto']));

            //Se ci sono più di un negozio
            if(data.length > 1) {
                //Passo tutti i dati
                for (var i = data.length; i > 0; i--) {
                    //Inserisco i  nomi dei negozi che vendono il prodotto
                    var shop = document.createElement("li");
                    shop.setAttribute("class", "shop");
                    shop.appendChild(document.createTextNode("Negozio "+ i +": " + data[i - 1]['nome_negozio']));

                    //Prendo la lista e inserisco il nuovo elemento prima del nome del prodotto
                    var list = document.getElementById("detailsList");
                    list.insertBefore(shop, list.childNodes[1]);
                }
            }else{
                //Inserisco i  nomi dei negozi che vendono il prodotto
                var shop = document.createElement("li");
                shop.setAttribute("class", "shop");
                shop.appendChild(document.createTextNode("Negozio: " + data[0]['nome_negozio']));

                //Prendo la lista e inserisco il nuovo elemento prima del nome del prodotto
                var list = document.getElementById("detailsList");
                list.insertBefore(shop, list.childNodes[1]);
            }

            //Inserisco il prezzo del prodotto
            var price = document.getElementById("price");
            price.appendChild(document.createTextNode("Prezzo: "+ data[0]['prezzo_prodotto'] +" Fr."));

            //Inserisco il prezzo del prodotto
            var quantity = document.getElementById("quantity");
            quantity.appendChild(document.createTextNode("Quantità: "+ data[0]['quantita_prodotto'] +" pezzi"));
        }
    }
    xhttp.open("POST", "/gestionevendita2018/product/getProduct", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&name=" + prodKey[0] + "&price=" + prodKey[1] + "&quantity=" + prodKey[2]);

    document.getElementById('detailsModal').style.display = "block";
}

/**
 * Funzione che imposta il select nascosto per il negozio.
 * @param id id del select.
 */
function setSelectPickupShop(id){
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
}