# Requirements
- docker (for Windows and MacOS https://www.docker.com/products/docker-desktop)

# Installation
1. set up your .env with database conection
```
set up your .env with database conection
```

2. install paackages
```
composer install

```

3. Create database
```
php artisan db:create
```

4. Run migrations and seeders
```
php artisan migrate:fresh --seed
```

5. Install passport package
```
php artisan passport:install
```

6. Run Test
```
php artisan test
```
