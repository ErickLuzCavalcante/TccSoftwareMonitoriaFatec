

CREATE DATABASE IF NOT EXISTS `softwaredemonitoria`;
USE `softwaredemonitoria`;



CREATE TABLE IF NOT EXISTS `disciplinas` (
  `codigoDisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `nomeDisciplina` varchar(50) NOT NULL,
  `imagemDisciplina` text NOT NULL,
  `sobreDisciplina` text NOT NULL,
  `professorDisciplina` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigoDisciplina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `materiais` (
  `codigoMaterial` int(11) NOT NULL,
  `tituloMaterial` varchar(255) NOT NULL DEFAULT '',
  `conteudoMaterial` text NOT NULL,
  `dataCriacaoMaterial` text NOT NULL,
  PRIMARY KEY (`codigoMaterial`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;



CREATE TABLE IF NOT EXISTS `usuarios` (
  `CPFUsuario` varchar(50) NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `sobrenomeUsuario` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(12) DEFAULT NULL,
  `emailUsuario` varchar(320) NOT NULL,
  `palavraChaveUsuario` text DEFAULT NULL,
  PRIMARY KEY (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `alunos` (
  `raAluno` varchar(20) NOT NULL DEFAULT '',
  `CPFUsuario` varchar(11) DEFAULT NULL,
  `monitorAluno` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`raAluno`),
  UNIQUE KEY `CPFUsuario` (`CPFUsuario`),
  CONSTRAINT `FK_alunos_usuarios` FOREIGN KEY (`CPFUsuario`) REFERENCES `usuarios` (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rascunhos` (
  `codigoRascunho` int(11) NOT NULL AUTO_INCREMENT,
  `tituloRascunho` varchar(255) NOT NULL DEFAULT '',
  `conteudoRascunho` text NOT NULL,
  `dataCriacaoRascunho` text NOT NULL,
  `codigoDisciplina` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigoRascunho`),
  KEY `FK_rascunhos_disciplinas` (`codigoDisciplina`),
  CONSTRAINT `FK_rascunhos_disciplinas` FOREIGN KEY (`codigoDisciplina`) REFERENCES `disciplinas` (`codigoDisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `atualizacoes` (
  `codigoRascunho` int(11) DEFAULT NULL,
  `codigoMaterial` int(11) DEFAULT NULL,
  `descricaoAtualizacoes` varchar(50) DEFAULT NULL,
  `personaAtualizacoes` varchar(50) DEFAULT NULL,
  `dataAtualizacoes` date DEFAULT NULL,
  KEY `FK_updates_rascunhos` (`codigoRascunho`),
  KEY `FK_updates_materiais` (`codigoMaterial`),
  CONSTRAINT `FK_updates_materiais` FOREIGN KEY (`codigoMaterial`) REFERENCES `materiais` (`codigoMaterial`),
  CONSTRAINT `FK_updates_rascunhos` FOREIGN KEY (`codigoRascunho`) REFERENCES `rascunhos` (`codigoRascunho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


