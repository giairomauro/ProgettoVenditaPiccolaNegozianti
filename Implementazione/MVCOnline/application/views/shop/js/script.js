//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

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
function getProducts() {
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Richiamo la funzione per inserire i prodotti
            insertProducts(obj);
        }
    }
    xhttp.open("POST", "/gestionevendita2018/home/getProducts", true);
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
    xhttp.send("&category="+ category);
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

        //Inserisco l'aggiunta al cart se si va sull'immagine
        var divHover = document.createElement("div");
        divHover.setAttribute("class", "hover-content");
        var divCart = document.createElement("div");
        divCart.setAttribute("class", "add-to-cart");
        var a = document.createElement("a");
        a.setAttribute("class", "btn essence-btn");
        a.setAttribute("onclick", "addToCart");
        a.setAttribute("style", "color:white;");
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