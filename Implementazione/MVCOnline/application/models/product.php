<?php

class Product extends PDO
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
        $sql = $conn->prepare("SELECT * FROM prodotto");

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
}