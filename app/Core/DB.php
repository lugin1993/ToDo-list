<?php

namespace App\Core;

use PDO;

class DB
{
    public static function getConnection(): PDO
    {
        $connection = sprintf(
			"%s:host=%s;port=%s;dbname=%s;",
			$_ENV['DB_CONNECTION'],
			$_ENV['DB_HOST'],
			$_ENV['DB_PORT'],
			$_ENV['DB_NAME']
		);
		return new PDO($connection, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }
}