# To setup and run project
1. `git clone https://github.com/elaine1129/AWAD_Assignment.git` clone from repository
2.  cd into project directory
3. `composer install` install dependency 
4. Setup .env files, by copying the .env.example and setup database (password, ...)
5. `php artisan key:generate`
7. `npm -g install pnpm` install pnpm as global if havent install before
1. `pnpm install` install all dependency
1. `pnpm run watch`
6. `php artisan serve`
1. `pnpm add [new package name]` to install package you need

## Run from time to time 
1. `composer dumpauto`

## To seed database
1. set up database in `.env` file
1. run `php artisan migrate` / `php artisan migrate:fresh` if got errors
1. run `php artisan db:seed` (if fail run again or migrate fresh) 
1. to configure number of seed go to `DatabaseSeeder.php`.

---
