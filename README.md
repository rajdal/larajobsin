# Installation Steps

Clone Repo
```
git clone https://github.com/rajentrivedi/lara-jobs.git
```

Change directory to `lara-jobs`
```
cd lara-jobs
```

Install Dependancies (php)
```
composer install
```

Install fillament and scaffold primary stuffs
```
php artisan filament:install  --scaffold  --forms
```

Copy example env file
```
cp .env.example .env
```

Generate Key
```
php artisan key:generate
```

Configure env file for frontend
```
APP_URL=http://localhost:8000
```

Configure env file for database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larajobs
DB_USERNAME=root
DB_PASSWORD=root
```

Run migration to prepare database structure   
_**Note:** Make sure you have created specified database (`larajobs`) in env file_
```
php artisan migrate
```

Run seeder to feed database with some data.
```
php artisan db:seed
```

Link storage to local filesystem. (not needed if you are using s3 or some other source)
```
php artisan storage:link
```

Run php server
```
php artisan serve
```

Install Dependacies (node)
```
npm install
```

Build and run frontend assets
```
npm run dev
```