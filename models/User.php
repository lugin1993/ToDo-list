<?php

namespace Models;

use Core\DB;
use PDO;

class User
{
	public function getByLogin(string $login)
	{
		$pdo = DB::getConnection();
		$sql = 'SELECT id, password, name FROM users WHERE login = :login';
		$sth = $pdo->prepare($sql);
		$sth->execute([
			'login' => $login
		]);
		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	public static function isAuthorized():bool
	{
		return isset($_COOKIE['userId']) && isset($_COOKIE['userName']);
	}
}