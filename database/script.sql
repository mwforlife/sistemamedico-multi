
create table diagnosticos(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre text not null,
    registro datetime not null default current_timestamp
);

insert into diagnosticos(codigo,nombre) values('C00','Cáncer Colorrectal');
insert into diagnosticos(codigo,nombre) values('C01','Cáncer de endometrio');
insert into diagnosticos(codigo,nombre) values('C02','Cáncer de higado');
insert into diagnosticos(codigo,nombre) values('C03','Leucemia');
insert into diagnosticos(codigo,nombre) values('C04','Linfoma no Hodgkin');
insert into diagnosticos(codigo,nombre) values('C05','Melanoma');
insert into diagnosticos(codigo,nombre) values('C06','Cáncer de páncreas'); 
insert into diagnosticos(codigo,nombre) values('C07','Cáncer de próstata');
insert into diagnosticos(codigo,nombre) values('C08','Cáncer de pulmón');
insert into diagnosticos(codigo,nombre) values('C09','Cáncer de riñón');
insert into diagnosticos(codigo,nombre) values('C10','Cáncer de mama (seno)');
insert into diagnosticos(codigo,nombre) values('C11','Cáncer de tiroides');
insert into diagnosticos(codigo,nombre) values('C12','Cáncer de vejiga');

/*Tipo diagnostico CIEO*/
create table tipodiagnostico(
    id int not null auto_increment primary key,
    nombre varchar(50) not null
);

/***Insert tipo Diagnostico*/
insert into tipodiagnostico values(1,'Morfologico');
insert into tipodiagnostico values(2,'Topografico');

/*Diagnosticos CIEO*/
create table diagnosticoscieo(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    descipcioncompleta text not null,
    descripcionabreviada text not null,
    tipodiagnostico int not null references tipodiagnostico(id),
    registro datetime not null default current_timestamp
);

/*Diagnosticos CIE10*/
create table diagnosticoscie10(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    descripcion text not null,
    nodo_final int null,
    manifestacion_no_dp int null,
    perinatal int null,
    pediatrico int null,
    obstetrico int null,
    adulto int null,
    mujer int null,
    hombre int null,
    poa_exempto int null,
    dp_no_principal int null,
    vcdp int null,
    registro datetime not null default current_timestamp
);


create table ecog(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);


