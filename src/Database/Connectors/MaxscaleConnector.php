<?php

namespace Motomedialab\MaxscaleConnector\Database\Connectors;

use Illuminate\Database\Connectors\MySqlConnector;

class MaxscaleConnector extends MySqlConnector
{
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        // We need to grab the PDO options that should be used while making the brand
        // new connection instance. The PDO options control various aspects of the
        // connection's behavior, and some might be specified by the developers.
        $connection = $this->createConnection($dsn, $config, $options);

        $this->configureIsolationLevel($connection, $config);

        $this->configureEncoding($connection, $config);

        // Next, we will check to see if a timezone has been specified in this config
        // and if it has we will issue a statement to modify the timezone with the
        // database. Setting this DB timezone is an optional configuration item.
        $this->configureTimezone($connection, $config);

        $this->setModes($connection, $config);

        return $connection;
    }
}
