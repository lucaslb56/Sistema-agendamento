
-- Pagina sem funcionalidade, somente pra salvar os codigos de criação de base de dados

CREATE DATABASE cordlab;

CREATE TABLE usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nomecompleto VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    telefone VARCHAR(50),
    senha VARCHAR(30) NOT NULL,
    permissão VARCHAR(30) NOT NULL,
    turma VARCHAR(30),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

INSERT INTO usuarios (nomecompleto, email, telefone, senha, permissão)
VALUES ('Administrador', 'admistrador123@gmail.com', '9494949494', '123', '3');

CREATE TABLE agendamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nomecompleto VARCHAR(30) NOT NULL,
    Area VARCHAR(30) NOT NULL,
    Sala VARCHAR(50) NOT NULL,
    Dia DATE,
    Especificações VARCHAR(300),
    Coments VARCHAR(300),
    Comeco TIME NOT NULL,
    Termino TIME NOT NULL,
    InicioEx DATE,
    FimEx DATE,
    Semanal VARCHAR(300),
    Usuario VARCHAR(30),
    Tipo VARCHAR(30),
    Permissão VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

CREATE TABLE Salas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Sala VARCHAR(30) NOT NULL,
    Area VARCHAR(30) NOT NULL,
); 