/*
	USE MASTER
	GO
	DROP DATABASE SIGNA 
*/
SELECT @@SERVERNAME
GO
CREATE DATABASE SIGNA
GO
USE SIGNA
GO
CREATE TABLE TBADMIN
(
	IDADMIN INT IDENTITY(1,1) NOT NULL,															-- ID USUÁRIO
	NOME VARCHAR(256) NOT NULL,																	-- NOME
	MATRICULA VARCHAR(256) NOT NULL,															-- MATRÍCULA (DEFINIR TAMANHO)
	EMAIL VARCHAR(256) NOT NULL UNIQUE,																
	SENHA VARCHAR(256) NOT NULL,																-- SENHA (CRIPTOGRAFADA)
	CODRECUPERACAO INT, 																		-- Código de recuperação 
	DATACAD SMALLDATETIME NOT NULL,
	ESTADO VARCHAR(1),																			-- STATUS (DEFINIR)
	CONSTRAINT TBADMIN_PK PRIMARY KEY (IDADMIN)
)
GO
CREATE TABLE TBESPECIE
(
	IDESPECIE INT IDENTITY(1,1),												 -- ID ESPÉCIE
	NOMECIE VARCHAR(256),						                                 -- NOME CIENTÍFICO
	NOMEPOP VARCHAR(256),						                                 -- NOME POPULAR
	FAMILIA VARCHAR(256),						                                 -- FAMÍLIA
	HABITAT VARCHAR(max),						                                 -- HABITAT NATURAL
	ALTURA DECIMAL(5,2),							                             -- ALTURA DA MÁXIMA DA PLANTA (999.99)
	IMAGEM VARCHAR(256),						                                 -- ENDEREÇO DA IMAGEM
	DESCRICAOIMG VARCHAR(256),					                                 -- DESCRIÇÃO IMAGEM (AUDIODESCRIÇÃO)
	DATACAD SMALLDATETIME,						                                 -- DATA DE CADASTRO
	IDCADADM INT, 
	CONSTRAINT TBESPECIE_PK PRIMARY KEY (IDESPECIE),
	CONSTRAINT TBESPECIE_FK_TBADMIN FOREIGN KEY (IDCADADM) REFERENCES TBADMIN(IDADMIN)
)
GO
CREATE TABLE TBATRIBUTO
(
	IDATRIBUTO INT IDENTITY(1,1),												
	NOMEATRIBUTO VARCHAR(50),																		-- EX: Flor
	CONSTRAINT TBATRIBUTO_PK PRIMARY KEY (IDATRIBUTO)
)
GO
CREATE TABLE TBATRI_ESPECIE
(
	IDESPECIE INT,
	IDATRIBUTO INT,
	DESCRICAO VARCHAR(256),																			-- EX: flor preta com pintas brancas
	CONSTRAINT TBATRI_ESPECIE_PK PRIMARY KEY CLUSTERED (IDESPECIE,IDATRIBUTO),
	CONSTRAINT TBATRI_ESPECIE_FK_TBESPECIE FOREIGN KEY (IDESPECIE) REFERENCES TBESPECIE(IDESPECIE),
	CONSTRAINT TBATRI_ESPECIE_FK_TBATRIBUTO FOREIGN KEY (IDATRIBUTO) REFERENCES TBATRIBUTO(IDATRIBUTO)
)
GO
CREATE TABLE TBESPECIME
(
	IDESPECIME INT IDENTITY(1,1),																	-- ID ESPÉCIME
	IDESPECIE INT NOT NULL,																			-- ESPÉCIE
	COORD VARCHAR(50),																				-- COORDENADAS
	IMAGEM VARCHAR(256),																			-- ENDEREÇO DA IMAGEM
	DESCRICAOIMG VARCHAR(256),																		-- DESCRIÇÃO IMAGEM (AUDIODESCRIÇÃO)
	ESTADO CHAR(1),																					-- STATUS (DEFINIR)
	DAP DECIMAL(4,2),																				-- DIÂMETRO NA ALTURA DO PEITO
	DATPLANT SMALLDATETIME,																			-- DATA DE PLANTIU
	DATACAD SMALLDATETIME,																			-- DATA DE CADASTRO					
	IDCADADM INT,																					-- ID DO USUÁRIO
	CONSTRAINT TBESPECIME_PK PRIMARY KEY (IDESPECIME),
	CONSTRAINT TBESPECIME_FK_TBESPECIE FOREIGN KEY (IDESPECIE) REFERENCES TBESPECIE(IDESPECIE),
	CONSTRAINT TBESPECIME_FK_TBADMIN FOREIGN KEY (IDCADADM) REFERENCES TBADMIN(IDADMIN)
)
GO
CREATE TABLE TBLOGEXEC
(
	IDLOG INT IDENTITY(1,1),																		-- ID LOG
	IDADMIN INT,																					-- ID DO USUÁRIO
	DATALOG DATETIME,																				-- DATA LOG
	SERVEXEC VARCHAR(256),																			-- NOME DA MÁQUINA DO EXECUTANTE (PHP gethostname()?)
	EXECUCAO VARCHAR(1),																			-- (C/R/U/D)
	TABELA VARCHAR(256),																			-- (TBESPECIME/TBESPECIE/TBADMIN/TBFEEDBACK)
	IDAFETADO INT,																					-- ID AFETADO 
	SQLTXT VARCHAR(256),																				-- TEXTO 
	CONSTRAINT TBLOGEXEC_PK PRIMARY KEY (IDLOG),
	CONSTRAINT TBLOGEXEC_FK_TBADMIN FOREIGN KEY (IDADMIN) REFERENCES TBADMIN(IDADMIN)
)
GO
CREATE TABLE TBBI -- BI
(
	IDACESSO INT IDENTITY(1,1),																		-- ID ACESSO
	DATAACESSO SMALLDATETIME,																		-- DATA DE ACESSO
	PAGACESS INT,																					-- PÁGINA ACESSADA
	SERVEXEC VARCHAR(256),																			-- NOME DA MÁQUINA DO ACESSO (PHP gethostname()?)
	TPPLATFORM VARCHAR(256),																		-- PLATAFORMA ($_SERVER['HTTP_SEC_CH_UA_PLATFORM'])
	TPMODELO VARCHAR(256),																			-- MODELO ($_SERVER['HTTP_SEC-CH-UA-MODEL'])
	TPBROWSER VARCHAR(256),																			-- BROWSER ($_SERVER['HTTP_SEC_CH_UA'])
	CONSTRAINT TBBI_PK PRIMARY KEY (IDACESSO)
)
GO
CREATE TABLE TBASSUNTO
(
	IDASSUNTO INT IDENTITY(1,1),
	DESCRICAO VARCHAR(256),
	CONSTRAINT TBASSUNTO_PK PRIMARY KEY (IDASSUNTO)
)

