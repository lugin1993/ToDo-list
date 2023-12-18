<?php

namespace Controllers;

use Core\Validator;
use Core\View;
use Exception;
use Laminas\Diactoros\Response\RedirectResponse;
use Models\Task;
use Psr\Http\Message\ServerRequestInterface;

class TaskController
{
	/**
	 * @throws Exception
	 */
	public function add(ServerRequestInterface $request, $params = []): \Laminas\Diactoros\Response
	{
		$view = new View();
		$params = array_merge(['title' => 'Добавление задачи'], $params);
		return $view->render('task-create-form', $params);
	}

	public function create(ServerRequestInterface $request): \Laminas\Diactoros\Response
	{
		$values = $request->getParsedBody();
		$valid = Validator::validate(
			$values,
			[
				'description' => 'required|string',
				'email' => 'required|string|email',
				'user_name' => 'required|string'
			]
		);
		if(!$valid){
			return $this->add($request, ['error'=>'Поля заполнены не верно']);
		}
		$task = new Task($values);
		$task->insert();
		return new RedirectResponse('/');
	}

	/**
	 * @throws Exception
	 */
	public function update(ServerRequestInterface $request)
	{
		$values = $request->getParsedBody();
		$valid = Validator::validate(
			$values,
			[
				'description' => 'required|string'
			]
		);
		if(!$valid){
			return $this->add($request, ['error'=>'Поля заполнены не верно']);
		}

		$id = (int)$request->getAttribute('id');

		$status = $values['status'] ?? 0;

		$description = $values['description'];


		$task = Task::getById($id);
		$task->setStatus($status);

		if ($task->getDescription() != htmlspecialchars($description)) {
			$task->setStatus(2);
		}

		$task->setDescription($description);
		$task->update();

		$view = new View();
		return $view->render(
			'task-update-form',
			[
				'title' => "Редактирование задачи {$task['id']}",
				'task' => $task->getAttributes(),
				'message' => 'Задача успешно обновлена'
			]
		);
	}

	/**
	 * @throws Exception
	 */
	public function completed(ServerRequestInterface $request)
	{
		$id = $request->getAttribute('id');
		$task = Task::getById($id);
		$task->setStatus(1);
		$task->update();
		return new RedirectResponse('/');
	}

	/**
	 * @throws Exception
	 */
	public function edit(ServerRequestInterface $request): \Laminas\Diactoros\Response
	{
		$id = $request->getAttribute('id');
		$task = Task::getById($id);
		if (!$task) {
			throw new Exception('Not found', 404);
		}
		$view = new View();
		return $view->render(
			'task-update-form',
			[
				'title' => "Редактирование задачи {$task['id']}",
				'task' => $task->getAttributes()
			]
		);
	}
}