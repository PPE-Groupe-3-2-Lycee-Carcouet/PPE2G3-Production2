<?php
Class pays
	{
	//ATTRIBUTS PRIVES -------------------------------------------------------------------------
	private $idPays;
	private $nomPays;
	private $photoPays;
	private $saLangue;
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdPays, $unNomPays, $photoPays,$saLangue)
		{
		$this->idPays = $unIdPays;
		$this->nomPays = $unNomPays;
		$this->photoPays = $photoPays;
		$this->saLangue = $saLangue;
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdPays()
		{
		return $this->idPays;
		}
		
	public function getNomPays()
		{
		return $this->nomPays;
		}
	public function getPhotoPays()
		{
		return $this->photoPays;
		}
	public function getSaLangue()
		{
		return $this->saLangue;
		}	
	
	}
	
?>