GO
CREATE TABLE TBFEEDBACK
(
	IDFEEDBACK INT IDENTITY(1,1),																	-- ID FEEDBACK
	DATACAD SMALLDATETIME,
	IDESPECIME INT,																					-- ID FEEDBACK
	AVALIACAO CHAR(1),																				-- (1/2/3/4/5) NÍVEL DE SATISFAÇÃO
	IDASSUNTO INT,																					-- TIPO DE ASSUNTO DO FEDDBACK (DEFINIR)
	TEXTO VARCHAR(MAX),																				-- TEXTO DO FEEDBACK 
	EMAIL VARCHAR(256),																				-- EMAIL DA PESSOA
	IDADMIN INT,																					-- ID FEEDBACK
	COMENT_ADMIN VARCHAR(MAX),
	TPUSUARIO CHAR(1),																				-- (0 = VISITANTE, 1 = ALUNO, 2 = PROFESSOR)
	CONSTRAINT TBFEEDBACK_PK PRIMARY KEY (IDFEEDBACK),
	CONSTRAINT TBFEEDBACK_FK_TBESPECIME FOREIGN KEY (IDESPECIME) REFERENCES TBESPECIME (IDESPECIME),
	CONSTRAINT TBFEEDBACK_FK_TBADMIN FOREIGN KEY (IDADMIN) REFERENCES TBADMIN (IDADMIN),
	CONSTRAINT TBFEEDBACK_FK_TBASSUNTO FOREIGN KEY (IDASSUNTO) REFERENCES TBASSUNTO (IDASSUNTO)
)

/* Conteúdo */

