<?php

namespace Core;

use Exception;
use Laminas\Diactoros\Response;
use Models\User;

class View
{
	public bool $authorizedUser = false;
	public array $templateParams = [];
	public function __construct()
	{
		$this->authorizedUser = User::isAuthorized();
		$this->templateParams = [
			'authorized' => $this->authorizedUser,
			'pageParams' => ''
		];

		return $this;
	}

    public function render(string $path, array $data = [])
    {
		$res = $this->renderLayout($data, $this->renderView($path, $data));
		$response = new Response();
		$response->getBody()->write($res);
        return $response;
    }

    private function renderLayout($data, $content)
    {
		$data = array_merge($this->templateParams, $data);
        $fullPath = __DIR__ . '/../views/layouts/default.php';

        if (!file_exists($fullPath)) {
            throw new Exception('view cannot be found');
        }
		ob_start();
		extract($data);
        include $fullPath;
		return ob_get_clean();
    }

    private function renderView(string $viewName, array $data = [])
    {
		$data = array_merge($this->templateParams, $data);

        $fullPath = __DIR__ . '/../views/' . $viewName . '.php';

        if (!file_exists($fullPath)) {
            throw new Exception('view cannot be found');
        }

        ob_start();
        extract($data);
        include $fullPath;
		return ob_get_clean();
    }
}