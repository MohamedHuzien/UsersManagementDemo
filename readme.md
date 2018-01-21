# Simple users management demo app!


# you can run this demo by

- clone the repo 
- run `composer install`
- run `php artisan migrate` to run migration 
- run `php artisan db:seed --class=UsersTableSeeder`
- run `npm install` to install gulp and laravel-elixir
- run `gulp` or `gulp --production` to build and move style and script to public folder
- now you can run `vendor/bin/phpunit`  
- login with `admin@zwaar.org` and `123456`

## what this repo contain 
 this sample users management demo has one table `users` with 
a flag `is_admin` to refer if user is a member or an admin ,
 admin can add/edit/delete/list users and assign rules to each user
 admin and user can view and edit their information.
 all validation and validation rules in `CreateUserRequest` and `UpdateUserRequest` request classes,
 and permissions handled in `AuthMiddleware` middleware class
 
 ## feature enhancement
 add separated rules table to handel more than two type of users
  
