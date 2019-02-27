<?php

class ProductModel extends PDO
{
    private $connection;

    public function __construct()
    {
        require_once 'application/models/connection.php';
        $this->connection = new Connection();
    }

    /**
     * Funzione che prende tutti i prodotti.
     * @return array Tutti i prodotti.
     */
    public function getProducts(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * from prodotto");

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        // Ciclo tutti i valori
        while ($row = $sql->fetch()) {
            array_push($dataArray, $row);
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i dati di un singolo prodotto.
     * @param $name Nome del prodotto.
     * @param $price Prezzo del prodotto.
     * @param $quantity Quantità del prodotto
     * @return array Dati del prodotto.
     */
    public function getProduct($name, $price, $quantity){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * from prodotto p
                              inner join vende v on v.nome_prodotto = p.nome
                              inner join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio
                              WHERE p.nome LIKE :nome AND p.prezzo LIKE :prezzo AND p.quantita LIKE :quantita");
        $sql->bindParam(':nome', $name, PDO::PARAM_STR);
        $sql->bindParam(':prezzo', $price, PDO::PARAM_INT);
        $sql->bindParam(':quantita', $quantity, PDO::PARAM_STR);

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        //Inserisco il prodotto nell'array e lo ritorno
        array_push($dataArray, $sql->fetch());
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende tutte le cateorie.
     * @return array Tutte le categorie.
     */
    public function getDealerProducts(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * from prodotto p inner join vende v on v.nome_prodotto = p.nome inner join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio WHERE n.email_gestore = :email");
        $sql->bindParam(':email', $_SESSION['dealer'], PDO::PARAM_STR);

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        // Ciclo tutti i valori
        while ($row = $sql->fetch()) {
            array_push($dataArray, $row);
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende tutte le cateorie con una materia.
     * @return category Categoria dei prodotti.
     */
    public function getProductsByCategory($category, $dealer = false){
        if($dealer) {
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getDealerProducts();
        }else{
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProducts();
        }

        //Creo un array vuoto ee faccio passare tutti i dati presi
        $dataArray = array();
        foreach ($data as $value){

            //Se la categoria del prodott è corretta lo inserisco nell'array
            if($value['nome_categoria'] == $category){
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }

    /**
     * Funzione che prende tutte le cateorie con una materia.
     * @return category Categoria dei prodotti.
     */
    public function getProductsByName($name){
        //Prendo tutti i prodotti dell'utente corrente
        $data = $this->getProducts();

        //Creo un array vuoto ee faccio passare tutti i dati presi
        $dataArray = array();
        foreach ($data as $value){

            //Se la categoria del prodott è corretta lo inserisco nell'array
            if($value['nome'] == $name){
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }


    public function setQuantity($prodName, $prodPrice, $prodQuantity, $quantity){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la nuova quantità
        $sql = $conn->prepare("UPDATE prodotto SET quantita = :quantity WHERE nome LIKE :prodName
                AND prezzo LIKE :prodPrice
                AND quantita LIKE :prodQuantity");
        $sql->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $sql->bindParam(':prodName', $prodName, PDO::PARAM_STR);
        $sql->bindParam(':prodPrice', $prodPrice);
        $sql->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);

        //Eseguo la query
        if(!$sql->execute()){
            $conn = null;
            return false;
        }

        $conn = null;
        return true;
    }

    /**
     * Funzione che prende tutte le cateorie.
     * @return array Tutte le categorie.
     */
    public function insertProduct($category, $title, $prize, $quantity, $image){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("INSERT INTO prodotto(nome_categoria, nome, prezzo, quantita, img) values(:categoria, :nome, :prezzo, :quantita, :img)");
        $sql->bindParam(':categoria', $category, PDO::PARAM_STR);
        $sql->bindParam(':nome', $title, PDO::PARAM_STR);
        $sql->bindParam(':prezzo', $prize, PDO::PARAM_INT);
        $sql->bindParam(':quantita', $quantity, PDO::PARAM_INT);
        $sql->bindParam(':img', $image, PDO::PARAM_STR);

        //Eseguo la query
        if(!$sql->execute()){
            $conn = null;
            $_SESSION['ExistData'] = true;
            return $_SESSION['ExistData'];
        }

        $conn = null;
        $_SESSION['created'] = true;
        return $_SESSION['created'];
    }

    /**
     * Funzione che prende tutte le cateorie con una materia.
     * @return category Categoria dei prodotti.
     */
    public function searchProducts($category, $valueS){
        if($category === "false") {
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProducts();
        }else{
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProductsByCategory($category);
        }

        //Creo un array vuoto e faccio passare tutti i dati presi
        $dataArray = array();

        foreach ($data as $value){
            //Se il valore cercato è contenuto nel nome del prodotto passato
            if(gettype(stripos($value['nome'], $valueS)) != 'boolean'){

                //Inserisco il prodotto nell'array
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }
}