<?php /** @noinspection ALL */

/**
 * Class SellModel Classe che gestisce la connessione
 *  alla tabella "vende"
 */
class SellModel extends PDO
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
     * Funzione che inserisce i dati nella tabella della vendita.
     * @param $prodName Nome del prodotto.
     * @param $prodPrice Prezzo del prodotto.
     * @param $prodQuantity Quantità del prodotto.
     * @param $custMail Email del cliente.
     * @return bool Controllo se laquery va a buon fine.
     */
    public function insertData($shopName, $shopAddress, $shopCity, $prodName, $prodPrice, $prodQuantity){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //se il campo è nuovo inserisco la nuova riga
        $quantity = 1;
        //Imposto la query
        $sql = $conn->prepare("INSERT INTO vende (nome_prodotto, prezzo_prodotto, quantita_prodotto, nome_negozio, indirizzo_negozio, citta_negozio)
                              VALUES (:prodName, :prodPrice, :prodQuantity, :shopName, :shopAddress, :shopCity)");
        $sql->bindParam(':prodName', $prodName, PDO::PARAM_STR);
        $sql->bindParam(':prodPrice', $prodPrice);
        $sql->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
        $sql->bindParam(':shopName', $shopName, PDO::PARAM_STR);
        $sql->bindParam(':shopAddress', $shopAddress, PDO::PARAM_STR);
        $sql->bindParam(':shopCity', $shopCity, PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

        //Se la query va a buon fine
        if($sql->rowCount() > 0){
            $conn = null;
            return true;
        } else {
            $conn = null;
            return false;
        }
    }

    /**
     * Funzione che modifica i dati nella tabella della vendita.
     * @param $prodName Nome edel prodotto.
     * @param $prodPrice Prezzo del prodotto.
     * @param $prodQuantity Quantità del prodotto.
     * @param $custMail Email del cliente.
     * @return bool Controllo se laquery va a buon fine.
     */
    public function modifyData($shopName, $shopAddress, $shopCity, $prodName, $prodPrice, $prodQuantity, $oldData){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //se il campo è nuovo inserisco la nuova riga
        $quantity = 1;
        //Imposto la query
        $sql = $conn->prepare("UPDATE vende set nome_negozio = :shopName, indirizzo_negozio = :shopAddress, citta_negozio = :shopCity
                              WHERE nome_prodotto = :oldProdName AND prezzo_prodotto = :oldProdPrice AND quantita_prodotto = :oldProdQuantity AND
                              nome_negozio = :oldShopName AND indirizzo_negozio = :oldShopAddress AND citta_negozio = :oldShopCity");
        $sql->bindParam(':shopName', $shopName, PDO::PARAM_STR);
        $sql->bindParam(':shopAddress', $shopAddress, PDO::PARAM_STR);
        $sql->bindParam(':shopCity', $shopCity, PDO::PARAM_STR);
        $sql->bindParam(':oldProdName', $oldData[7], PDO::PARAM_STR);
        $sql->bindParam(':oldProdPrice', $oldData[8]);
        $sql->bindParam(':oldProdQuantity', $oldData[9], PDO::PARAM_INT);
        $sql->bindParam(':oldShopName', $oldData[4], PDO::PARAM_STR);
        $sql->bindParam(':oldShopAddress', $oldData[5], PDO::PARAM_STR);
        $sql->bindParam(':oldShopCity', $oldData[6], PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

        //Se la query va a buon fine
        if($sql->rowCount() > 0){
            $conn = null;
            return true;
        } else {
            $conn = null;
            return false;
        }
    }
}