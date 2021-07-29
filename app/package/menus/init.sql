CREATE TABLE `cms_menus` (
    `menu_id` int(11) NOT NULL,
    `menu_name` varchar(255) NOT NULL,
    `menu_url` varchar(255) NOT NULL,
    `menu_level` int(1) NOT NULL,
    `menu_parent_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cms_menus`
    ADD PRIMARY KEY (`menu_id`);

ALTER TABLE `cms_menus`
    MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;