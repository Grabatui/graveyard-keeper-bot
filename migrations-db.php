<?php

use DI\Container;
use Doctrine\DBAL\Connection;

require_once(__DIR__ . '/bootstrap.php')

/** @var Container $container */;

return $container->get(Connection::class);
