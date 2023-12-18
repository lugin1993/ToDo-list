<?php

namespace Controllers;

use Core\View;
use Laminas\Diactoros\Response\RedirectResponse;
use Models\User;
use Psr\Http\Message\ServerRequestInterface;

class LoginController
{
    public function index(ServerRequestInterface $request, $params = []): \Laminas\Diactoros\Response
	{
		$params = array_merge(['title' => 'Авторизация'], $params);
        return (new View())->render('login-form', $params);
    }

    public function login(ServerRequestInterface $request)
    {
        $values = $request->getParsedBody();
        $login = $values['login'];
        $password = $values['password'];
		if(!$login || !$password){
			return $this->index($request, ['error'=>'Имя пользователя и пароль обязательные для заполнения']);
		}
        $model = new User();
        $user = $model->getByLogin($login);
        if ($user['password'] !== md5($password)) {
			return $this->index($request, ['error'=>'Неверный логин или пароль']);
        }
        setcookie("userId", $user['id'], time() + 50000, '/');
        setcookie("userName", $user['name'], time() + 50000, '/');
		return new RedirectResponse('/');
    }

    public function logout()
    {
        setcookie("userName", '', time() - 3600, '/');
        setcookie("userId", '', time() - 3600, '/');
		return new RedirectResponse('/');
    }
}