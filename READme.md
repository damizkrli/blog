# Projet de Blog 

### 📋 Création du projet
`symfony new nomduprojet --webapp`

### 🔥 Mise en place de Webpack
`composer require symfony/webpack-encore-bundle`

### 🔽 Installation de Yarn et lancement du server web Symfony 
`composer require symfony/webpack-encore-bundle` <br>
`yarn install` <br>
`symfony server:start` <br>
`yarn run dev --watch` <br>

### 📝 Mise en place de l'environnement de test
Créer l'environnement de test pour **Unit** mais aussi pour **Functional**
Pour lancer les tests : <br>
`php bin/phpunit`

### ✅ Création de l'entité Post
Créer l'entité Post grâce au maker bundle mais en ajoutant le contenu à la main <br>
`console make:entity NameEntity` <br>
Faire les migrations <br>
`console make:migration` <br>
`console doctrine:migrations:migrate`

### 🔥 Mise en place d'un Slug avec Cocur/Slugify
Installer la librairie grâce à composer <br>
`composer require cocur/slugify` <br>
et mettre un évènement prePersist en place pour générer automatiquement le slug

### ✅ Rendre l'Entité unique avec Unique Entity
Ajouter le tag Unique Entity sur l'entité concernée
`#[UniqueEntity('nomdelapropriété')]`
On peut ajouter un message personnalisé.

### 🔥 Mise en place de VichUploader
Installer Vichuploader à l'aide de composer <br>
`composer require vich/uploader-bundle` <br>
Mettre en place le bundle dans une entité **Thumbnail** en relation avec une entité existante pour plus de cohérence (ex: Product => Thumbnail).
Mettre à jour l'entité miroir. Supprimer les migrations pour avoir une seule et unique migration pour l'entité **Post**.

### ✅ Mettre en place les fixtures
Installer les fixtures et faker <br>
`composer req orm-fixtures` <br>
`composer req fakerphp/faker` <br>
Renommer le fichier dans DataFixtures, et créer les fixtures dans EntitéFixtures. Se référer à la doc pour plus d'informations.
Attention à bien annoter les champs obligatoires qui ne sont pas présents dans les fixtures avec
> #[ORM\PrePersist] <br>

Puis lancer les fixtures <br>
`php bin/console doctrine:fixtures:load` <br>
Vérifier si les fixtures on été chargées en BDD.

