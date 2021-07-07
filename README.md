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

Attention, sur Nginx uniquement, la configuration suivante du serveur est nécessaire :

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

Une fois les fichiers du site téléchargés, accédez à votre site. Vous serez automatiquement redirigé vers l'installateur de CraftMySite.
Pensez à supprimer le dossier `/installation` une fois le CMS configuré.

Nous aider dans le développement
------------

Rejoignez-nous sur [Discord](https://discord.gg/bv3NuXXgyq) pour pouvoir échanger sur le projet et le faire grandir !