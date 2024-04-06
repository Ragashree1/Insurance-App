# Insurance App

## Setup
1. Install node.js, npm, composer and php 
2. clone the repo and add .env file (copy from .example.env)
    ```
    git clone <url>
    cp .env.example .env
    ```
3. run the following commands 
    ```
    composer install
    npm ci
    npm run build
    ```
4. Seeding in data
    ```
    touch database/database.sqlite
    php artisan migrate:fresh --seed
    ```

## Running the application
```
php artisan serve & npm run dev
```
