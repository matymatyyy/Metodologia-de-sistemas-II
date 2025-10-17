ALTER TABLE `carreras` ADD `fecha_inicio` DATE NOT NULL DEFAULT NULL DEFAULT '0000-00-00' AFTER `titulo`;
ALTER TABLE `carreras` CHANGE `duracion` `fecha_fin` DATE NOT NULL DEFAULT '0000-00-00';