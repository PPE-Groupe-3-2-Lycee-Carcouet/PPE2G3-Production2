<?php
include 'C:\wamp64\www\PPE2G3\Modeles\Metiers\Pays.php';

Class conteneurPays
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $lesPays;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct()
		{
		$this->lesPays = new arrayObject();
		}
	
	//METHODE AJOUTANT UN Pays------------------------------------------------------------------------------
	public function ajouteUnPays($unIdPays, $unNomPays, $unePhotoPays, $uneLanguePays)
		{
		$unPays = new pays($unIdPays, $unNomPays, $unePhotoPays, $uneLanguePays);
		$this->lesPays->append($unPays);
			
		}
		
	//METHODE RETOURNANT LE NOMBRE DE PAYS-------------------------------------------------------------------------------
	public function nbPays()
		{
		return $this->lesPays->count();
		}	
		
	//METHODE RETOURNANT LA LISTE DES PAYS-----------------------------------------------------------------------------------------
	public function listeDesPays()
		{
		$liste = '';
		foreach ($this->lesPays as $unPays)
			{	$laLangue=$unPays->getSaLangue();
			
				$liste = $liste.'En "'.$unPays->getNomPays().' on parle :'.$laLangue->getLibelleLangue().' <img src=Images/'.$unPays->getPhotoPays().'></img><br>';
			}
		return $liste;
		}
		
		//METHODE RETOURNANT LA LISTE DES PAYS DANS UNE BALISE <SELECT>------------------------------------------------------------------
	public function lesPaysAuFormatHTML()
		{
		$liste = "<SELECT name = 'idPays'>";
		foreach ($this->lesPays as $unPays)
			{
			$liste = $liste."<OPTION value='".$unPays->getIdPays()."'>".$unPays->getNomPays()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}			
	
	}
	
?> 