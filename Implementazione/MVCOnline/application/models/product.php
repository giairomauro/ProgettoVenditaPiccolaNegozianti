<?php /** @noinspection ALL */

class ProductModel extends PDO
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
     * Funzione che prende tutti i prodotti.
     * @return array Tutti i prodotti.
     */
    public function getProducts(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Prendo i dati dell'utente in base alla mail
        $sql = $conn->prepare("SELECT * from prodotto");

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        // Ciclo tutti i valori
        while ($row = $sql->fetch()) {
            array_push($dataArray, $row);
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i dati di un singolo prodotto.
     * @param $name Nome del prodotto.
     * @param $price Prezzo del prodotto.
     * @param $quantity Quantità del prodotto
     * @return array Dati del prodotto.
     */
    public function getProduct($name, $price, $quantity, $custMail = null){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        require_once 'application/models/buy.php';
        $buy = new BuyModel();

        //Se il prodotto esiste già nel carrello (la tabella compra)
        if(count($buy->getDataByProduct($name, $price, $quantity, $custMail)) > 0) {
            //Prendo i dati del prodotto in base alle chievi e prendo anche i dati di chi compra e chi vende
            $sql = $conn->prepare("SELECT * from prodotto p
                              right outer join compra c on p.nome = c.nome_prodotto and p.prezzo = c.prezzo_prodotto and p.quantita = c.quantita_prodotto
                              left outer join vende v on v.nome_prodotto = p.nome
                              left outer join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio 
                              WHERE p.nome LIKE :nome AND p.prezzo LIKE :prezzo AND p.quantita LIKE :quantita");
            $sql->bindParam(':nome', $name, PDO::PARAM_STR);
            $sql->bindParam(':prezzo', $price, PDO::PARAM_INT);
            $sql->bindParam(':quantita', $quantity, PDO::PARAM_STR);
        }else{
            //Prendo i dati del prodotto in base alle chievi e prendo anche i dati di chi vende
            $sql = $conn->prepare("SELECT * from prodotto p
                              left outer join vende v on v.nome_prodotto = p.nome
                              left outer join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio 
                              WHERE p.nome LIKE :nome AND p.prezzo LIKE :prezzo AND p.quantita LIKE :quantita");
            $sql->bindParam(':nome', $name, PDO::PARAM_STR);
            $sql->bindParam(':prezzo', $price, PDO::PARAM_INT);
            $sql->bindParam(':quantita', $quantity, PDO::PARAM_STR);
        }

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        //Ciclo tutti i valori e li ritorno
        if($sql->rowCount() > 0) {

            // Ciclo tutti i valori
            while ($row = $sql->fetch()) {
                //Inserisco il prodotto nell'array e lo ritorno
                array_push($dataArray, $row);
            }
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende i dati del prodotto con quelli del venditore
     */
    public function getDealerProducts(){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("SELECT * from prodotto p inner join vende v on v.nome_prodotto = p.nome
                               inner join negozio n on n.nome = v.nome_negozio and n.indirizzo = v.indirizzo_negozio and n.citta = v.citta_negozio
                               WHERE n.email_gestore = :email");
        $sql->bindParam(':email', $_SESSION['dealer'], PDO::PARAM_STR);

        $dataArray = array();
        //Eseguo la query
        $sql->execute();

        // Ciclo tutti i valori
        while ($row = $sql->fetch()) {
            array_push($dataArray, $row);
        }
        $conn = null;
        return $dataArray;
    }

    /**
     * Funzione che prende tutti i prodotto in base alla categoria
     */
    public function getProductsByCategory($category, $dealer = false){
        if($dealer) {
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getDealerProducts();
        }else{
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProducts();
        }

        //Creo un array vuoto ee faccio passare tutti i dati presi
        $dataArray = array();
        foreach ($data as $value){

            //Se la categoria del prodott è corretta lo inserisco nell'array
            if($value['nome_categoria'] == $category){
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }

    /**
     * Funzione che prende tutti i prodotti in base al nome
     */
    public function getProductsByName($name){
        //Prendo tutti i prodotti dell'utente corrente
        $data = $this->getProducts();

        //Creo un array vuoto ee faccio passare tutti i dati presi
        $dataArray = array();
        foreach ($data as $value){

            //Se la categoria del prodott è corretta lo inserisco nell'array
            if($value['nome'] == $name){
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }

    /**
     * Funzione che imposta la quantità di un prodotto
     * @param $prodName Nome prodotto.
     * @param $prodPrice Prezzo Prodotto.
     * @param $prodQuantity Quantità prodotto
     * @param $quantity Nuova quantità prodotto.
     */
    public function setQuantity($prodName, $prodPrice, $prodQuantity, $quantity){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Imposto la query
        $sql = $conn->prepare("UPDATE prodotto SET quantita = :quantity WHERE nome LIKE :prodName
                AND prezzo LIKE :prodPrice
                AND quantita LIKE :prodQuantity");
        $sql->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $sql->bindParam(':prodName', $prodName, PDO::PARAM_STR);
        $sql->bindParam(':prodPrice', $prodPrice);
        $sql->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);

        //Eseguo la query
        if(!$sql->execute()){
            $conn = null;
            return false;
        }

        $conn = null;
        return true;
    }

    /**
     * Funzione che inserisce un prodotto
     * @param $category Categoria del prodotto.
     * @param $title Nome del prodotto
     * @param $prize Prezzo del prodotto
     * @param $quantity Quantità del prodotto
     * @param $image Immagine del prdotto
     */
    public function insertProduct($category, $title, $prize, $quantity, $image){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Inserisco il prodotto
        $sql = $conn->prepare("INSERT INTO prodotto(nome_categoria, nome, prezzo, quantita, img) 
                      values(:categoria, :nome, :prezzo, :quantita, :img)");
        $sql->bindParam(':categoria', $category, PDO::PARAM_STR);
        $sql->bindParam(':nome', $title, PDO::PARAM_STR);
        $sql->bindParam(':prezzo', $prize, PDO::PARAM_INT);
        $sql->bindParam(':quantita', $quantity, PDO::PARAM_INT);
        $sql->bindParam(':img', $image, PDO::PARAM_STR);

        //Eseguo la query
        if(!$sql->execute()){
            $conn = null;
            $_SESSION['ExistData'] = true;
            return $_SESSION['ExistData'];
        }

        $conn = null;
        $_SESSION['created'] = true;
        return $_SESSION['created'];
    }

    /**
     * Funzione che Modifica un prodotto
     * @param null $category Categoria del prodotto
     * @param null $title Nome del prodotto
     * @param null $price Prezzo ddel prodotto
     * @param null $quantity Quantità del prodotto
     * @param null $image Immagine del prodotto
     * @param $oldData Vecchio dato
     */
    public function modifyProduct($category = null, $title = null, $price = null, $quantity = null, $image = null, $oldData){
        //Connetto al database
        $conn = $this->connection->sqlConnection();

        //Controllo se c'è un immagine
        if($image!= ""){
            $sql = $conn->prepare("UPDATE prodotto set nome = :name, prezzo = :price, quantita = :quantity, nome_categoria = :category, img = :img
                      WHERE nome = :oldName AND prezzo = :oldPrice AND quantita = :oldQuantity");
            $sql->bindParam(':img', $image, PDO::PARAM_STR);
        }else{
            $sql = $conn->prepare("UPDATE prodotto set nome = :name, prezzo = :price, quantita = :quantity, nome_categoria = :category
                      WHERE nome = :oldName AND prezzo = :oldPrice AND quantita = :oldQuantity");
        }
        $sql->bindParam(':name', $title, PDO::PARAM_STR);
        $sql->bindParam(':price', $price, PDO::PARAM_INT);
        $sql->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $sql->bindParam(':category', $category, PDO::PARAM_STR);
        $sql->bindParam(':oldName', $oldData[7], PDO::PARAM_STR);
        $sql->bindParam(':oldPrice', $oldData[8], PDO::PARAM_INT);
        $sql->bindParam(':oldQuantity', $oldData[9], PDO::PARAM_INT);

        //Eseguo la query
        if(!$sql->execute()){
            $conn = null;
            $_SESSION['ExistData'] = true;
            return $_SESSION['ExistData'];
        }

        $conn = null;
        $_SESSION['created'] = true;
        return $_SESSION['created'];
    }

    /**
     * Funzione che cerca un prodotto
     * @param $category Categoria da cercare
     * @param $valueS Valore da cercare
     */
    public function searchProducts($category, $valueS){
        if($category === "false") {
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProducts();
        }else{
            //Prendo tutti i prodotti dell'utente corrente
            $data = $this->getProductsByCategory($category);
        }

        //Creo un array vuoto e faccio passare tutti i dati presi
        $dataArray = array();

        foreach ($data as $value){
            //Se il valore cercato è contenuto nel nome del prodotto passato
            if(gettype(stripos($value['nome'], $valueS)) != 'boolean'){

                //Inserisco il prodotto nell'array
                array_push($dataArray, $value);
            }
        }

        //Ritorno l'array
        return $dataArray;
    }
}