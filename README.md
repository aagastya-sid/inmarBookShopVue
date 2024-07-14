## Inmar Book Store

### Project Setup for Local Environment

Clone the repo locally:

```sh
git clone https://github.com/aagastya-sid/inmarBookShopVue.git
```

Install the dependencies:

```sh
composer install
npm install
```

Compile the assets:

```sh
npm run dev
```

Start the Laravel server:

```sh
php artisan serve
```

```sh
php artisan migrate
```

Seed the database for initial data for Books:

```sh
php artisan db:seed
```

Visit `http://localhost:8000` to view the application


