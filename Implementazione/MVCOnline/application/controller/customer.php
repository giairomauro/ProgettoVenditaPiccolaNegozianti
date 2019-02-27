<?php
/**
 *
 */
class Customer
{

    /*
     *	Apertura della pagina di login
    */
    public function index()
    {
        //Apro la pagina con il login
        /*require_once 'application/controller/login.php';
        $login = new Login("localhost","root","", "ripetizioni");
        $login->loginPageD();*/
    }

    /*
     *	Apertura della pagina principale dell venditore
    */
    public function addToCart()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/buy.php';
            $buy = new BuyModel();

            //Prendo le variabili passate dal POST
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $price = isset($_POST["price"])? $_POST["price"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;

            //Se entrambi i campi non sono vuoti
            if ($name != null && $price != null&& $quantity != null) {
                $buy->insertData($name, $price, $quantity, $_SESSION['customer']);
            }
        //Altrimenti
        }else{

        }
    }

    /*
     *	Apertura della pagina principale dell venditore
    */
    public function getCart()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/buy.php';
            $buy = new BuyModel();

            $cartProducts = $buy->getDataByMail($_SESSION['customer']);

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($cartProducts);
        //Altrimenti
        }else{

        }
    }

    /*
     *	Apertura della pagina dei dettagli
    */
    public function details()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['dealer'])) {
            require 'application/views/_templates/header.php';
            require 'application/views/dealer/static/header.php';
            require 'application/views/dealer/details.php';
        }else{
            header("location: ". URL);
        }
    }
}

?>