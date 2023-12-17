<?php

namespace Core;

use PDO;

class DB
{
    public static function getConnection(): PDO
    {
        $connection = sprintf("%s:host=%s;port=%s;dbname=%s;", DB_TYPE, DB_HOST, DB_PORT, DB_NAME);
		return new PDO($connection, DB_USER, DB_PASSWORD);
    }
}