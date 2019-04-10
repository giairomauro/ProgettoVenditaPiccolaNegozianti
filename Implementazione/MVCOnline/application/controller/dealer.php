<?php
/**
* Classe dei venditori
*/
class Dealer
{

    /*
     *	Apertura della pagina di login
    */
    public function index()
    {
        //Apro la pagina con il login
        require_once 'application/controller/login.php';
        $login = new Login();
        $login->loginPageD();
    }

    /**
     * Funzione che prende tutti i negozi in base all'utente.
     */
    public function getShopsByDealer(){
        //COntrollo che la funzione entri in POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //COntrollo che sia aperta la sessione e abbia fatto il login un venditore
            if (isset($_SESSION['dealer'])) {
                //Prendo la classe model
                require_once 'application/models/shop.php';
                $shop = new ShopModel();

                $shops = $shop->getShopsByDealer($_SESSION['dealer']);

                //Stampo con json i valori dei coach
                header('Content-Type: application/json');
                echo json_encode($shops);
            }else{
                header("location: javascript://history.back()");
            }
        }else{
            header("location: javascript://history.back()");
        }
    }

    /*
     *	Apertura della pagina principale dell venditore
    */
    public function home()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['dealer'])) {
            require 'application/views/_templates/header.php';
            require 'application/views/dealer/static/header.php';
            require 'application/views/dealer/shop.php';
            require 'application/views/_templates/footer.php';
        }else{
            $this->index();
        }
    }

    /*
     *	Apertura della pagina dei dettagli
    */
    public function add()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['dealer'])) {
            $this->home();
        }else{
            $this->index();
        }
    }

    /*
        Funzione che prende i dati e inserisce il prodotto nuovo
    */
    public function insertProduct()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();
            require_once 'application/models/sell.php';
            $sell = new SellModel();

            // Connssione all'ftp
            $connFTP = ftp_connect("efof.ftp.infomaniak.com");
            $login = ftp_login($connFTP, "efof_gestvend", "GestVend_Admin_2018");

            //Prendo le variabili passate dal post.
            $image = isset($_FILES['imageQuestion'])? $_FILES['imageQuestion'] : null; //Prendo il nome del file
            $name = $image['name'];

            //Prendo il percorso temporaneo del file e gli cambio nome
            $tmpName = $image['tmp_name'];
            $newName = 'application/img/'. $name;
            rename($tmpName, $newName);

            //Imposto i permessi per il file
            ftp_chmod($connFTP, 0664, $newName);

            //Prendo le variabili passate dal POST
            $category = isset($_POST["category"])? $_POST["category"] : null;
            $title = isset($_POST["title"])? $_POST["title"] : null;
            $prize = isset($_POST["prize"])? $_POST["prize"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;

            //Prendo i dati del negozio
            $shop = isset($_POST["shop"])? explode(".", $_POST["shop"]) : null;
            $sName = $shop[0];
            $sAddress = $shop[1];
            $sCity = $shop[2];

            //Se i campi che devono comparire non sono vuoti
            if ($title != null && $prize != null && $quantity != null) {
                //Inserisco i dati del prodotto
                $var = $product->insertProduct($category, $title, $prize, $quantity, $newName);

                //Se i campi che devono comparire non sono vuoti
                if ($sName != null && $sAddress != null && $sCity != null) {
                    //Inserisco i dati del prodotto
                    $var = $sell->insertData($sName, $sAddress, $sCity, $title, $prize, $quantity);
                }
            }

            header("location: ". URL ."dealer/add");
            //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }

    /*
        Funzione che prende i dati e modifica il prodotto
    */
    public function modifyProduct()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();
            require_once 'application/models/sell.php';
            $sell = new SellModel();

            // Connssione all'ftp
            $connFTP = ftp_connect("efof.ftp.infomaniak.com");
            $login = ftp_login($connFTP, "efof_gestvend", "GestVend_Admin_2018");

            //Prendo le variabili passate dal post.
            $newname = null;
            $image = isset($_FILES['imageQuestion'])? $_FILES['imageQuestion'] : null; //Prendo il nome del file
            if($image['name'] != "") {
                $name = $image['name'];

                //Prendo il percorso temporaneo del file e gli cambio nome
                $tmpName = $image['tmp_name'];
                $newName = 'application/img/' . $name;
                rename($tmpName, $newName);

                //Imposto i permessi per il file
                ftp_chmod($connFTP, 0664, $newName);
            }

            //Prendo le variabili passate dal POST
            $category = isset($_POST["category"])? $_POST["category"] : null;
            $title = isset($_POST["title"])? $_POST["title"] : null;
            $price = isset($_POST["prize"])? $_POST["prize"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;
            $oldData = isset($_POST["oldData"])? explode(".", $_POST["oldData"]) : null;

            //Prendo i dati del negozio
            $shop = isset($_POST["modShop"])? explode(".", $_POST["modShop"]) : null;

            print_r($shop);
            $sName = $shop[0];
            $sAddress = $shop[1];
            $sCity = $shop[2];

            //Se i campi che devono comparire non sono vuoti
            if ($title != null && $price != null && $quantity != null) {
                //Inserisco i dati del prodotto
                $product->modifyProduct($category, $title, $price, $quantity, $newname, $oldData);

                //Controllo se è cambiato il negozio
                if($sName != $oldData[4]){
                    $sell->modifyData($sName, $sAddress, $sCity, $title, $price, $quantity, $oldData);
                }
            }

            header("location: ". URL ."dealer/home");
            //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }
} 

?>