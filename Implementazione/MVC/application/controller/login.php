<?php
/**
* 
*/
class Login
{

	/*
		Funzione che carica la pagina di index
		e fa la connesione al server
	*/
	public function index($msn = "")
	{
		require_once 'application/models/connection.php';
		$connection = new Connection("localhost","root","", "ripetizioni");
		$connection->sqlConnection();
		require 'application/views/_templates/header.php';
            require 'application/views/login/header.php';
		require 'application/views/login/index.php';
	}

	/*
		Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
	*/
	public function log_in()
	{
            require_once 'application/models/connection.php';
            $connection = new Connection("localhost","root","", "ripetizioni");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $mail = $_POST["mail"];
                $pass = $_POST["pass"];
                $pass = hash('sha512', $pass);
            }
            if ((strcmp($mail, "") || strcmp($pass, ""))) {
        	$var = ($connection->checkLogin($mail, $pass));

        	switch ($var) {
        		case 2: // LOGIN ADMIN
        			$_SESSION['mail'] = $mail;
        			header("location: http://localhost:8042/MVC/home/coach/");
        			break;
        		
                case 3: // LOGIN USER
                    $_SESSION['mail'] = $mail;
                    header("location: http://localhost:8042/MVC/home/user/");
                    break;

        		case 4: // INACTIVE USER
 					$this->phpAlert("Utente inattivo");
        			$this->index();
        			break;

        		case 5: // WRONG PASSWORD
        			$this->phpAlert("E-mail o password errati");
        			$this->index();
        			break;
                default:
                    $this->phpAlert("Utente non registrato");
                    $this->index();
                    break;
        	}
            }
	}

	function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
} 

?>