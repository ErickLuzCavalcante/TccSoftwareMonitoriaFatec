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
  PRIMARY KEY (`raAluno`),
  UNIQUE KEY `CPFUsuario` (`CPFUsuario`),
  CONSTRAINT `FK_alunos_usuarios` FOREIGN KEY (`CPFUsuario`) REFERENCES `usuarios` (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.disciplinas
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `codigoDisciplina` int(11) NOT NULL,
  `nomeDisciplina` varchar(50) NOT NULL,
  `imagemDisciplina` text NOT NULL,
  `sobreDisciplina` text NOT NULL,
  PRIMARY KEY (`codigoDisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.monitores
CREATE TABLE IF NOT EXISTS `monitores` (
  `raAluno` varchar(20) NOT NULL,
  UNIQUE KEY `raAluno` (`raAluno`),
  CONSTRAINT `FK_monitores_alunos` FOREIGN KEY (`raAluno`) REFERENCES `alunos` (`raAluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.rascunhos
CREATE TABLE IF NOT EXISTS `rascunhos` (
  `codigoRascunho` int(11) NOT NULL,
  `tituloRascunho` varchar(255) NOT NULL DEFAULT '',
  `conteudoRascunho` text NOT NULL,
  `dataCriacaoRascunho` text NOT NULL,
  PRIMARY KEY (`codigoRascunho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela softwaredemonitoria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `CPFUsuario` varchar(50) NOT NULL,
  `nomeUsuario` varchar(50) NOT NULL,
  `sobrenomeUsuario` varchar(50) NOT NULL,
  `telefoneUsuario` varchar(12) DEFAULT NULL,
  `emailUsuario` varchar(320) NOT NULL,
  PRIMARY KEY (`CPFUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
