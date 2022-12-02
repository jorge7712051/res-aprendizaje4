-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2022 a las 03:46:40
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `collegesurvey`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answer`
--

CREATE TABLE `answer` (
  `id` bigint(20) NOT NULL,
  `answer` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `idQuestion` bigint(20) NOT NULL,
  `idUser` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `answer`
--

INSERT INTO `answer` (`id`, `answer`, `idQuestion`, `idUser`) VALUES
(1, 'SQL', 2, 306),
(2, ' PHP', 2, 306),
(3, ' DOCKER', 2, 306),
(4, ' C#', 2, 306),
(5, ' ANGULAR', 2, 306),
(6, ' Otro', 20, 306),
(7, 'Si', 21, 306),
(8, 'Barranquilla', 22, 306),
(9, 'SQL', 2, 309),
(10, ' PHP', 2, 309),
(11, ' C#', 2, 309),
(12, ' JAVA', 2, 309),
(13, ' ANGULAR', 2, 309),
(14, ' DELPHI', 2, 309),
(15, ' AZURE', 2, 309),
(16, ' Mujer', 20, 309),
(17, ' No', 21, 309),
(18, ' Cali', 22, 309),
(19, 'googole', 23, 309),
(20, 'jorge7712051@outlok.com', 24, 309),
(21, 'Seguir mejorando', 25, 309),
(22, 'Bogota', 26, 306);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domain`
--

CREATE TABLE `domain` (
  `id` bigint(20) NOT NULL,
  `domain` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `idQuestion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `domain`
--

INSERT INTO `domain` (`id`, `domain`, `active`, `idQuestion`) VALUES
(27, 'SQL', 1, 2),
(28, ' PHP', 1, 2),
(29, ' DOCKER', 1, 2),
(30, ' C#', 1, 2),
(31, ' JAVA', 1, 2),
(32, ' CISCO', 1, 2),
(33, ' JAVASCRIPT', 1, 2),
(34, ' ANGULAR', 1, 2),
(35, ' DELPHI', 1, 2),
(36, ' GIT', 1, 2),
(37, ' AWS', 1, 2),
(38, ' AZURE', 1, 2),
(44, 'Barranquilla', 1, 22),
(45, ' Bogota', 1, 22),
(46, ' Caldas ', 1, 22),
(47, ' Cali', 1, 22),
(48, ' Medellin', 1, 22),
(49, ' Vichada', 1, 22),
(50, 'Hombre', 1, 20),
(51, ' Mujer', 1, 20),
(52, ' Otro', 1, 20),
(53, 'Si', 1, 21),
(54, ' No', 1, 21),
(55, 'Bogota', 1, 26),
(56, ' Cali', 1, 26),
(57, ' Medellin', 1, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question`
--

CREATE TABLE `question` (
  `id` bigint(20) NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `idQuiz` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `question`
--

INSERT INTO `question` (`id`, `question`, `type`, `required`, `icon`, `active`, `idQuiz`) VALUES
(1, 'Otra ¿Cuales?', 'text', 1, 'bi bi-3-circle-fill', 0, 1),
(2, '¿Qué tecnologias le interesan?', 'checkbox', 1, '', 1, 1),
(20, 'Sexo con el cual se identifica', 'radio', 1, '', 1, 1),
(21, '¿Cree que la universidad esta a la vanguardia con las tecnologías anteriores?', 'radio', 1, 'bi bi-patch-question-fill', 1, 1),
(22, '¿En que ciudad reside?', 'select', 1, '', 1, 1),
(23, 'Alguna tecnologia que le gustaria conocer ¿Cual?', 'text', 0, '', 1, 1),
(24, 'Linkedin', 'text', 0, 'bi bi-linkedin', 1, 1),
(25, 'Sugerencia', 'textarea', 0, '', 1, 1),
(26, '¿En que ciudad Trabaja?', 'select', 1, '', 1, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quiz`
--

CREATE TABLE `quiz` (
  `id` bigint(20) NOT NULL,
  `quizName` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `quiz`
--

INSERT INTO `quiz` (`id`, `quizName`, `active`) VALUES
(1, 'Tecnologias emergentes', 1),
(11, 'Empleo de egresados', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `userName` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `userEmail` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `userPassword` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `userLastUpdate` date NOT NULL DEFAULT current_timestamp(),
  `userResponse` tinyint(1) NOT NULL,
  `privacyPolicy` tinyint(1) NOT NULL,
  `validate` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `userName`, `userEmail`, `userPassword`, `userLastUpdate`, `userResponse`, `privacyPolicy`, `validate`) VALUES
(306, 'Jorge Correa', 'jorge7712051@hotmail.com', '', '2022-11-26', 0, 1, 0),
(309, 'leonardo7712051@outlook.es', 'leonardo7712051@outlook.es', '$2y$10$3MrvNLbCKpKIPjHT./ftre0pTKmDsMdjytNFpD9UBXnByo8vkGR6K', '2022-11-26', 0, 1, 1),
(313, 'JORGE LEONARDO CORREA MUÑOZ', 'jlcorream@correo.udistrital.edu.co', '', '2022-11-28', 0, 1, 0),
(320, 'jorge7712051@gmail.com', 'jorge7712051@gmail.com', '$2y$10$M8sUgoma/5PdQc9LwOX2L.FYEsyrax34SYO0o4qZB0Uh5nUKirwKK', '2022-11-29', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_quiz`
--

CREATE TABLE `user_quiz` (
  `id` bigint(20) NOT NULL,
  `idUser` bigint(11) NOT NULL,
  `idQuiz` bigint(20) NOT NULL,
  `dateResponse` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `user_quiz`
--

INSERT INTO `user_quiz` (`id`, `idUser`, `idQuiz`, `dateResponse`) VALUES
(1, 306, 1, '2022-11-27'),
(2, 309, 1, '2022-11-28'),
(3, 306, 11, '2022-11-28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_FK` (`idUser`),
  ADD KEY `answer_FK_1` (`idQuestion`);

--
-- Indices de la tabla `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `domain_FK` (`idQuestion`);

--
-- Indices de la tabla `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueEmail` (`userEmail`),
  ADD KEY `userEmail` (`userEmail`),
  ADD KEY `userPassword` (`userPassword`);

--
-- Indices de la tabla `user_quiz`
--
ALTER TABLE `user_quiz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idUser` (`idUser`,`idQuiz`),
  ADD KEY `fk_quiz` (`idQuiz`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `answer`
--
ALTER TABLE `answer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `domain`
--
ALTER TABLE `domain`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `question`
--
ALTER TABLE `question`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT de la tabla `user_quiz`
--
ALTER TABLE `user_quiz`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_FK` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `answer_FK_1` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`id`);

--
-- Filtros para la tabla `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_FK` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`id`);

--
-- Filtros para la tabla `user_quiz`
--
ALTER TABLE `user_quiz`
  ADD CONSTRAINT `fk_quiz` FOREIGN KEY (`idQuiz`) REFERENCES `quiz` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
