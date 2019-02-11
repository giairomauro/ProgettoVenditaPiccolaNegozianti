<?php

class Admin
{
    private $connection;

    public function __construct()
    {
        require_once 'application/models/connection.php';
        $connection = new Connection();
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
        $sql = $conn->prepare('SELECT * FROM amministratore WHERE email LIKE :mail');
        $sql->bindParam(':mail', $mail, PDO::PARAM_STR);

        //Variabile per controlare la variabile di sessione da ritornare
        $checkSession = "";

        //Eseguo la query
        $sql->execute();

        //Se ci sono dei valori
        if($sql->fetch() != ""){

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {

                //Controllo che la password sia corretta
                if (!(strcmp($pass, $row["password"]))) {
                    // LOGIN AMMINISTRATORE
                    $_SESSION['admin'] = $mail;
                    $checkSession = "admin";
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
            case "admin":
                return $_SESSION['admin'];
            case "wrongPass":
                return $_SESSION['wrongPass'];
            case "noUser":
                return $_SESSION['noUser'];
            default:
                return "ERRORE";
        }
    }

    /**
     * Funzione che ritorna tutti i dati di un utente in un array
     * @param type $mail mail dell'utente da prendere
     * @return boolean
     */
    public function getUser($mail){
        //Connetto al database
        $conn = mysqli_connect($this->connection->servername, $this->connection->username, $this->connection->password, $this->connection->dbName);

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * FROM amministratore WHERE email = ?");
        $sql->bind_param("s", $mail);

        $dataArray = false;
        if ($sql->execute()) {

            $result = $sql->get_result();
            // while che prende tutti i dati
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        }
        $conn->close();
        return $dataArray;
    }
}