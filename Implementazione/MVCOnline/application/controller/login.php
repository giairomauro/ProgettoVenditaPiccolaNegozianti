<?php
/**
* Classe per il login
*/
class Login
{

    public function index() {}
	/*
	 *	Function to open the registration/login page
	*/
	public function loginPageC()
	{
		require 'application/views/login_register/static/header.php';
        require 'application/views/login_register/switch.php';
		require 'application/views/login_register/login.php';
        require 'application/views/login_register/registerC.php';
        require 'application/views/login_register/register.php';
        require 'application/views/login_register/static/footer.php';
	}

    /*
     *	Function to open the login page
    */
    public function loginPageA()
    {
        require 'application/views/login_register/static/header.php';
        require 'application/views/login_register/loginA.php';
        require 'application/views/login_register/static/footer.php';
    }

    /*
     *	Function to open the login page
    */
    public function loginPageD()
    {
        require 'application/views/login_register/static/header.php';
        require 'application/views/login_register/loginD.php';
        require 'application/views/login_register/static/footer.php';
    }

    /*
        Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
    */
    public function loginD()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Prendo la classemodel
            require_once 'application/models/dealer.php';
            $dealer = new dealer();

            //Prendo le variabili passate dal post.
            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;
            $pass = hash('sha512', $pass);

            //Se entrambi i campi non sono vuoti
            if ($email != null && $pass != null) {

                //controllo il login
                $var = ($dealer->checkLogin($email, $pass));

                //Se viene ritornata la mail apre la pagina dell'utente
                if (strcmp($var, $email)) {
                    header("location: " . URL . "dealer");
                    //Altrimenti torna alla pagina di login
                } else {
                    header("location: " . URL . "dealer/home");
                }
            }
        }else{
            header("location: javascript://history.back()");
        }
    }


    /*
        Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
    */
    public function loginC()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Prendo la classe model
            require_once 'application/models/customer.php';
            $customer = new Customer();

            //Prendo le variabili passate dal post.
            $email = isset($_POST["email"])? $_POST["email"] : null;
            $pass = isset($_POST["pass"])? $_POST["pass"] : null;
            $pass = hash('sha512', $pass);

            //Se entrambi i campi non sono vuoti
            if ($email != null && $pass != null) {

                //controllo il login
                $var = ($customer->checkLogin($email, $pass));

                //Se viene ritornata la mail apre la pagina dell'utente
                if(!strcmp($var, $email)){
                    header("location: ". URL);
                //Altrimenti torna alla pagina di login
                }else{
                    header("location: ". URL ."login/loginPageC");
                }
            }
        }else{
            header("location: javascript://history.back()");
        }
    }


    /*
        Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
    */
    public function loginA()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/admin.php';
            $admin = new Admin();

            //Prendo le variabili passate dal post.
            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;
            $pass = hash('sha512', $pass);

            //Se entrambi i campi non sono vuoti
            if ($email != null && $pass != null) {

                //controllo il login
                $var = ($admin->checkLogin($email, $pass));

                //Se viene ritornata la mail apre la pagina dell'utente
                if (strcmp($var, $email)) {
                    header("location: " . URL . "admin");
                    //Altrimenti torna alla pagina di login
                } else {
                    header("location: " . URL . "admin/home");
                }
            }
        }else{
            header("location: javascript://history.back()");
        }
    }

	function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
} 

?>