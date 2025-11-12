# Online Data Sheets

This is a project to learn the new stack with php@7.4 and laravel@8

## Getting Started

`npm install`

- this will install all the dependencies

`npm run dev`

- this will run everything (handy to run `npm run watch` while working on it)

`php artisan test`

- this will run the feature and unit tests

`php artisan dusk`

- this will run the browser tests

## To Do

- split the user profile page into an update password form and an update user form
- better sort handling for fields on a page
- `vpa make:resource User`: use resources in the api
- email functionality and queueing (`php artisan queue:listen`)
- Admin vs. User functionality
- multi-language support
- custom laravel messages (`php artisan lang:publish`)
- prevent n+1 issues
  - AppServiceProvider > boot() > Model::preventLazyLoading()
- timestamped deletions (only delete in the first few minutes)
- policies
- Laravel breeze has authentication
- laravel dusk testing
- github actions
- authenticate api routes with sanctum
  - add user_id to the field_data_history
- calculation fields
- api sync with external systems
- different page styles
- field history
- custom out of range handling
