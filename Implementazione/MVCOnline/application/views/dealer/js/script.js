//Variabile di connessione per ajax
var xhttp = new XMLHttpRequest();

/**
 * JQuery per far cambiare la classe
 * alle parti con i nomi specificati
 * dopo il click sul bottone "switch"
 */
$(function() {

    $('#switch').click(function() {
        window.location = 'http://samtinfo.ch/gestionevendita2018/dealer/details';
    });

})

/**
 * Funzione che riempie la lista delle categorie.
 */
function getCategories() {

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            //Prendo i valori passati dal server e li metto in un array
            var obj = JSON.parse(xhttp.responseText);

            //Prendo il corpo della tabella in cui inserire le righe
            var tbody = document.getElementById('menu-content2');
                console.log();
            //Inserisco tutti le righe con i relativi corsi.
            for (var i = 0; i < obj.length; i++) {
                //Creo la riga i cui inserire i campi e gli metto lee informazioni
                var li = document.createElement("li");
                li.setAttribute("data-toggle", "collapse");

                //Creo ina nuova colonna e inserisco ildato, per ogni informazioni richiesta
                var a = document.createElement("a");
                a.appendChild(document.createTextNode(obj[i]["nome"]));
                a.setAttribute("href", "#");
                li.appendChild(a);

                //Inserisco la riga nela tabella
                tbody.appendChild(li);
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

            //Prendo il corpo del div in cui inserire i campi
            var divbody = document.getElementById('prodContainer');

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
                div.appendChild(img);
                divWrapper.appendChild(div);

                //Creo un nuovo div che contiene le informaazioni e lo metto nel padre
                var div = document.createElement("div");
                var a = document.createElement("a");
                a.setAttribute("href", "#");
                var h6 = document.createElement("h6");
                h6.appendChild(document.createTextNode(obj[i]['nome']));
                a.appendChild(h6);
                div.appendChild(a);
                divWrapper.appendChild(div);

                //Creo un paragrafo chee conterrà il prezzo
                var p = document.createElement("p");
                var prezzo = obj[i]['prezzo'] +" Fr."
                p.appendChild(document.createTextNode(prezzo));
                divWrapper.appendChild(p);

                //aggiungo tutti i div a quello primario
                divContainer.appendChild(divWrapper);
                divbody.appendChild(divContainer);
            }
        }
    }
    xhttp.open("POST", "/gestionevendita2018/home/getProducts", true);
    xhttp.send();
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