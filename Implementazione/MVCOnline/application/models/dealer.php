<?php /** @noinspection ALL */

class Dealer extends PDO
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
     * Funzione che inserisce un nuovo venditore.
     * @param $email Email nuovo venditore.
     * @param $name Nome nuovo venditore.
     * @param $surname Cognome nuovo venditore.
     * @param $password Password nuovo venditore.
     * @param $phone Telefono nuovo venditore.
     */
    public function insertDealer($email, $name, $surname, $password, $phone){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("INSERT INTO gestore(email, nome, cognome, password, telefono)
            values(:email, :name, :surname, :pass, :phone)");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':surname', $surname, PDO::PARAM_STR);
        $sql->bindParam(':pass', $password, PDO::PARAM_STR);
        $sql->bindParam(':phone', $phone, PDO::PARAM_STR);

        //Se ci sono dei valori
        if($sql->execute()) {
            return true;
        }else {
            return $sql->errorInfo();
        }
        $conn = null;
    }

    /**
     * Funzione che modifica i dati di un venditore.
     * @param $email Email venditore.
     * @param $name Nome venditore.
     * @param $surname Cognome venditore.
     * @param $phone Telefono venditore.
     * @param $oldMail Vecchia mail venditore.
     */
    public function modifyDealer($email, $name, $surname, $phone, $oldMail){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("UPDATE gestore set email = :email, nome = :name, cognome = :surname, telefono = :phone
                      WHERE email LIKE :emailW");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':surname', $surname, PDO::PARAM_STR);
        $sql->bindParam(':phone', $phone, PDO::PARAM_STR);
        $sql->bindParam(':emailW', $oldMail, PDO::PARAM_STR);

        //Se ci sono dei valori
        if($sql->execute()) {
            return true;
        }else {
            return $sql->errorInfo();
        }
        $conn = null;
    }

    /**
     * Funzione che prende tutti i venditori.
     * @return array Tutti i venditore.
     */
    public function getDealers(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * FROM gestore");

        //Eseguo la query
        $sql->execute();

        $dataArray = array();
        //Se ci sono dei valori
        if($sql->rowCount() > 1) {
            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {
                array_push($dataArray, $row);
            }
            //Se ce n'è uno lo prendo
        }else if($sql->rowCount() == 1) {
            $dataArray = $sql->fetch();
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i valori dell'utente richiesto.
     * Utilizzata per il login.
     */
    public function checkLogin($mail, $pass){

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare('SELECT * FROM gestore WHERE email LIKE :mail');
        $sql->bindParam(':mail', $mail, PDO::PARAM_STR);

        //Variabile per controlare la variabile di sessione da ritornare
        $checkSession = "";

        //Eseguo la query
        $sql->execute();

        //Se ci sono dei valori
        if($sql->rowCount() > 0) {

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                //Controllo che la password sia corretta
                if (!(strcmp($pass, $row["password"]))) {
                    // LOGIN VENDITORE
                    $_SESSION['dealer'] = $mail;
                    $checkSession = "dealer";
                    break;
                } else {
                    // PASSWORD ERRATA
                    $_SESSION['wrongPass'] = "wrongPass";
                    $checkSession = "wrongPass";
                }
            }
        //Altrimenti
        }else{
            // UTENTE INESISTENTE
            $_SESSION['noUser'] = "noUser";
            $checkSession = "noUser";
        }

                //Chiudo la sessione
        $conn = null;

        //Ritorno il valore
        switch ($checkSession) {
            case "dealer":
                return $_SESSION['dealer'];
            case "wrongPass":
                return $_SESSION['wrongPass'];
            case "noUser":
                return $_SESSION['noUser'];
            default:
                return "ERRORE";
        }
    }
}