<?php  

class Connection extends PDO
{
	private $servername = "efof.myd.infomaniak.com";
	private $username = "efof_gestvend";
	private $password = "GestVend_Admin_2018";
	private $dbName = "efof_gestvend";

    /**
     * Costruttore vuoto della classe.
     */
    function __construct(){}

    /**
     * Costruttore della classe che modfica le variabili del database.
     * @param $servername Nuovo nome del server.
     * @param $username Nuovo nome utente.
     * @param $password Nuova password.
     * @param $dbName Nuovo nome del database.
     */
	function __construct1($servername, $username, $password, $dbName)
	{
		$this->servername = $servername;
		$this->username = $username;
		$this->password = $password;
		$this->dbName = $dbName;
	}

	/**
	* Funzione che connette il sito al database
	*/
	public function sqlConnection()
	{
        $conn = "";
        try{
            //Variabile di connessione con PDO
            $conn = new PDO('mysql:host='. $this->servername .';dbname='. $this->dbName .';port=3306', $this->username, $this->password);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        //Ritorno la variabile
		return $conn;
	}
}