create table histologico(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table invaciontumoral(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table tipotnm(
    id int not null auto_increment primary key,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table tnm(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    tipotnm int not null references tipotnm(id),
    diagnostico int not null references diagnosticos(id),
    registro datetime not null default current_timestamp
);

create table regiones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table provincias(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    region int not null references regiones(id),
    registro datetime not null default current_timestamp
);

create table comunas(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    region int not null references regiones(id),
    provincia int not null references provincias(id),
    registro datetime not null default current_timestamp
);

create table ciudades(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    region int not null references regiones(id),
    provincia int not null references provincias(id),
    registro datetime not null default current_timestamp
);

/***********************************Empresa****************************************/
create table codigoactividad(
    id int not null auto_increment primary key,
    codigosii int not null,
    nombre varchar(200) not null
);

create table empresa(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    razonsocial varchar(200) not null,
    calle varchar(200) not null,
    villa varchar(200) null,
    numero varchar(20) not null,
    dept varchar(200) null,
    region int not null references regiones(id),
    comuna int not null references comunas(id),
    ciudad int not null references ciudades(id),
    telefono varchar(20) not null,
    email varchar(200) not null,
    giro varchar(200) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp
);

create table nubcodigoactividad(
    id int not null auto_increment primary key,
    codigo int not null references codigoactividad(id),
    empresa int not null references empresa(id)
);

create table representantelegal(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    nombre varchar(200) not null,
    primerapellido varchar(200) not null,
    segundoapellido varchar(200) not null,
    empresa int not null references empresa(id)
);

/*******************************************************************************************/

create table paises(
	id int not null auto_increment primary key,
	codigo varchar(10) not null, 
	nombre varchar(300) not null, 
	registro datetime not null
);

create table nacionalidades(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table generos(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table especialidades(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table profesiones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    especialidad int not null references especialidades(id),
    registro datetime not null default current_timestamp
);

create table servicioproveniencia(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into servicioproveniencia values(null,"1", "Patología", now());
insert into servicioproveniencia values(null,"2", "Coloproctología", now());
insert into servicioproveniencia values(null,"3", "Servicio Mamario", now());
insert into servicioproveniencia values(null,"4", "Urología", now());

create table usuarios(
    id int not null auto_increment primary key,
    rut varchar(20) not null,
    nombre varchar(400) not null,
    apellido1 varchar(400) not null,
    apellido2 varchar(400) null,
    correo varchar(400) not null,
    direccion varchar(400) not null,
    region int not null references regiones(id),
    comuna int not null references comunas(id),
    telefono varchar(400) not null,
    contrasena varchar(64) not null,
    registro datetime not null default current_timestamp
);

create table usuarioprofesion(
    id int not null auto_increment primary key,
    usuario int not null references usuarios(id),
    profesion int not null references profesiones(id),
    proveniencia int not null references servicioproveniencia(id),
    empresa int not null references empresa(id),
    estado int not null default 1,
    registro datetime not null default current_timestamp
);


create table sesionusuario (
    id int not null auto_increment primary key,
    usuario int not null references usuarios(id),
    token varchar(200) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp
);

/**********************************/
create table roles(
    id int not null auto_increment primary key,
    nombre varchar(50) not null,
    descripcion varchar(200) not null
);

insert into roles(nombre,descripcion) values('Administracion General','El Administrador general tiene permiso para administrar todo el sistema');
insert into roles(nombre,descripcion) values('Administrador Sistema','El Administrador del sistema tiene permiso para administrar todo el sistema con restricciones');
insert into roles(nombre,descripcion) values('Administrador Empresa','El Administrador de la empresa tiene permiso para administrar la empresa que pertenece');
insert into roles(nombre,descripcion) values('Supervisor','El Supervisor tiene permiso para administrar los usuarios de la empresa que pertenece');
insert into roles(nombre,descripcion) values('Medico','El Medico tiene permiso para administrar los pacientes de la empresa que pertenece');

create table rolesusuarios(
    id int not null auto_increment primary key,
    usuario int not null references usuario(id),
    rol int not null references roles(id),
    empresa int not null references empresa(id),
    registro datetime not null default current_timestamp
);
/*****************************/

create table acciones(
    id int not null auto_increment primary key,
    nombre varchar(50) not null
);

insert into acciones(nombre) values('Registro');
insert into acciones(nombre) values('Edicion');
insert into acciones(nombre) values('Eliminacion');

create table auditoriaeventos(
    id int not null auto_increment primary key,
    usuario int not null references usuarios(id),
    accion int not null references acciones(id),
    titulo varchar(200) not null,
    evento text not null,
    fecha timestamp not null default current_timestamp
);


/**************************************************************************************************************************************************/
create table tipoidentificaciones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into tipoidentificaciones(codigo, nombre) values('1', 'RUN');
insert into tipoidentificaciones(codigo, nombre) values('2', 'SIN RUN');
insert into tipoidentificaciones(codigo, nombre) values('3', 'PASAPORTE');
insert into tipoidentificaciones(codigo, nombre) values('4', 'IDENTIFICACION DE SU PAIS');

create table funcionarios(
    id int not null auto_increment primary key,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into funcionarios values(1,'SI',now());
insert into funcionarios values(2,'NO',now());

create table discapacidad(
    id int not null auto_increment primary key,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into discapacidad values(1,'SI',now());
insert into discapacidad values(2,'NO',now());


create table tipopartos(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into tipopartos(codigo, nombre) values('1', 'CESAREA');
insert into tipopartos(codigo, nombre) values('2', 'VAGINAL');
insert into tipopartos(codigo, nombre) values('3', 'FORCEPS');

create table reciennacidos(
    id int not null auto_increment primary key,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into reciennacidos values(1,'SI',now());
insert into reciennacidos values(2,'NO',now());

create table estadocivil(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into estadocivil(codigo, nombre) values('1', 'SOLTERO(A)');
insert into estadocivil(codigo, nombre) values('2', 'CASADO(A)');
insert into estadocivil(codigo, nombre) values('3', 'VIUDO(A)');
insert into estadocivil(codigo, nombre) values('4', 'DIVORCIADO(A)');
insert into estadocivil(codigo, nombre) values('5', 'SEPARADO(A)');




create table pacientes(
    id int not null auto_increment primary key,
    tipoidentificacion int not null references tipoidentificaciones(id),
    rut varchar(20)  null,
    identificacion varchar(20) null,
    nacionalidad int not null references nacionalidades(id),
    paisorigen int not null references paises(id),
    email varchar(400)  null,
    nombre varchar(400) not null,
    apellido1 varchar(400) not null,
    apellido2 varchar(400) null,
    genero int not null references generos(id),
    estadocivil int not null references estadocivil(id),
    fechanacimiento date not null,
    horanacimiento time null,
    fonomovil varchar(400) not null,
    fonofijo varchar(400) null,
    nombresocial varchar(400) null,
    funcionario int not null references funcionarios(id),
    discapacidad int not null references discapacidad(id),
    reciennacido int not null references reciennacidos(id),
    hijode varchar(400) null,
    pesodenacimiento int null,
    tallanacimiento int null,
    tipoparto int not null references tipopartos(id),
    rol varchar(400) null,
    fechafallecimiento date null,
    horafaallecimiento time null,
    estado int not null default 1,
    registro datetime not null default current_timestamp
);


create table prevision(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into prevision(codigo, nombre) values('1', 'FONASA');
insert into prevision(codigo, nombre) values('2', 'ISAPRE');
insert into prevision(codigo, nombre) values('3', 'PRAIS');

create table tipoprevisiones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    prevision int not null references prevision(id),
    registro datetime not null default current_timestamp
);

insert into tipoprevisiones(codigo, nombre, prevision) values('1', 'TIPO A', 1);
insert into tipoprevisiones(codigo, nombre, prevision) values('2', 'TIPO B', 1);
insert into tipoprevisiones(codigo, nombre, prevision) values('3', 'TIPO C', 1);

insert into tipoprevisiones(codigo, nombre, prevision) values('01','BANMÉDICA', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('02','CONSALUD', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('03','VIDA TRES', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('04','COLMENA', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('05','CRUZ BLANCA', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('10','NUEVA MAS VIDA', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('11','CODELCO LTD', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('12','BANCO ESTADO', 2);
insert into tipoprevisiones(codigo, nombre, prevision) values('25','CRUZ DEL NORTE', 2);


create table inscripcionprevision(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    ficha varchar(200) null,
    fechaadmision date null,
    familia varchar(400)  null,
    inscrito varchar(400)  null,
    sector varchar(400) not null,
    tipoprevision int not null references tipoprevisiones(id),
    estadoafiliar int  null default 1,
    chilesolidario int  null default 2,
    prais int  null default 2,
    sename int  null default 2,
    ubicacionficha varchar(400) not null,
    saludmental int  null default 1,
    registro datetime not null default current_timestamp
);

create table tipocalle(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into tipocalle(codigo, nombre) values('1', 'AVENIDA');
insert into tipocalle(codigo, nombre) values('2', 'CALLE');
insert into tipocalle(codigo, nombre) values('3', 'CAMINO');
insert into tipocalle(codigo, nombre) values('4', 'PASAJE');
insert into tipocalle(codigo, nombre) values('0', 'OTRO');



create table datosubicacion(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    region int not null references regiones(id),
    provincia int not null references provincias(id),
    comuna int not null references comunas(id),
    ciudad int not null references ciudades(id),
    tipocalle int not null references tipocalle(id),
    nombrecalle varchar(400) not null,
    numerocalle varchar(400) not null,
    restodireccion varchar(400) not null,
    registro datetime not null default current_timestamp
);

create table pueblooriginarios(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into pueblooriginarios(codigo, nombre) values('1', 'AIMARA');
insert into pueblooriginarios(codigo, nombre) values('2', 'ALACALUFE O KAWASHKAR');
insert into pueblooriginarios(codigo, nombre) values('3', 'ATACAMEÑO (LICKAN ANTAY)');
insert into pueblooriginarios(codigo, nombre) values('4', 'COLLA');
insert into pueblooriginarios(codigo, nombre) values('5', 'DIAGUITA');
insert into pueblooriginarios(codigo, nombre) values('6', 'MAPUCHE');
insert into pueblooriginarios(codigo, nombre) values('7', 'NINGUNO');
insert into pueblooriginarios(codigo, nombre) values('8', 'QUECHUA');
insert into pueblooriginarios(codigo, nombre) values('9', 'RAPA NUI');
insert into pueblooriginarios(codigo, nombre) values('10', 'YÁMANA O YAGÁN');
insert into pueblooriginarios(codigo, nombre) values('11', 'OTRO PUEBLO ORIGINARIO DECLARADO');


create table escolaridad(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into escolaridad(codigo, nombre) values('1', 'PRE-KINDER');
insert into escolaridad(codigo, nombre) values('2', 'KINDER');
insert into escolaridad(codigo, nombre) values('3', '1° BASICO');
insert into escolaridad(codigo, nombre) values('4', '2° BASICO');
insert into escolaridad(codigo, nombre) values('5', '3° BASICO');
insert into escolaridad(codigo, nombre) values('6', '4° BASICO');
insert into escolaridad(codigo, nombre) values('7', '5° BASICO');
insert into escolaridad(codigo, nombre) values('8', '6° BASICO');
insert into escolaridad(codigo, nombre) values('9', '7° BASICO');
insert into escolaridad(codigo, nombre) values('10', '8° BASICO');
insert into escolaridad(codigo, nombre) values('10', 'BASICA COMPLETA');
insert into escolaridad(codigo, nombre) values('11', '1° MEDIO');
insert into escolaridad(codigo, nombre) values('12', '2° MEDIO');
insert into escolaridad(codigo, nombre) values('13', '3° MEDIO');
insert into escolaridad(codigo, nombre) values('14', '4° MEDIO');
insert into escolaridad(codigo, nombre) values('14', 'MEDIA COMPLETA');
insert into escolaridad(codigo, nombre) values('15', 'TÉCNICA');
insert into escolaridad(codigo, nombre) values('16', 'PROFESIONAL');
insert into escolaridad(codigo, nombre) values('17', 'NO RECUERDA');
insert into escolaridad(codigo, nombre) values('18', 'NO RESPONDE');
insert into escolaridad(codigo, nombre) values('19', 'NINGUNA');

create table situacionlaboral(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into situacionlaboral(codigo, nombre) values('1', 'ACTIVO');
insert into situacionlaboral(codigo, nombre) values('2', 'CESANTE');
insert into situacionlaboral(codigo, nombre) values('3', 'DESCONOCIDO');
insert into situacionlaboral(codigo, nombre) values('4', 'INACTIVO');

create table ocupaciones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into ocupaciones(codigo, nombre) values('1', 'Agricultores y trabajadores calificados agropecuarios y pesqueros');
insert into ocupaciones(codigo, nombre) values('2', 'Desconocido');
insert into ocupaciones(codigo, nombre) values('3', 'Dueña(o) de casa');
insert into ocupaciones(codigo, nombre) values('4', 'Empleados de oficina');
insert into ocupaciones(codigo, nombre) values('5', 'Estudiante');
insert into ocupaciones(codigo, nombre) values('6', 'Fuerzas armadas');
insert into ocupaciones(codigo, nombre) values('7', 'Inactivo');
insert into ocupaciones(codigo, nombre) values('8', 'Oficiales, operarios y artesanos de artes mecánicas y de otros oficios');
insert into ocupaciones(codigo, nombre) values('9', 'Operadores de instalaciones y maquinaria y montadores');
insert into ocupaciones(codigo, nombre) values('10', 'Profesionales científicos e intelectuales');
insert into ocupaciones(codigo, nombre) values('11', 'Técnicos y profesionales de nivel medio');
insert into ocupaciones(codigo, nombre) values('12', 'Trabajadores de los servicios y vendedores de comercios y mercados');
insert into ocupaciones(codigo, nombre) values('13', 'Trabajadores no calificados');
insert into ocupaciones(codigo, nombre) values('14', 'Pensionado');

create table otrosantecedentes(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    pueblooriginario int not null references pueblooriginarios(id),
    escolaridad int not null references escolaridad(id),
    cursorepite varchar(400) not null,
    situacionlaboral int not null references situacionlaboral(id),
    ocupacion int not null references ocupaciones(id),
    registro datetime not null default current_timestamp
);

create table relaciones(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    registro datetime not null default current_timestamp
);

insert into relaciones(codigo, nombre) values('1', 'ABUELO(A)');
insert into relaciones(codigo, nombre) values('2', 'AMIGO(A)');
insert into relaciones(codigo, nombre) values('3', 'COLABORADOR(A)');
insert into relaciones(codigo, nombre) values('4', 'COLEGA');
insert into relaciones(codigo, nombre) values('5', 'ESPOSO(A)');
insert into relaciones(codigo, nombre) values('6', 'HERMANO(A)');
insert into relaciones(codigo, nombre) values('7', 'HIJO(A)');
insert into relaciones(codigo, nombre) values('8', 'JEFE(A)');
insert into relaciones(codigo, nombre) values('9', 'MADRE');
insert into relaciones(codigo, nombre) values('10', 'NIETO(A)');
insert into relaciones(codigo, nombre) values('11', 'NUERO(A)');
insert into relaciones(codigo, nombre) values('0', 'OTRO PARENTESCO');
insert into relaciones(codigo, nombre) values('13', 'PADRE');
insert into relaciones(codigo, nombre) values('14', 'PAREJA O NOVIO(A)');
insert into relaciones(codigo, nombre) values('15', 'PRIMO(A)');
insert into relaciones(codigo, nombre) values('16', 'SIN VINCULO');
insert into relaciones(codigo, nombre) values('17', 'SUBORDINADO(A)');
insert into relaciones(codigo, nombre) values('18', 'SUEGRO(A)');
insert into relaciones(codigo, nombre) values('19', 'TIO(A)');
insert into relaciones(codigo, nombre) values('20', 'VECINO(A)');
insert into relaciones(codigo, nombre) values('21', 'YERNO(A)');

create table personaresponsable(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    rut varchar(20) not null,
    nombre varchar(400) not null,
    relacion int not null references relaciones(id),
    telefono varchar(400) not null,
    direccion varchar(400) not null,
    registro datetime not null default current_timestamp
);

/**************************************************************************************************************************************************/

create table nombrecomite(
    id int not null auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(400) not null,
    empresa int not null references empresa(id),
    estado int not null default 1,
    registro datetime not null default current_timestamp
);

create table comite(
    id int not null auto_increment primary key,
    folio varchar(20) not null,
    fecha date not null,
    nombrecomite int not null references nombrecomite(id),
    estado int not null default 1,
    registro datetime not null default current_timestamp
);

create table profesionalescomite(
    id int not null auto_increment primary key,
    comite int not null references comite(id),
    profesional int not null references usuarios(id),
    registro datetime not null default current_timestamp
);

create table pacientescomite(
    id int not null auto_increment primary key,
    comite int not null references comite(id),
    paciente int not null references pacientes(id),
    profesionalresponsable int not null references usuarios(id),
    observacion varchar(400) not null,
    registro datetime not null default current_timestamp
);

/**************************************************************************************************************************************************/
create table informecomitediagnostico(
    id int not null auto_increment primary key,
    diagnosticos text null,
    diagnosticosid int null default 0,
    diagnosticocieotop text  null,
    diagnosticocieotopid int  null default 0,
    diagnosticocieomor text  null,
    diagnosticocieomorid int  null default 0,
    diagnosticocie10 text  null,
    diagnosticocie10id int  null default 0,
    fechabiopsia date  null,
    reingreso int  null default 0,
    registro datetime not null default current_timestamp
);

create table informecomite(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    diagnosticos int not null references informecomitediagnostico(id),
    comite int not null references comite(id),
    ecog int not null references ecog(id),
    histologico int not null references histologico(id),
    invaciontumoral int not null references invaciontumoral(id),
    mitotico int not null,
    tnmprimario text not null,
    tnmprimarioid int not null,
    observacionprimario text  null,
    tnmregionales text not null,
    tnmregionalesid int not null,
    observacionregionales text  null,
    tnmdistancia text not null,
    tnmdistanciaid int not null,
    observaciondistancia text  null,
    anamesis text  null,
    cirugia int not null default 0,
    quimioterapia int not null default 0,
    radioterapia int not null default 0,
    tratamientosoncologicos int not null default 0,
    seguimientosintratamiento int not null default 0,
    completarestudios int not null default 0,
    revaluacionposterior int not null default 0,
    estudioclinico int not null default 0,
    observaciondesicion text  null,
    consultade text not null,
    consultadeid int not null,
    programacionquirurgica int not null default 0,
    traslado int not null default 0,
    ciudadospaliativos int not null default 0,
    ingresohospitalario int not null default 0,
    observacionplan text  null,
    resolucion text  null,
    registro datetime not null default current_timestamp
);

/**************************************************************************************************************************************************/
/********Signos Vitales*/
create table signosvitales(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    fresp float not null,
    psist float not null,
    pdias float not null,
    sat02 float not null,
    fc float not null,
    tauxiliar float not null,
    trect float not null,
    totra float not null,
    hgt float not null,
    peso float not null,
    registro datetime not null default current_timestamp
);
/********Medidas Antopométricas*/
create table pe(
    id int not null auto_increment primary key,
    nombre varchar(50) not null,
    registro datetime not null default current_timestamp
);


insert into pe values(1,"Normal",now());
insert into pe values(2,"Riesgo Obesidad Abdominal",now());
insert into pe values(3,"Obesidad Abdominal",now());

create table pt(id int not null auto_increment primary key,
    nombre varchar(50) not null,
    registro datetime not null default current_timestamp
);

insert into pt values(1,"Normal",now());
insert into pt values(2,"Riesgo Obesidad Abdominal",now());
insert into pt values(3,"Obesidad Abdominal",now());

create table te(id int not null auto_increment primary key,
    nombre varchar(50) not null,
    registro datetime not null default current_timestamp
);

insert into te values(1,"Normal",now());
insert into te values(2,"Riesgo Obesidad Abdominal",now());
insert into te values(3,"Obesidad Abdominal",now());


create table clasificacioncintura(id int not null auto_increment primary key,
    nombre varchar(50) not null,
    registro datetime not null default current_timestamp
);


insert into clasificacioncintura values(1,"Normal",now());
insert into clasificacioncintura values(2,"Riesgo Obesidad Abdominal",now());
insert into clasificacioncintura values(3,"Obesidad Abdominal",now());

create table medidasantropometricas(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    peso float not null,
    talla float not null,
    pcee float not null,
    pe int not null references pe(id),
    pt int not null references pt(id),
    te int not null references te(id),
    imc float not null,
    clasifimc float not null,
    pce float not null,
    clasificacioncintura int not null references clasificacioncintura(id),
    registro datetime not null default current_timestamp
);

/*----------------------------Agenda
-------------Dias feriados*/
create table diasferiado(
    id int not null auto_increment primary key,
    periodo int not null,
    fecha date not null,
    descripcion varchar(200) not null
);

/*-------------Disponibilidad*/
create table disponibilidad(
    id int not null auto_increment primary key,
    usuario int not null references usuarios(id),
    empresa int not null references empresa(id),
    fecha date not null,
    horainicio time not null,
    horafin time not null,
    intervalo int not null,
    estado int not null default 1,
    registro datetime not null default current_timestamp    
);

/********************Horarios***************/
create table horarios(
    id int not null auto_increment primary key,
    usuario int not null references usuarios(id),
    empresa int not null references empresa(id),
    fecha date not null,
    horainicio time not null,
    horafin time not null,
    intervalo int not null,
    disponibilidad int not null references disponibilidad(id),
    estado int not null default 1,
    registro datetime not null default current_timestamp    
);

create table atenciones(
    id int not null auto_increment primary key,
    paciente int not null references pacientes(id),
    horario int not null references horarios(id),
    observacion text null,
    estado int not null default 1,
    registro datetime not null default current_timestamp
);