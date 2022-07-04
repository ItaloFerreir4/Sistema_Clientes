CREATE DATABASE Sistema;

USE Sistema;

CREATE TABLE Clientes
(
	idCliente	int	not	null	primary	key	auto_increment,
	nomeCliente varchar(50) not null,
    nascimento date	not	null,
    cpf	varchar(15)	not	null unique,
    celular	varchar(15) not null,
    email	varchar(100)	not	null,
    observacao	varchar(300)
);