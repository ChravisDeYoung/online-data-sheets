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

- deletion
- email functionality and queueing (`php artisan queue:listen`)
- multi-language support
- custom laravel messages (`php artisan lang:publish`)
- timestamped deletions (only delete in the first few minutes)
- Laravel breeze has authentication
- laravel dusk testing
- github actions (testing on push)
- calculation fields
- conditional fields
- chart fields (graph over time)
- report for date range
- api sync with external systems
- different page styles (row and column)
- subscribe to pages
- custom subscriptions for fields and pages (ex. custom range or % out of range on a page)
- support multiple organizations
  - timezones, logos, colours?
- ability to assign users to fields and fields to users
