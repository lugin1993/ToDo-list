<?php

namespace App\Models;

use App\Core\DB;
use PDO;

class Task
{
	const limitTaskOnPage = 3;

	private int $id;
	private string $user_name = '';
	private int $status = 0;
	private string $email = '';
	private string $description = '';

	public function __construct(array $params = [])
	{
		foreach ($params as $key => $value) {
			$this->$key = htmlspecialchars($value);
		}
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getStatus(): int
	{
		return $this->status;
	}

	public function setStatus(int $newStatus)
	{
		if($newStatus == 2 && $this->status == 1){
			$this->status = $newStatus;
		}elseif($newStatus == 0){
			$this->status = $newStatus;
		}elseif($newStatus == 1 && $this->status != 2){
			$this->status = $newStatus;
		}
	}

	public function setDescription(string $description)
	{
		$this->description = htmlspecialchars($description);
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public static function getNumberPage(): int
	{
		$pdo = DB::getConnection();
		$sql = 'SELECT count(*) FROM tasks';
		$sth = $pdo->query($sql);
		$result = $sth->fetchColumn();
		return $result > 0 ? ceil($result / self::limitTaskOnPage) : 0;
	}

	public static function getById(int $id): bool|Task
	{
		$pdo = DB::getConnection();
		$sql = 'SELECT id, user_name, email, description, status FROM tasks WHERE id = :id';
		$sth = $pdo->prepare($sql);
		$sth->execute([
			'id' => $id
		]);
		$res = $sth->fetch(PDO::FETCH_ASSOC);
		if(!$res) return false;
		return new self($res);
	}

	public static function getAll(int $page = 1, string $orderBy = 'id', string $direction = 'ASC'): array
	{
		$pdo = DB::getConnection();
		$sql = "SELECT
				   id,
				   user_name, 
				   email, 
				   description, 
				   status  
			from tasks 
			ORDER BY {$orderBy} {$direction} 
			LIMIT :limit 
			OFFSET :offset";
		$sth = $pdo->prepare($sql);
		$limit = self::limitTaskOnPage;
		$sth->bindParam(':limit', $limit, PDO::PARAM_INT);
		$offset = ($page - 1) * self::limitTaskOnPage;
		$sth->bindParam(':offset', $offset, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert()
	{
		$pdo = DB::getConnection();
		$sql = 'INSERT INTO tasks (user_name, email, description, status) VALUES (:user_name, :email, :description, :status)';
		$sth = $pdo->prepare($sql);
		$sth->execute($this->getAttributes());
	}

	public function update()
	{
		$pdo = DB::getConnection();
		$sql = 'UPDATE tasks SET 
                 user_name = :user_name, 
                 email = :email, 
                 description = :description, 
                 status = :status 
                WHERE id = :id';
		$sth = $pdo->prepare($sql);
		$sth->execute($this->getAttributes());
	}

	public function getAttributes(): array
	{
		$attrs = [
			'description' => $this->description,
			'email' => $this->email,
			'user_name' => $this->user_name,
			'status' => $this->status
		];
		if(isset($this->id)) $attrs['id'] = $this->id;
		return $attrs;
	}
}