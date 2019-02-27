<?php

class BuyModel extends PDO
{
    private $connection;

    public function __construct()
    {
        require_once 'application/models/connection.php';
        $this->connection = new Connection();
    }

    /**
     * Funzione che inserisce i dati nella tabella del "carrello".
     * @param $prodName Nome edel prodotto.
     * @param $prodPrice Prezzo del prodotto.
     * @param $prodQuantity Quantità del prodotto.
     * @param $custMail Email del cliente.
     * @return bool Controllo se laquery va a buon fine.
     */
    public function insertData($prodName, $prodPrice, $prodQuantity, $custMail){
        //Connetto al database
        $conn = $this->connection->sqlConnection();
        $sql = null;

        $quantity = 0;
        $buyCount = $this->getDataByProduct($prodName, $prodPrice, $prodQuantity, $custMail);

        //Controllo se il prodotto è già inserito
        if(count($buyCount) > 0){

            //Setto la nuova quantità e modifico il campo nella tabella
            if(is_array($buyCount[0]))
                $quantity = $buyCount[0]['quantita_richiesta'] + 1;
            else
                $quantity = $buyCount['quantita_richiesta'] + 1;

            $sql = $conn->prepare("UPDATE compra SET quantita_richiesta = :quantity, data = now() WHERE nome_prodotto LIKE :prodName
            AND prezzo_prodotto LIKE :prodPrice AND
            quantita_prodotto LIKE :prodQuantity AND email_cliente LIKE :custMail");
            $sql->bindParam(':prodName', $prodName, PDO::PARAM_STR);
            $sql->bindParam(':prodPrice', $prodPrice);
            $sql->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
            $sql->bindParam(':custMail', $custMail, PDO::PARAM_STR);
            $sql->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        }else{

            //se il campo è nuovo inserisco la nuova riga
            $quantity = 1;
            $sql = $conn->prepare("INSERT INTO compra (nome_prodotto, prezzo_prodotto, quantita_prodotto, email_cliente, data, quantita_richiesta)
		  VALUES (:prodName, :prodPrice, :prodQuantity, :custMail, now(), :quantity)");
            $sql->bindParam(':prodName', $prodName, PDO::PARAM_STR);
            $sql->bindParam(':prodPrice', $prodPrice);
            $sql->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
            $sql->bindParam(':custMail', $custMail, PDO::PARAM_STR);
            $sql->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        }

        //Eseguo la query
        $sql->execute();
        print_r($sql->errorInfo()[2]);

        //Imposto la nuova quantità del prodotto
        require_once 'application/models/product.php';
        $product = new ProductModel();
        $product->setQuantity($prodName, $prodPrice, $prodQuantity, $prodQuantity - 1);

        //Se ci sono dei valori
        if($sql->rowCount() > 0){
            $conn = null;
            return true;
        } else {
            $conn = null;
            return false;
        }
    }

    /**
     * Funzione che prende i dati della tabella.
     * @return array Dati da ritornare.
     */
    public function getData(){

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //echo "Connected successfully";
        $sql = $conn->prepare("SELECT * FROM compra");

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if($sql->rowCount() > 1) {

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {
                array_push($dataArray, $row);
            }
            //Se c'è un solo valore lo inserisco
        }else if($sql->rowCount() == 1) {
            $dataArray = $sql->fetch();
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i dati in base all'utente.
     * @param $custMail ail dell'utente.
     * @return array Dati da ritornare.
     */
    public function getDataByMail($custMail){

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //echo "Connected successfully";
        $sql = $conn->prepare("SELECT * FROM compra WHERE email_cliente LIKE :email");
        $sql->bindParam(':email', $custMail, PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if($sql->rowCount() > 1) {

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {
                array_push($dataArray, $row);
            }
        //Se c'è un solo valore lo inserisco
        }else if($sql->rowCount() == 1) {
            $dataArray = $sql->fetch();
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i dati in base al prodotto eall'occorenza anche all'utente
     * @param $prodName Nome del prodotto.
     * @param $prodPrice Prezzo del prodotto.
     * @param $prodQuantity Quantità del prodotto.
     * @param null $custMail Email dell'utente (opzionale)
     * @return array Dati da ritornare.
     */
    public function getDataByproduct($prodName, $prodPrice, $prodQuantity, $custMail = null){

        //Se richiesto prendo i dati dell'utente
        $products = array();
        if($custMail != null)
            $products = $this->getDataByMail($custMail);
        else
            $products = $this->getData();

        $dataArray = array();

        //Se ci sono dei valori
        if(array_key_exists(0,$products) && is_array($products[0])) {

            // Ciclo tutti i valori
            foreach ($products as $value) {
                //Se passa il prodotto richiesto
                if ($value['nome_prodotto'] == $prodName && $value['prezzo_prodotto'] == $prodPrice
                    && $value['quantita_prodotto'] == $prodQuantity) {

                    //inserisco il valore nell'array
                    array_push($dataArray, $value);
                }
            }
            //Se c'è un solo valore lo inserisco
        }else if(array_key_exists(0,$products) && !is_array($products[0])) {
            //Se passa il prodotto richiesto
            if ($products['nome_prodotto'] == $prodName && $products['prezzo_prodotto'] == $prodPrice
                && $products['quantita_prodotto'] == $prodQuantity) {

                $dataArray = $products;
            }
        }
        $conn = null;
        return $dataArray;
    }
}