<?php
/**
 *
 */
class Product
{

    /**
     * Funzione che prende tutti i prodotti di un negozio
     */
    public function getDealerProducts(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            $products = $product->getDealerProducts();

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($products);
        }else{
            header("location: javascript://history.back()");
        }
    }

    /**
     * Funzione che prende tutti i prodotti di un negozio
     */
    public function getProductsByCategory(){

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

            //Stampo con json i valori dei coach
            header('Content-Type: application/json');
            echo json_encode($categories);
        }else{
            header("location: javascript://history.back()");
        }
    }

    /*
        Funzione che richiama il metodo della classe Connection che controlla se le credenziali sono corrette
    */
    public function insertProduct()
    {
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

            header("location: ". URL ."dealer/details");
        }else{
            header("location: javascript://history.back()");
        }
    }
}