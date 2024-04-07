# Stores and Books registration service

Registration, editing, listing and deletion service for stores and books.

## 1 - Stack

**Back-end:** Laravel 11, PHP 8.2, Docker, Docker-compose, Unit Tests

## 2 - Features

Some development patterns were used, let's check some of them:

- **Repository Pattern:** The use of the repository pattern means that the logic is not entirely in the controller, creating a layer above for model data access logic.
- **Commit Pattern:** A commit naming standard was used, called "conventional commit", for example in new features, we use "feat" at the beginning of the commit. Link: https://www.freecodecamp.org/news/how-to-write-better-git-commit-messages/
- **Gitflow:** Branch pattern, with master being the main branch
- **Response API Pattern:** Creating laravel response classes to standardize json responses with a field structure
- **DDD (DOMAIN DRIVEN DESIGN):** Creation of domains for the necessary application entities, with stores and books, separating the responsibility of each domain
- **Unit Test:** The use of testing promotes a new vision of development, ensuring ease of maintenance and support of the application

## 3 - Libraries

- [JWT Auth](https://github.com/PHP-Open-Source-Saver/jwt-auth)
- [PHPUnit](https://phpunit.de/documentation.html)

## 4 - Installation

In the root of the project there are 3 folders, one called "application" which is responsible for the laravel project. The second folder is called "conf" where it is responsible for containing the docker configuration files and a ".vscode" folder for using the php debug

```ini
...
├── .vscode
├── application
├── conf
...
```


1º Step: Clone project on your workspace, access the root of project and up containers

```bash
  cd book-store-api
  docker-compose up -d
```

2º Step: Access php container:

```bash
  docker exec -it book_store_php bash
```

3º Step: Inside the php container terminal, run these commands to load the libraries and populate the database:

```bash
  composer install
  composer dump-autoload
  cp .env.example .env
  php artisan key:generate
  php artisan jwt:secret
  php artisan migrate
  php artisan db:seed
```

It's Done! :) . 

4º extra step: Run Unit Tests! 

```bash
  php artisan test
```

## 5 - Documentation API

Check Documentation on Postman: https://documenter.getpostman.com/view/5876341/2sA35MxyJb

#### API SUCCESS RESPONSE DEFAULT STRUCTURE

```json
{
    "success": true,
    "message": '',
    "data": {},
    "metadata": {}
}
```

- Success: "True" for succes
- Message: String field to return messages to client
- Data: Multi-dimensional Array to return some data from request
- Metadata: Extra information about data field

#### API ERROR RESPONSE DEFAULT STRUCTURE

```json
{
    "success": false,
    "debug": {},
    "message": '',
}
```
- Success: "False" for failure request
- Message: String field to return some message to client
- Debug: Multi-dimensional Array to return some data errors from failure request. This field is available on api response just in development environment.

### Authentication
Authentication was build using JWT, so after login is successful, a "bearer_token" is returned.

Default User 

Email: test@example.com 

Password: password

#### Login

```http
  POST /api/auth/login
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| email | string | *Required*. |
| password | string | *Required*. |

#### Logout

```http
  POST /api/auth/logout
```

#### Me

```http
  GET /api/auth/me
```

#### Refresh Token

```http
  POST /api/auth/refresh
```
<hr>

### **Book**

#### GET

```http
GET /api/books
```
#### POST

```http
POST /api/books
```
| Parameter   | Type       | Description                                   |
| :---------- | :--------- | :------------------------------------------ |
| name      | string | *Required*.|
| isbn      | integer | *Required*.|
| value      | decimal | *Required*.|

#### PUT

```http
PUT /api/books/{book_id}
```
| Parameter   | Type       | Description                                   |
| :---------- | :--------- | :------------------------------------------ |
| name      | string | |
| isbn      | integer | UNIQUE |
| value      | decimal | |

#### DELETE

```http
DELETE /api/books/{book_id}
```
### **Store**

#### GET

```http
GET /api/stores
```
#### POST

```http
POST /api/stores
```
| Parameter   | Type       | Description                                   |
| :---------- | :--------- | :------------------------------------------ |
| name      | string | *Required*.|
| address      | string | *Required*.|
| active      | string | Default Value: true|
| books_id      | Array | |

#### PUT

```http
PUT /api/stores/{store_id}
```
| Parameter   | Type       | Description                                   |
| :---------- | :--------- | :------------------------------------------ |
| name      | string | |
| address      | string | |
| active      | string | |
| books_id      | Array | |

#### DELETE

```http
DELETE /api/stories/{stores_id}
```

## 6 - Domain and Directory Tree

```ini
...
├── Domain
│   ├── User
│   └── Store
│   └── Book
...
```
Within each domain there are files relating to each entity, such as Models, Controllers, Factories, Seeders and Repositories.
