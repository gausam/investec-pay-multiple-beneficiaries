
## Investec Pay-Multiple API Demo
This app is a simple demonstration of Investec's mutiple-beneficiary payment API.

It is built with the Laravel framework.

## Running the app

This app requires an environment with current-generation installations of PHP, MySQL and NPM.

You can learn more about setting up a Laravel environment at https://laravel.com/docs/9.x/installation.

Clone the app and install dependencies with:

```
composer install
npm install
```

Setup a local MySQL database (with [DBNgin](https://dbngin.com) or similar) and add the appropriate credentials to the DB_DATABASE, DB_USERNAME and DB_PASSWORD keys in a `.env` config file that you can create by running:

```
cp .env.example .env
```

To setup the database, you may run:
```
php artisan migrate
```

To start the backend, use:

```
php artisan serve
```

And finally, start the frontend by running:
```
npm run dev
```

## Investec Configuration

The app will ask for your client ID, client secret and API key after registration. This enables the app to execute beneficiary payments.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
