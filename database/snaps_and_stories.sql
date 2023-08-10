-- Creación de la base de datos.
CREATE DATABASE `snaps_and_stories` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE snaps_and_stories;

-- Creación de table usuarios.
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `email` varchar(512) NOT NULL,
  `password` varchar(128) NOT NULL,
  `password_salt` varchar(32) NOT NULL,
  `nombre` varchar(512) NOT NULL,
  `apellidos` varchar(512) DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `foto_perfil` varchar(64),
  `activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de table fotos.
CREATE TABLE `fotos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `secure_id` varchar(64) NOT NULL,
  `usuario_subio_id` int NOT NULL,
  `nombre_archivo` varchar(256) NOT NULL,
  `tamaño` int NOT NULL,
  `descripcion` varchar(1024) DEFAULT NULL,
  `fecha_subido` datetime NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de table fotos_likes.
CREATE TABLE `fotos_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `foto_id` int NOT NULL,
  `usuario_dio_like_id` int NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de table seguidores.
CREATE TABLE `seguidores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_seguidor_id` int NOT NULL,
  `usuario_siguiendo_id` int NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de view fotos_v
CREATE VIEW `fotos_v` AS 
	SELECT 
			`f`.`id` AS `id`,
            `f`.`secure_id` AS `secure_id`,
            `f`.`usuario_subio_id` AS `usuario_subio_id`,
            `u`.`username` AS `usuario_subio_username`,
            `u`.`nombre` AS `usuario_subio_nombre`,
            `u`.`apellidos` AS `usuario_subio_apellidos`,
            `u`.`foto_perfil` AS `usuario_subio_foto_perfil`,
            `f`.`nombre_archivo` AS `nombre_archivo`,
            `f`.`tamaño` AS `tamaño`,
            `f`.`descripcion` AS `descripcion`,
            `f`.`fecha_subido` AS `fecha_subido`,
            `f`.`eliminado` AS `eliminado`,
            (SELECT COUNT(0) FROM `fotos_likes` `l` WHERE `l`.`foto_id` = `f`.`id` AND `l`.`eliminado` = 0) AS `likes`
		FROM 
			`fotos` `f` 
            INNER JOIN `usuarios` `u` 
				ON `f`.`usuario_subio_id` = `u`.`id`;
