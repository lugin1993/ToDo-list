<?php

namespace Controllers;

use Exception;
use Models\Task;
use Core\View;
use Psr\Http\Message\ServerRequestInterface;

class MainController
{
    /**
     * @throws Exception
     */
    public function index()
    {
        return (new View())->render('index',
            [
                'tasks' => Task::getAll(),
                'number_pages' => Task::getNumberPage(),
                'page' => 1,
                'title' => 'Главная страница'
            ]);
    }

    /**
     * @throws Exception
     */
    public function page(ServerRequestInterface $request)
    {
        $page = $request->getAttribute('id');
        $orderBy = $request->getQueryParams()['orderBy'] ?? 'id';
        $direction = $request->getQueryParams()['direction'] ?? 'ASC';
        $numberPage = Task::getNumberPage();
        if($page > $numberPage){
            throw new Exception('Not found', 404);
        }

        return (new View())->render('index',
            [
                'tasks' => Task::getAll($page, $orderBy, $direction),
                'number_pages' => $numberPage,
				'pageParams' => sprintf('?orderBy=%s&direction=%s', $orderBy, $direction),
                'page' => $page,
                'title' => 'Главная страница'
            ]);
    }
}