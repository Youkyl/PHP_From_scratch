<?php

namespace App\core;

class Router
{
    public function run()
    {
        /*
             http://localhost:8000/index.php?controller=compte&action=create
             $controller = $_GET['controller'];  ==> compte
             $action =  $_GET['action'];
         */

        $controller = $_REQUEST['controller'] ?? 'home';  //ucfirst(home) ==> Home
        $action     = $_REQUEST['action'] ?? 'index';

        $controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';
      
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo "Controller introuvable";
            return;
        }

        $controllerInstance = new $controllerClass();
        if (!method_exists($controllerInstance, $action)) {
            http_response_code(404);
            echo "Action introuvable";
            return;
        }
        
        $controllerInstance->$action();
    }
}