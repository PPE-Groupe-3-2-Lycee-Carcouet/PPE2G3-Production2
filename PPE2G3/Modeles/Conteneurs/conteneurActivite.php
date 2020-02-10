<?php
include 'C:\wamp64\www\PPE2G3\Modeles\Metiers\activite.php';

Class conteneurActivite
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $lesActivites;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct()
		{
		$this->lesActivites = new arrayObject();
		}
	
	//METHODE AJOUTANT UNE ACTIVITE-----------------------------------------------------------------------------------
	public function ajouteUneActivite($unIdActivite,$unNomActivite)
		{
		$uneActivite = new activite ($unIdActivite,$unNomActivite);
		$this->lesActivites->append($uneActivite);
		}
		
	//METHODE RETOURNANT LE NOMBRE D ACTIVITES------------------------------------------------------------------
	public function nbActivites()
		{
		return $this->lesActivites->count();
		}
		
	//METHODE RETOURNANT UNE ACTIVITE A PARTIR DE SON NUMERO--------------------------------------------	
	public function donneObjetActiviteDepuisNumero($unIdActivite)
		{
		//initialisation d'un booléen (on part de l'hypothèse que l activite n'existe pas)
		$trouve=false;
		$laBonneActivite=null;
		//création d'un itérateur sur la collection lesActivites
		$iActivite = $this->lesActivites->getIterator();
		//TQ on a pas trouvé l activite et que l'on est pas arrivé au bout de la collection
		while ((!$trouve)&&($iActivite->valid()))
			{
			//SI le numéro de l activite courante correspond au numéro passé en paramètre
			if ($iActivite->current()->getIdActivite()==$unIdActivite)
				{
				//maj du booléen
				$trouve=true;
				//sauvegarde de l activite courante
				$laBonneActivite = $iActivite->current();
				}
			//SINON on passe à l activite suivante
			else
				$iActivite->next();
			}
		return $laBonneActivite;
		}
		
	//METHODE RETOURNANT LA LISTE DES ACTIVITES-------------------------------------------------------------------------------------------------------
	public function listeLesActivites()
		{
		$liste = '<TABLE>';
		foreach ($this->lesActivites as $uneActivite)
			{
			$liste = $liste.'<TR><TD>';
			$liste = $liste.'Activites "'.$uneActivite->getLibelleActivite();
			$liste = $liste.'<TD><A href = "index.php?vue=activite&action=detail&numero='.$uneActivite->getIdActivite().'">Voir le detail des guides</A></TD></TR>';
			}
		return $liste.'</TABLE>';
		}

	//METHODE RETOURNANT LA LISTE DES ACTIVITES DANS UNE BALISE <SELECT>------------------------------------------------------------------
	public function lesActivitesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idActivite'>";
		foreach ($this->lesActivites as $uneActivite)
			{
			$liste = $liste."<OPTION value='".$uneActivite->getIdActivite()."'>".$uneActivite->getLibelleActivite()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}			
	}
	
?>