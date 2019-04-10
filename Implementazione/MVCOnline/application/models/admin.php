<?php

/**
 * Class Admin Classe che gestisce la connessione
 *  alla tabella "amministratore"
 */
class Admin
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
     * Funzione che prende i valori dell'utente richiesto.
     * Utilizzata per il login.
     */
    public function checkLogin($mail, $pass){

        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Query per prendere i gestori
        $sql = $conn->prepare('SELECT * FROM amministratore WHERE email LIKE :mail');
        $sql->bindParam(':mail', $mail, PDO::PARAM_STR);

        //Variabile per controllare la variabile di sessione da ritornare
        $checkSession = "";

        //Eseguo la query
        $sql->execute();

        //Se ci sono dei valori
        if($sql->rowCount() > 0) {

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
     */
    public function getUser($mail){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * FROM amministratore WHERE email = ?");
        $sql->bind_param("s", $mail);

        //Eseguo la query
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