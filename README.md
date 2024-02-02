# Customer Wallet

## How to run

1. docker-compose up -d
2. docker-compose exec app composer install
3. docker-compose exec app cp .env.example .env
4. docker-compose exec app php artisan key:generate
5. docker-compose exec app php artisan migrate
6. docker-compose exec app npm install
7. docker-compose exec app npm run build
8. docker-compose exec app php artisan queue:work
