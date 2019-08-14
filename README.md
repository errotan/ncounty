## County and city registry application

#### Installation steps

- composer install
- create env.local and set DATABASE_URL
- php bin/console doctrine:database:create
- php bin/console doctrine:schema:create
- php bin/console doctrine:fixtures:load
- set APP_ENV to prod in env.local
- npm install
- npm run build
