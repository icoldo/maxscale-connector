<?php

namespace Motomedialab\MaxscaleConnector;

use Illuminate\Database\Connection;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\ServiceProvider;
use Motomedialab\MaxscaleConnector\Database\Connectors\MaxscaleConnector;

class MaxscaleConnectorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Connection::resolverFor('maxscale', function ($connect, $database, $prefix, $config) {
            return new MySqlConnection($connect, $database, $prefix, $config);
        });

        app()->bind('db.connector.maxscale', function () {
            return new MaxscaleConnector;
        });
    }
}
