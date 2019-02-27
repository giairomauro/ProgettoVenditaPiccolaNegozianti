<?php

class Dealer extends PDO
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