# Laravel MariaDB MaxScale Connector

A simple package designed to provide a fix for the existing `Illuminate\Database\Connectors\MySQLConnector` class.

cWhen connecting to MaxScale using Laravel, the `$connection->exec("use {$config['database']};");` command is run,
not only creating a surplus query but also triggering a database connection error when using MariaDB MaxScale.
Within MaxScale logs, you'll see an error similar to:

```
error  : (1) Invalid authentication message from backend 'your-backend'. Error code: 1044, Msg : #42000: Access denied for user 'username'@'%' to database '`database_name`'
```

The reason for this, is that Laravel is trying to establish a connection with '\`database_name\`' (backticks) when it should simply be connecting to 'database_name' (no backticks).

As the database name has already been declared within the PDO DSN (see [PR #34389](https://github.com/laravel/framework/pull/34389)), the offending line of code is effectively surplus to requirements already.
All this package does is remove the surplus database selection by overriding the existing MySQL connector to remove a few lines of code.

## Installation

Install via composer `composer require motomedialab/maxscale-connector`

Within your `config/database.php` you have two options:

1. Update your `database.connections.mysql.driver` config flag to `maxscale`

2. Create a new configuration for MaxScale
    1. Copy the entire `database.connections.mysql` config array
    2. Rename the key to `maxscale`
    3. Change the driver flag `database.connections.maxscale.driver` to `maxscale`
    4. Update your `.env` file to reflect this change, e.g. `DB_CONNECTION=maxscale`

Once one of the above options have been completed, you should be able to connect to your MaxScale instance
via Laravel no problem.

### Notes

- This package will still work with MySQL and remove the surplus database selection query being performed on each load.
