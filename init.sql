-- Listage de la structure de la table cms. cms_core_options
CREATE TABLE IF NOT EXISTS `cms_core_options` (
    `option_id` int(11) NOT NULL AUTO_INCREMENT,
    `option_value` varchar(255) NOT NULL,
    `option_name` varchar(255) NOT NULL,
    `option_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`option_id`),
    UNIQUE KEY `option_name` (`option_name`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Listage de la structure de la table cms. cms_menus
CREATE TABLE IF NOT EXISTS `cms_menus` (
    `menu_id` int(11) NOT NULL AUTO_INCREMENT,
    `menu_name` varchar(255) NOT NULL,
    `menu_url` varchar(255) NOT NULL,
    `menu_level` tinyint(1) NOT NULL,
    `menu_parent_id` int(11) NOT NULL,
    PRIMARY KEY (`menu_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage de la structure de la table cms. cms_users
CREATE TABLE IF NOT EXISTS `cms_users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_email` varchar(255) NOT NULL,
    `user_pseudo` varchar(255) DEFAULT NULL,
    `user_firstname` varchar(255) DEFAULT NULL,
    `user_lastname` varchar(255) DEFAULT NULL,
    `user_password` varchar(255) NOT NULL,
    `user_state` tinyint(1) NOT NULL DEFAULT '1',
    `user_role` tinyint(1) NOT NULL DEFAULT '1',
    `user_key` varchar(255) NOT NULL,
    `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `user_email` (`user_email`),
    UNIQUE KEY `user_pseudo` (`user_pseudo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `cms_core_options` (`option_id`, `option_value`, `option_name`, `option_updated`) VALUES
(1, 'Sampler', 'theme', NOW());