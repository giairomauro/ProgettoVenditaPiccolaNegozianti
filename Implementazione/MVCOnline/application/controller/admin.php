<?php /** @noinspection ALL */

/**
 * Class Admin Classe che gestisce il lavoro delle informazioni.
 */
class Admin
{

    /*
     *	Apertura della pagina di login
    */
    public function index()
    {
        //Apro la pagina con il login
        require_once 'application/controller/login.php';
        $login = new Login();
        $login->loginPageA();
    }

    /*
     *	Apertura della pagina principale dell ammministratore
    */
    public function home()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['admin'])) {
            require 'application/views/_templates/header.php';
            require 'application/views/admin/static/header.php';
            require 'application/views/admin/shops.php';
            require 'application/views/_templates/footer.php';
        }else{
            $this->index();
        }
    }

    /**
     * Funzione che prende tutti i negozi.
     */
    public function getShops(){
        //COntrollo che la funzione entri in POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //COntrollo che sia aperta la sessione e abbia fatto il login un amministratore
            if (isset($_SESSION['admin'])) {
                //Prendo la classe model
                require_once 'application/models/shop.php';
                $shop = new ShopModel();

                $shops = $shop->getShops();

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

    /**
     * Funzione che prende i adti di un negozio e del suo gestore
     */
    public function getShopDealer(){
        //COntrollo che la funzione entri in POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //COntrollo che sia aperta la sessione e abbia fatto il login un amministratore
            if (isset($_SESSION['admin'])) {

                //Prendo la classe model
                require_once 'application/models/shop.php';
                $shop = new ShopModel();

                //Prendo le variabili passate dal POST del negozio
                $name = isset($_POST["name"])? $_POST["name"] : null;
                $address = isset($_POST["address"])? $_POST["address"] : null;
                $city = isset($_POST["city"])? $_POST["city"] : null;

                //Se i campi che devono comparire non sono vuoti
                if ($name != null && $address != null && $city != null) {
                    $shops = $shop->getShopDealer($name, $address, $city);
                }

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

    /**
     * Funzione che prende tutti i negozi in base al venditore.
     */
    public function getShopsByDealer(){
        //COntrollo che la funzione entri in POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //COntrollo che sia aperta la sessione e abbia fatto il login un amministratore
            if (isset($_SESSION['admin'])) {
                //Prendo la classe model
                require_once 'application/models/shop.php';
                $shop = new ShopModel();

                $shops = $shop->getShopsByDealer($_SESSION['admin']);

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
     *	Apertura della pagina dei dettagli
    */
    public function add()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['admin'])) {
            $this->home();
        }else{
            $this->index();
        }
    }

    /*
        Funzione che prende i dati e inserisce il negozio nuovo e il suo gestore
    */
    public function registerShopDealer()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/shop.php';
            $shop = new ShopModel();
            require_once 'application/models/dealer.php';
            $dealer = new Dealer();

            //Prendo le variabili passate dal POST del negozio
            $shopName = isset($_POST["shopName"])? $_POST["shopName"] : null;
            $shopAddress = isset($_POST["shopAddress"])? $_POST["shopAddress"] : null;
            $shopCity = isset($_POST["shopCity"])? $_POST["shopCity"] : null;
            $shopPhone = isset($_POST["shopPhone"])? $_POST["shopPhone"] : null;

            //Prendo le variabili passate dal POST del venditore
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $surname = isset($_POST["surname"])? $_POST["surname"] : null;
            $phone = isset($_POST["phone"])? $_POST["phone"] : null;
            $mail = isset($_POST["mail"])? $_POST["mail"] : null;
            $password = isset($_POST["password"])? $_POST["password"] : null;
            $password = hash('sha512', $password);

            //Se i campi che devono comparire non sono vuoti
            if ($mail != null && $name != null && $surname != null && $password != null && $phone != null) {
                //Inserisco i dati del venditore
                print_r($dealer->insertDealer($mail, $name, $surname, $password, $phone));
            }

            //Se i campi che devono comparire non sono vuoti
            if ($shopName != null && $shopAddress != null && $shopCity != null && $shopPhone != null && $mail != null) {
                echo $mail;
                //Inserisco i dati del negozio
                 print_r($shop->insertShop($shopName, $shopAddress, $shopCity, $shopPhone, $mail));
            }

            header("location: ". URL ."admin/home");
            //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }

    /*
        Funzione che modifica i dati del negozio
    */
    public function modifyShop()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/shop.php';
            $shop = new ShopModel();
            require_once 'application/models/dealer.php';
            $dealer = new Dealer();

            //Prendo le variabili passate dal POST del negozio
            $shopName = isset($_POST["modShopName"])? $_POST["modShopName"] : null;
            $shopAddress = isset($_POST["modShopAddress"])? $_POST["modShopAddress"] : null;
            $shopCity = isset($_POST["modShopCity"])? $_POST["modShopCity"] : null;
            $shopPhone = isset($_POST["modShopPhone"])? $_POST["modShopPhone"] : null;

            //Prendo le variabili passate dal POST del venditore
            $name = isset($_POST["modName"])? $_POST["modName"] : null;
            $surname = isset($_POST["modSurname"])? $_POST["modSurname"] : null;
            $phone = isset($_POST["modPhone"])? $_POST["modPhone"] : null;
            $mail = isset($_POST["modMail"])? $_POST["modMail"] : null;

            //Prendo i vecchi valori delle chiavi passati dal POST
            $oldMail = isset($_POST["oldMail"])? $_POST["oldMail"] : null;
            $oldShopName = isset($_POST["oldShopName"])? $_POST["oldShopName"] : null;
            $oldShopAddress = isset($_POST["oldShopAddress"])? $_POST["oldShopAddress"] : null;
            $oldShopCity = isset($_POST["oldShopCity"])? $_POST["oldShopCity"] : null;

            //Se i campi che devono comparire non sono vuoti
            if ($mail != null && $name != null && $surname != null && $phone != null && $oldMail != null) {
                //Inserisco i dati del venditore
                $dealer->modifyDealer($mail, $name, $surname, $phone, $oldMail);
            }

            //Se i campi che devono comparire non sono vuoti
            if ($shopName != null && $shopAddress != null && $shopCity != null && $shopPhone != null && $mail != null && $oldShopName != null && $oldShopAddress != null && $oldShopCity != null) {
                //Inserisco i dati del negozio
                $shop->modifyShop($shopName, $shopAddress, $shopCity, $shopPhone, $mail, $oldShopName, $oldShopAddress, $oldShopCity);
            }

            header("location: ". URL ."admin/home");
            //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende i dati passati e richiama la funzione del model
     * per archiviare il negozio
     */
    public function fileShop()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/shop.php';
            $shop = new ShopModel();

            //Prendo le variabili passate dal POST
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $address = isset($_POST["address"])? $_POST["address"] : null;
            $city = isset($_POST["city"])? $_POST["city"] : null;

            if($name != null && $address != null && $city != null){
                $shop->fileShop($name, $address, $city);
            }

            header("location: ". URL ."admin/home");
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }
}

?>