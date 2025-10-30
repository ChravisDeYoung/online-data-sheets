# Online Data Sheets

This is a project to learn the new stack with php@7.4 and laravel@8

## Getting Started

`npm install`

- this will install all the dependencies

`npm run dev`

- this will run everything (handy to run `npm run watch` while working on it)

`php artisan test`

- this will run the tests

## To Do

- split the user profile page into an update password form and an update user form
- better sort handling for fields on a page
- create tests and a testing database (should use same kind of database)
- `vpa make:resource User`: use resources in the api
- email functionality and queueing (`php artisan queue:listen`)
- Admin vs. User functionality
- multi-language support
- custom laravel messages (`php artisan lang:publish`)
- prevent n+1 issues
  - AppServiceProvider > boot() > Model::preventLazyLoading()
- testing
