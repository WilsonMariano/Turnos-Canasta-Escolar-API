DELIMITER $$

DROP PROCEDURE IF EXISTS restoreDB$$
CREATE PROCEDURE restoreDB()
BEGIN
	
	drop table if exists Titulares;
	drop table if exists Familiares;
	drop table if exists Cronograma;
	drop table if exists LugaresEntrega;
	drop table if exists EmpresasDelegados;
	drop table if exists Diccionario;
    drop table if exists Usuarios;
	
	
	create table Titulares (
		id              int  unsigned auto_increment  primary key,
		numAfiliado     int         not null,
		nombre          varchar(50) not null,
		apellido        varchar(50) not null,
		cuil            bigint      not null,
		domicilio       varchar(50) not null,
		localidad       varchar(50) not null,
		cuitEmpresa     bigint      not null,
		razonSocialEmpresa     varchar(50)  ,
		telefono        int                 ,
		celular         int         not null,
		email           varchar(50) not null,
        fechaAlta       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP     
	);

    create table Familiares (
        id              int  unsigned auto_increment  primary key,
        idTitular       int         not null,
        dni             int         not null,
        nombre          varchar(50) not null,
        apellido        varchar(50) not null,
        fechaNacimiento date        not null,
        edad            int         not null,
        nivelEducacion  varchar(50)         ,
        sexo            char        not null
    );

    create table Cronograma (
        id              int  unsigned auto_increment  primary key,
        idTitular       int         not null,
        idPuntoEntrega  int         not null,
        fechaEntrega    date                ,
        horaEntrega     time                ,
        estado          varchar(50) DEFAULT 'ESTADO_SOLICITUD_1' not null,
        observaciones   varchar(300) 
    );

    create table LugaresEntrega (
        id              int  unsigned auto_increment  primary key,
        nombre          varchar(50) not null,
        domicilio       varchar(50) not null,
        horario         varchar(50) not null,
        lnglat          varchar(50) not null
    );
    

    insert into LugaresEntrega(nombre, domicilio, horario, lnglat) values
    ("Sindicato Adrogué (C. jubilados)", "Av. Espora 953, Adrogué", "09:00 a 16:00 hs", "-58.388479, -34.801165"),
    ("Campo Deportivo Burzaco", "Pino 1995, Burzaco", "09:00 a 16:00 hs", "-58.420550, -34.822067"),
    ("Filial Guernica", "Calle 101 N° 41, Guernica", "09:00 a 16:00 hs", "-58.382249, -34.915978"),
    ("Filial San Vicente", "Belgrano 309, San Vicente", "09:00 a 16:00 hs", "-58.420288, -35.025269");


    create table EmpresasDelegados (
        id              int  unsigned auto_increment  primary key,
        cuit            bigint          not null,
        razonSocial     varchar(50)  not null
    );
    
    insert into EmpresasDelegados(cuit, razonSocial) values 
    (30550273558, "OSECAC"),
    (30549493196, "SECAB"),
    (30687310434, "CARREFOUR "),
    (30710376456, "AGLOLAM"),
    (30612865333, "MAYCAR"),
    (30663005843, "MAXICONSUMO"),
    (30710589018, "TREOLAND"),
    (30678138300, "WALMART"),
    (30708772964, "JUMBO"),
    (30576344321, "CARPAS DANGIOLA"),
    (30685849751, "DIA ARGENTINA"),
    (30541222800, "RICARDO OSPITAL"),
    (30683009195, "DISTRIBUIDORA PLACASUR"),
    (30707270159, "HENDEL HOGAR"),
    (30691054833, "APRESA"),
    (30710532180, "MEDAMAX"),
    (30655725829, "SODIMAC"),
    (33708103409, "YMK"),
    (30590360763, "DISCO"),
    (20218720855, "MAXICERAMICOS");

    create table Diccionario (
        id              int  unsigned auto_increment  primary key,
        clave           varchar(50)  not null,
        valor           varchar(50)  not null
    );

    insert into Diccionario(clave, valor) values
    ("NIVEL_EDUCACION_1", "Sin estudios"),
    ("NIVEL_EDUCACION_2", "Preescolar"),
    ("NIVEL_EDUCACION_3", "Primaria (1° a 3°)"),
    ("NIVEL_EDUCACION_4", "Primaria (4° a 6°)"),
    ("NIVEL_EDUCACION_5", "Secundaria"),
    ("ESTADO_SOLICITUD_1", "Pendiente"),
    ("ESTADO_SOLICITUD_2", "Aprobado"),
    ("ESTADO_SOLICITUD_3", "Rechazado"),
    ("ESTADO_SOLICITUD_4", "Entregado");

    create table Usuarios (
        id              int  unsigned auto_increment  primary key,
        email           varchar(50) not null,
        password        varchar(50) not null,
        role            varchar(20) not null,
        idPuntoEntrega  varchar(3)
    );

    insert into Usuarios(email, password, role, idPuntoEntrega) values
    ("admin@admin", "asd123", "admin", ""),
    ("usuario@sindicato", "@Sindicato2020", "usuario", "1"),
    ("usuario@campodeportivo", "@CampoDeportivo2020", "usuario", "2"),
    ("usuario@guernica", "@FilialGuernica2020", "usuario", "3"),
    ("usuario@sanvicente", "@SanVicente2020", "usuario", "4");


END$$

DELIMITER ;

