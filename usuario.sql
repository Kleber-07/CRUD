create database usuario;
use usuario;

create table usuario(
	id int auto_increment,
    nome varchar(30),
    idade int,
    cpf int,
    senha varchar(10),
    primary key(id)
);


insert into usuario(nome,idade,cpf,senha) values ("Kleber", 20,999,123);

insert into usuario(nome,idade,cpf,senha) values ("junio", 20,999,123);
select * from usuario;

drop table usuario;

select count(id) as num from usuario where nome="junio" and senha=123;
