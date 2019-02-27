<?php
/**
* 
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
    public function add()
    {

        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['dealer'])) {
            require 'application/views/_templates/header.php';
            require 'application/views/dealer/static/header.php';
            require 'application/views/dealer/add.php';
        }else{
            $this->index();
        }
    }

    /*
        Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
    */
    public function insertProduct()
    {
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

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

            //Se entrambi i campi non sono vuoti
            if ($category != null && $title != null && $prize != null && $quantity != null && $image != null) {

                $var = $product->insertProduct($category, $title, $prize, $quantity, $newName, $newName);
            }

            header("location: ". URL ."dealer/add");
            //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }
} 

?>