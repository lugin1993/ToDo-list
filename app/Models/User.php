<?php

namespace App\Models;

use App\Core\DB;
use PDO;

class User
{
	public int $id;
	public string $name;
	private string $password;

	public function __construct(array $params = [])
	{
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public static function getByLogin(string $login)
	{
		$pdo = DB::getConnection();
		$sql = 'SELECT id, password, name FROM users WHERE login = :login';
		$sth = $pdo->prepare($sql);
		$sth->execute([
			'login' => $login
		]);
		$res = $sth->fetch(PDO::FETCH_ASSOC);
		return $res ? new User($res) : null;
	}

	public static function isAuthorized():bool
	{
		return isset($_COOKIE['userId']) && isset($_COOKIE['userName']);
	}
}