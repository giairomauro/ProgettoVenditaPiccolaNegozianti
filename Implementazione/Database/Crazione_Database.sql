create database if not exists efof_gestvend;

use efof_gestvend;

create table cliente(
email varchar(50) primary key not null,
nome varchar(50) not null,
cognome varchar(50) not null,
password varchar(500) not null,
telefono varchar(20) not null
);

create table if not exists amministratore(
email varchar(50) primary key not null,
nome varchar(50) not null,
cognome varchar(50) not null,
password varchar(500) not null,
telefono varchar(20) not null
);

create table if not exists gestore(
email varchar(50) primary key,
nome varchar(50) not null,
cognome varchar(50) not null,
password varchar(500) not null,
telefono varchar(20) not null
);

create table if not exists categoria(
nome varchar(50) primary key
);

create table if not exists prodotto(
nome varchar(50) primary key,
prezzo float default 0.0,
quantita int default 0,

nome_categoria varchar(50),
foreign key (nome_categoria) references categoria(nome) on update cascade on delete set null
);

create table if not exists negozio(
nome varchar(50),
indirizzo varchar(50),
citta varchar(50),
telefono varchar(20) not null,
archiviato bit(1) default 0,

primary key(nome, indirizzo, citta),

email_gestore varchar(50),
foreign key (email_gestore) references gestore(email) on update cascade on delete set null
);

create table if not exists luogo_ritiro(
id int primary key auto_increment,
indirizzo varchar(50) not null,
citta varchar(50) not null,
nome varchar(50) not null,
telefono varchar(20) not null,
email varchar(50) not null
);

create table if not exists compra(
data date,
nome_prodotto varchar(50),
email_cliente varchar(50),
id_luogo_ritiro int,
data_entrata_merce date,
data_ritiro date,
data_ritorno date,
acquistato bit(1) default 0,

foreign key (nome_prodotto) references prodotto(nome),
foreign key (email_cliente) references cliente(email),
foreign key (id_luogo_ritiro) references luogo_ritiro(id),

primary key (data, nome_prodotto, email_cliente)
);