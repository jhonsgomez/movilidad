-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-05-2024 a las 21:27:34
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
  `id` int NOT NULL,
  `tipo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion_tipo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `resultados` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `responsable` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo_empleado` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion_tipo_empleado` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `pais` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `inst_ent_nacs` bigint UNSIGNED DEFAULT NULL,
  `inst_ent_ints` bigint UNSIGNED DEFAULT NULL,
  `doc_soporte` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `movilidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `tipo`, `descripcion_tipo`, `resultados`, `responsable`, `documento`, `tipo_empleado`, `descripcion_tipo_empleado`, `pais`, `inst_ent_nacs`, `inst_ent_ints`, `doc_soporte`, `movilidad`) VALUES
(8, 'Clase Espejo', 'Clase espejo', 'Promocion de temas nuevos', 'ANGIE CACERES', '123456789', 'Docente', 'Docente de ingenieria ambiental', 'Colombia', 6, NULL, '', 9),
(9, 'Webinar', 'Webinar de prueba', 'Aprendizaje nativo', 'NANCY CAROLINA', '123456789', 'Docente', 'Docente de ingenieria ambiental', 'Colombia', NULL, 4, '', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_ints`
--

CREATE TABLE `convenio_ints` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaInicio` date NOT NULL,
  `tipo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `es_nacional` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `convenio_ints`
--

INSERT INTO `convenio_ints` (`id`, `codigo`, `fechaInicio`, `tipo`, `supervisor`, `breve_objeto`, `activo`, `vigencia`, `docSoportes`, `estado`, `instEntInt_id`, `user_id`, `created_at`, `updated_at`, `resultados_concretos`, `n_usuarios`, `es_nacional`) VALUES
(3, '310-1000', '2024-05-26', 'Practicas', 'Juan Perez', 'Breve objeto', 'Sí', '2024-06-26', '1716760490_Ejercicio no balanceado.pdf', 1, 5, 1, '2024-05-27 02:54:50', '2024-05-28 20:25:03', 'Resultados', 2, 0),
(4, '310-1001', '2024-05-27', 'Interadministrativo', 'Juan', 'Brevesss', 'Sí', '2024-05-30', '1716819874_Ejercicio no balanceado.pdf', 1, 3, 1, '2024-05-27 19:24:34', '2024-05-27 19:25:09', 'Res', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_nacs`
--

CREATE TABLE `convenio_nacs` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaInicio` date NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `convenio_nacs` (`id`, `codigo`, `fechaInicio`, `tipo`, `supervisor`, `breve_objeto`, `activo`, `vigencia`, `docSoportes`, `estado`, `instEntNac_id`, `user_id`, `created_at`, `updated_at`, `resultados_concretos`, `n_usuarios`, `es_nacional`) VALUES
(10, '310-1000', '2024-05-14', 'Marco', 'Ing. Alexander Anchicoque', 'Celebrar un convenio marco de cooperacion interinstitucional de actividades de investigacion y extension, a travez de proyectos de consultoria y asesoria cientifica con el ctia', 'Sí', '2026-05-13', '1715721228_Doc_Soporte.pdf', 1, 4, 1, '2024-05-15 02:13:48', '2024-05-28 20:26:44', 'Visitas tecnicas con descuento preferencial para los estudiantes de uts\r\nponencia conversatorio de empresarios en el marco de conais', 4, 1),
(11, '310-1001', '2024-05-14', 'Marco', 'Ing. Alexander Anchicoque', 'Celebrar un convenio marco de cooperacion interinstitucional de actividades de investigacion y extension, a travez de proyectos de consultoria y asesoria cientifica con el ctia', 'Sí', '2026-05-13', '1715721330_Doc_Soporte.pdf', 1, 5, 1, '2024-05-15 02:15:30', '2024-05-29 02:21:30', 'Ponencia en conversatorio de empresarios en el marco de conais', 0, 1),
(12, '310-1002', '2024-05-27', 'Interadministrativo', 'Juanito', 'Breve', 'Sí', '2024-05-30', '1716819773_Ejercicio no balanceado.pdf', 1, 4, 1, '2024-05-27 19:22:53', '2024-05-27 19:22:53', 'Re4s', 0, 1);

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
(5, 'CORPORACION BIOTIC', 'Perú', 'Lima', '475896312', 'Juan Perez', '3147852146', 'biotic@correo.edu.pe', 1, 1, '2024-05-15 02:41:07', '2024-05-29 00:26:47'),
(6, 'Cambridge', 'Estados unidos', 'Cambridge', NULL, 'juanita', NULL, 'juaniAAA@gmail.com', 0, 1, '2024-05-27 19:44:22', '2024-05-27 19:48:20');

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
(6, 'UNIVERSIDAD DE CARTAGENA', 'Cartagena', '145632741', 'Juanita', 3189652416, 'ucartagena@cartagena.edu.co', '1715721985_Doc_Soporte.pdf', 1, 1, '2024-05-15 02:26:25', '2024-05-27 19:37:55'),
(7, 'UNAB', 'Santander', '123475812', 'Juanito', 3142581287, 'juanito@unab.com', '1716820392_Ejercicio no balanceado.pdf', 0, 1, '2024-05-27 19:33:12', '2024-05-27 19:38:10');

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

INSERT INTO `users` (`id`, `first_name`, `second_name`, `last_name`, `email`, `password`, `estado`, `rol_id`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', NULL, 'Sistemas', 'sistemas@correo.uts.edu.co', '$2y$10$pvO1cfYC2ndAwWEnDQrycOi6RCsaMwGkaSkmTV2tmOqRp2IqVgZXy', 1, 6, NULL, NULL);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `convenio_ints`
--
ALTER TABLE `convenio_ints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `convenio_nacs`
--
ALTER TABLE `convenio_nacs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `movilidad`
--
ALTER TABLE `movilidad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
