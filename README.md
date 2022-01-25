# WatchCrunch test

### Installation
- Clone the repo
- `cd` to the project folder
- Run `composer install`
- If you don't have a `.env` file after installing the project run `cp .env.example .env`
- Run `php artisan key:generate`
- Change the DB and redis related configurations on the .env file
- Run `php artisan config:cache`
- Run `php artisan migrate --seed`

### Problem 1
The `/{username}` route has been setup. Got to this route by using some of the usernames generated from the seeders.  
Also see: `tests\Feature\ProfileTest` and `tests\Feature\Models\UserTest`

### Problem 2
`Actions\GetLessActiveUsers` action class solves this problem. Can be run in `php artisan tinker` like: `app(GetLessActiveUsers::class)->handle()`.   
Also see: `tests\Feature\Actions\GetLessActiveUsersTest`

### Tests
The tests use a sqlite in-memory db  
Before running the tests you might need to run `php artisan config:clear`   
Run the tests by using: `php artisan test`

### Code Style
Run `composer cs-fix` to apply code style fixes (from php cs fixer)
