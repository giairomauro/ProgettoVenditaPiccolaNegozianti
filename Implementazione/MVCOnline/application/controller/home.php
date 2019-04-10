<?php

/**
 * Class Home Classe home utile per tutti
 */
class Home
{
	/**
	* Apertura della pagina dello shop
	*/
    public function index()
    {
        require 'application/views/_templates/header.php';
        require 'application/views/shop/static/header.php';
        require 'application/views/shop/index.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * Apertura della pagina dello shop
     */
    public function shop()
    {
        require 'application/views/_templates/header.php';
        require 'application/views/shop/static/header.php';
        require 'application/views/shop/shop.php';
        require 'application/views/_templates/footer.php';
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
}
