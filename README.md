# Illay Travel Blog

Ce projet est un site/blog de voyages avec des articles sur les voyages. La lecture des articles est accessible à tout le monde, en revanche, l'ajout, la modification et la suppression d'articles sont réservés aux administrateurs.

# Installation
Suivez les instructions ci-dessous pour installer et configurer le projet :

```bash
# Cloner le dépôt
git clone https://github.com/maeminar/blog_travel.git

# Accéder au répertoire du projet
cd blog_travel

# Installer les dépendances
composer install

# Configurer l'accès à la base de données en définissant la variable d'environnement dans un fichier .env.local

# Configurer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Charger les fixtures (données de test)
php bin/console doctrine:fixtures:load

# Démarrer le serveur de développement
symfony serve --no-tls

# Démarrer Tailwind
php bin/console tailwind:build –watch
```
# Description

Ce site a un architecture MVC, avec des vues Twig, l’utilisation de deux formulaires (un pour article et un pour les commentaires).

## Gestion de la connexion

Pour gérer la connexion en tant qu’administrateur, j’ai utilisé EasyAdmin.

Pour vous connecter :

Identifiant de connexion : admin@illay.com

Mot de passe : admin

Je n’ai pas réussi à faire un message Flash qui indique que l’on est bien connecté lors de la connexion en tant qu’administrateur. Je l’ai quand même affiché sur l’accueil mais ce n’est pas un message flash. 
Lorsque l’on est connecté en tant qu’admin, j’ai ajouté une page profile que je n’ai pas eu le temps de développer. J’aurais aimé pouvoir y ajouter une gestion du profil.

## Champs supplémentaires

Ce qui m’a pris du temps, pour l’upload d’images dans EasyAdmin, c'est qu'il a fallut configuré le fichier twig.yaml en ajoutant une variable globale img_upload_dir, dont la valeur est définie par %app.upload_dir% dans services.yaml. Cela centralise le chemin d'accès aux images (/uploads/images/) ce qui permet de l'utiliser par la suite facilement dans tous les templates Twig.

Une fois que j’ai eu ma première version de l’article et que EasyAdmin fonctionnait, j’ai décidé d’ajouter les champs des catégories, des modes de transports, de la distance et des auteurs.

L’objectif d’avoir ajouté un mode de transport et une distance était de créer une méthode qui permette lors de l’ajout d’un nouvel article, de calculer l’empreinte carbone du voyage en CO2. Pour cela, j’ai crée une fonction que j’ai nommé calculateCarbon() dans mon entité Article, qui retourne le résultat de la multiplication du mode de transport par la distance. Sachant que j’ai défini dans mes fixtures une constante emission_factor en fonction du type de mode de transport. 
J’ai ajouté dans mon template Article une condition selon laquelle si le résultat de ma méthode est > 1 alors le bakground du message sera rouge, s’il est inférieur à 1 il sera vert. 

## Commentaires

J’ai décidé d’ajouter des commentaires afin d’avoir un site plus interactif. J'y ai passé du temps, surtout sur le formulaire pour récupérer l'ID lors de l’envoi du commentaire en BDD. La solution était de préremplir le champ en donnant des valeurs à l’objet Comment, donc je lui ai donné les valeurs articles et date. 

## Fixtures 
Pour les fixtures, j’ai utilisé Faker, qui permet d’ajouter aléatoirement des données en BDD.

## Améliorations
Enfin, j'ai eu l'idée d'intégrer l'API Google Maps afin d’afficher une carte du Monde interactive avec des repères placés en fonction des pays de chaque article mais j’ai manqué de temps.
