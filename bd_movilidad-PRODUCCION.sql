-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-06-2024 a las 20:44:20
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
