<?php
Class activite
	{
	//ATTRIBUTS PRIVES -------------------------------------------------------------------------
	private $idActivite;
	private $libelleActivite;
	private $sesGuides;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdActivite, $unLibelleActivite)
		{
		$this->idActivite = $unIdActivite;
		$this->libelleActivite = $unLibelleActivite;
		$this->sesGuides = new arrayObject();
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdActivite()
		{
		return $this->idActivite;
		}
		
	public function getLibelleActivite()
		{
		return $this->libelleActivite;
		}
		
	//AJOUTE UN GUIDE-------------------------------------------------------------
	
	public function ajouteUnGuide($unGuide)
		{
		$this->sesGuides->append($unGuide);
		}
	
	}
	
?>