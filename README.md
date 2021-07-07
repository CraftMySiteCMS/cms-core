Projet CRAFT MY SITE - CMS multi-gaming
=================================================

Ce projet a pour ambition de proposer à l'ensemble des administrateurs de serveurs de jeux de mettre à disposition de ses joueurs une plateforme web performante et pertinente.

[![License](https://img.shields.io/badge/License-GNU%20GPL-%239f9f9f)](https://www.gnu.org/licenses/gpl-3.0.fr.html)
[![Latest release](https://img.shields.io/badge/Alpha-0.0.1-%234c29cc)](https://github.com/CraftMySiteCMS/cms-core)


Table des matières
-----------------

* [Introduction](#introduction)
* [Installation](#installation)


Introduction
------------

A ce stade du projet, seul le jeu Minecraft sera utilisable avec le CMS. 

Installation
------------

Attention, sur Nginx uniquement, la configuration suivante du serveur est nécéssaire :

```bash
autoindex off;

location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /%1 redirect;
  }
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php?url=$1 break;
  }
```

Configuration des variables d'environnement, à mettre dans le fichier `.env` à la racine du projet :

```bash
PATH_ADMIN_VIEW=admin/resources/views/
DB_HOST=
DB_USERNAME=
DB_PASSWORD=
DB_NAME=
PATH_SUBFOLDER=
DEV_MODE=
LOCALE=fr
TIMEZONE=UTC
```
* `DB_HOST` : Adresse du serveur SQL (Généralement localhost)
* `DB_USERNAME` : Utilisateur SQL
* `DB_PASSWORD` : Mot de passe utilisateur SQL
* `DB_NAME` : Nom de la base de données
* `PATH_SUBFOLDER` : Sous-dossier d'installation. Si le CMS est installé à la racine, mettre un `/`
* `DEV_MODE` : `1` active le mode debug (affiche les erreurs PHP), sinon mettre `0`

Nous aider dans le développement
------------

Rejoignez-nous sur [Discord](https://discord.gg/bv3NuXXgyq) pour pouvoir échanger sur le projet et le faire grandir !