<?php
include 'Conteneurs/conteneurGuide.php';
include 'Conteneurs/conteneurPays.php';
include 'Conteneurs/conteneurActivite.php';
include 'Conteneurs/conteneurLangue.php';
include 'accesBD.php';

Class gestionVoyage
	{
	//ATTRIBUTS PRIVES---------------------------------------------------------------------------------------------------------------------------
	private $toutesLesActivites;
	private $toutesLesLangues;
	private $TousLesPays;
	private $tousLesGuides;
	private $maBD;
	
	//CONSTRUCTEUR--------------------------------------------------------------------------------------------------------------------------------
	public function __construct()
		{
		$this->toutesLesActivites = new conteneurActivite();
		$this->toutesLesLangues = new conteneurLangue();
		$this->tousLesPays = new conteneurPays();
		$this->tousLesGuides = new conteneurGuide();
		$this->maBD = new accesBD();
		$this->chargeLesLangues();	
		$this->chargeLesGuides();
		$this->chargeLesActivites();
		$this->chargeLesPays();
	
		}
	
		
	//METHODE CHARGEANT TOUTES LES ACTIVITES--------------------------------------------------------------------------------------
	private function chargeLesActivites()
		{
		$resultat=$this->maBD->chargement('activite');
		$nb=0;
		while ($nb<sizeof($resultat))
			{
			//instanciation de la chambre et ajout de celle-ci dans la collection
			$this->toutesLesActivites->ajouteUneActivite($resultat[$nb][0],$resultat[$nb][1]);
			$nb++;
			}
		}
	
	//METHODE CHARGEANT TOUTES LES GUIDES-----------------------------------------------------------------------------------
	private function chargeLesGuides()
		{
		$resultat=$this->maBD->chargement('guide');
		$resultat1=$this->maBD->chargement('parler');
		$nb=0;
		$nb1=0;
		while ($nb<sizeof($resultat))
			{
			$this->tousLesGuides->ajouteUnGuide($resultat[$nb][0],$resultat[$nb][1]);
			while ($nb1 < sizeof($resultat1))
			{
				if($resultat[$nb][0] == $resultat1[$nb1][0])
				{
					$laLangue = $this->toutesLesLangues->donneObjetLangueDepuisNumero($resultat1[$nb1][1]);
					$this->tousLesGuides->ajouterUneLangueAuGuide($resultat[$nb][0],$laLangue);
					
				}
				$nb1++;
			}
			$nb1=0;
			$nb++;
			}
		
		$nb=0;
		
		}
		//METHODE CHARGEANT TOUTES LES LANGUES-----------------------------------------------------------------------------------
	private function chargeLesLangues()
		{
		$resultat=$this->maBD->chargement('langue');
		$nb=0;
		while ($nb<sizeof($resultat))
			{
			$this->toutesLesLangues->ajouteUneLangue($resultat[$nb][0],$resultat[$nb][1]);
			$nb++;
			}
		}
			//METHODE CHARGEANT TOUS LES PAYS-----------------------------------------------------------------------------------
	private function chargeLesPays()
		{
		$resultat=$this->maBD->chargement('pays');
		$nb=0;
	
		while ($nb<sizeof($resultat))
			{
			//récupération de l'objet Chambre à partir de son numéro
			$lObjetLangue = $this->toutesLesLangues->donneObjetLangueDepuisNumero($resultat[$nb][3]);
			//instanciation de la langue et ajout de celle-ci dans la collection
			$this->tousLesPays->ajouteUnPays($resultat[$nb][0],$resultat[$nb][1],$resultat[$nb][2],$lObjetLangue);
			$nb++;
			}
		}
	//METHODE INSERANT UNE Langue----------------------------------------------------------------------------------------------------------
	public function ajouteUneLangue($unLibelleLangue)
		{
		//insertion de la langue dans la base de données
		$sonNumero = $this->maBD->insertLangue($unLibelleLangue);
		//instanciation de la langue et ajout de celle-ci dans la collection
		$this->toutesLesLangues->Langue($sonNumero,$unLibelleLangue);
		}
	//METHODE INSERANT UNE Activite----------------------------------------------------------------------------------------------------------
	public function ajouteUneActivite($unLibelleActivite)
		{
		//insertion de l activite dans la base de données
		$sonNumero = $this->maBD->insertActivite($unLibelleActivite);
		//instanciation de l activite et ajout de celle-ci dans la collection
		$this->toutesLesActivites->activite($sonNumero,$unLibelleActivite);
		}
		//METHODE INSERANT UN GUIDE----------------------------------------------------------------------------------------------------------
	public function ajouteUnGuide($unNomGuide)
		{
		//insertion du guide dans la base de données
		$sonNumero = $this->maBD->insertGuide($unNomGuide);
		//instanciation du Guide et ajout de celui-ci dans la collection
		$this->tousLesGuides->ajouteUnGuide($sonNumero,$unNomGuide);
		}
	//METHODE INSERANT UN PAYS--------------------------------------------------------------------------------------------------------
	public function ajouteUnPays($unNomPays, $unePhotoPays, $unNumeroLangue)
		{
		//insertion du pays  dans la base de données
		$sonCode=$this->maBD->insertPays($unNomPays,$unePhotoPays,$unNumeroLangue);
		//récupération de l'objet Langue à partir de son numéro
		$laLangue = $this->toutesLesLangues->donneObjetLangueDepuisNumero($unNumeroLangue);
		//instanciation du pays et ajout de celle-ci dans la collection
		$this->tousLesPays->ajouteUnPays($sonCode,$unNomPays,$unePhotoPays,$laLangue);
		}	

	//METHODE RETOURNANT LE NOMBRE DE GUIDE-------------------------------------------------------------------------------------------------
	public function donneNbGuides()
		{
		return $this->tousLesGuides->nbGuides();
		}

	//METHODE RETOURNANT LE NOMBRE DE Pays----------------------------------------------------------------------------------------------
	public function donneNbPays()
		{
		return $this->tousLesPays->nbPays();
		}
	public function donneNbActivites()
		{
		return $this->toutesLesActivites->nbActivites();
		}		
	public function donneNbLangues()
		{
		return $this->toutesLesLangues->nbLangues();
		}
	//METHODE RETOURNANT LA LISTE DES GUIDES-------------------------------------------------------------------------------------------------------
	public function listeLesGuides()
		{
		return $this->tousLesGuides->listeLesGuides();
		}
	public function listeLesLangues()
		{
		return $this->toutesLesLangues->listeLesLangues();
		}
	public function listeLesActivites()
		{
		return $this->toutesLesActivites->listeLesActivites();
		}
	public function listeLesPays()
		{
		return $this->tousLesPays->listeDesPays();
		}
			
			
	//METHODE RETOURNANT LA LISTE DES GUIDES DANS UNE BALISE <SELECT>-----------------------------------------------------------------
	public function lesGuidesAuFormatHTML()
		{
		return $this->tousLesGuides->lesGuidesAuFormatHTML();
		}
	public function lesActivitesAuFormatHTML()
		{
		return $this->toutesLesActivites->lesActivitesAuFormatHTML();
		}	
	public function lesPaysAuFormatHTML()
		{
		return $this->tousLesPays->lesPaysAuFormatHTML();
		}	
	public function lesLanguesAuFormatHTML()
		{
		return $this->toutesLesLangues->leslanguesAuFormatHTML();
		}	
		
	//METHODE RETOURNANT LES DETAILS D'UN GUIDE----------------------------------------------------------------------------------------------------
	public function donneDetails($unNumeroGuide)
		{
		  $retour=$this->tousLesGuides->donneToutesLeslanguesDUnGuide($unNumeroGuide);
		  return $retour;
		}
		
	}
	
?>