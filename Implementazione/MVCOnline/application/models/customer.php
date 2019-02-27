<?php

class Customer extends PDO
{
    private $connection;

    public function __construct()
    {
        require_once 'application/models/connection.php';
        $this->connection = new Connection();
    }

    /**
     * Funzione che prende i valori dell'utente richiesto.
     * Utilizzata per il login.
     */
    public function checkLogin($mail, $pass)
    {

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Query per prendere i gestori
        $sql = $conn->prepare('SELECT * FROM cliente WHERE email LIKE :mail');
        $sql->bindParam(':mail', $mail, PDO::PARAM_STR);

        //Variabile per controlare la variabile di sessione da ritornare
        $checkSession = "";

        //Eseguo la query
        $sql->execute();

        //Se ci sono dei valori
        if($sql->rowCount() > 0){

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                //Controllo che la password sia corretta
                if (!(strcmp($pass, $row["password"]))) {

                    // LOGIN VENDITORE
                    $_SESSION['customer'] = $mail;
                    $checkSession = "customer";
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
            case "customer":
                return $_SESSION['customer'];
            case "wrongPass":
                return $_SESSION['wrongPass'];
            case "noUser":
                return $_SESSION['noUser'];
            default:
                return "ERRORE";
        }
    }

    /**
     * Funzione che permette l'inserimento dei docenti nel DB.
     * @param type $name Nome dell'utente.
     * @param type $surname Cognome dell'utente.
     * @param type $mail Mail dell'utente.
     * @param type $phone Numero di telefono dell'utente.
     * @param type $pass Password dell'utente.
     */
    public function addUser($name, $surname, $mail, $phone, $pass)
    {

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //echo "Connected successfully";
        $sql = $conn->prepare("INSERT INTO cliente (email, nome, cognome, password, telefono)
		VALUES (:email, :nome, :cognome, :password, :telefono)");
        $sql->bindParam(':email', $mail, PDO::PARAM_STR);
        $sql->bindParam(':nome', $name, PDO::PARAM_STR);
        $sql->bindParam(':cognome', $surname, PDO::PARAM_STR);
        $sql->bindParam(':password', $pass, PDO::PARAM_STR);
        $sql->bindParam(':telefono', $phone, PDO::PARAM_STR);

        //Eseguo la query
        $sql->execute();

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
     * Funzione che ritorna tutti i dati di un utente in un array
     * @param type $mail mail dell'utente da prendere
     * @return boolean
     */
    public function getUser($mail){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * FROM customer WHERE email = :email");
        $sql->bindParam(':email', $mail, PDO::PARAM_STR);

        $dataArray = false;
        if ($sql->execute()) {

            // while che prende tutti i dati
            while($row = $sql->fetch()) {
                return $row;
            }
        }

        $conn->close();
        return $dataArray;
    }

    /**
     * Funzione che ritorna i dati di tutti gli utenti
     * @return array Dati degli utenti
     */
    public function getUsers(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * FROM cliente");
        $sql->execute();

        $dataArray = array();

        //Se ci sono dei valori
        if($sql->rowCount() > 0){

            // while che prende tutti i dati
            while($row = $sql->fetch()) {
                array_push($dataArray, $row);
            }
        } else {
            $conn = null;
            return false;
        }

        $conn = null;
        return $dataArray;
    }
}