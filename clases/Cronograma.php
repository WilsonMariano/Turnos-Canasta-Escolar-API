<?php

class Cronograma {

    public $id;
    public $idTitular;
    public $fechaEntrega;
    public $lugarEntrega;
    public $estado;
    public $observaciones;


    
    public function BindQueryParams($consulta, $objEntidad, $includePK = true){
        if($includePK == true)
        $consulta->bindValue(':id'		        ,$objEntidad->id            ,\PDO::PARAM_INT);
        
        $consulta->bindValue(':idTitular'       ,$objEntidad->idTitular     ,\PDO::PARAM_INT);
        $consulta->bindValue(':fechaEntrega'    ,$objEntidad->fechaEntrega  ,\PDO::PARAM_STR);
        $consulta->bindValue(':lugarEntrega'    ,$objEntidad->lugarEntrega  ,\PDO::PARAM_STR);
        $consulta->bindValue(':estado'          ,$objEntidad->estado        ,\PDO::PARAM_STR);
        $consulta->bindValue(':observaciones'   ,$objEntidad->observaciones ,\PDO::PARAM_STR);
    }
}