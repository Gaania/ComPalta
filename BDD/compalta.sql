-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-04-2024 a las 18:18:48
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `compalta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

DROP TABLE IF EXISTS `comida`;
CREATE TABLE IF NOT EXISTS `comida` (
  `comidaID` int(11) NOT NULL AUTO_INCREMENT,
  `restauranteID` int(11) NOT NULL,
  `tipoComidaID` int(11) NOT NULL,
  `momentoDiaID` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ingredienteID` int(11) NOT NULL,
  PRIMARY KEY (`comidaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE IF NOT EXISTS `direccion` (
  `direccionID` int(11) NOT NULL AUTO_INCREMENT,
  `calle1` int(50) NOT NULL,
  `calle2` int(50) DEFAULT NULL,
  `altura` int(11) NOT NULL,
  PRIMARY KEY (`direccionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `favoritoID` int(11) NOT NULL AUTO_INCREMENT,
  `restauranteID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `comentario` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`favoritoID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
CREATE TABLE IF NOT EXISTS `ingrediente` (
  `ingredienteID` int(11) NOT NULL AUTO_INCREMENT,
  `ingrediente` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `comidaID` int(11) NOT NULL,
  `tipoIngredienteID` int(11) NOT NULL,
  PRIMARY KEY (`ingredienteID`),
  UNIQUE KEY `ingrediente` (`ingrediente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `momentodia`
--

DROP TABLE IF EXISTS `momentodia`;
CREATE TABLE IF NOT EXISTS `momentodia` (
  `momentoDiaID` int(11) NOT NULL AUTO_INCREMENT,
  `momento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`momentoDiaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntaje`
--

DROP TABLE IF EXISTS `puntaje`;
CREATE TABLE IF NOT EXISTS `puntaje` (
  `puntajeID` int(11) NOT NULL AUTO_INCREMENT,
  `puntaje` tinyint(4) NOT NULL,
  `comidaID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `comentario` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`puntajeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

DROP TABLE IF EXISTS `restaurante`;
CREATE TABLE IF NOT EXISTS `restaurante` (
  `restauranteID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `direccionID` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `instagram` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`restauranteID`),
  UNIQUE KEY `instagram` (`instagram`),
  UNIQUE KEY `nombre` (`nombre`),
  UNIQUE KEY `direccionID` (`direccionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempodecomida`
--

DROP TABLE IF EXISTS `tiempodecomida`;
CREATE TABLE IF NOT EXISTS `tiempodecomida` (
  `tiempoDeComidaID` int(11) NOT NULL AUTO_INCREMENT,
  `momentoDiaID` int(11) NOT NULL,
  `comidaID` int(11) NOT NULL,
  PRIMARY KEY (`tiempoDeComidaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocomida`
--

DROP TABLE IF EXISTS `tipocomida`;
CREATE TABLE IF NOT EXISTS `tipocomida` (
  `tipoComidaID` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`tipoComidaID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoingrediente`
--

DROP TABLE IF EXISTS `tipoingrediente`;
CREATE TABLE IF NOT EXISTS `tipoingrediente` (
  `tipoIngredienteID` int(11) NOT NULL AUTO_INCREMENT,
  `tipoIngrediente` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`tipoIngredienteID`),
  UNIQUE KEY `tipoIngrediente` (`tipoIngrediente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `tipoUsuarioID` int(11) NOT NULL AUTO_INCREMENT,
  `tipoUsuario` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`tipoUsuarioID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuarioID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(12) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fechaCreacion` date NOT NULL,
  PRIMARY KEY (`usuarioID`),
  UNIQUE KEY `nom` (`nombre`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
