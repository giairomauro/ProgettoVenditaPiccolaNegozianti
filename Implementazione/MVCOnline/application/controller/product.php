<?php
/**
 *
 */
class Product
{

    /**
     * Funzione che prende tutte le categorie
     */
    public function getProducts(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            $products = $product->getProducts();

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($products);
        }else{
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutte le categorie
     */
    public function getProduct()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();
            $name = isset($_POST["name"]) ? $_POST["name"] : null;
            $price = isset($_POST["price"]) ? $_POST["price"] : null;
            $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : null;

            if ($name != null && $price != null && $quantity != null) {

                $productData = $product->getProduct($name, $price, $quantity);
            }

                //Stampo con json i valori dei coach
                header('Content-Type: application/json');
                echo json_encode($productData);
        } else {
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutti i prodotti di un negozio
     */
    public function getDealerProducts(){
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            $products = $product->getDealerProducts();

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($products);
        //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutti i prodotti di un negozio
     */
    public function getProductsByCategory(){
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            //Prendo il valore della categoria
            $category = isset($_POST["category"])? $_POST["category"] : null;

            if(isset($_POST["dealer"])) {
                $categories = $product->getProductsByCategory($category, true);
            }else{
                $categories = $product->getProductsByCategory($category);
            }

            //Stampo con json i valori presi
            header('Content-Type: application/json');
            echo json_encode($categories);
        //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutti  prodotti adatti alla ricerca e li stampa in JSON
     */
    public function searchProducts(){
        //Se la funzione è richiamata come POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            //Prendo le variabili passate dal POST
            $category = isset($_POST["category"])? $_POST["category"] : null;
            $value = isset($_POST["value"])? $_POST["value"] : null;

            if($value != null){
                $products = $product->searchProducts($category, $value);
            }

            //Stampo con json i valori presi
            header('Content-Type: application/json');
            echo json_encode($products);
        //Altrimenti
        }else{
            //Ritorno alla pagina precedente
            header("location: javascript://history.back()");
        }
    }
}