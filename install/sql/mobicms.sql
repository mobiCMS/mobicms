DROP TABLE IF EXISTS `system__session`;
CREATE TABLE `system__session`
(
    `session_id` VARBINARY(128)   NOT NULL PRIMARY KEY,
    `modified`   INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `data`       BLOB             NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_bin;

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test`
(
    `id`   int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255)     NOT NULL DEFAULT ''
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

INSERT INTO `test` (`id`, `name`)
VALUES (1, 'Проверка слуха!'),
       (2, 'Если не слышно - срочно к доктору.'),
       (3, 'Если слышно, то хорошо, продолжаем.'),
       (4, 'Ну и наконец...'),
       (5, 'На этом все.');
