<?php  

class Connection
{
	private $servername;
	private $username;
	private $password;
	private $dbName;
	function __construct($servername, $username, $password, $dbName)
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
		//Connetto al database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		// Check connection
		if (!$conn) {
		    //die("Connection failed: " . mysqli_connect_error());
		    $this->phpAlert( mysqli_connect_error());
		}
		$conn->close();
		return $conn;
	}
        
	/**
         * Funzione che permette l'inserimento dei docenti nel DB.
         * @param type $name Nome dell'utente.
         * @param type $surname Cognome dell'utente.
         * @param type $mail Mail dell'utente.
         * @param type $phone Numero di telefono dell'utente.
         * @param type $via Via dell'utente.
         * @param type $cap CAP dell'utente.
         * @param type $city città dell'utente.
         * @param type $pass Password dell'utente.
         * @param type $role Ruolo dell'utente.
         */
	public function addUser($name, $surname, $mail, $phone, $via, $cap, $city, $pass, $role)
	{
		$active = 0;

		//Connect to database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		//echo "Connected successfully";
		$sql = $conn->prepare("INSERT INTO utente (nome, cognome, telefono, email, password, via, CAP, citta, nome_tipo, attivo)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		$sql->bind_param("ssssssissi", $name, $surname, $phone, $mail, $pass, $via, $cap, $city, $role, $active);
		
		if ($sql->execute()) {
		   // echo "New record created successfully";
		} else {
		    //echo "Error: " . $sql . "<br>" . $conn->error;
		    $msg = "Registrazione utente non avvenuta, l'utente é già esistente.";
		    return $msg;
		}
		$conn->close();
	}

	/**
	* Funzione che permette l'inserimento dei docenti nel DB
	*/
	public function activeUser($mail)
	{
		//Connect to database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		//echo "Connected successfully";
		$sql = $conn->prepare("UPDATE utente SET attivo = 1 WHERE email LIKE ?");

		$sql->bind_param("s", $mail);
		
		if ($sql->execute()) {
		   // echo "New record created successfully";
		} else {
		    //echo "Error: " . $sql . "<br>" . $conn->error;
		    $msg = "Registrazione utente non avvenuta, l'utente é già esistente.";
		    return $msg;
		}
		$conn->close();
	}
	/**
	* Funzione che prende i valori dell'utente richiesto, utilizzata per il login.
	*/
	public function checkLogin($mail, $pass)
	{
		//Connetto al database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = $conn->prepare("SELECT * FROM utente WHERE email LIKE ?");
		$sql->bind_param("s", $mail);

		if ($sql->execute()) {
			$result = $sql->get_result();

		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        if (!(strcmp($pass, $row["password"]))) {
		        	if(!strcmp($row["attivo"], 1)){
		        		if(!strcmp($row["nome_tipo"], "amministratore")){
				        	// LOGIN ADMIN
				        	return 1;
		        		}else if(!strcmp($row["nome_tipo"], "coach")){
				        	// LOGIN USER
				        	return 2;
		        		}else{
		        			// LOGIN USER
		        			return 3;
		        		}
		        	}else{
		        		//INACIVE USER
		        		return 4;
		        	}
		        }
		        else {
		        	// WRONG PASSWORD
		        	return 5;
		        }
		    }
		}
		else {
			// NOT REGISTERED USER
			return 6;
		}
		$conn->close();
	}


	/**
	* Funzione che ritorna i valori dell'admin, o uno solo richiesto dal parametro
	*/
	public function getAdmin($data = null)
	{
		//Connetto al database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = $conn->prepare("SELECT * FROM utente WHERE nome_tipo LIKE ?");
		$sql->bind_param("s", "amministratore");

		if ($sql->execute()) {
			$result = $sql->get_result();

		    // while che prende tutti i dati
		    while($row = $result->fetch_assoc()) {
		        if(strcmp($data, null)){
		        	return $row[$data];
		        }else{
		        	return $row;
		        }
		    }
		}
		else {
			
		}
		$conn->close();
	}

	/**
         * Funzione che ritorna tutti i dati di un utente in un array
         * @param type $mail mail dell'utente da prendere
         * @return boolean 
         */
	public function getUser($mail){
		//Connetto al database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		
		//Prendo i dati dell'utente in base alla mail
		$sql = $conn->prepare("SELECT * FROM utente WHERE email = ?");
		$sql->bind_param("s", $mail);
	
		$dataArray = false;
		if ($sql->execute()) {

			$result = $sql->get_result();
		    // while che prende tutti i dati
		    while($row = $result->fetch_assoc()) {
		    	return $row;
		    }
		}
		return $dataArray;
	}

	/**
	* Funzione che ritorna il ruolo di un utente
	*/
	public function getRole()
	{
		//Connect to database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

		//Get roles
		$sql = $conn->prepare("SELECT nome FROM tipo");
		$ruoli = array();
                
                if($sql->execute()){
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        array_push($ruoli, $row['nome']);
                    }
                }
		$conn->close();
		return $ruoli;
	}

        /**
         * Funzione che prende dal database le materia e le ritorna in un array
         */
	public function getSubject() {
		//Connect to database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

		//Get subjects
		$sql = $conn->prepare("SELECT nome FROM materia");
		$materie = array();
                
                if($sql->execute()){
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        array_push($materie, $row['nome']);
                    }
                }
		$conn->close();
		return $materie;
        }
        
        /**
         * Funzione che inserisce i corsi nel database, e di conseguenza crea questi ultimi.
         * @param type $subject Materia del corso da creare.
         * @param type $day Il giorno in cui si fa il corso.
         * @param type $hour L'ora a cui inizia il corso.
         * @param type $credits I crediti che costa il corso.
         * @param type $learners Il numero di allievi possibili nel corso.
         * @param type $mail_insegnante La mail dell'insegnante del corso.
         * @return int Ritorna se la query è passata o il messaggio di errore
         */
        public function createCourse($subject, $day, $hour, $credits, $learners, $mail_insegnante){
		$active = 0;

		//Connect to database
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		//echo "Connected successfully";
		$sql = $conn->prepare("INSERT INTO corso (mail_insegnante, giorno, ora, crediti, num_allievi, nome_materia)
		VALUES (?, ?, ?, ?, ?, ?)");
                
                echo $mail_insegnante .", ". $day .", ". $hour .", ". $credits .", ". $learners .", ". $subject ."<br>";
                
		$sql->bind_param("ssiiis", $mail_insegnante, $day, $hour, $credits, $learners, $subject);
		
		if ($sql->execute()) {
                    return 0;
		} else {
		    return "Error: <br>" . $conn->error;//" . $sql . "
		}
		$conn->close();
        }
        
        /**
         * 
         * @param type $msg
         */
	function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
        
        
        /*public function resetPassword($mail, $password)
	{
		$conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
		$id = $this->getId($mail);
		$password = hash('sha512', $password);
		$sql = "UPDATE Docente SET Password = '$password' WHERE ID_Docente = $id";
		if ($conn->query($sql) === FALSE) {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}*/
}