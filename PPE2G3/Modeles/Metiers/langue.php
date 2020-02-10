<?php
Class langue
	{
	//ATTRIBUTS PRIVES -------------------------------------------------------------------------
	private $idLangue;
	private $libelleLangue;
	private $sesGuides;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdLangue,$unLibelleLangue)
		{    	    $this->idLangue = $unIdLangue;
					$this->libelleLangue = $unLibelleLangue;
					$this->sesGuides = new arrayObject();
		}
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdLangue()
		{
		return $this->idLangue;
		}
		
	public function getLibelleLangue()
		{
		return $this->libelleLangue;
		}
		
	//AJOUTE UN GUIDE-------------------------------------------------------------
	
	public function ajouteUnGuide($unGuide)
		{
		$this->sesGuides->append($unGuide);
		}
	
	}
	
?>