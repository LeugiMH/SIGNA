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
-- SELECT * FROM TBADMIN
-- INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Miguel Henrique','12211212','teste@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
-- INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) VALUES ('Nathaly Valim','777777','teste2@teste.com','$2y$10$9IKKozNeJvhfIDv/DReS0uIPdcWQNBCnkKpu21cVoLtiuVM6i1rVO','17/08/2024','1')
delete tbadmin
GO
CREATE TABLE TBESPECIE
(
	IDESPECIE INT IDENTITY(1,1),												 -- ID ESPÉCIE
	NOMECIE VARCHAR(256),						                                 -- NOME CIENTÍFICO
	NOMEPOP VARCHAR(256),						                                 -- NOME POPULAR
	FAMILIA VARCHAR(256),						                                 -- FAMÍLIA
	HABITAT VARCHAR(256),						                                 -- HABITAT NATURAL
	ALTURA VARCHAR(4),							                                 -- ALTURA DA MÁXIMA DA PLANTA
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
	IDESPECIE INT,																					-- ESPÉCIE
	DATPLANT SMALLDATETIME,																			-- DATA DE PLANTIU
	DATACAD SMALLDATETIME,																			-- DATA DE CADASTRO					
	IMAGEM VARCHAR(256),																			-- ENDEREÇO DA IMAGEM
	DESCRICAOIMG VARCHAR(256),																		-- DESCRIÇÃO IMAGEM (AUDIODESCRIÇÃO)
	ESTADO VARCHAR(1),																				-- STATUS (DEFINIR)
	COORD VARCHAR(MAX),																				-- COORDENADAS
	DAP DECIMAL(4,2),																				-- DIÂMETRO NA ALTURA DO PEITO
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