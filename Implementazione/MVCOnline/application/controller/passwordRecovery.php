<?php 

class PasswordRecovery
{
	/**
	* View per il password recovery
	*/
	public function index()
	{
		require 'application/views/_templates/header.php';
		require_once "application/views/no_password/index.php";
	}
	/**
	* Funzione che manda una mail al docente se si é dimenticato 
	* nell'email viene scritta la password del docente
	*/
	public function recovery()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = $_POST["mail"];
        }
		$msn = "Gentile utente,\nper reimpostare la sua password clicchi il link seguente: ";
		require_once 'application/models/connection.php';
		$connection = new Connection("efof.myd.infomaniak.com","efof_eserciz2018","Eserciz_Admin2018", "efof_Eserciz2018");
		$msn = $msn."http://eserciz.samtinfo.ch/passwordRecovery/nuovaPassword/$mail";
		$msn = $msn."\nE' pregato di non rispondere a questa e-mail.";
		$headers = "From: progettoeserciziario@gmail.com";
		$a = mail($mail,"Password Recovery",$msn,$headers);
		$this->index();
	}

	public function nuovaPassword($mail)
	{
		require_once 'application/models/connection.php';
		$connection = new Connection("efof.myd.infomaniak.com","efof_eserciz2018","Eserciz_Admin2018", "efof_Eserciz2018");
		require 'application/views/_templates/header.php';
		require_once 'application/views/no_password/nuova.php';
	}

	public function reset()
	{
		require_once 'application/models/connection.php';
		$connection = new Connection("efof.myd.infomaniak.com","efof_eserciz2018","Eserciz_Admin2018", "efof_Eserciz2018");
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = $_POST["mail"];
            $password = $_POST["pass"];
            $reset = $_POST["confPass"];
        }

        if (md5($password) != md5($reset)) {
        	$this->phpAlert("Le password non sono uguali.");
        	$this->nuovaPassword($mail);
        }
        else {
        	$connection->resetPassword($mail,$password);
        	require_once 'application/controller/login.php';
        	$login = new Login();
        	$login->index();
        }
	}

	function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}

}