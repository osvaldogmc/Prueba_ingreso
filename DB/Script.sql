create database prueba_ingreso;
use prueba_ingreso;

create table region(
	id int not null auto_increment,
	nombre varchar(200) not null,
	primary key(id) 
);

create table comuna(
	id int not null auto_increment,
	nombre varchar(200) not null,
	id_region int,
	foreign key(id_region) references region(id),
	primary key(id)
);

create table candidato(
	id int not null auto_increment,
	nombre varchar(200) not null,
	primary key(id)
);

create table voto (
	id int not null auto_increment,
	nombre_apellido varchar(500) not null,
	alias varchar(200) not null,
	rut int not null unique,
	email varchar(200) not null,
	ind_web boolean,
	ind_tv boolean,
	ind_red_social boolean,
	ind_amigo boolean,
	id_comuna int,
	id_candidato int,
	foreign key(id_comuna) references comuna(id),
	foreign key(id_candidato) references candidato(id),
	primary key(id)
);

insert into region (nombre) values
('REGION METROPOLITANA'),
('REGION DE LOS RIOS');

insert into comuna (nombre, id_region) values
('SANTIAGO', 1),
('SAN MIGUEL', 1),
('VALDIVIA', 2),
('PANGUIPULLI', 2);

insert into candidato (nombre) values
('SEBASTIAN PIÑERA'),
('MICHELLE BACHELET'),
('RICARDO LAGOS');



