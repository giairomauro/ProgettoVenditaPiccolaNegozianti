<?php /** @noinspection ALL */

/**
 * Classe del cliente
 */
class Customer
{

    /*
     *	Funzione iniziale
    */
    public function index()
    {

    }

    /*
     *	Funzione che modifica il carello
    */
    public function modifyCart()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/buy.php';
            $buy = new BuyModel();

            //Prendo le variabili passate dal POST
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $price = isset($_POST["price"])? $_POST["price"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;
            $action = isset($_POST["action"])? $_POST["action"] : null;

            //Se entrambi i campi non sono vuoti
            if ($name != null && $price != null && $quantity != null && $action != null) {
                $buy->modifyData($name, $price, $quantity, $_SESSION['customer'], $action);
            }
        //Altrimenti
        }else{
            header("location: ". URL);
        }
    }

    /*
     *	Funzione che prende un oggetto che si aggiunge al carrello
    */
    public function getCartProduct()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/product.php';
            $product = new ProductModel();

            //Prendo le variabili passate dal POST
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $price = isset($_POST["price"])? $_POST["price"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;

            //Array che conterrà tutti i prodotti
            $prodArray = array();

            //Per ogni dato inserisco il prodotto relativo nell'array
            array_push($prodArray, $product->getProduct($name, $price, $quantity, $_SESSION['customer']));

            //Stampo con json l'array con i prodotti
            header('Content-Type: application/json');
            echo json_encode($prodArray);
            //Altrimenti
        }else{
            header("location: ". URL);
        }
    }

    /*
     *	Funzione che prende tutti i prodotti del carrello
    */
    public function getCart()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/buy.php';
            require_once 'application/models/product.php';
            $buy = new BuyModel();
            $product = new ProductModel();

            //Array che conterrà tutti i prodotti
            $prodArray = array();

            //Prendo i dati del carrello
            $cartProducts = $buy->getDataByMail($_SESSION['customer']);

            //Per ogni dato inserisco il prodotto relativo nell'array
            if(count($cartProducts) > 0 && is_array($cartProducts[0])) {
                foreach ($cartProducts as $value)
                    array_push($prodArray,
                        $product->getProduct($value['nome_prodotto'], $value['prezzo_prodotto'], $value['quantita_prodotto'])[0]);
            }else if(count($cartProducts) > 0){
                array_push($prodArray,
                    $product->getProduct($cartProducts['nome_prodotto'], $cartProducts['prezzo_prodotto'], $cartProducts['quantita_prodotto'])[0]);
            }

            //Stampo con json l'array con i prodotti
            header('Content-Type: application/json');
            echo json_encode($prodArray);
        //Altrimenti
        }else{
            header("location: ". URL);
        }
    }

    /*
     *	Funzione che prende tutti i prodotti dei luoghi di ritiro
    */
    public function getPickupShop()
    {
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo la classe model
            require_once 'application/models/pickupshop.php';
            $pickupShop = new PickupShopModel();

            //Array che conterrà tutti i prodotti
            $dataArray = array();

            //Prendo i dati del carrello
            $shops = $pickupShop->getData();

            //Per ogni dato inserisco il prodotto relativo nell'array
            foreach ($shops as $value)
                array_push($dataArray, $value);

            //Stampo con json l'array con i prodotti
            header('Content-Type: application/json');
            echo json_encode($dataArray);
            //Altrimenti
        }else{
            header("location: ". URL);
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
            header("location: ". URL);
        }
    }

    /**
     * Funzione che implementa il checkout
     * Crea il pdf con le informazioni
     */
    public function doCheckout(){
        //Se la sessione è aperta apro le pagine altrimeenti no
        if(isset($_SESSION['customer'])) {

            //Prendo le variabili passate dal POST
            $name = isset($_POST["name"])? $_POST["name"] : null;
            $price = isset($_POST["price"])? $_POST["price"] : null;
            $quantity = isset($_POST["quantity"])? $_POST["quantity"] : null;
            $totPrice = isset($_POST["totPrice"])? $_POST["totPrice"] : null;
            $cartObjects = isset($_POST["cartObjects"])? $_POST["cartObjects"] : null;
            $pickupShop = isset($_POST["pickupShop"])? $_POST["pickupShop"] : null;

            if($name != null && $price != null && $quantity != null && $totPrice != null && $cartObjects != null && $pickupShop != null) {

                //Prendo i dati del negozio di ritiro
                $pickupShopInfos = explode(".", $pickupShop);

                require('application/fpdf/fpdf.php');

                // crea l'istanza del documento
                $pdf = new FPDF();
                $pdf->AddPage();

                //---Header---
                // Arial bold 15
                $pdf->SetFont('Arial', 'B', 15);
                // Dati utente
                $pdf->Cell(30, 10, $_SESSION['customer'], 0, 0, 'L');
                //Data odierna
                $pdf->Cell(130);
                $pdf->Cell(30, 10, date("Y/m/d"), 0, 0, 'R');
                // Vado a capo
                $pdf->Ln(20);

                //Metto il titolo
                // Seleziona Arial 15
                $pdf->SetFont('Arial', 'B', 30);
                // Muove verso destra
                $pdf->Cell(80);
                // Titolo in riquadro
                $pdf->Cell(30, 10, 'Il suo ordine', 0, 0, 'C');
                // Interruzione di linea
                $pdf->Ln(20);

                //Metto l'indice
                // Seleziona Arial 15
                $pdf->SetFont('Arial', '', 16);
                // Indice
                $pdf->Cell(30, 10, 'Prodotto', 0, 0, 'L');
                $pdf->Cell(50);
                $pdf->Cell(30, 10, 'Quantita', 0, 0, 'C');
                $pdf->Cell(50);
                $pdf->Cell(30, 10, 'Prezzo', 0, 0, 'C');
                // Interruzione di linea
                $pdf->Ln(20);

                //Traccio una linea
                $pdf->SetDrawColor(180, 180, 180);
                $pdf->SetLineWidth(1);
                $pdf->Line(10, 70, 200, 70);
                // Interruzione di linea
                $pdf->Ln(10);

                //Variabile per la prossima riga
                $nextLine = 70;

                for ($i = 0; $i < count($name); $i++) {
                    //Insersco i prodotti
                    $pdf->Cell(30, 10, $name[$i], 0, 0, 'L');
                    $pdf->Cell(50);
                    $pdf->Cell(30, 10, $quantity[$i], 0, 0, 'C');
                    $pdf->Cell(50);
                    $pdf->Cell(30, 10, $price[$i] . 'Fr.', 0, 0, 'C');
                    // Interruzione di linea
                    $pdf->Ln(20);
                    $nextLine += 21;
                }

                //Traccio una linea
                $pdf->SetDrawColor(180, 180, 180);
                $pdf->SetLineWidth(1);
                $pdf->Line(10, $nextLine, 200, $nextLine);
                // Interruzione di linea
                $pdf->Ln(10);

                //Metto il totale
                // Seleziona Arial 15
                $pdf->SetFont('Arial', '', 16);
                // Indice
                $pdf->Cell(30, 10, 'Totale', 0, 0, 'L');
                $pdf->Cell(50);
                $pdf->Cell(30, 10, $cartObjects, 0, 0, 'C');
                $pdf->Cell(50);
                $pdf->Cell(30, 10, $totPrice . 'Fr.', 0, 0, 'C');
                // Interruzione di linea
                $pdf->Ln(10);
                $nextLine += 30;

                //Traccio una linea
                $pdf->SetDrawColor(180, 180, 180);
                $pdf->SetLineWidth(1);
                $pdf->Line(10, $nextLine, 200, $nextLine);
                // Interruzione di linea
                $pdf->Ln(10);

                //Metto il totale
                // Seleziona Arial 15
                $pdf->SetFont('Arial', '', 16);
                // Indice
                $pdf->Cell(30, 10, 'Negozio', 0, 0, 'L');
                $pdf->Cell(50);
                $pdf->Cell(30, 10, $pickupShopInfos[0], 0, 0, 'C');
                // Indirizzo
                $pdf->Ln(10);
                $pdf->Cell(80);
                $pdf->Cell(30, 10, $pickupShopInfos[1], 0, 0, 'C');
                $pdf->Cell(25);
                $pdf->Cell(30, 10, $pickupShopInfos[2], 0, 0, 'C');
                // Contatti
                $pdf->Ln(10);
                $pdf->Cell(80);
                $pdf->Cell(30, 10, $pickupShopInfos[3] .".". $pickupShopInfos[4], 0, 0, 'C');
                $pdf->Cell(25);
                $pdf->Cell(30, 10, $pickupShopInfos[5], 0, 0, 'C');
                // Interruzione di linea
                $pdf->Ln(10);
                $nextLine += 30;

                // Piè di pagina
                $pdf->SetY(-35);
                // Arial italic 8
                $pdf->SetFont('Arial','I',10);
                // Numero della pagina
                $pdf->Cell(0,10,'Progetto vendita piccoli negozi',0,0,'L');

                //Salvo il pdf
                $pdf->Output();
            }else{
                header("location: ". URL);
            }
        }else{
            header("location: ". URL);
        }
    }
}
?>