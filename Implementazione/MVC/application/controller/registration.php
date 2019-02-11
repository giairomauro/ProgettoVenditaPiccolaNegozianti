<?php
/**
* 
*/
class Registration
{

    /*
        Funzione che richiama la classe Connection e inserisce i dati nel Database
    */
    public function sendMail()
    {
        require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");

        //Get the entered data
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $mail = $_POST["mail"];
            $phone = $_POST["phone"];
            $via = $_POST["via"];
            $cap = $_POST["cap"];
            $city = $_POST["city"];
            $pass = $_POST["pass"];
            $pass = hash('sha512', $pass);
            $role = $_POST["role"];
        }

        if (strcmp($name, "") || strcmp($surname, "") || strcmp($mail, "") || strcmp($phone, "") || strcmp($via, "") || strcmp($cap, "") || strcmp($city, "") || strcmp($pass, "") || strcmp($role, "")) {
            $connection->addUser($name, $surname, $mail, $phone, $via, $cap, $city, $pass, $role);
        }

        if(strcmp($role, "coach")){
            $msn = "'$name $surname' attiva il tuo account";
            $msn = $msn."\nhttp://localhost:8042/MVC/registration/register/$mail";
            $headers = "From: progettoripetizioni@gmail.com";
            $a = mail($mail,"NON RISPONDERE A QUESTA MAIL",$msn,$headers);
        }else{
            //<a href=''>Attiva</a>
            //<a href=''>Non attivare</a>
            $to = $connection->getAdmin("email");
            $subject = "NON RISPONDERE A QUESTA MAIL";
            $msn = "'$name $surname' vorrebbe creare un account sulla mail $mail";
            $msn = $msn."\nhttp://localhost:8042/MVC/registration/register/$mail";
            $msn = $msn."\nhttp://localhost:8042/MVC/registration/noRegister/$mail";
            $headers = "From: progettoripetizioni@gmail.com";
            $a = mail($to, $subject, $msn, $headers);
        }

        header("location: ". URL);
    }

    /*
        Funzione che richiama la classe Connection e inserisce i dati nel Database
    */
    public function noRegister($mail)
    {
        //Send email to the not activated user
        $msn ="Il suo account non è stato attivato";
        $msn = $msn."\nPer maggiori informazioni contattare l'admin a questa mail:";
        $msn = $msn."\ngiairo.maro@samtrevano.ch";
        $headers = "From: progettoripetizioni@gmail.com";
        $a = mail($mail,"NON RISPONDERE A QUESTA MAIL",$msn,$headers);

        header("location: ". URL);
    }

    /*
        Funzione che richiama la classe Connection e inserisce i dati nel Database
    */
    public function register($mail)
    {
        require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");
        $connection->activeUser($mail);

        //Send email to the activated user
        $msn = "Il suo account è stato attivato";
        $msn = $msn."\nPò accedere a questo link: http://localhost:8042/MVC";
        $headers = "From: progettoripetizioni@gmail.com";
        $a = mail($mail,"NON RISPONDERE A QUESTA MAIL",$msn,$headers);
        header("location: ". URL);
    }
}
?>