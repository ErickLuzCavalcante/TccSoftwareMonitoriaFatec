-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.17-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para softwaredemonitoria
CREATE DATABASE IF NOT EXISTS `softwaredemonitoria` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `softwaredemonitoria`;

-- Copiando estrutura para tabela softwaredemonitoria.alunos
CREATE TABLE IF NOT EXISTS `alunos` (
  `raAluno` varchar(20) NOT NULL DEFAULT '',
  `CPFUsuario` varchar(11) DEFAULT NULL,
  `monitorAluno` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`raAluno`),
  UNIQUE KEY `CPFUsuario` (`CPFUsuario`),
  CONSTRAINT `FK_alunos_usuarios` FOREIGN KEY (`CPFUsuario`) REFERENCES `usuarios` (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.atualizacoes
CREATE TABLE IF NOT EXISTS `atualizacoes` (
  `codigoRascunho` int(11) DEFAULT NULL,
  `codigoMaterial` int(11) DEFAULT NULL,
  `descricaoUpdate` varchar(50) DEFAULT NULL,
  `personaUpdate` varchar(50) DEFAULT NULL,
  `dataUpdate` date DEFAULT NULL,
  KEY `FK_updates_rascunhos` (`codigoRascunho`),
  KEY `FK_updates_materiais` (`codigoMaterial`),
  CONSTRAINT `FK_updates_materiais` FOREIGN KEY (`codigoMaterial`) REFERENCES `materiais` (`codigoMaterial`),
  CONSTRAINT `FK_updates_rascunhos` FOREIGN KEY (`codigoRascunho`) REFERENCES `rascunhos` (`codigoRascunho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.disciplinas
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `codigoDisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `nomeDisciplina` varchar(50) NOT NULL,
  `imagemDisciplina` text NOT NULL,
  `sobreDisciplina` text NOT NULL,
  `professorDisciplina` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigoDisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.materiais
CREATE TABLE IF NOT EXISTS `materiais` (
  `codigoMaterial` int(11) NOT NULL,
  `tituloMaterial` varchar(255) NOT NULL DEFAULT '',
  `conteudoMaterial` text NOT NULL,
  `dataCriacaoMaterial` text NOT NULL,
  PRIMARY KEY (`codigoMaterial`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.rascunhos
CREATE TABLE IF NOT EXISTS `rascunhos` (
  `codigoRascunho` int(11) NOT NULL,
  `tituloRascunho` varchar(255) NOT NULL DEFAULT '',
  `conteudoRascunho` text NOT NULL,
  `dataCriacaoRascunho` text NOT NULL,
  `codigoDisciplina` int(11) DEFAULT NULL,
  `CPFUsuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigoRascunho`),
  KEY `FK_rascunhos_disciplinas` (`codigoDisciplina`),
  KEY `FK_rascunhos_usuarios` (`CPFUsuario`),
  CONSTRAINT `FK_rascunhos_disciplinas` FOREIGN KEY (`codigoDisciplina`) REFERENCES `disciplinas` (`codigoDisciplina`),
  CONSTRAINT `FK_rascunhos_usuarios` FOREIGN KEY (`CPFUsuario`) REFERENCES `usuarios` (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `CPFUsuario` varchar(50) NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `sobrenomeUsuario` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(12) DEFAULT NULL,
  `emailUsuario` varchar(320) NOT NULL,
  `palavraChaveUsuario` text DEFAULT NULL,
  PRIMARY KEY (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
