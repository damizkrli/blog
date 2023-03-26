# Projet de Blog 

### 📋 Création du projet
`symfony new nomduprojet --webapp`

### 🔥 Mise en place de Webpack
`composer require symfony/webpack-encore-bundle`

### 🔽 Installation de Yarn et lancement du server web Symfony 
`composer require symfony/webpack-encore-bundle`
`yarn install`
`symfony server:start`
`yarn run dev --watch`

### 📝 Mise en place de l'environnement de test
Créer l'environnement de test pour **Unit** mais aussi pour **Functional**
Pour lancer les tests : 
`php bin/phpunit`

### ✅ Création de l'entité Post
Créer l'entité Post grâce au maker bundle mais en ajoutant le contenu à la main
`console make:entity NameEntity`
Faire les migrations
`console make:migration`
`console doctrine:migrations:migrate`

### 