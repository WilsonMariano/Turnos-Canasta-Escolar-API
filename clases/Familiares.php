<?php

class Familiares {

    public $id;
    public $idTitular;
    public $dni;
    public $nombre;
    public $apellido;
    public $fechaNacimiento;
    public $edad;
    public $nivelEducacion;
    public $sexo;

    public function __construct($arrData = null){
		if($arrData != null){
            $this->id               = $arrData["id"] ?? null;
			$this->idTitular        = $arrData["idTitular"];
            $this->dni              = $arrData["dni"];
            $this->nombre           = $arrData["nombre"];
            $this->apellido         = $arrData["apellido"];
            $this->fechaNacimiento  = $arrData["fechaNacimiento"];
            $this->edad             = $arrData["edad"];
            $this->nivelEducacion   = $arrData["nivelEducacion"];
            $this->sexo             = $arrData["sexo"];
		}
	}
    
    public function BindQueryParams($consulta, $objEntidad, $includePK = true){
        if($includePK == true)
        $consulta->bindValue(':id'		          ,$objEntidad->id            ,\PDO::PARAM_INT);
        
        $consulta->bindValue(':idTitular'         ,$objEntidad->idTitular       ,\PDO::PARAM_INT);
        $consulta->bindValue(':dni'               ,$objEntidad->dni             ,\PDO::PARAM_INT);
        $consulta->bindValue(':nombre'            ,$objEntidad->nombre          ,\PDO::PARAM_STR);
        $consulta->bindValue(':apellido'          ,$objEntidad->apellido        ,\PDO::PARAM_STR);
        $consulta->bindValue(':fechaNacimiento'   ,$objEntidad->fechaNacimiento ,\PDO::PARAM_STR);
        $consulta->bindValue(':edad'              ,$objEntidad->edad            ,\PDO::PARAM_INT);
        $consulta->bindValue(':nivelEducacion'    ,$objEntidad->nivelEducacion  ,\PDO::PARAM_STR);
        $consulta->bindValue(':sexo'              ,$objEntidad->sexo            ,\PDO::PARAM_STR);
    }
}