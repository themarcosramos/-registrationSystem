<?php


function loadController($matchedUri,$params)
{
    // usando List 
    // List($controller,$method) = explode('@',array_values($matchedUri)[0]);

    //versão reduzida usando List
    [$controller,$method] = explode('@',array_values($matchedUri)[0]);
    
    $controllerWithNamespace = CONTROLLER_PATH.$controller;

    //verificar se classe controller não existe 
    if (! class_exists($controllerWithNamespace)) {
       throw new Exception("A classe {$controller} não existe");
       
    }

    $controllerInstance = new $controllerWithNamespace;

     //verifica se o metodo não existe
     if(!method_exists($controllerInstance,$method)){
        throw new Exception("O método {$method} não existe na classe {$controller}");
     }

     $controller = $controllerInstance->$method($params);

     //se a requsiação só  do tipo post para o redirecionamento 
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      die();
  }

     return $controller;
}
