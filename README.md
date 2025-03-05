# The obligatory TODO list project

Laravel version with Vue.js frontend using Inertia.js.

## Installation

1. Clone the repository
2. Run `lando start`
3. Run `lando composer install`
4. Run `lando artisan migrate`
5. Run `lando npm install`
6. Run `lando dev`

## Testing

1. Make a testing .env file: `cp .env.testing.example .env.testing`
2. Run `lando artisan key:generate --env=testing` to make a new app key for the testing environment
3. Run `lando artisan test`
