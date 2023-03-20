## Overview
A clinic booking management system that involves 3 types of users which are the admins, doctors and patients. Policies and Gates are used to implemented for the authorization of users with different roles.

### Backend
- Laravel

### Frontend
- Tailwindcss
- axios
- datatables

## Features
- Login or register
- Create appointment
- View appointment
- Update appointment
- Cancel appointment 
- Manage patients
- Manage doctors
- Generate schedule
- Manage Profile

## Screenshots
<img width="250" src="https://user-images.githubusercontent.com/78791519/226430876-dd4f444c-3b33-492e-bd87-28f9fa49dfb2.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226430988-9f8115b7-1506-476f-bbea-6a3e7d5f9d6e.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226431046-a738eca3-8ca3-4c27-a8cf-bfe024156a21.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226431181-e0d9baf1-d026-423d-8ddf-1a6e6651cfc0.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226431181-e0d9baf1-d026-423d-8ddf-1a6e6651cfc0.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226431328-22fedcf3-6a5d-4ace-be04-0ee1e9a05713.png"/>
<img width="250" src="https://user-images.githubusercontent.com/78791519/226431368-dc1a17bb-0d51-46b1-9b18-c0ea288954e9.png"/>

## Setup
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
