create database if not exists cookevents;

use cookevents;

create table if not exists eventi
(	nome varchar(255),
	data_ DATE,
	descrizione varchar(1000),
	PRIMARY KEY (nome)
);

create table if not exists cuochi
(	nome varchar(255),
	descrizione varchar(1000),
	PRIMARY KEY (nome)
);

create table if not exists piatti
(	nome varchar(255),
	autore varchar(255),
	descrizione varchar(1000),
	evento varchar(255),
	numlike int default 0,
	numdislike int default 0,
	PRIMARY KEY (nome),
	FOREIGN KEY (autore) REFERENCES cuochi(nome),
	FOREIGN KEY (evento) REFERENCES eventi(nome)
);