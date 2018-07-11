<?php
class Db {

	private $host = HOST;
	private $name = DBNAME;
	private $user = USER;
	private $pass = PWD;

	public $connexion;
	public $table;

	function __construct($host=null,$name=null,$user=null,$pass=null){

		if($host != null){
			$this->host = $host;
			$this->name = $name;
			$this->user = $user;
			$this->pass = $pass;
		}

		try{

			$this->connexion = new PDO('mysql:host='.$this->host.';dbname='.$this->name,$this->user, $this->pass,array(
					PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8',
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
				));

		}catch(PDOException $e){
			echo $host;
			var_dump($e);
			echo "Erreur : Impossible de se connecter à la base de coaching : ".$this->host;
			die();
		}

	}

	// Récupére un enregistrement à partir d'un id.
	public function getId($id){
		$table = $this->table;
		$req = $this->connexion->prepare("SELECT * FROM {$table} WHERE id=:id");
		$req->execute(array("id"=>$id));
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	// Récupére tous les enregistrements de la table.
	public function getALL(){
		$table = $this->table;
		$req = $this->connexion->prepare("SELECT * FROM {$table}");
		$req->execute();
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	// Récupére tous les enregistrements selon un critére de tri.
	public function getALLOrderBy($order){
		$table = $this->table;
		$req = $this->connexion->prepare("SELECT * FROM {$table} ORDER BY {$order}");
		$req->execute();
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	// Suppression d'un enregistrement à partir d'un id
	public function deleteId($id){
		$table = $this->table;
		$req = $this->connexion->prepare("DELETE FROM {$table} WHERE id=:id");
		$req->execute(array("id"=>$id));
		return $req;
	}

	// Retourne le nombre d'enregistrements dans la table.
	public function countRow () {
		$table = $this->table;
		$req = $this->connexion->prepare("SELECT * FROM {$table}");
		$req->execute();
		return $req->rowCount();
	}

	// Insere un enregistrement dans la table. Le contenu des champs se trouve dans la variable $data.
	public function insertIntoDB($data){
		if (isset($data) && !empty($data)){
			$strFields = "(";
			$strData   = "(";
			$table     = $this->table;
			foreach ($data as $key => $value) {
				$strFields .= $key.", ";
				$strData   .= ":".$key.", ";
			}
			$strFields = rtrim($strFields,", ").")";
			$strData   = rtrim($strData,", ").")";

			$sql = "INSERT INTO {$table} {$strFields} VALUES {$strData}";

			$req = $this->connexion->prepare($sql);
			$req->execute($data);
			return $this->connexion->lastInsertId();
		}
	}

	// MAJ d'un enregistrement dans la table selon un id. Le contenu des champs se trouve dans la variable $data.
	public function updateDB($data, $id) {
		if (isset($data) && !empty($data) && isset($id) && !empty($id)){
			$strFields = "";
			$table     = $this->table;
			foreach ($data as $key => $value) {
					$strFields .= $key."=:".$key.", ";
			}
			$strFields = rtrim($strFields,", ");
			$sql = "UPDATE {$table} SET {$strFields} WHERE id=:id";

			$data['id'] = $id;
			$req = $this->connexion->prepare($sql);
			return $req->execute($data);
		}
	}

	// Récupére tous les enregistrements de a table passée en paramètre et selon un ordre de tri (non obligatoire.)
	public function queryALL($table, $order=null){
		$sql = "SELECT * FROM {$table}";
		if (isset($order)) {
			$sql = $sql." ORDER BY {$order} ASC";
		}
		$req = $this->connexion->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	public function query($sql,$data=array()){
		$req = $this->connexion->prepare($sql);
		$req->execute($data);

		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	public function tquery($sql,$data=array()){
		$req = $this->connexion->prepare($sql);
		$req->execute($data);

		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($sql,$data=array()){
		$req = $this->connexion->prepare($sql);
		$nbr = $req->execute($data);
		return $nbr;
	}

	public function getAndUpdateCompteur(){
		$sql = "SELECT compteur FROM compteur";
		$req = $this->connexion->prepare($sql);
		$req->execute();
		$cpt = $req->fetchAll(PDO::FETCH_ASSOC);
		$cpt = $cpt[0]['compteur']+1;

		$sql = "UPDATE compteur SET compteur = {$cpt}";
		$req = $this->connexion->prepare($sql);
		$req->execute();

		return $cpt;
	}

    public function getTourneeID(){
        $sql = "SELECT `id` AS id,  CONCAT(`numtournee`, ' - ', TIME(`dateheure_start`)) AS libelle FROM `tournee`
        		WHERE DATE(`dateheure_start`) = DATE(NOW()) AND `start_chargement` = 1 AND `start_receipt` = 0
        		ORDER BY TIME(`dateheure_start`) DESC LIMIT 4";
        $req = $this->connexion->prepare($sql);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTournee($id){
        $sql = "SELECT `numtournee` FROM `tournee` WHERE id = ".intval($id);
        $req = $this->connexion->prepare($sql);
        $req->execute();
        return $req->fetchColumn();
    }


}
