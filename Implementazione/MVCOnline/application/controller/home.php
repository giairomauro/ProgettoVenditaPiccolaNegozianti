<?php
class Home
{
	/**
	* Apertura della pagina dello shop
	*/
    public function index()
    {
    	require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");
		$connection->sqlConnection();

        require 'application/views/_templates/header.php';
        require 'application/views/shop/index.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * Apertura della pagina dello shop
     */
    public function shop()
    {
        require_once 'application/models/connection.php';
        $connection = new Connection("localhost","root","", "ripetizioni");
        $connection->sqlConnection();

        require 'application/views/_templates/header.php';
        require 'application/views/shop/shop.php';
        require 'application/views/_templates/footer.php';
    }

    /**
    * Apertura della pagina utente
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
     * Funzione che prende tutte le categorie
     */
    public function getCategories(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/category.php';
            $category = new Category();

            $categories = $category->getCategories();

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($categories);
        }else{
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutte le categorie
     */
    public function getProducts(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new Product();

            $products = $product->getProducts();

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($products);
        }else{
            header("location: javascript://history.back()");
        }
    }
}
