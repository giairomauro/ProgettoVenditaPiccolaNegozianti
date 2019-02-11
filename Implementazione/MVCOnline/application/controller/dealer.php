<?php
/**
* 
*/
class dealer
{

	/*
	 *	Apertura della pagina di login
	*/
	public function index()
	{
	    //Apro la pagina con il login
        require_once 'application/controller/login.php';
        $login = new Login("localhost","root","", "ripetizioni");
        $login->loginPageD();
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
    public function details()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['dealer'])) {
            require 'application/views/_templates/header.php';
            require 'application/views/dealer/static/header.php';
            require 'application/views/dealer/details.php';
        }else{
            $this->index();
        }
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
            $email = isset($_POST["email"])? $_POST["email"] : null;
            $pass = isset($_POST["pass"])? $_POST["pass"] : null;
            $pass = hash('sha512', $pass);

            //Se entrambi i campi non sono vuoti
            if ($email != null && $pass != null) {

                //controllo il login
                $var = ($dealer->checkLogin($email, $pass));

                //Se viene ritornata la mail apre la pagina dell'utente
                if(!strcmp($var, $email)){
                    header("location: ". URL ."dealer");
                //Altrimenti torna alla pagina di login
                }else{
                    header("location: ". URL ."dealer/home");
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

            //Prendo la classemodel
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
                    header("location: ". URL ."login/index");
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

            //Prendo la classemodel
            require_once 'application/models/dealer.php';
            $admin = new Admin();

            //Prendo le variabili passate dal post.
            $email = isset($_POST["email"])? $_POST["email"] : null;
            $pass = isset($_POST["pass"])? $_POST["pass"] : null;
            $pass = hash('sha512', $pass);

            //Se entrambi i campi non sono vuoti
            if ($email != null && $pass != null) {

                //controllo il login
                $var = ($admin->checkLogin($email, $pass));

                //Se viene ritornata la mail apre la pagina dell'utente
                if(!strcmp($var, $email)){
                    header("location: ". URL);
                    //Altrimenti torna alla pagina di login
                }else{
                    header("location: ". URL ."login/index");
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