-- DELETE TBADMIN
INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Miguel Henrique','12211212','teste@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Nathaly Valim','777777','teste2@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Carolina Mattiazzo','11112','teste3@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Alessandra Aragão','11114','teste4@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('User Teste','11133','teste5@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','0')
SELECT * FROM TBADMIN
GO
-- DELETE TBESPECIE
INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) VALUES ('Paubrasilia echinata','Pau-Brasil','Fabaceae','Seu habitat natural é a floresta ombrófila densa da Mata Atlântica, a partir do extremo nordeste do Brasil até o Rio de Janeiro, ou seja, os estados do Rio Grande do Norte, Paraíba, Pernambuco, Alagoas, Sergipe, Bahia, Espírito Santo e Rio de Janeiro.',15.00,'pauBrasil.webp','Imagem de um Pau-Brasil','27/08/2024',1)
INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) VALUES ('Eugenia brasiliensis Lam','Grumixamao','Myrtaceae',' Árvore de até 15 metros de altura, nativa das matas primárias desde a Bahia até Santa Catarina, em mata aluviais e encostas suaves, é, hoje, rara. Possuem três variedades, a xaneira anã, xaneira amarela e a xaneira grande. Seus frutos - pequenas bagas esféricas roxas-escuras, com polpa aquosa levemente ácida e de uma ou duas sementes',15.00,'grumixama.webp','Imagem de Grumixama','27/08/2024',2)
INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) VALUES ('Handroanthus chrysotricus','Ipê-amarelo','Bignoniaceae',' É muito conhecido por sua beleza, exuberância das flores e ampla distribuição em todas as regiões do Brasil. Os ipês são caducifólias, ou seja, perdem todas as folhas que são substituídas por cachos de flores de cores intensas. São árvores de grande porte que gostam de calor e sol pleno.',14.00,'ypeAmarelo.jpg','Imagem de Ipê Amarelo','27/08/2024',2)
INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) VALUES ('Pseudobombax grandiflorum','Imbiruçu','Malvaceae','Flores brancas muito bonitas, geralmente aparecem com a árvore sem folhas. Fruto capsula que se abre mostrando sementes pequenas, envoltas em paina marrom. Germinação fácil, desenvolvimento da muda rápido.',25.00,'imbiruçu.jpg','Imagem de Imbiruçu','27/08/2024',2)
INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) VALUES ('Leucochloron incuriale','Angico rajado','Fabaceae','Possui glândulas secretoras de néctar; tronco possui cortiças salientes e é utilizada em ações de reflorestamento e devido sua madeira resistente, ele pode ser utilizado na construção civil',25.00,'angicoRajado.webp','Imagem de Angico Rajado','27/08/2024',2)
SELECT * FROM TBESPECIE
GO
-- DELETE FROM TBESPECIME
INSERT INTO TBESPECIME (IDESPECIE,DATPLANT,DATACAD,IMAGEM,DESCRICAOIMG,ESTADO,COORD,DAP,IDCADADM) VALUES (1,'21-08-2024','21-09-2024',NULL,NULL,'1','-23.3363083, -46.7218591',15,1)
INSERT INTO TBESPECIME (IDESPECIE,DATPLANT,DATACAD,IMAGEM,DESCRICAOIMG,ESTADO,COORD,DAP,IDCADADM) VALUES (2,'28-08-2024','28-08-2024',NULL,NULL,'1','-23.3365201, -46.7226419',15,1)
SELECT * FROM TBESPECIME
GO
-- DELETE FROM TBATRIBUTO
INSERT INTO TBATRIBUTO (NOMEATRIBUTO) VALUES ('Uso Comercial')
INSERT INTO TBATRIBUTO (NOMEATRIBUTO) VALUES ('Flor')
INSERT INTO TBATRIBUTO (NOMEATRIBUTO) VALUES ('Fruto')
INSERT INTO TBATRIBUTO (NOMEATRIBUTO) VALUES ('Importância Histórica')
INSERT INTO TBATRIBUTO (NOMEATRIBUTO) VALUES ('Curiosidades')
GO
SELECT * FROM TBATRIBUTO
-- DELETE FROM TBASSUNTO
INSERT INTO TBASSUNTO (DESCRICAO) VALUES ('Informações incorretas')
INSERT INTO TBASSUNTO (DESCRICAO) VALUES ('Mal funcionamento do site')
INSERT INTO TBASSUNTO (DESCRICAO) VALUES ('Acessibilidade não funcionando')
INSERT INTO TBASSUNTO (DESCRICAO) VALUES ('Outros')
SELECT * FROM TBASSUNTO