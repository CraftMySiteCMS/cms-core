create table if not exists cms_shop_categories
(
    shop_category_id           int auto_increment
        primary key,
    shop_category_name         varchar(255) null,
    shop_category_description text         null,
    shop_category_permission   json         null
)
    comment 'Catégories pour les articles de la boutique';

create table if not exists cms_shop_commands
(
    shop_command_id      int auto_increment
        primary key,
    shop_command_created timestamp null,
    user_id              int       null,
    payment_id           int       null,
    constraint cms_shop_commands_cms__payment_id_fk
        foreign key (payment_id) references cms__payments (payment_id),
    constraint cms_shop_commands_user_id_fk
        foreign key (user_id) references cms_users (user_id)
)
    comment 'Commande d''un article provenant de la boutique';

create table if not exists cms_shop_items
(
    shop_item_id          int auto_increment
        primary key,
    shop_item_name        varchar(255) null,
    shop_item_price       float        null,
    shop_item_stock       int          null,
    shop_item_description text         null,
    shop_item_thumbnail   text         null,
    shop_item_userLimit   int          null,
    shop_item_state       tinyint(1)   null
)
    comment 'Articles de la boutique';

create table if not exists cms_shop_commands_items
(
    shop_command_id int null,
    shop_item_id    int null,
    constraint cms_shop_command_id_fk
        foreign key (shop_command_id) references cms_shop_commands (shop_command_id),
    constraint cms_shop_commands_items_item_id_fk
        foreign key (shop_item_id) references cms_shop_items (shop_item_id)
)
    comment 'Liaison des Articles et des commandes';

create table if not exists cms_shop_items_categories
(
    shop_item_id     int null,
    shop_category_id int null,
    constraint cms_shop_category__fk
        foreign key (shop_category_id) references cms_shop_categories (shop_category_id),
    constraint cms_shop_item
        foreign key (shop_item_id) references cms_shop_items (shop_item_id)
)
    comment 'Stockage des catégories de chaque article';

create table if not exists cms_shop_opinions
(
    shop_opinion_id        int auto_increment
        primary key,
    shop_command_id        int       null,
    shop_item_id           int       null,
    shop_opinion_score     float     null,
    shop_opinon_commentary text      null,
    user_id                int       null,
    shop_opinion_created   timestamp null,
    constraint cms_shop_items_opinions_user_id_fk
        foreign key (user_id) references cms_users (user_id),
    constraint cms_shop_opinions_command_id_fk
        foreign key (shop_command_id) references cms_shop_commands (shop_command_id),
    constraint cms_shop_opinions_item_id_fk
        foreign key (shop_item_id) references cms_shop_items (shop_item_id)
);

