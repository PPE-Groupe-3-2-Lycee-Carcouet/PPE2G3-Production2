<?php
include 'C:\wamp64\www\PPE2G3\Modeles\Metiers\Guide.php';

Class conteneurGuide
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $lesGuides;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct()
		{
		$this->lesGuides = new arrayObject();
		}
	
	//METHODE AJOUTANT UN GUIDE-----------------------------------------------------------------------------------
	public function ajouteUnGuide($unIdGuide,$unNomGuide)
		{
		$unGuide = new guide ($unIdGuide,$unNomGuide);
		$this->lesGuides->append($unGuide);
		}
		
	//METHODE RETOURNANT LE NOMBRE DE GUIDES------------------------------------------------------------------
	public function nbGuides()
		{
		return $this->lesGuides->count();
		}
		
	//METHODE RETOURNANT UN GUIDE A PARTIR DE SON NUMERO--------------------------------------------	
	public function donneObjetGuideDepuisNumero($unIdGuide)
		{
		//initialisation d'un booléen (on part de l'hypothèse que le guide n'existe pas)
		$trouve=false;
		$leBonGuide=null;
		//création d'un itérateur sur la collection lesGuides
		$iGuide = $this->lesGuides->getIterator();
		//TQ on a pas trouvé le Guide et que l'on est pas arrivé au bout de la collection
		while ((!$trouve)&&($iGuide->valid()))
			{
			//SI le numéro du Guide courant correspond au numéro passé en paramètre
			if ($iGuide->current()->getIdGuide()==$unIdGuide)
				{
				//maj du booléen
				$trouve=true;
				//sauvegarde du guide courant
				$leBonGuide = $iGuide->current();
				}
			//SINON on passe au guide suivant
			else
				$iGuide->next();
			}
		return $leBonGuide;
		}
		
	//METHODE RETOURNANT LA LISTE DES GUIDES-------------------------------------------------------------------------------------------------------
	public function listeLesGuides()
		{
		$liste = '<TABLE>';
		foreach ($this->lesGuides as $unGuide)
			{
			$liste = $liste.'<TR><TD>';
			$liste = $liste.'Guide "'.$unGuide->getNomGuide();
			$liste = $liste.'<TD><A href = "index.php?vue=guide&action=detail&numero='.$unGuide->getIdGuide().'">Voir le detail des langues du guide</A></TD></TR>';
			}
		return $liste.'</TABLE>';
		}

	//METHODE RETOURNANT LA LISTE DES GUIDES DANS UNE BALISE <SELECT>------------------------------------------------------------------
	public function lesGuidesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idGuide'>";
		foreach ($this->lesGuides as $unGuide)
			{
			$liste = $liste."<OPTION value='".$unGuide->getIdGuide()."'>".$unGuide->getNomGuide()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}	
	public function donneToutesLeslanguesDUnGuide($unNumeroGuide)
		{
		$liste = '';
		foreach ($this->lesGuides as $unGuide)
		{
			if($unGuide->getIdGuide()==$unNumeroGuide)
				$liste = $liste.'Ce guide parle : '.$unGuide->getSesLangues();
		}
		
		if($liste == 'Ce guide parle : ')
			$liste = "Il n'y a pas de langue pour ce guide";
		
		return $liste;
		}
		
	public function ajouterUneLangueAuGuide($unNumeroGuide,$uneLangue)
	{		
		foreach ($this->lesGuides as $unGuide)
		{
			if($unGuide->getIdGuide()==$unNumeroGuide)
				$unGuide->ajouteUneLangue($uneLangue);
		}
	}
	}
	
?>