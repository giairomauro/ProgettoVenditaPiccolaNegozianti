<?php


class Home
{
	/**
	* Coach home page
	*/
    public function coach()
    {
    	if (!isset($_SESSION['mail'])) {
    		header("location: http://localhost:8042/MVC/");
    	}
    	require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");
		$connection->sqlConnection();

        $dataArray = $connection->getUser($_SESSION['mail']);
        require 'application/views/_templates/header.php';
        require 'application/views/coach/Static/headerMC.php';
        require 'application/views/coach/index.php';
    }

    /**
    * User home page
    */
    public function user()
    {
        if (!isset($_SESSION['mail'])) {
            header("location: http://localhost:8042/MVC");
        }
        require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");
        $connection->sqlConnection();
        require 'application/views/_templates/header.php';
        require 'application/views/allievo/index.php';
    }
    
    /**
     * Funzione che prende un range di orari e li mette dentroun array.
     */
    public function takeHours(){
        //Array che conterrà l'oraario e il valore del'ora
        $hour = 8;
        $hours = array(
            array()
        );
        
        //For che inserisce nella prima posizione il valore e nella seconda l'orario
        for($i = 0; $i <= 11; $i++){
            $str = $hour .":00";
            $hours[$i][0] = $hour;
            $hours[$i][1] = $str;
            $hour++;
        }
        
        return $hours;
    }
    
    /**
     * Funzione che inserisce i dati dentro la tabella del corso e lo crea.
     */
    public function createCourse(){
        require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");

        //Get the entered data
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $subject = $_POST["subject"];
            $day = $_POST["day"];
            $hour = $_POST["hour"];
            $credits = $_POST["credits"];
            $learners = $_POST["learners"];
        }
        
        $userData = $connection->getUser($_SESSION['mail']);
        
        //Controllo che i campi non siano vuoti e richiamo la funzione che inserisce i valori nel database creando il corso.
        if (strcmp($subject, "") || strcmp($day, "") || strcmp($hour, "") || strcmp($credits, "") || strcmp($learners, "")) {
            $createCourse = $connection->createCourse($subject, $day, $hour, $credits, $learners, $userData['email']);
        }
        
        if($createCourse == 0){
            echo $subject .", ". $day .", ". $hour .", ". $credits .", ". $learners .", ". $userData['email'];
        }else{
            echo "Errore nell'inserimento dei dati";
        }
    }
}
