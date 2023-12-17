<?php

namespace Core;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public static function run()
    {
        $path = $_SERVER['REQUEST_URI'];
        $pathParts = explode('/', $path);
        $controller = 'controllers\\' . $pathParts[1] . 'Controller';
        $action = strtolower($pathParts[2]);
        if(!class_exists($controller)){
            throw new Exception('Controller does not exist');
        }

        $objController = new $controller;

        if(!method_exists($objController, $action)){
            throw new Exception('Action does not exist');
        }

        $objController->$action();
    }
}