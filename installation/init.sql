CREATE TABLE `cms_core_options`
(
    `option_id`      int(11)      NOT NULL,
    `option_value`   varchar(255) NOT NULL,
    `option_name`    varchar(255) NOT NULL,
    `option_updated` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `cms_menus`
(
    `menu_id`        int(11)      NOT NULL,
    `menu_name`      varchar(255) NOT NULL,
    `menu_url`       varchar(255) NOT NULL,
    `menu_level`     tinyint(1)   NOT NULL,
    `menu_parent_id` int(11)      NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `cms_roles`
(
    `role_id`   int(11) DEFAULT NULL,
    `role_name` tinytext NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `cms_users`
(
    `user_id`        int(11)      NOT NULL,
    `user_email`     varchar(255) NOT NULL,
    `user_pseudo`    varchar(255)          DEFAULT NULL,
    `user_firstname` varchar(255)          DEFAULT NULL,
    `user_lastname`  varchar(255)          DEFAULT NULL,
    `user_password`  varchar(255) NOT NULL,
    `user_state`     tinyint(1)   NOT NULL DEFAULT '1',
    `role_id`        int(11)      NOT NULL DEFAULT '1',
    `user_key`       varchar(255) NOT NULL,
    `user_created`   timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_updated`   timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


ALTER TABLE `cms_core_options`
    ADD PRIMARY KEY (`option_id`),
    ADD UNIQUE KEY `option_name` (`option_name`);

ALTER TABLE `cms_menus`
    ADD PRIMARY KEY (`menu_id`);

ALTER TABLE `cms_roles`
    ADD UNIQUE KEY `role_id` (`role_id`);

ALTER TABLE `cms_users`
    ADD PRIMARY KEY (`user_id`),
    ADD UNIQUE KEY `user_email` (`user_email`),
    ADD UNIQUE KEY `user_pseudo` (`user_pseudo`),
    ADD KEY `role_id` (`role_id`);


ALTER TABLE `cms_core_options`
    MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cms_menus`
    MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cms_users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `cms_users`
    ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `cms_roles` (`role_id`);
COMMIT;



INSERT INTO `cms_core_options` (`option_id`, `option_value`, `option_name`, `option_updated`)
VALUES (1, 'Sampler', 'theme', NOW());

INSERT INTO `cms_roles` (`role_id`, `role_name`) VALUES
(0, 'Visiteur'),
(1, 'Utilisateur'),
(2, 'Editeur'),
(3, 'Modérateur'),
(10, 'Administrateur');