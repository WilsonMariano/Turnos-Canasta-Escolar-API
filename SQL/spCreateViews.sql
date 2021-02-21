DELIMITER $$

-- DROP PROCEDURE IF EXISTS createViews$$
CREATE PROCEDURE createViews()
BEGIN
	
	DROP VIEW IF EXISTS vwSolicitudes; 
	CREATE VIEW vwSolicitudes AS 
		
        SELECT TI.fechaAlta, TI.numAfiliado, TI.cuil, TI.apellido, TI.nombre, TI.cuitEmpresa, LE.nombre as 'puntoEntrega', 
		DI.valor as 'nombreEstado', CR.*
		FROM Titulares as TI  
		INNER JOIN Cronograma       CR  ON TI.id    = CR.idTitular
        INNER JOIN Diccionario      DI  ON DI.clave = CR.estado
        INNER JOIN LugaresEntrega   LE  ON LE.id    = CR.idPuntoEntrega
		ORDER BY DATE(TI.fechaAlta) ASC;   

END$$

DELIMITER ;