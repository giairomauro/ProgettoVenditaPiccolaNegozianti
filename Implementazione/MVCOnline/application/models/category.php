<?php
/**
 * Class Category Classe che gestisce la connessione
 *  alla tabella "categoria"
 */
class Category extends PDO
{
    /**
     * @var Connection variabile della connessione
     */
    private $connection;

    /**
     * Category constructor Contruttore che imposta la connessione
     */
    public function __construct()
    {
        require_once 'application/models/connection.php';
        $this->connection = new Connection();
    }

    /**
     * Funzione che prende tutte le cateorie.
     * @return array Tutte le categorie.
     */
    public function getCategories(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * FROM categoria");

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if($sql->rowCount() > 1) {
            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {
                array_push($dataArray, $row);
            }
            //Se è solo uno lo prendo
        }else if($sql->rowCount() == 1) {
            $dataArray = $sql->fetch();
        }
        $conn = null;
        return $dataArray;
    }
}