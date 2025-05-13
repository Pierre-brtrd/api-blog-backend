<p align="center">   <img src="https://img.shields.io/badge/Symfony-7.2-000000?logo=symfony" alt="Symfony 7" />   <img src="https://img.shields.io/badge/PHP-8.2-%23777BB4?logo=php" alt="PHP 8.2" />   <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License: MIT" />   <img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status" /> </p>

# MonAPI Symfony

> **MonAPI** est le back-end RESTful d’une application de gestion d’articles.
>  Il expose des endpoints pour **CRUD** d’articles et gère l’upload d’images.
>
> Ce projet est à but éducatif et est utilisé dans le cadre de formation en développement web.

------

## 📋 Table des matières

1. [Prérequis](#-prérequis)
2. [Installation](#-installation)
3. [Configuration](#-configuration)
4. [Usage](#-usage)
5. [Endpoints API](#-endpoints-api)
6. [Tests](#-tests)
7. [Contribution](#-contribution)
8. [Licence](#-licence)

------

## 🛠️ Prérequis

Avant de commencer, assurez-vous d’avoir :

| Outil              | Version minimale |
| ------------------ | ---------------- |
| PHP                | 8.2              |
| Composer           | 2.5              |
| Symfony CLI (opt.) | 6.4              |
| MySQL / PostgreSQL | 10+              |



------

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

------

## 🚀 Usage

- Toutes les routes sont préfixées par `/api`
- JSON requests & responses uniquement
- Authentification JWT (LexikJWTBundle) sur les routes protégées

------

## 📡 Endpoints API

| Méthode    | Chemin                            | Description                                | Auth               | Paramètres                                                   |
| ---------- | --------------------------------- | ------------------------------------------ | ------------------ | ------------------------------------------------------------ |
| **GET**    | `/api/admin/articles`             | Récupère tous les articles (paged)         | **Bearer** (Admin) | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6) |
| **POST**   | `/api/admin/articles`             | Crée un nouvel article                     | **Bearer** (Admin) | Body JSON → `CreateArticleRequest` { title, content, enabled, userId } |
| **GET**    | `/api/admin/articles/{id}`        | Récupère un article par son ID             | **Bearer** (Admin) | `id` (path, string)                                          |
| **PATCH**  | `/api/admin/articles/{id}`        | Met à jour un article                      | **Bearer** (Admin) | `id` (path), Body JSON → `UpdateArticleRequest` { title?, content?, enabled?, userId? } |
| **DELETE** | `/api/admin/articles/{id}`        | Supprime un article                        | **Bearer** (Admin) | `id` (path)                                                  |
| **POST**   | `/api/admin/articles/{id}/upload` | Upload d’une image pour un article         | **Bearer** (Admin) | `id` (path), Body multipart → champ `image` (binary)         |
| **GET**    | `/api/admin/articles/{id}/switch` | Bascule l’état `enabled` d’un article      | **Bearer** (Admin) | `id` (path)                                                  |
| **GET**    | `/api/articles`                   | Récupère la liste paginée d’articles front | *Public*           | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6) |
| **GET**    | `/api/admin/users`                | Récupère tous les utilisateurs (paged)     | **Bearer** (Admin) | `page` (query, integer, défaut 1), `limit` (query, integer, défaut 6) |
| **GET**    | `/api/admin/users/{id}`           | Récupère un utilisateur par son ID         | **Bearer** (Admin) | `id` (path, string)                                          |
| **PATCH**  | `/api/admin/users/{id}`           | Met à jour un utilisateur                  | **Bearer** (Admin) | `id` (path), Body JSON → `UpdateProfileRequest` { firstName?, lastName?, username?, currentPassword?, plainPassword?, confirmPassword? } |
| **DELETE** | `/api/admin/users/{id}`           | Supprime un utilisateur                    | **Bearer** (Admin) | `id` (path)                                                  |
| **POST**   | `/api/profile/register`           | Inscription d’un nouvel utilisateur        | *Public*           | Body JSON → `RegistrationRequest` { username, firstName?, lastName?, plainPassword, confirmPassword } |
| **GET**    | `/api/profile`                    | Récupère le profil de l’utilisateur        | **Bearer** (User)  | *Aucun*                                                      |
| **PATCH**  | `/api/profile/update`             | Met à jour le profil de l’utilisateur      | **Bearer** (User)  | Body JSON → `UpdateProfileRequest` { firstName?, lastName?, username?, currentPassword?, plainPassword?, confirmPassword? } |
| **DELETE** | `/api/profile/delete`             | Supprime le profil de l’utilisateur        | **Bearer** (User)  | *Aucun*                                                      |

> 📝 Pour chaque endpoint protégé, ajoutez le header `Authorization: Bearer <token>`.

------

## 🤝 Contribution

1. Forkez le projet
2. Créez une branche `feat/ma-feature`
3. Committez vos changements (`git commit -m 'feat: add ...'`)
4. Pushez vers `origin feat/ma-feature`
5. Ouvrez une Pull Request

Merci pour votre contribution ! 🚀

------

## 📄 Licence

Ce projet est sous licence **MIT** — voir le fichier LICENSE pour plus de détails.
