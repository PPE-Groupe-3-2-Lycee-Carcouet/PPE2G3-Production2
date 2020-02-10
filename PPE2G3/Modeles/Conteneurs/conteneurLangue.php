<?php
include 'C:\wamp64\www\PPE2G3\Modeles\Metiers\langue.php';

Class conteneurLangue
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $lesLangues;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct()
		{
		$this->lesLangues = new arrayObject();
		}
	
	//METHODE AJOUTANT UNE LANGUE-----------------------------------------------------------------------------------
	public function ajouteUneLangue($unIdLangue,$unLibelleLangue)
		{
		$uneLangue = new langue ($unIdLangue,$unLibelleLangue);
		$this->lesLangues->append($uneLangue);
		}
		
	//METHODE RETOURNANT LE NOMBRE DE LANGUES------------------------------------------------------------------
	public function nbLangues()
		{
		return $this->lesLangues->count();
		}
		
	//METHODE RETOURNANT UNE LANGUE A PARTIR DE SON NUMERO--------------------------------------------	
	public function donneObjetLangueDepuisNumero($unIdLangue)
		{
		//initialisation d'un booléen (on part de l'hypothèse que la langue n'existe pas)
		$trouve=false;
		$laBonneLangue=null;
		//création d'un itérateur sur la collection lesLangues
		$iLangue = $this->lesLangues->getIterator();
		//TQ on a pas trouvé la langue et que l'on est pas arrivé au bout de la collection
		while ((!$trouve)&&($iLangue->valid()))
			{
			//SI le numéro de la langue courante correspond au numéro passé en paramètre
			if ($iLangue->current()->getIdLangue()==$unIdLangue)
				{
				//maj du booléen
				$trouve=true;
				//sauvegarde de la langue courante
				$laBonneLangue = $iLangue->current();
				
				}
			//SINON on passe à la langue suivante
			else
				$iLangue->next();
			}
		return $laBonneLangue;
		}
		
	//METHODE RETOURNANT LA LISTE DES LANGUES-------------------------------------------------------------------------------------------------------
	public function listeLesLangues()
		{
		$liste = '<TABLE>';
		foreach ($this->lesLangues as $uneLangue)
			{
			$liste = $liste.'<TR><TD>';
			$liste = $liste.'Langue "'.$uneLangue->getLibelleLangue();
			$liste = $liste.'<TD><A href = "index.php?vue=langue&action=detail&numero='.$uneLangue->getIdLangue().'">Voir le detail des guides</A></TD></TR>';
			}
		return $liste.'</TABLE>';
		}

	//METHODE RETOURNANT LA LISTE DES LANGUES DANS UNE BALISE <SELECT>------------------------------------------------------------------
	public function lesLanguesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idLangue'>";
		foreach ($this->lesLangues as $uneLangue)
			{
			$liste = $liste."<OPTION value='".$uneLangue->getIdLangue()."'>".$uneLangue->getLibelleLangue()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}	

	
	}
	
?>