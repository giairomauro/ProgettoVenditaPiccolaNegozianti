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
     * Funzione che prende tutte le cateorie.
     * @return array Tutte le categorie.
     */
    public function getProducts(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * from prodotto p inner join vende v on v.nome_prodotto = p.nome inner join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio");

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
}