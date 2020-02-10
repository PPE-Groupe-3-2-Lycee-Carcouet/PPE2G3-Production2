<?php

Class guide
	{
	//ATTRIBUTS PRIVES -------------------------------------------------------------------------
	private $idGuide;
	private $nomGuide;
	private $sesLangues;
	private $sesActivites;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdGuide, $unNomGuide)
		{
		$this->idGuide = $unIdGuide;
		$this->nomGuide = $unNomGuide;
		$this->sesLangues = new arrayObject();
		$this->sesActivites = new arrayObject();
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdGuide()
		{
		return $this->idGuide;
		}
		
	public function getNomGuide()
		{
		return $this->nomGuide;
		}
	public function getSesLangues()
	{
		$liste = '';
		foreach ($this->sesLangues as $uneLangue)
			{
				$liste = $liste.$uneLangue->getLibelleLangue().' - ';
			}
		return $liste;
	}	
	//AJOUTE UNE LANGUE-------------------------------------------------------------
	
	public function ajouteUneLangue($uneLangue)
		{
		$this->sesLangues->append($uneLangue);
		}
	//AJOUTE UNE LANGUE-------------------------------------------------------------
	
	public function ajouteUneActivite($uneActivite)
		{
		$this->sesActivites->append($uneActivite);
		}
	
	}
	
?>