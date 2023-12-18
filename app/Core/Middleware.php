<?php

namespace App\Core;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Middleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
        if(User::isAuthorized()){
            return $handler->handle($request);
        }
		return (new View())->render('login-form', ['title' => 'Авторизация', 'error'=>'Необходимо авторизоваться']);
    }
}