# Shopify Laravel App Template 

This is a template for building a [Shopify app](https://shopify.dev/docs/apps/getting-started) using PHP and React. It contains the basics for building a Shopify app.

#### This Repository is a clone version of [Shopify App Template - PHP](https://github.com/Shopify/shopify-app-template-php) with updated versions of Laravel and React Js.


### Setting up your Laravel app

1. Clone the application
    ```
    git clone https://github.com/prabinsapal/Shopify-App-Template-Laravel.git
    ```

1. Start off by switching to the `web` folder:

    ```shell
    cd web
    ```

1. Install your composer dependencies:

    ```shell
    composer install
    ```

1. Create the `.env` file:

    ```shell
    cp .env.example .env
    ```

1. Bootstrap the default [SQLite](https://www.sqlite.org/index.html) database and add it to your `.env` file:

    ```shell
    touch storage/db.sqlite
    ```

    **NOTE**: Once you create the database file, make sure to update your `DB_DATABASE` variable in `.env` since Laravel requires a full path to the file.

1. Generate an `APP_KEY` for your app:

    ```shell
    php artisan key:generate
    ```

1. Create the necessary Shopify tables in your database:

    ```shell
    php artisan migrate
    ```
1. Create Jobs table

    ```shell
    php artisan make:queue-table
    ```

 And your Laravel app is ready to run! You can now switch back to your app's root folder to continue:

```shell
cd ..
```

### Local Development

[The Shopify CLI](https://shopify.dev/docs/apps/tools/cli) connects to an app in your Partners dashboard.
It provides environment variables, runs commands in parallel, and updates application URLs for easier development.

You can develop locally using your preferred Node.js package manager.
Run one of the following commands from the root of your app:

Using yarn:

```shell
yarn dev
```

Using npm:

```shell
npm run dev
```

Using pnpm:

```shell
pnpm run dev
```

Open the URL generated in your console. Once you grant permission to the app, you can start development.

## Deployment

### Application Storage

This template uses [Laravel's Eloquent framework](https://laravel.com/docs/9.x/eloquent) to store Shopify session data.
It provides migrations to create the necessary tables in your database, and it stores and loads session data from them.

The database that works best for you depends on the data your app needs and how it is queried.
You can run your database of choice on a server yourself or host it with a SaaS company.
Once you decide which database to use, you can update your Laravel app's `DB_*` environment variables to connect to it, and this template will start using that database for session storage.

### Build

The frontend is a single page React app. It requires the `SHOPIFY_API_KEY` environment variable, which you can find on the page for your app in your partners dashboard.
The CLI will set up the necessary environment variables for the build if you run its `build` command from your app's root:

Using yarn:

```shell
yarn build --client-key=REPLACE_ME
```

Using npm:

```shell
npm run build --client-key=REPLACE_ME
```

Using pnpm:

```shell
pnpm run build --client-key=REPLACE_ME
```

The app build command will build both the frontend and backend when running as above.
If you're manually building (for instance when deploying the `web` folder to production), you'll need to build both of them:

```shell
cd web/frontend
SHOPIFY_API_KEY=REPLACE_ME yarn build
cd ..
composer build
```

## Hosting

When you're ready to set up your app in production, you can follow [our deployment documentation](https://shopify.dev/docs/apps/deployment/web) to host your app on a cloud provider like [Heroku](https://www.heroku.com/) or [Fly.io](https://fly.io/).

When you reach the step for [setting up environment variables](https://shopify.dev/docs/apps/deployment/web#set-env-vars), you also need to set the following variables:

| Variable          | Secret? | Required |     Value      | Description                                                                         |
| ----------------- | :-----: | :------: | :------------: | ----------------------------------------------------------------------------------- |
| `APP_KEY`         |   Yes   |   Yes    |     string     | Run `php web/artisan key:generate --show` to generate one.                          |
| `APP_NAME`        |         |   Yes    |     string     | App name for Laravel.                                                               |
| `APP_ENV`         |         |   Yes    | `"production"` |                                                                                     |
| `DB_CONNECTION`   |         |   Yes    |     string     | Set this to the database you want to use, e.g. `"sqlite"`.                          |
| `DB_DATABASE`     |         |   Yes    |     string     | Set this to the connection string to your database, e.g. `"/app/storage/db.sqlite"` |
| `DB_FOREIGN_KEYS` |         |          |     `true`     | If your app is using foreign keys.                                                  |

## Known issues

### Hot module replacement and Firefox

When running the app with the CLI in development mode on Firefox, you might see your app constantly reloading when you access it.
That happened in previous versions of the CLI, because of the way HMR websocket requests work.

We fixed this issue with v3.4.0 of the CLI, so after updating it, you can make the following changes to your app's `web/frontend/vite.config.js` file:

1. Change the definition `hmrConfig` object to be:

    ```js
    const host = process.env.HOST
        ? process.env.HOST.replace(/https?:\/\//, "")
        : "localhost";

    let hmrConfig;
    if (host === "localhost") {
        hmrConfig = {
            protocol: "ws",
            host: "localhost",
            port: 64999,
            clientPort: 64999,
        };
    } else {
        hmrConfig = {
            protocol: "wss",
            host: host,
            port: process.env.FRONTEND_PORT,
            clientPort: 443,
        };
    }
    ```

1. Change the `server.host` setting in the configs to `"localhost"`:

    ```js
    server: {
      host: "localhost",
      ...
    ```

## Developer resources

-   [Introduction to Shopify apps](https://shopify.dev/docs/apps/getting-started)
-   [App authentication](https://shopify.dev/docs/apps/auth)
-   [Shopify CLI](https://shopify.dev/docs/apps/tools/cli)
-   [Shopify API Library documentation](https://github.com/Shopify/shopify-api-php/tree/main/docs)
-   [Getting started with internationalizing your app](https://shopify.dev/docs/apps/best-practices/internationalization/getting-started)
    -   [i18next](https://www.i18next.com/)
        -   [Configuration options](https://www.i18next.com/overview/configuration-options)
    -   [react-i18next](https://react.i18next.com/)
        -   [`useTranslation` hook](https://react.i18next.com/latest/usetranslation-hook)
        -   [`Trans` component usage with components array](https://react.i18next.com/latest/trans-component#alternative-usage-components-array)
    -   [i18n-ally VS Code extension](https://marketplace.visualstudio.com/items?itemName=Lokalise.i18n-ally)
