<?php

class LugaresEntrega {

    public $id;
    public $nombre;
    public $domicilio;
    public $horario;

    public function __construct($arrData = null){
		if($arrData != null){
            $this->id          = $arrData["id"];
			$this->nombre      = $arrData["nombre"];
            $this->domicilio   = $arrData["domicilio"];
            $this->horario     = $arrData["horario"];
            $this->lnglat      = $arrData["lnglat"];

		}
	}
}