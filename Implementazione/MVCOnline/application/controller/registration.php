<?php
/**
*  Classe della registrazione
*/
class Registration
{

    /*
     *	Funzione iniziale
    */
    public function index()
    {

    }

    /*
        Funzione che richiama la classe Connection e inserisce i dati nel Database per il venditore
    */
    public function createC($name, $surname, $mail, $phone, $pass)
    {
        require_once 'application/models/customer.php';
        $customer = new Customer();

        if (strcmp($name, "") || strcmp($surname, "") || strcmp($mail, "") || strcmp($phone, "") || strcmp($pass, "")) {
            $customer->addUser($name, $surname, $mail, $phone, $pass);
            $this->sendMail($name, $surname, $mail);
        }

        header("location: ". URL ."login/loginPageC");
    }

    /**
     * Funzione cheinvia una mail all'utente registrato.
     * @param $name Nome dell'utente.
     * @param $surname Cognome dell'utente.
     */
    public function sendMail($name, $surname, $mail){

        //Messaggio da inviare
        $msn = "'$name $surname' Sei stato correttamente registrato";
        $msn = $msn. "\nAccedi da qui http:". URL;

        //Invio il messaggio
        $headers = "From: progettoripetizioni@gmail.com";
        $a = mail($mail,"NON RISPONDERE A QUESTA MAIL",$msn,$headers);
    }

    public function post(){
        //Controllo ci sia la chiamatain POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "LOG";
            //Prendo le variabili
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $mail = $_POST["emailR"];
            $phone = $_POST["phone"];
            $pass = $_POST["password"];
            $pass = hash('sha512', $pass);

            //Tipo dell'utente del presente
            $type = $_POST["type"];

            switch ($type){
                case "customer":
                    //Richiamo la funzione di inserimento dell'utente
                    $this->createC($name, $surname, $mail, $phone, $pass);
                case "dealer":
                    //Richiamo la funzione di inserimento dell'utente
                    $this->createD($name, $surname, $mail, $phone, $pass);
                case "admin":
                    //Richiamo la funzione di inserimento dell'utente
                    $this->createA($name, $surname, $mail, $phone, $pass);
            }
        }else{
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che controlla l'esistena della mail
     */
    public function checkMail(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $user = "";

            switch ($_POST['type']){
                case "customer":
                    require_once 'application/models/customer.php';
                    $user = new Customer();
                    break;
                case "dealer":
                    require_once 'application/models/customer.php';
                    $user = new Customer();
                    break;
                case "admin":
                    require_once 'application/models/customer.php';
                    $user = new Customer();
                    break;
            }

            //Stampo con json tutti gli utenti
            header('Content-Type: application/json');
            echo json_encode($user->getUsers());
        }else{
            header("location: javascript://history.back()");
        }
    }
}
?>