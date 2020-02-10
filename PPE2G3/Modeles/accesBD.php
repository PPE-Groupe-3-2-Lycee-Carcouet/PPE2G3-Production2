<?php

class accesBD
{
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------ATTRIBUTS PRIVES--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private $hote;
	private $login;
	private $passwd;
	private $base;
	private $conn;
	private $port;
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------CONSTRUCTEUR------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function __construct()
	{
		// ORDI PROFSIO
		$this->hote="localhost";
		$this->port="";
		$this->login="root";
		$this->passwd="";
		$this->base="ppe2Voyage";
		
		$this->connexion();
		
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------CONNECTION A LA BASE---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private function connexion()
	{
		try
        {
			//echo "sqlsrv:server=$this->hote$this->port;Database=$this->base"." | ".$this->login." | ".$this->passwd;
			// Pour SQL Server
			//$this->conn = new PDO("sqlsrv:server=$this->hote$this->port;Database=$this->base", $this->login, $this->passwd);
			//$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
            
            // Pour Mysql/MariaDB
            $this->conn = new PDO("mysql:dbname=$this->base;host=$this->hote",$this->login, $this->passwd);
            $this->boolConnexion = true;
        }
        catch(PDOException $e)
        {
            die("Connexion à la base de données échouée".$e->getMessage());
        }
	}
	
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------CHARGEMENT DES INFORMATIONS DE LA BASE--------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function chargement($uneTable)
	{
		$lesInfos=null;
		$nbTuples=0;
		$stringQuery="SELECT * FROM ";

		//définition de la requête SQL
		//On prépare la
		$stringQuery = $this->specialCase($stringQuery,$uneTable);
		$query = $this->conn->prepare($stringQuery);
		//POUR chaque tuple retourné par la requête SQL
		if($query->execute())
		{
			while($row = $query->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
				
			}
		}
		else
		{
			die('Problème dans chargement : '.$query->errorCode());
		}

		//retour du tableau à deux dimension
		return $lesInfos;
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//---------------------------CREATION DE LA REQUETE D'INSERTION GUIDE-------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function insertGuide($unNomGuide)
	{
		//génération automatique de l'identifiant
		$sonId = $this->donneProchainIdentifiant("guide","id");
		
		$requete = $this->conn->prepare("INSERT INTO guide (id,nom) VALUES (?,?)");
		//définition de la requête SQL
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomGuide);
		
		//exécution de la requête SQL
		if(!$requete->execute())
		{
			die("Erreur dans insertGuide : ".$requete->errorCode());
		}

		//retour de l'identifiant du nouveau tuple
		return $sonId;
	}
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//---------------------------CREATION DE LA REQUETE D'INSERTION DES LANGUES------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function insertLangue($unLibelleLangue)
	{
		//génération automatique de l'identifiant
		$sonId = $this->donneProchainIdentifiant("Langue","idLangue");
		
		//définition de la requête SQL
		$requete = $this->conn->prepare("INSERT INTO langue (idLangue, libelleLangue) VALUES (?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unLibelleLangue);

		//exécution de la requête SQL
		if(!$requete->execute())
		{
			die("Erreur dans insertLangue : ".$requete->errorCode());
		}

		//retour de l'identifiant du nouveau tuple
		return $sonId;
	}	
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//---------------------------CREATION DE LA REQUETE D'INSERTION des ACTIVITE-------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function insertActivite($unLibelleActivite)
	{
		//génération automatique de l'identifiant
		$sonId = $this->donneProchainIdentifiant("activite","idActivite");
		//définition de la requête SQL pour l activite
		$requete = $this->conn->prepare("INSERT INTO activite (idActivite, libelleActivite) VALUES (?,?);");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unLibelleActivite);
		//exécution de la requête SQL
		if(!$requete->execute())
		{
			die("Erreur dans insertActivite : ".$requete->errorCode());
		}
		
		//retour de l'identifiant du nouveau tuple
		return $sonId;
	}	

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//---------------------------CREATION DE LA REQUETE D'INSERTION des PAYS-------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function insertPays($unNomPays, $unePhotoPays, $uneLangue)
	{
		//génération automatique de l'identifiant
		$sonId = $this->donneProchainIdentifiant("Pays","code");
		//définition de la requête SQL 
		$requete = $this->conn->prepare("INSERT INTO Pays (code, nom, photo, idLangue) VALUES (?,?,?,?);");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomPays);
		$requete->bindValue(3,$unePhotoPays);
		$requete->bindValue(4,$uneLangue);
		//exécution de la requête SQL
		if(!$requete->execute())
		{
			die("Erreur dans insertPays : ".$requete->errorCode());
		}
		
		//retour de l'identifiant du nouveau tuple
		return $sonId;
	}	

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------EXECUTION D'UNE REQUETE---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		private function specialCase($stringQuery,$uneTable)
		{
			$uneTable = strtoupper($uneTable);
			switch ($uneTable) 
			{
			case 'PAYS':
				$stringQuery.='pays';
				break;
			case 'ACTIVITE':
				$stringQuery.='activite';
				break;
			case 'GUIDE':
				$stringQuery.='guide';
				break;
			case 'LANGUE':
				$stringQuery.='langue';
				break;
			case 'PARLER':
				$stringQuery.='parler';
				break;
			default:
				die('Pas une table valide');
				break;
			}

			return $stringQuery;
		}
	
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------DONNE LE PROCHAIN INDENTIFIANT---------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private function donneProchainIdentifiant($uneTable,$unIdentifiant)
	{
		//$prochainId[0]=0;
		//définition de la requête SQL
		$stringQuery = $this->specialCase("SELECT * FROM ",$uneTable);
		echo $stringQuery;
		$requete = $this->conn->prepare($stringQuery);
		$requete->bindValue(1,$unIdentifiant);

		//exécution de la requête SQL
		if($requete->execute())
		{
			$nb=0;
			//Retourne le prochain identifiant
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{

				$nb = $row[0];
			}
			return $nb+1;
		}
		else
		{
			die('Erreur sur donneProchainIdentifiant : '+$requete->errorCode());
		}
	}
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------DONNE LE PROCHAIN INDENTIFIANT D'UNE SAISON---------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private function donneProchainIdentifiantSaison($uneTable,$unIdentifiantSerie)
	{
		//$prochainId[0]=0;
		//définition de la requête SQL
		$stringQuery = $this->specialCase("SELECT MAX(NUMSAISON) FROM ",$uneTable,"WHERE idSerie = ",$unIdentifiantSerie,";");
		echo $stringQuery;
		$requete = $this->conn->prepare($stringQuery);
		$requete->bindValue(1,$unIdentifiantSerie);

		//exécution de la requête SQL
		if($requete->execute())
		{
			$nbSaison=0;
			//Retourne le prochain identifiant
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{

				$nbSaison = $row[0];
			}
			return $nbSaison+1;
		}
		else
		{
			die('Erreur sur donneProchainIdentifiantSaison : '+$requete->errorCode());
		}
	}	
}
?>
