<?php /** @noinspection ALL */

class ShopModel extends PDO
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
     * Funzione che inserisce un nuovo negozio
     * @param $name Nome del nuovo negozio
     * @param $address Indirizzo del nuovo negozio
     * @param $city Città del nuovo negozio
     * @param $phone Telefono del nuovo negozio
     * @param $email Email del nuovo negozio
     */
    public function insertShop($name, $address, $city, $phone, $email){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("INSERT INTO negozio(nome, indirizzo, citta, telefono, email_gestore)
            values(:name, :address, :city, :phone, :email)");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':city', $city, PDO::PARAM_STR);
        $sql->bindParam(':phone', $phone, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        //Se ci sono dei valori
        if($sql->execute()) {
            return true;
        }else {
            return $sql->errorInfo();
        }
        $conn = null;
    }

    /**
     * Funzione che modifica i dati di un negozio
     * @param $name Nome del negozio
     * @param $address Indirizzo del negozio
     * @param $city Citta del negozio
     * @param $phone Telefono del negozio
     * @param $email Email del negozio
     * @param $oldName Vecchio nome del negozio
     * @param $oldAddress Vecchio indirizzo del negozio
     * @param $oldCity Vecchia città del negozio
     */
    public function modifyShop($name, $address, $city, $phone, $email, $oldName, $oldAddress, $oldCity){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("UPDATE negozio set nome = :name, indirizzo = :address, citta = :city, telefono = :phone, email_gestore = :email
                      WHERE nome LIKE :nameW AND indirizzo LIKE :addressW AND citta LIKE :cityW");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':city', $city, PDO::PARAM_STR);
        $sql->bindParam(':phone', $phone, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':nameW', $oldName, PDO::PARAM_STR);
        $sql->bindParam(':addressW', $oldAddress, PDO::PARAM_STR);
        $sql->bindParam(':cityW', $oldCity, PDO::PARAM_STR);

        //Se ci sono dei valori
        if($sql->execute()) {
            return true;
        }else {
            return $sql->errorInfo();
        }
        $conn = null;
    }

    /**
     * Funzione che prende tutti i negozi
     */
    public function getShops()
    {
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT nome, indirizzo, citta FROM negozio WHERE archiviato = 0");

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if ($sql->rowCount() > 1) {
            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                array_push($dataArray, $row);
            }
        } else if ($sql->rowCount() == 1) {
            array_push($dataArray, $sql->fetch());
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende un negozio e i dati del suo venditore
     * @param $name Nome del negozio.
     * @param $address Indirizzo del negozio
     * @param $city Città del negozio
     */
    public function getShopDealer($name, $address, $city)
    {
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * FROM negozio n
                              right outer join gestore g on g.email = n.email_gestore
                              WHERE n.nome LIKE :nameR AND n.indirizzo LIKE :addressR AND n.citta LIKE :cityR
                              union
                              SELECT * FROM negozio n
                              left outer join gestore g on g.email = n.email_gestore
                              WHERE n.nome LIKE :nameL AND n.indirizzo LIKE :addressL AND n.citta LIKE :cityL");
        $sql->bindParam(':nameR', $name, PDO::PARAM_STR);
        $sql->bindParam(':addressR', $address, PDO::PARAM_STR);
        $sql->bindParam(':cityR', $city, PDO::PARAM_STR);
        $sql->bindParam(':nameL', $name, PDO::PARAM_STR);
        $sql->bindParam(':addressL', $address, PDO::PARAM_STR);
        $sql->bindParam(':cityL', $city, PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if ($sql->rowCount() > 1) {
            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                array_push($dataArray, $row);
            }
        } else if ($sql->rowCount() == 1) {
            array_push($dataArray, $sql->fetch());
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende tutte i negozi in base all'utente passato.
     * @param $dealerMail Mail dell'utente.
     */
    public function getShopsByDealer($dealerMail)
    {
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT nome, indirizzo, citta FROM negozio WHERE email_gestore LIKE :mail");
        $sql->bindParam(':mail', $dealerMail, PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if ($sql->rowCount() > 1) {
            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                array_push($dataArray, $row);
            }
        } else if ($sql->rowCount() == 1) {
            array_push($dataArray, $sql->fetch());
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che archivia il negozio modificandone il campo nel database.
     * @param $name Nome del negozio.
     * @param $address Indirizzo del negozio.
     * @param $city Città del negozio.
     */
    public function fileShop($name, $address, $city){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("UPDATE negozio set archiviato = 1
                      WHERE nome LIKE :name AND indirizzo LIKE :address AND citta LIKE :city");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':city', $city, PDO::PARAM_STR);

        //Se ci sono dei valori
        if($sql->execute()) {
            return true;
        }else {
            return $sql->errorInfo();
        }
        $conn = null;
    }
}