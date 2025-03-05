# The obligatory TODO list project

Laravel version with Vue.js frontend using Inertia.js.

## Installation

1. Clone the repository and cd into it.
2. Run `lando start`
3. Profit

Note: the application uses port 3068 to bind the vite dev server, that can be updated in the lando file
## Development

Several custom commands are available:

1. Run `lando dev` to start the development server
2. Run `lando build` to build the assets
3. Run `lando xdebug-on` to enable xdebug
4. Run `lando xdebug-off` to disable xdebug
5. Run `lando npm` to use npm inside the container

Note: although a database service is installed, the application uses SQLite by default.

## Testing

An .env.testing should have already been generated during `lando start` if not, follow these steps:

1. Make an .env.testing file: `cp .env.testing.example .env.testing`
2. Run `lando artisan key:generate --env=testing` to make a new app key for the testing environment
3. Run `lando artisan test`

## Next features AKA TODO

If only I had a todo list to keep track of all the things I need to do...

[ ] Sync with Google Tasks
[ ] Add a pomodoro timer
[ ] 
