# Projet de Blog 

### 📋 Création du projet
```symfony new nomduprojet --webapp```

### 🔥 Mise en place de Webpack
```composer require symfony/webpack-encore-bundle```

### 🔽 Installation de Yarn et lancement du server web Symfony 
```
composer require symfony/webpack-encore-bundle
yarn install
symfony server:start
yarn run dev --watch
```

### 📝 Mise en place de l'environnement de test
Créer l'environnement de test pour **Unit** mais aussi pour **Functional**
Pour lancer les tests : <br>
```php bin/phpunit```

### ✅ Création de l'entité Post
Créer l'entité Post grâce au maker bundle mais en ajoutant le contenu à la main <br>
```console make:entity NameEntity``` <br>
Faire les migrations <br>
```console make:migration``` <br>
```console doctrine:migrations:migrate```

### 🔥 Mise en place d'un Slug avec Cocur/Slugify
Installer la librairie grâce à composer <br>
```composer require cocur/slugify``` <br>
et mettre un évènement prePersist en place pour générer automatiquement le slug

### ✅ Rendre l'Entité unique avec Unique Entity
Ajouter le tag Unique Entity sur l'entité concernée
```#[UniqueEntity('nomdelapropriété')]```
On peut ajouter un message personnalisé.

### 🔥 Mise en place de VichUploader
Installer Vichuploader à l'aide de composer <br>
```composer require vich/uploader-bundle``` <br>
Mettre en place le bundle dans une entité **Thumbnail** en relation avec une entité existante pour plus de cohérence (ex: Product => Thumbnail).
Mettre à jour l'entité miroir. Supprimer les migrations pour avoir une seule et unique migration pour l'entité **Post**.

### ✅ Mettre en place les fixtures
Installer les fixtures et faker <br>
```composer req orm-fixtures``` <br>
```composer req fakerphp/faker``` <br>
Renommer le fichier dans DataFixtures, et créer les fixtures dans EntitéFixtures. Se référer à la doc pour plus d'informations.
Attention à bien annoter les champs obligatoires qui ne sont pas présents dans les fixtures avec
> #[ORM\PrePersist] <br>

Puis lancer les fixtures <br>
```php bin/console doctrine:fixtures:load``` <br>
Vérifier si les fixtures on été chargées en BDD.

### ✅ Récupérer les articles
Création du PostController et la méthode index. Dans le PostController, création d'une variable post qui permet de récupérer
la totalité des post grâce au Repository. Utilisation de la méthode render afin de renvoyer les données à la vue.

### ✅ Création d'une requête personnalisée
Création de la requête personnalisée dans le repository.

### ✅ Installation de TailwindCSS
Grâce à [Youri Galescot](https://www.yourigalescot.com/fr/blog/comment-integrer-tailwindcss-v3-a-un-projet-symfony-avec-webpack-encore)
on a une roadmap bien rodé pour installer correctement TailwindCSS. <br>
Installer Tailwind, postcss et autoprefixer <br>
```yarn add --dev tailwindcss postcss autoprefixer``` <br>
Ajouter le *content* dans le fichier de config de Tailwind : ici on ajoutera les templates et les fichiers js.
Ensuite on install le loader PostCSS <br>
```yarn install -D postcss-loader``` <br>
Ensuite on active PostCSS dans le **webpack.config.js** en ajoutant la ligne suivante : <br>
```.enablePostCssLoader()``` <br>
On crée le fichier **postcss.config.js** dans lequel on ajoute les modules d'export :
```
module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {}
    }
};
```
Enfin, dans **app.css** on indique à Tailwind les différentes couches 
```
@tailwind base;
@tailwind components;
@tailwind utilities;
```
Et pour finir on lance build les assets : <br>
```yarn run dev --watch```

Ensuite on implémente le tout dans Twig.
```
    <div class="h-screen flex flex-col items-center justify-center">
        <h1 class="text-gray-500 text-4xl mb-4">Hello world</h1>
        <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
            Click here
        </button>
    </div>
```
Petit+ <br>
Il est possible d'utiliser Tailwind Elements. On peut l'installer avec : <br>
```yarn add tw-elements```

Il fait indiquer à Tailwind d'utiliser Tw-elements : <br>
```./node_modules/tw-elements/dist/js/**/*.js```
et l'ajouter comme plugin :
```
  plugins: [
      require('tw-elements/dist/plugin')
  ],
```
Intégrer les fichiers js de Tailwind elements dans app.js : <br>
``ìmport 'tw-elements''``

### ✅Créer les cards pour les posts
Créer les cards.
Astuce : il est possible de rajouter un 'u' dans les variables twig en installant le composant suivant : <br>
```
composer require twig/string-extra
```

### ✅Créer un composant
Créer un composant pour réutiliser les cards.

### ✅Pagination avec KNP Paginator
Installer le bundle <br>
```composer require knplabs/knp-paginator-bundle``` <br>
Mettre en place la pagination dans le controller : <br>
```
    #[Route('/', name: 'post.index', methods: ['GET'])]
    public function index(
        PostRepository $postRepository,
        PaginatorInterface $pagination,
        Request $request
    ): Response
    {
        $data = $postRepository->findPublished();
        $post = $pagination->paginate(
            $data,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('pages/blog/index.html.twig', [
            'posts' => $post
        ]);
    }    
```
Ajouter la configuration de knp_paginator dans le dossier config

```
knp_paginator:
    page_range: 5                       # number of links shown in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links to page 4, 5, 6)
    default_options:
        page_name: page                 # page query parameter name
        sort_field_name: sort           # sort field query parameter name
        sort_direction_name: direction  # sort direction query parameter name
        distinct: true                  # ensure distinct results, useful when ORM queries are using GROUP BY statements
        filter_field_name: filterField  # filter field query parameter name
        filter_value_name: filterValue  # filter value query parameter name
    template:
        pagination: '@KnpPaginator/Pagination/sliding.html.twig'     # sliding pagination controls template
        sortable: '@KnpPaginator/Pagination/sortable_link.html.twig' # sort link template
        filtration: '@KnpPaginator/Pagination/filtration.html.twig'  # filters template
```
Dans le fichier **index.html.twig** ajouter une div qui contient la pagination : <br>
```
<div class="navigation flex justify-content mb-8">
    {{ knp_pagination_render(posts) }}
</div>
```
