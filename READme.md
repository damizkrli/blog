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
```php bin/phpunit --filter {NomDeLaMethode} {chemin/de/la/méthode.php}```

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
Mettre en place le bundle dans une entité **Thumbnail** en relation avec une entité existante pour plus de cohérence (
ex: Product => Thumbnail).
Mettre à jour l'entité miroir. Supprimer les migrations pour avoir une seule et unique migration pour l'entité **Post**.

### ✅ Mettre en place les fixtures

Installer les fixtures et faker <br>
```composer req orm-fixtures``` <br>
```composer req fakerphp/faker``` <br>
Renommer le fichier dans DataFixtures, et créer les fixtures dans EntitéFixtures. Se référer à la doc pour plus
d'informations.
Attention à bien annoter les champs obligatoires qui ne sont pas présents dans les fixtures avec
> #[ORM\PrePersist] <br>

Puis lancer les fixtures <br>
```php bin/console doctrine:fixtures:load``` <br>
Vérifier si les fixtures on été chargées en BDD.

### ✅ Récupérer les articles

Création du PostController et la méthode index. Dans le PostController, création d'une variable post qui permet de
récupérer
la totalité des post grâce au Repository. Utilisation de la méthode render afin de renvoyer les données à la vue.

### ✅ Création d'une requête personnalisée

Création de la requête personnalisée dans le repository.

### 🔥 Installation de TailwindCSS

Grâce
à [Youri Galescot](https://www.yourigalescot.com/fr/blog/comment-integrer-tailwindcss-v3-a-un-projet-symfony-avec-webpack-encore)
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

### ✅ Créer les cards pour les posts

Créer les cards.
Astuce : il est possible de rajouter un 'u' dans les variables twig en installant le composant suivant : <br>

```
composer require twig/string-extra
```

### ✅ Créer un composant

Créer un composant pour réutiliser les cards.

### 🔥 Pagination avec KNP Paginator

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

### 🔥 Retourner directement des articles paginés

Au lieu de retourner des articles, puis de les paginer il est beaucoup plus logique de
les paginer dans la requête du **repository**. Au lieu d'avoir la logique de la pagination dans le repo
on met tout dans le repository :

```
return $post = $this->paginator->paginate($data, $page, 9);
```

### 🔥 Modifier le style de la pagination

Pour modifier le style, on peut ajouter un style prédéfini dans <span style="color:blue">
*/vendor/knplabs/knp-paginator-bundle/templates/Pagination/*</span>
Ou alors on peut créer son propre design dans un dossier et l'appliquer dans le fichier de configuration de
knp-paginator.

### 📝 Tester une page

Pour créer un test fonctionnel, il est possible de passer la console de symfony <br>
```php bin/console make:test``` <br>
Choisir le type de test et le nom de la classe à tester. Puis lancer le test. <br>
```php bin/phpunit```

### ✅ Ajouter un Header et un footer

### ✅ Créer la page détail d'un article grâce au ParamConverter

Dans la fonction show, au lieu de passer par le repository, on peut utiliser l'injection de dépendance en passant
l'objet pour atteindre le slug et les informations dont on a besoin. C'est le ParamConverter : de manière automatique,
Symfony comprend que l'on souhaite avoir accès à l'objet et à tous ses composants.

```
    #[Route('/article/{slug}', name: 'post.show', methods: ['GET'])]
    public function show(Post $post, PostRepository $postRepository): Response
    {
        return $this->render('pages/blog/show.html.twig', [
            'post' => $post,
        ]);
    }
```

### ✅ Partager un article

Créer un bouton pour le réseau social souhaité : <br>

```
  <a href="https://www.facebook.com/sharer/sharer.php?u={{ absolute_url(path('post.show', {slug: post.slug})) }}"
       class="share facebook">
        <svg class="w-6 h-6 text-blue-600 fill-current mr-4" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
    </a>
```

### ✅ Relation ManyToMany enter 2 entités

Création de la jointure entre les entités Posts et Category. Ajout des Fixtures. 

Tout cela grâce à l'ArrayCollection qui va retourner les données sous forme de tableau PHP

```
$this->categories = new ArrayCollection();
```

Puis, création des fonctions d'ajout et de suppression des données grâce aux entités.

```
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addPost($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $category->removePost($this);
        }

        return $this;
    }
```

### ✅ Créer un composant pour badger les catégories
Dans component, on créer *_badges.html.twig* qui contient le code suivant : <br>
```
{% if badges %}
	<div class="badges flex justify-start my-1 flex-wrap">
		{% for badge in badges %}
			<span class="text-xs inline-block mr-2 mb-2 py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-blue-600 text-white rounded-full">
				<a href="{{ path('category.index', {slug: badge.slug}) }}">{{ badge.name }}</a>
			</span>
		{% endfor %}
	</div>
{% endif %}
```
On fait ensuite un **include** du component fraichement crée.
```
{% include "components/_badges.html.twig" with {
    badges: post.categories
} only %}
```

### Créer un dropdown avec un EventSubscriber
