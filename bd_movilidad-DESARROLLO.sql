-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-06-2024 a las 20:40:16
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_movilidad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion_tipo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `resultados` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `responsable` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo_empleado` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion_tipo_empleado` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `duracion` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `pais` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `inst_ent_nacs` bigint UNSIGNED DEFAULT NULL,
  `inst_ent_ints` bigint UNSIGNED DEFAULT NULL,
  `doc_soporte` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `movilidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `tipo`, `descripcion_tipo`, `resultados`, `responsable`, `documento`, `tipo_empleado`, `descripcion_tipo_empleado`, `duracion`, `pais`, `inst_ent_nacs`, `inst_ent_ints`, `doc_soporte`, `movilidad`) VALUES
(8, 'Clase Espejo', 'Clase espejo', 'Promocion de temas nuevos', 'ANGIE CACERES', '123456789', 'Docente', 'Docente de ingenieria ambiental', '2 Meses', 'Colombia', 6, NULL, '', 9),
(9, 'Webinar', 'Webinar de prueba', 'Aprendizaje nativo', 'NANCY CAROLINA', '123456789', 'Docente', 'Docente de ingenieria ambiental', '1 Dias', 'Colombia', NULL, 4, '', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_asistentes`
--

CREATE TABLE `actividades_asistentes` (
  `id` bigint UNSIGNED NOT NULL,
  `documento` bigint UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `programa_academico` bigint UNSIGNED NOT NULL,
  `periodo_academico` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo_institucional` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `numero_telefono` bigint DEFAULT NULL,
  `actividad_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `actividades_asistentes`
--

INSERT INTO `actividades_asistentes` (`id`, `documento`, `nombre`, `programa_academico`, `periodo_academico`, `correo_institucional`, `numero_telefono`, `actividad_id`) VALUES
(3, 1006582622, 'ANDRES PABON', 14, '2021-2', 'andrescpabon@uts.edu.co', NULL, 9),
(11, 1005152835, 'JHON GOMEZ', 4, '2024-1', 'jhonsebastiangomez@uts.edu.co', NULL, 9),
(12, 1007541236, 'LAURA PINZON', 10, '2023-1', 'lpinzon@uts.edu.co', 3124561214, 9),
(13, 1005152835, 'JHON GOMEZ', 4, '2024-1', 'jhonsebastiangomez@uts.edu.co', NULL, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_sesiones`
--

CREATE TABLE `auditoria_sesiones` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_ints`
--

CREATE TABLE `convenio_ints` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaInicio` date NOT NULL,
  `tipo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `breve_objeto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `activo` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vigencia` date NOT NULL,
  `docSoportes` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `instEntInt_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resultados_concretos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_usuarios` int DEFAULT '0',
  `es_nacional` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `convenio_ints`
--

INSERT INTO `convenio_ints` (`id`, `codigo`, `fechaInicio`, `tipo`, `breve_objeto`, `activo`, `vigencia`, `docSoportes`, `estado`, `instEntInt_id`, `user_id`, `created_at`, `updated_at`, `resultados_concretos`, `n_usuarios`, `es_nacional`) VALUES
(3, '310-1000', '2024-05-26', 'Practicas', 'Breve objeto', 'Sí', '2024-06-26', '1716760490_Ejercicio no balanceado.pdf', 1, 5, 1, '2024-05-27 02:54:50', '2024-06-10 19:23:37', 'Resultados', 0, 0),
(4, '310-1001', '2024-05-27', 'Interadministrativo', 'Breve', 'Sí', '2024-05-30', '1716819874_Ejercicio no balanceado.pdf', 1, 3, 1, '2024-05-27 19:24:34', '2024-05-27 19:25:09', 'Res', 0, 0),
(6, '310-1002', '2024-06-15', 'Interadministrativo', 'Breve', 'Sí', '2024-06-22', '1717874286_Ejercicio de repaso.pdf', 1, 3, 1, '2024-06-09 00:18:06', '2024-06-09 00:18:06', 'Res', 0, 0),
(12, '310-1003', '2024-06-11', 'Especifico', 'Objetivo', 'Sí', '2024-06-12', '1718137477_Ejercicio de repaso.pdf', 1, 3, 1, '2024-06-12 01:24:37', '2024-06-12 01:36:21', 'Resultados', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_nacs`
--

CREATE TABLE `convenio_nacs` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaInicio` date NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `breve_objeto` text COLLATE utf8mb4_unicode_ci,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vigencia` date NOT NULL,
  `docSoportes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `instEntNac_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resultados_concretos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_usuarios` int DEFAULT '0',
  `es_nacional` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `convenio_nacs`
--

INSERT INTO `convenio_nacs` (`id`, `codigo`, `fechaInicio`, `tipo`, `breve_objeto`, `activo`, `vigencia`, `docSoportes`, `estado`, `instEntNac_id`, `user_id`, `created_at`, `updated_at`, `resultados_concretos`, `n_usuarios`, `es_nacional`) VALUES
(10, '310-1000', '2024-05-14', 'Marco', 'Celebrar un convenio marco de cooperacion interinstitucional de actividades de investigacion y extension, a travez de proyectos de consultoria y asesoria cientifica con el ctia', 'Sí', '2026-05-13', '1715721228_Doc_Soporte.pdf', 1, 4, 1, '2024-05-15 02:13:48', '2024-06-12 01:01:31', 'Visitas tecnicas con descuento preferencial para los estudiantes de uts\r\nponencia conversatorio de empresarios en el marco de conais', 0, 1),
(11, '310-1001', '2024-05-14', 'Marco', 'Celebrar un convenio marco de cooperacion interinstitucional de actividades de investigacion y extension, a travez de proyectos de consultoria y asesoria cientifica con el ctia', 'Sí', '2026-05-13', '1715721330_Doc_Soporte.pdf', 1, 5, 1, '2024-05-15 02:15:30', '2024-06-10 19:26:38', 'Ponencia en conversatorio de empresarios en el marco de conais', 2, 1),
(12, '310-1002', '2024-05-27', 'Interadministrativo', 'Breve', 'Sí', '2024-05-30', '1716819773_Ejercicio no balanceado.pdf', 1, 4, 1, '2024-05-27 19:22:53', '2024-05-27 19:22:53', 'Re4s', 0, 1),
(20, '310-1003', '2024-06-20', 'Marco', 'hh', 'Sí', '2024-06-27', '1718138310_Ejercicio de repaso.pdf', 1, 6, 1, '2024-06-12 01:38:30', '2024-06-12 01:38:30', 'hhhh', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_usuarios`
--

CREATE TABLE `convenio_usuarios` (
  `id` int NOT NULL,
  `documento` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `programa_academico` bigint UNSIGNED NOT NULL,
  `periodo_academico` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo_institucional` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `numero_telefono` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_terminacion` date NOT NULL,
  `duracion` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `supervisor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nac_int` tinyint(1) NOT NULL,
  `convenio_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `convenio_usuarios`
--

INSERT INTO `convenio_usuarios` (`id`, `documento`, `nombre`, `programa_academico`, `periodo_academico`, `correo_institucional`, `numero_telefono`, `fecha_inicio`, `fecha_terminacion`, `duracion`, `supervisor`, `nac_int`, `convenio_id`, `created_at`, `updated_at`) VALUES
(4, '1006582622', 'JHON GOMEZ', 10, '8', 'andrescpabon@uts.edu.co', '3175442169', '2024-06-07', '2024-06-08', '4 Horas', NULL, 0, 11, '2024-06-08 05:58:02', '2024-06-11 19:47:48'),
(7, '1006582622', 'ANDRES PABON', 15, '8', 'andrescpabon@uts.edu.co', '3175448972', '2024-06-08', '2024-06-22', '4 Horas', NULL, 0, 17, '2024-06-08 23:26:43', '2024-06-11 19:47:54'),
(16, '1005472156', 'KEVIN CACERES', 4, '8', 'baldion01@gmail.com', '3145789355', '2024-06-16', '2024-06-18', '3 Semanas', 'JUAN PEREZ', 0, 11, '2024-06-10 19:26:38', '2024-06-11 19:48:00'),
(23, '1005152835', 'Jhon Gomez', 27, '8', 'jhonsebatsiangomez@uts.edu.co', '3175442189', '2024-06-11', '2024-06-12', '2 Meses', NULL, 1, 12, '2024-06-12 01:36:21', '2024-06-12 01:36:21'),
(24, '1007845623', 'ANA RONDON', 27, '7', 'arondon@uts.edu.co', '3175446871', '2024-06-18', '2024-06-18', '17 Dias', NULL, 0, 20, '2024-06-12 01:38:30', '2024-06-12 01:39:58'),
(25, '1005152835', 'Jhon Gomz', 29, '9', 'jhonsgomez@uts.edu.co', '317545555', '2024-06-18', '2024-06-18', '1 Horas', '', 0, 20, '2024-06-12 01:38:30', '2024-06-12 01:38:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inst_ent_ints`
--

CREATE TABLE `inst_ent_ints` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representante` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inst_ent_ints`
--

INSERT INTO `inst_ent_ints` (`id`, `nombre`, `pais`, `ciudad`, `nit`, `representante`, `telefono`, `email`, `estado`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'UTS-UCA', 'Argentina', 'Bucaramanga, Santander', '991742815', 'Juan Perez', '63554478', 'uts@uts.edu.co', 1, 1, '2024-05-15 02:18:32', '2024-05-29 02:20:39'),
(4, 'BENITO JUAREZ', 'Mexico', 'Bucaramanga', '123456789', 'Benito Juarez', '605471236', 'bjuares@bjuarez.com', 1, 1, '2024-05-15 02:25:37', '2024-05-28 23:39:41'),
(5, 'CORPORACION BIOTIC', 'Perú', 'Lima', '475896312', 'Juan Perez', '3147852146', 'biotic@correo.edu.pe', 1, 1, '2024-05-15 02:41:07', '2024-05-29 00:26:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inst_ent_nacs`
--

CREATE TABLE `inst_ent_nacs` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representante` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` bigint DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `docSoportes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inst_ent_nacs`
--

INSERT INTO `inst_ent_nacs` (`id`, `nombre`, `ciudad`, `nit`, `representante`, `telefono`, `email`, `docSoportes`, `estado`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'CERVECERIA LOCAL', 'Bucaramanga', '123456789', 'Reinaldo Luna', 3142586475, 'cerveceria@local.com', '1715720764_Doc_Soporte.pdf', 1, 1, '2024-05-15 02:06:04', '2024-05-29 00:23:45'),
(5, 'PRODUCTOS LA VICTORIA', 'Bucaramanga', '147852963', 'Victor Ochoa', 3201456324, 'lavictoria@productos.com', '1715720844_Doc_Soporte.pdf', 1, 1, '2024-05-15 02:07:24', '2024-05-29 00:23:30'),
(6, 'UNIVERSIDAD DE CARTAGENA', 'Cartagena', '145632741', 'Juanita', 3189652416, 'ucartagena@cartagena.edu.co', '1715721985_Doc_Soporte.pdf', 1, 1, '2024-05-15 02:26:25', '2024-05-27 19:37:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad`
--

CREATE TABLE `movilidad` (
  `id` int NOT NULL,
  `documento` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `est_pro` tinyint(1) NOT NULL,
  `inst_ent_nacs` bigint UNSIGNED DEFAULT NULL,
  `inst_ent_ints` bigint UNSIGNED DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `objeto` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `resultados` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `pres_virt` tinyint(1) NOT NULL,
  `ent_sal` tinyint(1) NOT NULL,
  `nac_ext` tinyint(1) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `doc_soporte` text COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `movilidad`
--

INSERT INTO `movilidad` (`id`, `documento`, `nombre`, `est_pro`, `inst_ent_nacs`, `inst_ent_ints`, `pais`, `objeto`, `resultados`, `pres_virt`, `ent_sal`, `nac_ext`, `fecha_inicio`, `fecha_final`, `doc_soporte`) VALUES
(7, '63559380', 'LUZ ELENA RAMIREZ GOMEZ', 1, NULL, 3, 'Argentina', 'Ponencia Internacional \"Evaliacion de la vida util en anaquel de cinco tipos de papa criolla (Solanum phureja), usando enmiendas organicas en la siembra\"', 'Productos para el grupo de investigacion y fortalecimiento de red de conocimiento', 0, 1, 1, '2023-10-03', '2023-10-07', '1715723129_Doc_Soporte.pdf'),
(8, '1098638705', 'NARCY CAROLINA PRIETO', 1, NULL, 4, 'Mexico', 'Ponencia \"modelo economico para la gestion publica san de la san en la celac\"', 'Productos para el grupo de investigacion y fortalecimiento de red de conocimiento', 1, 1, 1, '2023-12-12', '2023-12-13', '1715723369_Doc_Soporte.pdf'),
(9, '1098684130', 'ANGIE MILENE CACERES', 1, 6, NULL, 'Colombia', 'Evaluadora de proyectos de encuentro nacional de semilleros', 'Visibilidad del grupo de investigacion y de la institucion', 1, 1, 0, '2023-10-11', '2023-10-13', '1715723858_Doc_Soporte.pdf'),
(10, '63559380', 'LUZ ELENA RAMIREZ GOMEZ', 1, NULL, 5, 'Perú', 'Ponencia internacional \"un cumplimiento normativo o una cultura hacia la salud publica\"', 'Productos para el grupo de investigacion y fortalecimiento de red de conocimiento', 1, 1, 1, '2023-12-14', '2023-12-15', '1715723993_Doc_Soporte.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad_int_ents`
--

CREATE TABLE `movilidad_int_ents` (
  `id` bigint UNSIGNED NOT NULL,
  `tipoPersona` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colInd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulosOb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `vigencia` date NOT NULL,
  `sedeReg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objeto` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `instEnt_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad_int_sals`
--

CREATE TABLE `movilidad_int_sals` (
  `id` bigint UNSIGNED NOT NULL,
  `tipoPersona` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colInd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulosOb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `vigencia` date NOT NULL,
  `sedeReg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objeto` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `instEnt_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad_nac_ents`
--

CREATE TABLE `movilidad_nac_ents` (
  `id` bigint UNSIGNED NOT NULL,
  `tipoPersona` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colInd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulosOb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `vigencia` date NOT NULL,
  `sedeReg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objeto` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `instEnt_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movilidad_nac_sals`
--

CREATE TABLE `movilidad_nac_sals` (
  `id` bigint UNSIGNED NOT NULL,
  `tipoPersona` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colInd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulosOb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `vigencia` date NOT NULL,
  `sedeReg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objeto` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `instEnt_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas_academicos`
--

CREATE TABLE `programas_academicos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `programas_academicos`
--

INSERT INTO `programas_academicos` (`id`, `nombre`) VALUES
(12, 'Administración de Empresas'),
(4, 'Contaduría Pública'),
(21, 'Ingeniería Ambiental'),
(27, 'Ingeniería de Sistemas'),
(31, 'Ingeniería de Sistemas de Transporte'),
(25, 'Ingeniería de Telecomunicaciones'),
(23, 'Ingeniería Eléctrica'),
(17, 'Ingeniería Electromecánica'),
(15, 'Ingeniería Electrónica'),
(19, 'Ingeniería en Topografía'),
(29, 'Ingeniería Industrial'),
(8, 'Profesional en Administración Financiera'),
(2, 'Profesional en Cultura Física y Deporte'),
(6, 'Profesional en Diseño de Moda'),
(10, 'Profesional en Mercadeo'),
(26, 'Tecnología en Desarrollo de Sistemas informáticos'),
(22, 'Tecnología en Electricidad Industrial'),
(1, 'Tecnología en Entrenamiento Deportivo'),
(13, 'Tecnología en Gestión Agroindustrial'),
(7, 'Tecnología en Gestión Bancaria y Financiera'),
(5, 'Tecnología en Gestión de la Moda'),
(24, 'Tecnología en Gestión de Sistemas de Telecomunicaciones'),
(11, 'Tecnología en Gestión Empresarial'),
(14, 'Tecnología en Implementación de Sistemas Electrónicos Industriales'),
(18, 'Tecnología en Levantamientos Topográficos'),
(30, 'Tecnología en Logística del Transporte'),
(3, 'Tecnología en Manejo de la Información Contable'),
(20, 'Tecnología en Manejo de Recursos Ambientales'),
(9, 'Tecnología en Mercadeo y Gestión Comercial'),
(16, 'Tecnología en Operación y Mantenimiento Electromecánico'),
(28, 'Tecnología en Producción Industrial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `rol_codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol_codigo`, `rol_name`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'COORD', 'Coordinacion', 1, NULL, NULL),
(2, 'ORI', 'Oficina de Relaciones Interinstitucionales', 1, NULL, NULL),
(3, 'DIE', 'Dirección de Investigación y Extensión', 1, NULL, NULL),
(4, 'DEC', 'Decanatura', 1, NULL, NULL),
(5, 'OTRA', 'Otra dependencia', 1, NULL, NULL),
(6, 'SUPERADMIN', 'Super Administrador', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `documento` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `second_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `rol_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `documento`, `first_name`, `second_name`, `last_name`, `email`, `password`, `estado`, `rol_id`, `created_at`, `updated_at`) VALUES
(1, 0, 'Administrador', NULL, 'Sistemas', 'sistemas@correo.uts.edu.co', '$2y$10$pvO1cfYC2ndAwWEnDQrycOi6RCsaMwGkaSkmTV2tmOqRp2IqVgZXy', 1, 6, NULL, NULL),
(5, 123456789, 'ORI', NULL, 'UTS', 'ori@uts.edu.co', '$2y$10$KHCDDWAlVHlcVlSoGsrqDuheBg9QgfEsAJhXIEkeDlRr.sY8JtsyW', 1, 2, '2024-06-11 00:54:44', '2024-06-11 00:54:44'),
(6, 123456789, 'DIE', NULL, 'UTS', 'die@uts.edu.co', '$2y$10$B9scgy6loIhur/6vii1wqeqd7oyAX1b2yTRfNF7C4AMVGB1kIGmsy', 1, 3, '2024-06-11 01:01:33', '2024-06-11 01:01:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inst_ent_nacs` (`inst_ent_nacs`),
  ADD KEY `inst_ent_ints` (`inst_ent_ints`),
  ADD KEY `movilidad` (`movilidad`);

--
-- Indices de la tabla `actividades_asistentes`
--
ALTER TABLE `actividades_asistentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asistencia` (`actividad_id`),
  ADD KEY `fk_programa_asistente` (`programa_academico`);

--
-- Indices de la tabla `auditoria_sesiones`
--
ALTER TABLE `auditoria_sesiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convenio_ints`
--
ALTER TABLE `convenio_ints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `convenio_ints_codigo_unique` (`codigo`),
  ADD KEY `convenio_ints_user_id_foreign` (`user_id`),
  ADD KEY `convenio_ints_instentnac_id_foreign` (`instEntInt_id`);

--
-- Indices de la tabla `convenio_nacs`
--
ALTER TABLE `convenio_nacs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `convenio_nacs_codigo_unique` (`codigo`),
  ADD KEY `convenio_nacs_user_id_foreign` (`user_id`),
  ADD KEY `convenio_nacs_instentnac_id_foreign` (`instEntNac_id`);

--
-- Indices de la tabla `convenio_usuarios`
--
ALTER TABLE `convenio_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_convenio` (`convenio_id`),
  ADD KEY `fk_programa_academico` (`programa_academico`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inst_ent_ints`
--
ALTER TABLE `inst_ent_ints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucion_entidad_ints_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `inst_ent_nacs`
--
ALTER TABLE `inst_ent_nacs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inst_ent_nacs_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movilidad`
--
ALTER TABLE `movilidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inst_ent_nacs` (`inst_ent_nacs`),
  ADD KEY `inst_ent_ints` (`inst_ent_ints`);

--
-- Indices de la tabla `movilidad_int_ents`
--
ALTER TABLE `movilidad_int_ents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movilidad_int_ents_instent_id_foreign` (`instEnt_id`),
  ADD KEY `movilidad_int_ents_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `movilidad_int_sals`
--
ALTER TABLE `movilidad_int_sals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movilidad_int_sals_instent_id_foreign` (`instEnt_id`),
  ADD KEY `movilidad_int_sals_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `movilidad_nac_ents`
--
ALTER TABLE `movilidad_nac_ents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movilidad_nac_ents_instent_id_foreign` (`instEnt_id`),
  ADD KEY `movilidad_nac_ents_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `movilidad_nac_sals`
--
ALTER TABLE `movilidad_nac_sals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movilidad_nac_sals_instent_id_foreign` (`instEnt_id`),
  ADD KEY `movilidad_nac_sals_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `programas_academicos`
--
ALTER TABLE `programas_academicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`nombre`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_rol_id_foreign` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `actividades_asistentes`
--
ALTER TABLE `actividades_asistentes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `auditoria_sesiones`
--
ALTER TABLE `auditoria_sesiones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `convenio_ints`
--
ALTER TABLE `convenio_ints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `convenio_nacs`
--
ALTER TABLE `convenio_nacs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `convenio_usuarios`
--
ALTER TABLE `convenio_usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inst_ent_ints`
--
ALTER TABLE `inst_ent_ints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inst_ent_nacs`
--
ALTER TABLE `inst_ent_nacs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `movilidad`
--
ALTER TABLE `movilidad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `movilidad_int_ents`
--
ALTER TABLE `movilidad_int_ents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movilidad_int_sals`
--
ALTER TABLE `movilidad_int_sals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movilidad_nac_ents`
--
ALTER TABLE `movilidad_nac_ents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movilidad_nac_sals`
--
ALTER TABLE `movilidad_nac_sals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas_academicos`
--
ALTER TABLE `programas_academicos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`inst_ent_nacs`) REFERENCES `inst_ent_nacs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`inst_ent_ints`) REFERENCES `inst_ent_ints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_ibfk_3` FOREIGN KEY (`movilidad`) REFERENCES `movilidad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividades_asistentes`
--
ALTER TABLE `actividades_asistentes`
  ADD CONSTRAINT `fk_asistencia` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programa_asistente` FOREIGN KEY (`programa_academico`) REFERENCES `programas_academicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `convenio_ints`
--
ALTER TABLE `convenio_ints`
  ADD CONSTRAINT `convenio_ints_instentnac_id_foreign` FOREIGN KEY (`instEntInt_id`) REFERENCES `inst_ent_ints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `convenio_ints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `convenio_nacs`
--
ALTER TABLE `convenio_nacs`
  ADD CONSTRAINT `convenio_nacs_instentnac_id_foreign` FOREIGN KEY (`instEntNac_id`) REFERENCES `inst_ent_nacs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `convenio_nacs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `convenio_usuarios`
--
ALTER TABLE `convenio_usuarios`
  ADD CONSTRAINT `fk_programa_academico` FOREIGN KEY (`programa_academico`) REFERENCES `programas_academicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inst_ent_ints`
--
ALTER TABLE `inst_ent_ints`
  ADD CONSTRAINT `institucion_entidad_ints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inst_ent_nacs`
--
ALTER TABLE `inst_ent_nacs`
  ADD CONSTRAINT `inst_ent_nacs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movilidad`
--
ALTER TABLE `movilidad`
  ADD CONSTRAINT `movilidad_ibfk_1` FOREIGN KEY (`inst_ent_nacs`) REFERENCES `inst_ent_nacs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movilidad_ibfk_2` FOREIGN KEY (`inst_ent_ints`) REFERENCES `inst_ent_ints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movilidad_int_ents`
--
ALTER TABLE `movilidad_int_ents`
  ADD CONSTRAINT `movilidad_int_ents_instent_id_foreign` FOREIGN KEY (`instEnt_id`) REFERENCES `inst_ent_ints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movilidad_int_ents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movilidad_int_sals`
--
ALTER TABLE `movilidad_int_sals`
  ADD CONSTRAINT `movilidad_int_sals_instent_id_foreign` FOREIGN KEY (`instEnt_id`) REFERENCES `inst_ent_ints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movilidad_int_sals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movilidad_nac_ents`
--
ALTER TABLE `movilidad_nac_ents`
  ADD CONSTRAINT `movilidad_nac_ents_instent_id_foreign` FOREIGN KEY (`instEnt_id`) REFERENCES `inst_ent_nacs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movilidad_nac_ents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movilidad_nac_sals`
--
ALTER TABLE `movilidad_nac_sals`
  ADD CONSTRAINT `movilidad_nac_sals_instent_id_foreign` FOREIGN KEY (`instEnt_id`) REFERENCES `inst_ent_nacs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movilidad_nac_sals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
