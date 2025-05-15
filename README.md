<p align="center">   <img src="https://img.shields.io/badge/Symfony-7.2-000000?logo=symfony" alt="Symfony 7" />   <img src="https://img.shields.io/badge/PHP-8.2-%23777BB4?logo=php" alt="PHP 8.2" />   <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License: MIT" />   <img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status" /> </p>

# API Symfony Blog - Formation

> **MonAPI** est le back-end RESTful d’une application de gestion d’articles.
> Il expose des endpoints pour **CRUD** d’articles et gère l’upload d’images.
>
> Ce projet est à but éducatif et est utilisé dans le cadre de formation en développement web.

---

## 📋 Table des matières

1. [Prérequis](#%EF%B8%8F-prérequis)
2. [Installation](#%EF%B8%8F-installation)
3. [Usage](#-usage)
4. [Endpoints API](#-endpoints-api)
5. [Contribution](#-contribution)
6. [Licence](#-licence)
7. [Développement d'une API REST avec Symfony](#développement-dune-api-rest-avec-symfony-et-vuejs)

---

## 🛠️ Prérequis

Avant de commencer, assurez-vous d’avoir :

| Outil              | Version minimale |
| ------------------ | ---------------- |
| PHP                | 8.2              |
| Composer           | 2.5              |
| Symfony CLI (opt.) | 6.4              |
| MySQL / PostgreSQL | 10+              |

---

## ⚙️ Installation

1. **Cloner** le dépôt

    ```bash
    git clone https://github.com/Pierre-brtrd/api-blog-backend.git
    cd monapi
    ```

2. **Installer** les dépendances

    ```bash
    composer install
    ```

3. **Configurer** votre `.env`

    ```bash
    APP_ENV=dev
    APP_SECRET=your_secret
    DATABASE_URL="mysql://db_user:db_pass@127.0.0.1:3306/db_name"
    ```

4. **Créer** la base de données et **migrer**

    ```bash
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    ```

5. **Lancer** le serveur (dev)

    ```bash
    symfony serve
    # ou
    php -S 127.0.0.1:8000 -t public
    ```

---

## 🚀 Usage

-   Toutes les routes sont préfixées par `/api`
-   JSON requests & responses uniquement
-   Authentification JWT (LexikJWTBundle) sur les routes protégées

---

## 📡 Endpoints API

| Méthode    | Chemin                            | Description                                | Auth               | Paramètres                                                                                                                               |
| ---------- | --------------------------------- | ------------------------------------------ | ------------------ | ---------------------------------------------------------------------------------------------------------------------------------------- |
| **GET**    | `/api/admin/articles`             | Récupère tous les articles (paged)         | **Bearer** (Admin) | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6)                                                                    |
| **POST**   | `/api/admin/articles`             | Crée un nouvel article                     | **Bearer** (Admin) | Body JSON → `CreateArticleRequest` { title, content, enabled, userId }                                                                   |
| **GET**    | `/api/admin/articles/{id}`        | Récupère un article par son ID             | **Bearer** (Admin) | `id` (path, string)                                                                                                                      |
| **PATCH**  | `/api/admin/articles/{id}`        | Met à jour un article                      | **Bearer** (Admin) | `id` (path), Body JSON → `UpdateArticleRequest` { title?, content?, enabled?, userId? }                                                  |
| **DELETE** | `/api/admin/articles/{id}`        | Supprime un article                        | **Bearer** (Admin) | `id` (path)                                                                                                                              |
| **POST**   | `/api/admin/articles/{id}/upload` | Upload d’une image pour un article         | **Bearer** (Admin) | `id` (path), Body multipart → champ `image` (binary)                                                                                     |
| **GET**    | `/api/admin/articles/{id}/switch` | Bascule l’état `enabled` d’un article      | **Bearer** (Admin) | `id` (path)                                                                                                                              |
| **GET**    | `/api/articles`                   | Récupère la liste paginée d’articles front | _Public_           | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6)                                                                    |
| **GET**    | `/api/admin/users`                | Récupère tous les utilisateurs (paged)     | **Bearer** (Admin) | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6)                                                                    |
| **GET**    | `/api/admin/users/{id}`           | Récupère un utilisateur par son ID         | **Bearer** (Admin) | `id` (path, string)                                                                                                                      |
| **PATCH**  | `/api/admin/users/{id}`           | Met à jour un utilisateur                  | **Bearer** (Admin) | `id` (path), Body JSON → `UpdateProfileRequest` { firstName?, lastName?, username?, currentPassword?, plainPassword?, confirmPassword? } |
| **DELETE** | `/api/admin/users/{id}`           | Supprime un utilisateur                    | **Bearer** (Admin) | `id` (path)                                                                                                                              |
| **POST**   | `/api/profile/register`           | Inscription d’un nouvel utilisateur        | _Public_           | Body JSON → `RegistrationRequest` { username, firstName?, lastName?, plainPassword, confirmPassword }                                    |
| **GET**    | `/api/profile`                    | Récupère le profil de l’utilisateur        | **Bearer** (User)  | _Aucun_                                                                                                                                  |
| **PATCH**  | `/api/profile/update`             | Met à jour le profil de l’utilisateur      | **Bearer** (User)  | Body JSON → `UpdateProfileRequest` { firstName?, lastName?, username?, currentPassword?, plainPassword?, confirmPassword? }              |
| **DELETE** | `/api/profile/delete`             | Supprime le profil de l’utilisateur        | **Bearer** (User)  | _Aucun_                                                                                                                                  |

> 📝 Pour chaque endpoint protégé, ajoutez le header `Authorization: Bearer <token>`.

---

## 🤝 Contribution

1. Forkez le projet
2. Créez une branche `feat/ma-feature`
3. Committez vos changements (`git commit -m 'feat: add ...'`)
4. Pushez vers `origin feat/ma-feature`
5. Ouvrez une Pull Request

Merci pour votre contribution ! 🚀

---

## 📄 Licence

Ce projet est sous licence **MIT** — voir le fichier LICENSE pour plus de détails.

---

# Développement d'une API REST avec Symfony et VueJs

Dans ce cours, nous allons découvrir ce qu'est une API REST et comment la développer avec le framework Symfony. Une fois que nous aurons terminé le développement de l'API côté backend, nous allons développer le frontend avec le framework VueJS.

### Prérequis pour le cours

Vous devez avoir une base de connaissance dans l'écosystème Symfony et VueJs pour pouvoir suivre ce cours.

Nous utiliserons Postman comme client léger pour tester notre API sans avoir à devoir mettre en place notre application VueJS.

# Introduction aux API REST

## Qu’est-ce qu’une API ?

Une **API** (Application Programming Interface) est un ensemble de règles et de conventions qui permettent à des logiciels de communiquer entre eux. Elle définit les méthodes d'accès aux fonctionnalités ou aux données d'une application, sans en exposer les détails internes.

Dans le contexte du développement web, une API permet à une application cliente (comme une application web en Vue.js ou mobile) de dialoguer avec un serveur distant (souvent une application écrite en Symfony, Node.js, etc.).

Pour vulgariser, une API est souvent considéré comme un traducteur universel pour n'importe quelle type d'application (chaque techno par un langage différent), l'API sert donc de traducteur pour que tous les micro services de votre écosystème puissent se parler entre eux.

## Qu’est-ce qu’une API REST ?

**REST** (Representational State Transfer) est un style d'architecture d’API basé sur des principes simples, robustes et largement adoptés sur le web. Il repose sur les standards HTTP et utilise les **URI** pour identifier les ressources.

Une API REST est dite **stateless** : chaque requête doit contenir toutes les informations nécessaires à son traitement (authentification, paramètres, etc.), sans conserver d’état côté serveur entre deux requêtes.

## Principes fondamentaux d’une API REST

Voici les grands principes que doit respecter une API REST :

| Principe              | Description                                                                     |
| --------------------- | ------------------------------------------------------------------------------- |
| **Client-Serveur**    | Séparation claire entre le client (frontend) et le serveur (backend).           |
| **Stateless**         | Le serveur ne garde pas d’état entre deux requêtes.                             |
| **Cacheable**         | Les réponses peuvent être mises en cache, quand cela est pertinent.             |
| **Uniform Interface** | Interface uniforme pour manipuler les ressources.                               |
| **Layered System**    | L’architecture peut être composée de plusieurs couches (proxy, sécurité, etc.). |

## Les ressources dans une API REST

Une API REST repose sur la **manipulation de ressources** (ex. : utilisateurs, produits, commandes…). Chaque ressource est identifiée par une **URL unique**.

Exemple :

```http
GET /api/products        -> Liste des produits
GET /api/products/42     -> Produit avec l’identifiant 42
POST /api/products       -> Créer un nouveau produit
PUT /api/products/42     -> Mettre à jour le produit 42
DELETE /api/products/42  -> Supprimer le produit 42
```

## Les méthodes HTTP utilisées

| Méthode    | Utilisation courante                      |
| ---------- | ----------------------------------------- |
| **GET**    | Récupérer une ou plusieurs ressources     |
| **POST**   | Créer une ressource                       |
| **PUT**    | Mettre à jour entièrement une ressource   |
| **PATCH**  | Mettre à jour partiellement une ressource |
| **DELETE** | Supprimer une ressource                   |

## Exemple d'échange API REST

### Requête HTTP

```http
GET /api/users/1 HTTP/1.1
Host: api.example.com
Authorization: Bearer xxxxxx
```

### Réponse JSON

```json
{
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com"
}
```

---

## Avantages d'une API REST

-   Simplicité : Repose sur HTTP, un protocole universel.
-   Flexibilité : Peut être consommée par tout type de client (web, mobile, desktop).
-   Evolutivité : Architecture adaptée aux systèmes distribués.
-   Séparation des responsabilités : Permet un découplage clair entre frontend et backend.

# Les Endpoints dans une API REST

## Qu’est-ce qu’un endpoint ?

Un **endpoint** (ou point de terminaison) est une **URL** exposée par une API permettant à un client de communiquer avec le serveur. Il représente une **porte d’entrée** vers une ou plusieurs ressources de l’application.

Par exemple :

```http
GET /api/users
```

Cet endpoint permet de récupérer la liste des utilisateurs.

---

## Structure d’un endpoint

Un endpoint est généralement composé de :

-   Le **verbe HTTP** (GET, POST, PUT, PATCH, DELETE),
-   Une **route** (URL) pointant vers une ressource ou une action spécifique.

Exemple d’endpoint complet :

```http
GET /api/products/42
```

-   **Verbe HTTP :** GET (lecture)
-   **Ressource :** `/api/products`
-   **Identifiant :** `42` (produit spécifique)

---

## Convention de nommage RESTful

Dans une API REST bien conçue, les endpoints doivent suivre des conventions claires et cohérentes. Voici les plus courantes :

| Verbe HTTP | Endpoint             | Action                                 |
| ---------- | -------------------- | -------------------------------------- |
| GET        | `/api/products`      | Récupérer la liste des produits        |
| GET        | `/api/products/{id}` | Récupérer un produit spécifique        |
| POST       | `/api/products`      | Créer un nouveau produit               |
| PUT        | `/api/products/{id}` | Remplacer un produit existant          |
| PATCH      | `/api/products/{id}` | Mettre à jour partiellement un produit |
| DELETE     | `/api/products/{id}` | Supprimer un produit                   |

---

## Bonnes pratiques

-   Utiliser des **noms au pluriel** pour les ressources : `/api/users`, `/api/orders`.
-   Ne pas inclure de verbe dans l’URL : on n’écrit pas `/getUser` ou `/deleteProduct`.
-   Respecter les conventions HTTP pour les statuts de réponse :
    -   `200 OK` pour une récupération ou une modification réussie
    -   `201 Created` après une création
    -   `204 No Content` après une suppression
    -   `400 Bad Request`, `401 Unauthorized`, `404 Not Found`, etc. en cas d’erreur
-   Versionner l’API si nécessaire : `/api/v1/products`

---

## Exemple concret

Voici une série d’endpoints pour gérer des **utilisateurs** :

```http
GET    /api/users           -> Liste des utilisateurs
POST   /api/users           -> Création d’un utilisateur
GET    /api/users/5         -> Détails de l’utilisateur 5
PUT    /api/users/5         -> Mise à jour complète de l’utilisateur 5
PATCH  /api/users/5         -> Mise à jour partielle de l’utilisateur 5
DELETE /api/users/5         -> Suppression de l’utilisateur 5
```

Chaque endpoint est **déterministe**, basé sur l’**action** attendue et la **ressource** ciblée.

---

## Résumé

Un **endpoint** est une combinaison du verbe HTTP et d'une route d’URL représentant une action sur une ressource. Il est essentiel de les structurer clairement pour garantir la lisibilité, la maintenabilité et la cohérence de l’API.

## Débuter son développement Backend

Pour bien débuter son développement Backend, vous devez dans un premier temps définir vos endpoint et votre structure, qui va vous permettre de mieux organiser votre développement.

Pour ce cours, nous allons développer une API pour un blog avec les fonctionnalités suivantes:

-   Gestion des utilisateurs - CRUD
-   Gestion des articles - CRUD
-   Login - Auth

Maintenant avant de développer notre API, nous devons définir nos endpoints:

| Ressource         | Description              | Endpoints principaux                                                                                                                                                                                                                            |
| ----------------- | ------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Utilisateurs      | Gestion des utilisateurs | - `POST /api/register`<br />- `GET /api/profile`<br />- `PATCH /api/profile`<br />- `GET /api/admin/users`<br />- `GET /api/admin/users/{id}`<br />- `PATCH /api/admin/users/{id}`<br />- `DELETE /api/admin/users/{id}`                        |
| Articles          | Gestion des articles     | - `GET /api/articles`<br />- `GET /api/articles/{slug}`<br />- `GET /api/admin/articles`<br />-`GET /api/admin/articles/{id}`<br />- `POST /api/admin/articles`<br />- `PATCH /api/admin/articles/{id}`<br />-`DELETE /api/admin/articles/{id}` |
| Authentificassion | Gestion de la connexion  | - `POST /api/login`                                                                                                                                                                                                                             |

Voilà, maintenant c'est déjà plus claire dans notre développement et nous allons pouvoir commencer en ayant déjà en tête tous nos endpoints.

## Installer son projet Symfony

Pour notre Api, nous utilisons Symfony qui va nous permettre de faciliter le développement avec un ecosytème robuste, fiable et rapide.

Dans un premier installé votre projet symfony, créé un nouveau dossier vierge sur votre poste, ouvrez le avec VsCode et ouvrez un terminal, puis la ligne de commande:

```shell
symfony new . --version="7.*"
```

> [!WARNING]
>
> Si vous avez l'habitude de faire des webapp avec Symfony, ne rajoutez pas l'argument de commande --webapp qui va vous installer trop de dépendance inutile pour notre API, nous développons un micro service, pas une application en monolithique

Une fois que c'est fait, vous allez voir que nous avons très peu de dossier comparé à une Install en webapp, c'est normal, beaucoup moins de bundle sont installé par défaut, c'est pour ça qu'avant de débuter le développement nous allons rajouter des bundle qui vont nous être utiles:

```shell
composer require doctrine/orm doctrine/doctrine-bundle symfony/security-bundle symfony/serializer-pack doctrine/doctrine-migrations-bundle
```

Ici nous venons de rajouter Doctrine, l'ORM que nous allons utiliser, security qui va nous permettre de gérer les droits sur nos endpoint ainsi que la connexion, et enfin serializer, un bundle très pratique qui nous sera utile au moment de faire la traduction de nos entity en PHP pour du JSON.

Maintenant, pour notre développement, nous allons vouloir utiliser le Maker bundle, qui va nous permettre de générer des fichiers symfony et nous faire gagner du temps, et nous allons également installer le bundle de fixtures avec Faker pou générer du contenu de test.

```shell
composer require --dev doctrine/doctrine-fixtures-bundle fakerphp/faker symfony/maker-bundle
```

> [!WARNING]
>
> N'oublié pas l'argument --dev qui définit que ces bundle ne sont accessible qu'en environnement de dev, vous ne voulez pas les laisser disponible en production, ce qui serait une faille de sécurité

Dernière étape, vous devez configuré votre DATABASE_URL dans le fichier .env.local pour gérer la connexion avec votre base.

Ensuite vous pouvez créer votre base de données.

Et voilà, nous allons pouvoir commencer le développement.

## Création de la ressource User

Dans un premier temps, nous allons créer notre premier entity dans Symfony, celle de nos utilisateurs. Nous savons déjà que c'est une entité particulière, car elle doit être relié à notre système de connexion.

Donc pour créer cette entité, vous allez faire la commande:

```shell
symfony console make:user
```

Nous allons utiliser le username pour l'identification de nos user.

Maintenant, nous allons vouloir rajouter des propriétés à notre entité pour ajouter le prénom, le nom, la date de création et de dernière mise à jour. Le seul champ supplémentaire obligatoire est createdAt, le reste des nouveau peut être null

```shell
symfony console make:entity User
```

### Utiliser des Traits

Nous venons de voir 2 propriétés que nous allons retrouver dans beaucoup d'entité `createdAt` et `updatedAt`, donc, dans un contexte de code propre et réutilisable (principe DRY), nous allons pouvoir créer un trait PHP avec nos 2 propriétés, que nous ajouterons à toutes les entity qui en ont besoin.

Tout d'abord créez un dossier Traits dans le dossier Entity et créez votre `DateTimeTrait`:

```php
<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
```

> [!WARNING]
>
> Vous devez déplacer les propriétés et méthode createdAt et updatedAt depuis votre entité User (nous ne voulons plus qu'elle soit dans User mais seulement dans notre trait), sinon, vous allez créer des champs dupliqués

Maintenant dans votre User.php, vous devez simplement utiliser votre trait:

```php
<?php

namespace App\Entity;

use App\Entity\Trait\DateTimeTrait; // On Use le trait pour l'utiliser
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DateTimeTrait; // On importe le trait

  	// etc ...
}
```

Et voilà, maintenant, dès qu'une entité a besoin des 2 champs, vous n'avez plus qu'à importer votre trait dans l'entité !

### L'auto createdAt et updatedAt

Par soucis de temps et de simplicité, nous voulons que ces deux champs soit automatiquement remplit par notre application, respectivement à la création ET la mise à jour de nos entité.

Doctrine à un outil très pratique qui sont les `EntityListener` qui comme leur nom l'indique, sont des évènements liés aux entité, il en existe plusieurs, mais pour une logique aussi simplement nous allons utiliser un `LifecycleCallback`.

Concrètement nous allons créer une méthode dans notre trait qui sera appelé automatiquement pour notre application grâce à des évènements sur nos entité (création ou mise à jour par exemple). Dans un premier temps, nous allons créer 2 nouvelles méthode dans notre trait:

```php
# src/Entity/Traits/DateTimeTrait.php

trait DateTimeTrait
{
   // ...Propriétés et méthode du trait

  public function autoSetCreatedAt(): void
  {
      if ($this->createdAt === null) {
          $this->createdAt = new \DateTimeImmutable();
      }
  }

  public function autoSetUpdatedAt(): void
  {
      $this->updatedAt = new \DateTimeImmutable();
  }
}
```

Maintenant, il faut prévenir Doctrine quand exécuter ces méthode, pour ça nous allons utiliser les attributs PHP définit par Doctrine:

```php
# src/Entity/Traits/DateTimeTrait.php

trait DateTimeTrait
{
   // ...Propriétés et méthode du trait

  #[ORM\PrePersist]
  public function autoSetCreatedAt(): void
  {
      if ($this->createdAt === null) {
          $this->createdAt = new \DateTimeImmutable();
      }
  }

  #[ORM\PreUpdate]
  public function autoSetUpdatedAt(): void
  {
      $this->updatedAt = new \DateTimeImmutable();
  }
}
```

Ici nous ajoutons sur chaque méthode le déclenchement juste avant de créer une entité, et juste avant la mise à jour d'une entité, ce qui fait que ces méthodes vont être totalement automatique à partir du moment où on fait une manipulation en BDD pour une entité.

Dernier étape pour que cela fonctionne, il faut ajouter sur la classe de notre entité un attribut particulier pour que Doctrine écoute les évènements (`LifecycleCallbacks`), nous sommes obligé de l'ajouter sur une classe d'entité, donc nous ne pouvons pas l'ajouter directement dans notre Trait, mais sur l'entité.

```php
<?php

namespace App\Entity;

use App\Entity\Trait\DateTimeTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ORM\HasLifecycleCallbacks] // <- Nous rajoutons l'indication à doctrine d'écouter les events
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
}
```

> [!WARNING]
>
> Si vous ne rajoutez pas `#[ORM\HasLifecycleCallbacks]` à vos entité, aucune méthode ne sera exécuté de manière automatique, il faut toujours penser à le mettre si vous utilisez des LifecycleCallbacks dans vos entités

Pour plus d'informations sur ce process, vous pouvez regarder la [documentation](https://symfony.com/doc/current/doctrine/events.html)

### Créer votre table

Maintenant vous pouvez donc créer votre table avec les commandes:

```shell
symfony console make:migration
symfony console d:m:m
```

Et voilà vous avez maintenant votre table.

## Créer des fixtures

Avant de vouloir faire notre premier endpoint, nous allons devoir créer des users.

Pour ça, nous allons utiliser des fixtures pour gagner du temps. Dans votre dossier src, vous avez un dossier DataFixtures, qui a été créé avec l'installation du bundle de fixture et vous avez un fichier AppFixture, c'est dans fichier que nous allons créer nos fixtures.

```php
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setUsername('admin')
            ->setFirstName('Admin')
            ->setLastName('User')
            ->setRoles(['ROLE_ADMIN'])
            ;

      	$manager->persist($user);
        $manager->flush();
    }
}
```

Nous sommes en train de créer notre premier utilisateur admin, mais vous voyez ici qu'il n'y a pas le mot de passe, car dans symfony, pour hasher correctement le mot de passe il faut utiliser la `UserPasswordHasherInterface`, nous allons donc créer une propriété via le contruct de notre class AppFixture afin que Symfony nous autoload la bonne classe pour que nous puissions l'utiliser pour hasher le mot de passe:

```php
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setUsername('admin')
            ->setFirstName('Admin')
            ->setLastName('User')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword($user, 'admin')
            )
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
```

Maintenant pour créer votre fixture vous devez faire la commande:

```shell
symfony console doctrine:fixtures:load
```

Parfait, vous savez maintenant utiliser des fixtures, mais maintenant, nous allons vouloir créer 10 utilisateurs random en plus de notre admin. Pour ça nous allons vouloir utiliser Faker:

```php
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker; // Props qui va stocker le générateur faker

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        // On initialise le générateur faker
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setUsername('admin')
            ->setFirstName('Admin')
            ->setLastName('User')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword($user, 'admin')
            )
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
```

Maintenant, dans votre propriété faker, vous avez accès à toutes les méthodes de génération aléatoire de [faker](https://fakerphp.org/)

Pour créer 10 utilisateurs random, nous allons ajouter en dessous de notre premier user (il faut le garder car quand vous allez charger vos nouvelles fixtures, la BDD va être purgée)

```php
<?php

  // ...Fixture user admin

  for ($i = 0; $i < 10; $i++) {
      $user = new User();

      $user
          ->setUsername($this->faker->unique()->userName())
          ->setFirstName($this->faker->firstName())
          ->setLastName($this->faker->lastName())
          ->setRoles(['ROLE_USER'])
          ->setPassword(
              $this->passwordHasher->hashPassword($user, 'password')
          )
      ;

      $manager->persist($user);
  }

	$manager->flush();
```

Relancez la commande de load des fixtures, et voilà vous avez 10 utilisateurs aléatoire !

## Récupérer la liste des users

Maintenant que nous avons notre première table de remplis avec des données, nous allons pouvoir créer le premier endpoint admin `GET /api/admin/users` qui va permettre de récupérer la liste de tout les utilisateurs dans notre table.

Pour le moment, les endpoint /api/admin ne sont pas encore protégés, nous le ferons dans un second temps.

Tout d'abord, nous allons devoir créer un contrôler qui va nous permettre de créer une nouvel route (Oui, un endpoint du côté de Symfony est simplement une route).

```php
<?php

namespace App\Controller\Backend\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/users', name: 'api_admin_users_')]
class UserController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {

    }
}
```

Voilà un bon début de contrôler. Les points d'attention ici, c'est que, dans le cadre d'une API, nos méthode dans notre controller ne renverront QUE du JsonResponse (Objet de symfony représentant une réponse HTTP en format JSON).

Maintenant, juste pour tester, nous allons dire que pour ce endpoint, nous allons renvoyer en JSON un petit hello World:

```php
<?php

#[Route('', name: 'index', methods: ['GET'])]
public function index(): JsonResponse
{
    return $this->json([
        'message' => 'Hello World!',
    ]);
}
```

Ici on return non pas un `render()` comme dans une webapp classique, mais simplement `json()` qui va automatiquement formater le tableau associatif en paramètre en format JSON. Cette méthode est définit dans le `AbstractController` de Symfony.

### Tester son API

Maintenant, nous n'allons pas directement commencer à coder notre front en VueJs juste pour vérifier qu'on a bien un hello world. Pour simplifié la vie des développeur Backend API, des outils de clients comment Postman ou Bruno par exemple sont très pratique. De mon côté j'utilise PostMan par habitude.

Donc première étape de notre test, lancer son server symfony et ouvrir PostMan.

Maintenant sur PostMan faire une requête `GET https://localhost:8000/api/admin/users`

Vous devriez voir en réponse:

```json
{
    "message": "Hello World!"
}
```

Félicitations, vous venez de créer votre premier endpoint API fonctionnel !

Mais maintenant, nous voulons afficher la liste de tous les utilisateurs de ma BDD, donc je dois modifier mon controller.

Dans ma méthode index, je vais devoir utiliser le `UserRepository` afin de pouvoir faire un `findAll()` pour récupérer toute la liste:

```php
<?php

namespace App\Controller\Backend\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/users', name: 'api_admin_users_')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->userRepository->findAll() // Je récupère tous les utilisateurs
        );
    }
}
```

Ici je peux passer la réponse de `findAll()` directement en paramètre de `json()` car la réponse est un tableau, qui va être automatiquement convertit en json pour la réponse du server.

Et voilà, aussi simple que ça, vous avez maintenant votre endpoint users qui renvoie bien un tableau avec tout vos users en JSON.

## Filtrer les données envoyée

Pour le moment, nous avons peu de données, et peu de champ dans la table User. Mais dans certains cas, voir certains endpoint, nous ne voulons pas afficher certaines informations, comme le mot de passe, ou les roles de l'utilisateur si nous sommes sur un endpoint publique.

Pour régler ce problème, nous allons utiliser le concepts de `Groups` avec symfony ainsi que la serialization de nos objet.

Avant de rentrer dans le vif du sujet, voici le schéma de la [serialization dans symfony](https://symfony.com/doc/current/serializer.html):

![serializer](/Users/pierre/Documents/Formations/Visuel Cours/Symfony/serializer.png)

Comme nous pouvons le voir, le principe de `serialize` consiste à transformer un objet PHP en format Api (JSON par exemple), le concept inverse est donc le `deserialize` de passer d'un format API à un format PHP.

Symfony utilise ces concepts dès que vous voulez convertir des objet en JSON et vice-versa.

### Les Groups

Maintenant, les Groups dans symfony sont utilisés par le `serializer` pour filtrer les données à convertir ou non, c'est pourquoi c'est tout indiqué à utiliser dans un contexte d'API et de filtre des données à envoyer.

Pour définir un group, vous devez le faire directement dans l'entité concernée et pour chaque propriété ou méthode que vous souhaitez renvoyer à une réponse API.

Dans notre cas, pour la liste des admin, nous allons créer un Group `common:read` pour les utilitaires de chaque entité, un autre `user:index` et encore un autre `user:admin:index`.

Pourquoi ces 3 groups ?

-   `common:read` -> pour les utilitaires dans nos traits (createdAt par exemple)
-   `user:index` -> informations à envoyé dès que nous sommes sur un endpoint publique
-   `user:admin:index` -> Information sensible à envoyer dès que nous sommes sur un endpoint privé

Donc rendez-vous dans votre entité User et nous allons créer les groups pour user:

```php
<?php

namespace App\Entity;

// ... Autre use
use Symfony\Component\Serializer\Attribute\Groups;

// ...Attributs de classe
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
   	use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['common:index'])] // <- Nous décidons que pour le group 'common:index' l'id sera envoyé
    private ?int $id = null;

  	#[ORM\Column(length: 180)]
    #[Groups(['user:index'])]
    private ?string $username = null;

  	#[ORM\Column]
    #[Groups(['user:admin:index'])] // <- Group seulement pour les admin
    private array $roles = [];

  	#[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:index'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:index'])]
    private ?string $lastName = null;

  	// ... Reste du fichier
}
```

Dernière étape pour vérifier, nous devons dans le controller indiqué dans la méthode `json()` quel group il doit utiliser pour le serializer:

```php
<?php
// src/Controller/Backend/User/UserController.php

#[Route('', name: 'index', methods: ['GET'])]
public function index(): JsonResponse
{
    return $this->json(
        $this->userRepository->findAll(),// Je récupère tous les utilisateurs
        context: [
            'groups' => [
              'common:index',
              'user:index',
              'user:admin:index'
            ], // Je précise les groupes de sérialisation
        ]
    );
}
```

Maintenant, si vous relancer une requête sur PostMan, vous verrez seulement les données qui ont un des groups définit dans le contexte du controller.

Vous pouvez également ajouter le group `common:index` à createdAt et updatedAt directement dans votre Trait.

Vous pouvez également mettre un group sur une méthode dans une entité. Par exemple, nous allons créer une nouvelle méthode `getFullName()` dans notre entité User afin de pouvoir récupérer facilement le nom complet sans avoir besoin de recréer un nouveau champ en BDD:

```php
<?php
// src/Entity/User.php

public function getFullName(): string
{
    return "$this->firstName $this->lastName";
}
```

Vous pouvez très bien lui ajouter un group afin que dans la réponse, il y ait également le nom complet:

```php
<?php
// src/Entity/User.php

#[Groups(['user:index'])]
public function getFullName(): string
{
    return "$this->firstName $this->lastName";
}
```

Et voilà, vous avez maintenant le fullName dans la réponse JSON.

## La création de User

Maintenant, nous allons vouloir créer le endpoint `POST /api/register` qui va nous permettre de créer des utilisateurs.

Lorsqu’on expose des endpoints comme `POST /api/register`, on permet à n’importe quel client d’envoyer des données à notre API pour créer un utilisateur. Il est donc crucial de **contrôler, valider et sécuriser ces données** avant toute persistance.

C’est ici qu’entrent en jeu les **DTO** (Data Transfer Object) et les **contraintes de validation**.

### Qu’est-ce qu’un DTO ?

Un **DTO (Data Transfer Object)** est un objet **intermédiaire** entre la requête HTTP reçue et notre entité métier (`User` par exemple). Il sert à **transporter des données** sans exposer directement nos entités.

### Exemple simple

```php
<?php

class RegisterUserDto
{
    public string $email;
    public string $password;
    public string $firstname;
    public string $lastname;
}
```

### Objectif :

-   **Découpler** l’API de la structure interne de l’entité.
-   **Filtrer** les champs autorisés depuis le frontend.
-   **Valider** les données avec précision.
-   Éviter les failles comme le **mass assignment** (ex : pouvoir forcer un rôle via la requête).

### Pourquoi utiliser un DTO ?

| Avantage                  | Description                                                                                                   |
| ------------------------- | ------------------------------------------------------------------------------------------------------------- |
| **Sécurité**              | Empêche l’utilisateur de définir des champs sensibles (ex : `roles`, `isVerified`, etc.).                     |
| **Validation propre**     | Chaque DTO peut être validé avec des contraintes spécifiques (email valide, mot de passe fort, etc.).         |
| **Clarté**                | On sépare les responsabilités : l’Entité représente le modèle de données, le DTO représente la requête reçue. |
| **Maintenance facilitée** | On peut faire évoluer les DTO sans impacter la base de données ou les entités.                                |
| **Testabilité**           | Les DTO permettent d’écrire des tests ciblés sur les entrées utilisateur.                                     |

### Les contraintes de validation

Grâce au **composant Validator** de Symfony, on peut appliquer des règles directement sur le DTO avec des **attributs PHP 8+**

Tout d'abord, vous allez devoir installer le bundle:

```shell
composer require symfony/validator
```

Maintenant, vous allez pouvoir utiliser des contraints des symfony déjà prête à l'emploi et sécurisé.

## Création du DTO RegisterDto

Maintenant, vous allez créer un nouveau dossier dans le dossier src qui va se nommer `Dto`, c'est dans ce dossier que vous allez mettre tout les Dto de votre API:

```php
<?php

namespace App\Dto;

class RegisterDto
{
    public function __construct(
        private ?string $username,
        private ?string $plainPassword,
        private ?string $confirmPassword,
        private ?string $firstName,
        private ?string $lastName,
    ) {
    }
}
```

Ici nous avons créer les propriétés que nous allons attendre dans la requête de création d'un user, donc comme c'est un endpoint publique, nous n'allons pas demander les roles qui est une propriété sensible. Et nous n'avons pas la propriété Password, mais plainPassword et confirmPassword, car nous allons récupérer un mot de passe en claire et une confirmation de Password qui devra être identique à plainPassword pour être valide.

Maintenant nous allons rajouter les contraintes de validation:

```php
<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert; // On utilise un alias pour éviter trop de use

#[UniqueEntity(
    fields: ['username'],
    message: 'Ce nom d\'utilisateur est déjà utilisé', // <- Permet de gérer la contrainte d'unicité
    entityClass: User::class,
)]
class RegisterDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le mot de passe est requis')]
        #[Assert\Length(
            min: 1,
            max: 180,
            minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le mot de passe ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $username,

        #[Assert\NotBlank(message: 'Le mot de passe est requis')]
        #[Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le mot de passe ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $plainPassword,

        #[Assert\NotBlank(message: 'La confirmation du mot de passe est requise')]
        #[Assert\EqualTo(
            propertyPath: 'plainPassword',
            message: 'La confirmation du mot de passe doit être identique au mot de passe'
        )]
        private ?string $confirmPassword,

        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le prénom ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $firstName,

        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $lastName,
    ) {
    }
}
```

Et voilà, pour chaque propriété nous pouvons adapter les contraintes en fonction du contexte de register.

Maintenant n'oubliez pas de générer les getter (seulement les getters sont utile ici).

### Flux de traitement d’une requête `POST /api/register`

1. Le client envoie un JSON avec les données utilisateur.
2. Symfony les désérialise dans un `RegisterDto`.
3. On valide ce DTO avec le `ValidatorInterface`.
4. Si le DTO est valide, on crée un `User` à partir de ses données.
5. On encode le mot de passe avec `UserPasswordHasherInterface`.
6. On persiste l’entité `User` avec Doctrine.

### Pourquoi ne pas utiliser directement l’entité `User` ?

Même si cela peut fonctionner, exposer l’entité directement dans les formulaires d’API est **dangereux** :

❌ Risques :

-   Un utilisateur pourrait définir des champs non autorisés (`roles`, `isVerified`, `createdAt`, etc.).
-   Le mapping JSON ↔ entité devient complexe et peu lisible.
-   Difficile de gérer des cas spécifiques (ex : confirmation de mot de passe, conditions d’utilisation, champs temporaires).

✅ Solution : utiliser un **DTO bien défini** et contrôler précisément ce qu’on accepte.

## Mapper : Simplifier la transformation DTO → Entité

### Pourquoi un Mapper ?

Quand on utilise des **DTO** pour sécuriser et structurer les données entrantes dans notre API, il faut ensuite les **convertir en entités** Doctrine avant de les enregistrer en base de données.

Ce travail de transformation peut devenir **répétitif et verbeux**, surtout si on le fait dans les contrôleurs. Pour éviter ça, on externalise cette logique dans une **classe de mapping** appelée _Mapper_.

---

### Objectif du Mapper

-   Centraliser toute la logique de transfert des données d’un DTO vers une entité.
-   Garder les **contrôleurs légers et lisibles**.
-   Factoriser le **hachage du mot de passe** ou la gestion conditionnelle de certains champs.
-   Faciliter la **réutilisation** du mapping pour différents types de requêtes.

## Exemple de `UserMapper`

```php
<?php

namespace App\Mapper;

use App\Dto\User\UpdateAdminUpdateRequest;
use App\Dto\User\UserRequestInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {}

    public function map(UserRequestInterface $dto, ?User $user): User
    {
        $user ??= new User();

        if (null !== $dto->getUsername()) {
            $user->setUsername($dto->getUsername());
        }
        if (null !== $dto->getFirstName()) {
            $user->setFirstName($dto->getFirstName());
        }
        if (null !== $dto->getLastName()) {
            $user->setLastName($dto->getLastName());
        }

        if (null !== $dto->getPlainPassword()) {
            $hashed = $this->hasher->hashPassword($user, $dto->getPlainPassword());
            $user->setPassword($hashed);
        }

        if ($dto instanceof UpdateAdminUpdateRequest && null !== $dto->getRoles()) {
            $user->setRoles($dto->getRoles());
        }

        return $user;
    }
}
```

### Explication ligne par ligne

| Partie du code                        | Rôle                                                                                                     |
| ------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| `?User $user`                         | Permet de mapper soit vers un nouvel utilisateur (register), soit un utilisateur existant (mise à jour). |
| `UserRequestInterface`                | Interface commune pour tous les DTO liés à un utilisateur (register, update, etc.).                      |
| `null !== $dto->getX()`               | Permet d’ignorer les champs non définis dans le DTO (utile pour les mises à jour partielles).            |
| `UserPasswordHasherInterface`         | Service Symfony utilisé pour hasher proprement le mot de passe.                                          |
| `instanceof UpdateAdminUpdateRequest` | Permet d’ajouter un comportement spécifique (comme l’ajout de rôles) uniquement pour certains DTO.       |

## Avantages du Mapper

| Avantage         | Description                                                                                     |
| ---------------- | ----------------------------------------------------------------------------------------------- |
| **Lisibilité**   | Le contrôleur appelle juste `UserMapper::map()` et reste concentré sur le flow général.         |
| **Réutilisable** | On peut utiliser le mapper pour différentes actions : création, mise à jour admin, profil, etc. |
| **Testable**     | On peut tester la logique métier du mapping indépendamment du contrôleur.                       |
| **Évolutif**     | Facile d’ajouter un nouveau champ ou une logique conditionnelle sans toucher le contrôleur.     |

## Les interfaces pour centraliser le paramètre du mapper

Dans l'exemple, je parle d'interface, mais techniquement, le paramètre envoyé à la méthode `map()` n'est pas un objet de la classe `UserRequestInterface` mais un objet Dto comme celui que nous venons de faire `RegisterDto`, mais dans d'autre contexte, nous aurons `UserAdminUpdateDto` ou `UserUpdateProfileDto`, qui vont avoir des propriétés similaire, mais une logique métier différentes. Alors, pour éviter de multiplier les types de données, nous allons mettre en place une interface pour les Dto des Users.

## Introduction aux interfaces en PHP

### Qu’est-ce qu’une interface ?

En PHP, une **interface** définit un **contrat** que doivent respecter les classes qui l’implémentent. Elle ne contient **aucune logique**, uniquement les **signatures de méthodes** que la classe devra obligatoirement définir.

> 📌 Une interface, c’est un plan, pas une implémentation.

### Syntaxe d’une interface

```php
interface Animal
{
    public function makeSound(): string;
}
```

Une classe qui implémente cette interface doit définir toutes les méthodes :

```php
class Dog implements Animal
{
    public function makeSound(): string
    {
        return 'Woof';
    }
}
```

## Pourquoi utiliser des interfaces ?

| Avantage             | Explication                                                                                 |
| -------------------- | ------------------------------------------------------------------------------------------- |
| **Contrat clair**    | On impose à toutes les classes qui implémentent l’interface d’avoir certaines méthodes.     |
| **Découplage**       | Le code dépend d’un **contrat** (interface), pas d’une implémentation spécifique.           |
| **Testabilité**      | Facile de créer des doubles (mocks) pour les tests unitaires.                               |
| **Interopérabilité** | On peut écrire du code générique qui fonctionne avec plusieurs implémentations différentes. |

## Interfaces en pratique dans Symfony

Symfony utilise les interfaces **partout** :

-   `UserInterface`, `PasswordAuthenticatedUserInterface`
-   `EventSubscriberInterface`
-   `NormalizerInterface`
-   `UserPasswordHasherInterface`
-   `CommandInterface`
-   ...

### Exemple concret : Mapper de DTO vers User

Vous devez créer votre interface dans le dossier `Dto/Interfaces` et créer `UserRequestInterface`:

```php
namespace App\Dto\Interfaces;

interface UserRequestInterface
{
    public function getUsername(): ?string;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
    public function getPlainPassword(): ?string;
}
```

## Règle d’or en architecture

> **“Code to an interface, not an implementation.”**
> Autrement dit : dépends de ce que l’objet _doit faire_, pas de _comment il le fait_.

Maintenant, vous devez faire implémenter cette interface à RegisterDto et tous les autres Dto qui concerneront les Users:

```php
namespace App\Dto;

use App\Dto\Interfaces\UserRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto implements UserRequestInterface
{
  	// Propriétés de la classe
}
```

## Création du UserMapper

Maintenant que nous avons bien préparé notre Dto ainsi que notre interface, nous allons pouvoir créer notre UserMapper.

Comme dit précédemment, c'est dans ce fichier que nous allons définir toute la logique métier de transferts entre notre Dto et notre entité User.

Donc nous allons devoir récupérer et utiliser la `UserPasswordHasherInterface` pour hasher le mot de passe, et définir un algo qui va pouvoir fonctionner pour plusieurs contexte (création ou mise à jour d'un user).

Créer votre fichier dans `src/Mapper/UserMapper.php`:

```php
<?php

namespace App\Mapper;

use App\Dto\Interfaces\UserRequestInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * Map le DTO à l'entité User.
     *
     * @param UserRequestInterface $dto Le DTO à transformer.
     * @param User|null $user L'entité User à mettre à jour ou null pour en créer une nouvelle.
     * @return User L'entité User transformée.
     */
    public function map(UserRequestInterface $dto, ?User $user): User
    {
        $user ??= new User();

        if ($dto->getUsername()) {
            $user->setUsername($dto->getUsername());
        }

        if ($dto->getFirstName()) {
            $user->setFirstName($dto->getFirstName());
        }

        if ($dto->getLastName()) {
            $user->setLastName($dto->getLastName());
        }

        if ($dto->getPlainPassword()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $dto->getPlainPassword())
            );
        }

        return $user;
    }
}
```

Et voilà, nous faisons tout les if pour gérer le cas de la mise à jour, car nous voulons pouvoir faire une mise à jour partiel d'un user, donc le Dto Update que nous ferons plus tard ne va peut-être pas avoir toutes les informations de renseigné.

Étant donnée que ce sont nos Dto qui gère les contraintes de validation, nous savons que si c'est une création d'un user, tous les champs obligatoires sont forcément renseignés et valide.

## Le endpoint register

Maintenant, nous allons devoir créer un nouvel endpoint (donc une nouvelle route), nous allons donc créer un nouveau controller `Frontend/UserController.php` qui gérera nos endpoints publique.

```php
<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(): JsonResponse
    {
    }
}
```

Dans une méthode de controller, vous savez que nous pouvons récupérer la requête en important la classe `Request` en paramètre pour pouvoir l'utiliser. Avec ce process, nous devrons récupérer le contenu de la requête, créer un RegisterDto avec cette requête _(Deserialize)_, ensuite valider le Dto pour vérifier que toutes les informations sont bonne pour enfin utiliser notre UserMapper et l'EntityManager pour persister en BDD.

Mais tout ce process, c'était avant symfony 6.3 !

Maintenant, tout est beaucoup plus simple, voir même enfantin, nous allons utiliser un nouvel attribut PHP 8 de symfony: `MapRequestPayload`

> [!WARNING]
>
> Cet attribut est disponible seulement depuis la version 6.3, si vous utiliser une version antérieur, vous devrez utiliser le process classiqe

### Mapping Request Data to Typed Objects

Symfony 6.3 introduit deux nouveaux attributs pour **mapper automatiquement** les données HTTP vers des objets DTO :

-   `#[MapRequestPayload]` pour le corps de la requête (POST, JSON, form-data),
-   `#[MapQueryString]` pour la chaîne de requête (GET) [documentation](https://symfony.com/blog/new-in-symfony-6-3-mapping-request-data-to-typed-objects?utm_source=chatgpt.com).

### Principe de `#[MapRequestPayload]`

1. Récupère le payload de la requête via `$request->request->all()`.
2. Désérialise ces données dans un **objet DTO typé** passé en argument du contrôleur.
3. Exécute la **validation** via les contraintes Validator définies sur le DTO.
4. Gère automatiquement les erreurs :
    - **422 Unprocessable Entity** en cas de violation de contraintes,
    - **400 Bad Request** pour un payload mal formé,
    - **415 Unsupported Media Type** si le format n’est pas supporté [Documentation](https://symfony.com/blog/new-in-symfony-6-3-mapping-request-data-to-typed-objects?utm_source=chatgpt.com).

### Usage en contrôleur

```php
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
      	RegisterUserRequest $data // On type le Dto attendu pour cette requête
    ): JsonResponse {
        // $data est un objet typé, validé, prêt à être mappé en entité
        // ... logique métier (hash du mot de passe, mapping, persistance)
        dd($data) // Va renvoyer le DTO automatiquement généré via la requête envoyé
    }
}
```

Et voilà aussi simple que ça !

Tout le process de récupérer et validation du DTO sont gérer directement par l'attribut `MapRequestPayload` qui est un gain de temps considérable et permet d'avoir des controller très léger et propre.

Maintenant faite un test sur PostMan sur ce endpoint avec toutes les données du RegisterDto (Valide).

Vous verrez en réponse le dump de votre objet RegisterDto pré-rempli automatiquement par ce que vous avez mis en requête.

Ensuite, faite un test avec des données invalide (pas de plainPassword par exemple), vous allez voir une réponse JSON 422 avec le détail de l'erreur, la validation n'est pas passée et la méthode ne va pas faire de création de user.

Un pur régale à développer, nous avons mis en place tout nos outils pour un développement propre, robuste et avec le principe de responsabilité respecter à 100%.

Il ne nous reste plus qu'à Mapper le Dto en User et persister le user en BDD avec d'envoyer un message de succès en json.

```php
<?php

namespace App\Controller\Frontend;

use App\Dto\RegisterDto;
use App\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserMapper $userMapper, // On va utiliser le UserMapper
        private EntityManagerInterface $em, // Pour persister en BDD
    ) {
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        RegisterDto $registerDto
    ): JsonResponse {
      	// On éxecute map de notre UserMapper en envoyant le Dto
        $user = $this->userMapper->map($registerDto, null);

      	// On persiste en BDD
        $this->em->persist($user);
        $this->em->flush();

      	// On retourne le nouvel Id du user ainsi que le code HTTP qui correspond
        return $this->json(
            ['id' => $user->getId()],
            Response::HTTP_CREATED,
        );
    }
}
```

Maintenant si vous faite une requête sur votre endpoint register avec les bonnes données, vous aller voir que la création s'effectue en BDD.

## La mise à jour de nos Users

Maintenant, nous allons vouloir nous intéresser à la modification de nos User en admin.

Avec tout ce que nous avons mis en place, vous allez voir que ça ne demande pas beaucoup de travail.

Le process est maintenant simple:

-   Création d'un Dto pour le contexte du endpoint
-   Mise en place des contraintes de validation sur le Dto
-   Création du endpoint via une route dans un controller
-   Récupération automatique du Dto avec la requête et `MapRequestPayload`
-   Persistence en BDD

Une recette de cuisine est plus complexe que ça !

---

### Création du Dto

Maintenant nous devons créer notre `UserEditAdminDto`

```php
<?php

namespace App\Entity\Dto;

use App\Dto\Interfaces\UserRequestInterface;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['username'],
    message: 'Ce nom d\'utilisateur est déjà utilisé',
    entityClass: User::class,
)]
class UserEditAdminDto implements UserRequestInterface
{
    public function __construct(
        #[Assert\Length(
            min: 1,
            max: 180,
            minMessage: 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le nom d\'utilisateur ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $username,

        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le prénom ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $firstName,

        #[Assert\Length(
            min: 1,
            max: 255,
            minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $lastName,

        #[Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le mot de passe ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $plainPassword,

        #[Assert\EqualTo(
            propertyPath: 'plainPassword',
            message: 'La confirmation du mot de passe doit être identique au mot de passe'
        )]
        private ?string $confirmPassword,

        #[Assert\Choice(
            choices: ['ROLE_USER', 'ROLE_ADMIN'],
            message: 'Le rôle doit être soit ROLE_USER soit ROLE_ADMIN',
            multiple: true,
        )]
        private array $roles = [],
    ) {
    }

    // Tout les getters ...
}
```

Maintenant que nous avons notre Dto, il ne nous reste plus qu'à créer notre endpoint.

Ici nous pouvons simplement modifier le UserController dans le dossier Backend en ajoutant:

```php
<?php

namespace App\Controller\Backend\User;

use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/users', name: 'api_admin_users_')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private UserMapper $userMapper,
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->userRepository->findAll(),// Je récupère tous les utilisateurs
            context: [
                'groups' => ['common:index', 'user:index', 'user:admin:index'], // Je précise les groupes de sérialisation
            ]
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH'])]
    public function update(): JsonResponse
    {
    }
}
```

Maintenant, nous voulons récupérer 2 choses dynamiquement:

-   Le contenu de la requête et la transformer en Dto
-   Le user que l'on souhaite modifier (L'id en url)

Pour le Dto, nous savons déjà comment faire (`MapRequestPayload`), pour le User, nous pouvons simplement utiliser le paramConverter de Symfony.

## introduction au ParamConverter de Symfony

### Qu’est-ce que le ParamConverter ?

Le **ParamConverter** est un composant (via le bundle **SensioFrameworkExtraBundle**) qui permet de **convertir automatiquement** une valeur de la requête (typique­ment l’`id` d’une route) en **objet Doctrine** (ou autre) injecté dans ta méthode de contrôleur.
Ainsi, tu n’as plus besoin de faire manuellement un `find()` dans ton repository : Symfony gère la conversion et lève une exception `NotFoundHttpException` si l’entité n’existe pas.

## Principe de fonctionnement

1. **Route**

    ```php
    #[Route('/api/users/{id}', name: 'api_user_update', methods: ['PUT'])]
    public function update(User $user) { … }
    ```

2. **Listener ParamConverter**

    - Récupère l’attribut `id` de la route
    - Exécute `UserRepository->find($id)`
    - Injecte l’instance `User` dans l’argument `$user`
    - Si `null`, lève un `NotFoundHttpException` (404)

## Création de la logique de mise à jour

Maintenant que nous savons comment récupérer nos informations dynamiquement, nous pouvons mettre en place le controller:

```php
#[Route('/{id}', name: 'update', methods: ['PATCH'])]
public function update(
    #[MapRequestPayload]
    UserEditAdminDto $dto, // On récupère dynamiquement le Dto
    ?User $user, // On récupère dynamiquement le user
): JsonResponse {
    // On vérifie si l'utilisateur n'existe pas, on renvoie une erreur 404
    if (!$user) {
        return $this->json(
            [
              'status' => 'error',
              'detail' => 'Utilisateur non trouvé',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    // On met à jour l'utilisateur avec les données du DTO
    $this->userMapper->map($dto, $user);

    // On persiste les changements dans la base de données
    $this->em->flush();

    return $this->json(
        $user,
        context: [
            'groups' => [ // Je précise les groupes de sérialisation
              	'common:index',
              	'user:index',
              	'user:admin:index'
            ],
        ]
    );
}
```

Et voilà, vous pouvez maintenant faire vos tests sur PostMan, vous allez voir que vous aurez bien la persistance ou les erreur de validation définit.

## La suppression d'un user

Maintenant que vous savez tout ça, pour la suppression, ça va être très simple !

Une simple route avec l'id en méthode DELETE, le paramConverter qui récupère le user, et on supprime via l'EntityManager:

```php
#[Route('/{id}', name: 'delete', methods: ['DELETE'])]
public function delete(?User $user):JsonResponse
{
    if (!$user) {
        return $this->json(
            [
                'status' => 'error',
                'detail' => 'Utilisateur non trouvé'
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    $this->em->remove($user);
    $this->em->flush();

    return $this->json(
        [
            'status' => 'success',
            'detail' => 'Utilisateur supprimé avec succès'
        ],
        Response::HTTP_OK
    );
}
```

Et voilà c'est fait vous pouvez maintenant supprimer vos Users !

## Récupérer un user par son Id

Maintenant, avant de terminer les endpoints admin de nos users, il ne nous reste plus qu'à créer un dernier endpoint admin, le show d'un user, encore plus simple:

```php
#[Route('/{id}', name: 'show', methods: ['GET'])]
public function show(?User $user): JsonResponse
{
    // On vérifie si l'utilisateur n'existe pas, on renvoie une erreur 404
    if (!$user) {
        return $this->json(
            [
                'status' => 'error',
                'detail' => 'Utilisateur non trouvé'
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    return $this->json(
        $user,
        context: [
            'groups' => [
                'common:index',
                'user:index',
                'user:admin:index'
            ],
        ]
    );
}
```

Et voilà, vous savez maintenant comment faire un CRUD API RESTFul avec Symfony !

## La sécurité

Nous avons maintenant la possibilité de gérer nos users, mais nous avons pour le moment un problème de taille ! Toutes nos routes admin sont publique pour le moment.

Nous allons devoir mettre en place un moyen d'authentifier les requêtes. Dans une application classique c'est le système de login via un formulaire de connexion, sauf que notre API n'a pas la possibilité de gérer l'affichage d'une page HTML, et surtout, car le principe d'une API REST est qu'elle est **Stateless** (elle ne garde pas d’état entre deux requêtes !).

C'est là qu'entre en jeu les fameux **token JWT**.

### Qu’est-ce qu’un JWT ?

Un **JWT** est un **jeton** au format JSON, auto-porteur (self-contained), qui permet de transmettre des informations fiables entre deux parties (client ↔ serveur) sans conserver d’état côté serveur.

Un JWT est composé de trois parties séparées par des points (`.`) :

```php
<HEADER>.<PAYLOAD>.<SIGNATURE>
```

1. **Header** (en-tête)
    - Indique l’algorithme de signature (ex. `HS256`) et le type de token (`JWT`).
2. **Payload** (données)
    - Contient les **claims** : informations sur l’utilisateur ou la session (ex. `sub` pour l’ID utilisateur, `iat` pour la date d’émission, `exp` pour la date d’expiration, etc.).
3. **Signature**
    - Hachage du header et du payload avec une **clé secrète**. Assure l’intégrité et l’authenticité du jeton.

### À quoi ça sert ?

-   **Authentification stateless** : le serveur ne stocke rien.
-   **Transfert d’informations** : on peut y embarquer des rôles, permissions, ou tout autre claim utile.
-   **Performances** : pas d’accès à la base à chaque requête (uniquement vérification de la signature).
-   **Interopérabilité** : format standardisé, supporté dans de nombreux langages et frameworks.

### Comment ça fonctionne, simplement ?

1. **Login**

    - L’utilisateur envoie ses identifiants à `POST /api/login`.

    - Le serveur valide les credentials (username + mot de passe).

2. **Génération du token**

    - Si c’est OK, le serveur crée un JWT signé contenant l’`userId`, ses rôles, et une date d’expiration.

    - Il renvoie ce token au client (dans le corps ou en header).

3. **Requêtes authentifiées**

    - Le client inclut le token dans l’en-tête HTTP :

        ```http
        Authorization: Bearer <token>
        ```

    - À chaque requête, le serveur :

        1. Récupère le token depuis l’en-tête.
        2. Vérifie la **signature** (pour s’assurer qu’il n’a pas été modifié).
        3. Vérifie les **dates** (non expiré).
        4. Extrait les **claims** pour reconstituer l’utilisateur et ses permissions.

4. **Accès protégé**

    - Si tout est valide, la requête est traitée.
    - Sinon, le serveur renvoie `401 Unauthorized` ou `403 Forbidden`.

## LexikJWTAuthenticationBundle

Le bundle LexikJWTAuthenticationBundle propose une implémentation simple pour gérer l'attribution des tokens JWT et de gérer les routes sécurisé pour la vérification des tokens.

### 1. Installation du bundle

```shell
composer require lexik/jwt-authentication-bundle
```

> Symfony Flex se charge normalement d’ajouter automatiquement le bundle dans `config/bundles.php` [Symfony](https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html).

## 2. Génération des clés SSL

Les clés SSL sont obligatoires pour gérer la vérification des token

Génère une paire de clés RSA (privée + publique) :

```shell
symfony console lexik:jwt:generate-keypair
```

Par défaut, elles seront placées dans :

```shell
config/jwt/private.pem
config/jwt/public.pem
```

L’option `--skip-if-exists` permet de ne rien faire si elles existent déjà, et `--overwrite` de les régénérer [Symfony](https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html).

### 3. Configuration du bundle

Maintenant que nous avons installé le bundle et généré nos clé SSL, nous devons configurer le bundle.

#### 3.1. Variables d’environnement

Ajoutez dans votre `.env` (ou `.env.local`) :

```env
###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=dba36535e021cf7031bb992bf290bc3d27fc3f04c2ad8b7883a9e6cbbf6125f8
JWT_TOKEN_TTL=3600
###< lexik/jwt-authentication-bundle ###
```

N'oubliez pas de mettre à jour vos variables d'env avec:

```shell
composer dump-env dev
```

#### 3.2. Fichier `config/packages/lexik_jwt_authentication.yaml`

```yaml
lexik_jwt_authentication:
    secret_key: "%env(resolve:JWT_SECRET_KEY)%"
    public_key: "%env(resolve:JWT_PUBLIC_KEY)%"
    pass_phrase: "%env(JWT_PASSPHRASE)%"
    token_ttl: "%env(JWT_TOKEN_TTL)%"
```

### 4. Sécurisation des routes (`security.yaml`)

Maintenant, il va falloir sécuriser nos routes dans le fichier security.yaml afin de définir les roles pour les routes et surtout d'utiliser le bundle pour la connexion JSON API.

```yaml
firewalls:
    dev:
        pattern: ^/(_(profiler|wdt)|css|images|js)/
        security: false

    login:
    		# On définit le pattern d'url pour la connexion
        pattern: ^/api/login
        stateless: true
        # On définit le bundle comme gestionnaire de conexion (génération de token etc.)
        json_login:
            check_path: /api/login
            success_handler: lexik_jwt_authentication.handler.authentication_success
            failure_handler: lexik_jwt_authentication.handler.authentication_failure

		# Toute les routes /api sont en stateless true pour garder le principe API REST
    api:
        pattern: ^/api
        stateless: true
        jwt: ~

    main:
        lazy: true
        provider: app_user_provider

access_control:
    - { path: ^/api/login, roles: PUBLIC_ACCESS }
    # protège les routes admin /api/admin
    - { path: ^/api/admin, roles: ROLE_ADMIN }
```

### 5. Configuration des routes

Dans `config/routes.yaml`, il faut déclarer la route d’obtention du token :

```yaml
api_login:
    path: /api/login
```

Cette route est utilisée en interne par le firewall `login`, tu n’as pas à créer de contrôleur pour elle. [Symfony](https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html).

### 6 Test de connexion

Maintenant, vous pouvez tester sur PostMan d'envoyer une requête sur `POST /api/login` avec en body:

```json
{
    "username": "admin",
    "password": "admin"
}
```

La réponse que vous devriez avoir est:

```json
{
    "token": "eyJ0eXA...."
}
```

C'est votre token JWT pour l'utilisateur avec lequel vous vous êtes connecté.

Maintenant, pour toute les routes "protégé", vous devez envoyé le token en Authorization:

```http
Authorization: Bearer <token>
```

> [!TIP]
>
> Sur PostMan, pour ajouter une auth vous devez aller dans l'onglet `Authorization` sélectionner `Bearer token` dans le type, et vous devrez coller votre token pour envoyer une requête sur un endpoint sécurisé

Vous pouvez également tester un endpoint admin sans token JWT pour vérifier que vous avez bien une réponse 401.

## Création du CRUD pour les articles

Maintenant, nous commençons à avoir une API REST solide est sécurisé, mais elle ne gère que des Users. Nous voulons maintenant ajouter la table Article avoir la possibilité de faire un Crud.

### Création de l'entité

Pour commencer, vous devez créer votre entité, voici les champs à ajouter:

| Propriété      | Type                      | OPTIONS                    |
| -------------- | ------------------------- | -------------------------- |
| `id`           | `integer`                 | NOT NULL                   |
| `title`        | `string (255)`            | NOT NULL \| UNIQUE         |
| `content`      | `text`                    | NOT NULL                   |
| `shortContent` | `string (255)`            | NOT NULL                   |
| `user`         | `relation ManyToOne User` | NOT NULL \| ORPHAN REMOVAL |
| `createdAt`    | `datetime_immutable`      | NOT NULL                   |
| `updatedAt`    | `datetime_immutable`      | NULL                       |
| `enabled`      | `boolean`                 | DEFAULT: false             |

Voici l'entité que vous devez avoir:

```php
<?php

namespace App\Entity;

use App\Entity\Trait\DateTimeTrait;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\UniqueConstraint(fields: ['title'])]
#[ORM\HasLifecycleCallbacks]
class Article
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['common:index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:index'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article:show'])]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:index'])]
    private ?string $shortContent = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['article:index'])]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(['article:index'])]
    private ?bool $enabled = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getShortContent(): ?string
    {
        return $this->shortContent;
    }

    public function setShortContent(string $shortContent): static
    {
        $this->shortContent = $shortContent;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }
}

```

### Création du DTO Create et de l'interface

Comme pour les users, nous allons utiliser des DTO, ainsi qu'un Mapper, donc pour préparer la création d'un article, nous allons tout d'abord créer le DtoInterface pour nos Dto Article.

```php
<?php

namespace App\Dto\Interfaces;

interface ArticleRequestInterface
{
    public function getTitle(): ?string;

    public function getContent(): ?string;

    public function getShortContent(): ?string;

    public function getUserId(): ?int;

    public function isEnabled(): ?bool;
}
```

Et ensuite le Dto `ArticleCreateDto`:

```php
<?php

namespace App\Dto;

use App\Dto\Interfaces\ArticleRequestInterface;
use App\Entity\Article;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['title'],
    message: 'Ce titre est déjà utilisé.',
    entityClass: Article::class,
)]
class ArticleCreateDto implements ArticleRequestInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le titre ne doit pas être vide')]
        #[Assert\Length(
            min: 3,
            max: 255,
            minMessage: 'Le titre doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le titre ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $title = null,

        #[Assert\NotBlank(message: 'Le contenu ne doit pas être vide')]
        private ?string $content = null,

        #[Assert\NotBlank(message: 'Le contenu court ne doit pas être vide')]
        #[Assert\Length(
            min: 3,
            max: 255,
            minMessage: 'Le contenu court doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le contenu court ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $shortContent = null,

        #[Assert\NotBlank(message: 'L\'id de l\'utilisateur ne doit pas être vide')]
        #[Assert\Positive(message: 'L\'id de l\'utilisateur doit être un entier positif')]
        private int $userId,

        private bool $enabled = false
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getShortContent(): ?string
    {
        return $this->shortContent;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }
}
```

Ici dans le Dto, vous aurez sans doute compris que pour le user, nous allons attendre un Id pour le user et non l'objet user, c'est parce que nous ferons le mapping avec le vrai user en BDD au moment du map dans notre `ArticleMapper`.

## L'ArticleMapper

Maintenant, il est temps de créer notre `ArticleMapper` qui va nous permettre de traduire automatiquement nos Dto en Entity.

```php
<?php

namespace App\Mapper;

use App\Dto\Interfaces\ArticleRequestInterface;
use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleMapper
{
    public function __construct(
        private UserRepository $userRepository, // Utile pour mapper l'id du user avec l'objet
    ) {
    }

    public function map(ArticleRequestInterface $dto, ?Article $article = null): Article
    {
        $article ??= new Article();

        if ($dto->getTitle()) {
            $article->setTitle($dto->getTitle());
        }

        if ($dto->getContent()) {
            $article->setContent($dto->getContent());
        }

        if ($dto->getShortContent()) {
            $article->setShortContent($dto->getShortContent());
        }

        if ($dto->getUserId()) {
          	// On récupère le user via l'id envoyé
            $user = $this->userRepository->find($dto->getUserId());

          	// Si user non trouvé, on envoie une exception
            if (!$user) {
                throw new NotFoundHttpException('User not found');
            }

            $article->setUser($user);
        }

        if ($dto->isEnabled() !== null) {
            $article->setEnabled($dto->isEnabled());
        }

        return $article;
    }
}
```

Et voilà, tout est prêt pour créer votre endpoint `POST /api/admin/articles` pour créer un article.

Vous n'avez plus qu'à créer `src/Controller/Backend/Article/ArticleController`:

```php
<?php

namespace App\Controller\Backend\Article;

use App\Dto\ArticleCreateDto;
use App\Mapper\ArticleMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/article', name: 'api_admin_article_')]
class ArticleController extends AbstractController
{
    public function __construct(
        private ArticleMapper $articleMapper,
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        ArticleCreateDto $dto,
    ): JsonResponse {
        $article = $this->articleMapper->map($dto);

        $this->em->persist($article);
        $this->em->flush();

        return new JsonResponse(
            ['id' => $article->getId()],
            Response::HTTP_CREATED,
        );
    }
}
```

Et voilà, vous pouvez tester sur PostMan votre nouvel endpoint pour la création d'un article.

## La mise à jour d'un article

Maintenant pour la mise à jour, vous devez créer un nouveau Dto:

```php
<?php

namespace App\Dto;

use App\Dto\Interfaces\ArticleRequestInterface;
use App\Entity\Article;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleEditDto implements ArticleRequestInterface
{
    public function __construct(
        #[Assert\Length(
            min: 3,
            max: 255,
            minMessage: 'Le titre doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le titre ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $title = null,

        private ?string $content = null,

        #[Assert\Length(
            min: 3,
            max: 255,
            minMessage: 'Le contenu court doit contenir au moins {{ limit }} caractères',
            maxMessage: 'Le contenu court ne doit pas dépasser {{ limit }} caractères'
        )]
        private ?string $shortContent = null,

        #[Assert\Positive(message: 'L\'id de l\'utilisateur doit être un entier positif')]
        private ?int $userId = null,

        private bool $enabled = false
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getShortContent(): ?string
    {
        return $this->shortContent;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }
}
```

Et enfin, la route dans le controller:

```php
#[Route('/{id}', name: 'update', methods: ['PATCH'])]
public function update(
    #[MapRequestPayload]
    ArticleCreateDto $dto,
    ?Article $article,
): JsonResponse {
    if (!$article) {
        return $this->json(
            [
                'status' => 'error',
                'message' => 'Article not found'
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    $this->articleMapper->map($dto, $article);

    $this->em->flush();

    return $this->json(
        $article,
        Response::HTTP_OK,
        context: [
            'groups' => ['article:index', 'article:show'],
        ],
    );
}
```

Et voilà, votre nouveau endpoint est prêt à être testé avec PostMan !

## La suppression d'un article

Maintenant, dernière étape, la suppression d'un article, maintenant tout se joue dans le contrôler avec l'ajout d'une route:

```php
#[Route('/{id}', name: 'delete', methods: ['DELETE'])]
public function delete(?Article $article): JsonResponse
{
    if (!$article) {
        return $this->json(
            [
                'status' => 'error',
                'message' => 'Article not found'
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    $this->em->remove($article);
    $this->em->flush();

    return $this->json(
        [
            'status' => 'success',
            'message' => 'Article deleted successfully'
        ],
        Response::HTTP_OK,
    );
}
```

Et voilà, un nouveau endpoint prêt à être testé. Nous venons de finaliser notre CRUD.

<span style="font-weight:bold;font-size:26px;color:green;">Félicitations, vous avez maintenant toute les bases pour les API REST avec Symfony</span>

Pour aller plus loins, une API bien faite, c'est avant tout une API bien documenter, si vous souhaitez aller plus loins et apprendre à bien documenter votre API avec symfony, vous pouvez utiliser [NelmioApiDocBundle](https://symfony.com/bundles/NelmioApiDocBundle/current/index.html) pour la mise en place d'une documentation rapidement et facilement.
