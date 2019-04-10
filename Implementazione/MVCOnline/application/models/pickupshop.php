<?php

/**
 * Class PickupShopModel Classe che gestisce la connessione
 *  alla tabella "luogo_ritiro"
 */
class PickupShopModel extends PDO
{
    /**
     * @var Connection variabile della connessione
     */
    private $connection;

    /**
     * Admin constructor Contruttore che imposta la connessione
     */
    public function __construct()
    {
        require_once 'application/models/connection.php';
        $this->connection = new Connection();
    }

    /**
     * Funzione che prende i dati della tabella.
     * @return array Tutti i luoghi di ritiro.
     */
    public function getData()
    {
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * FROM luogo_ritiro");

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if ($sql->rowCount() > 1) {

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                array_push($dataArray, $row);
            }
            //Se ce n'è solo uno lo prendo
        } else if ($sql->rowCount() == 1) {
            array_push($dataArray, $sql->fetch());
        }
        $conn = null;
        return $dataArray;
    }
}