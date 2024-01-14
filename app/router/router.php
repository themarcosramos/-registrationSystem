<?php

 //array que vai ter todas as rotas do sistema
// function routes(): array
// {
//     return require'routes.php';
// }

//uri  com valore exatos 
function exactMatchUriInArrayRoutes($uri,$routes): array
{
    // if(array_key_exists($uri,$routes)){
    //     return [$uri =>$routes[$uri]];
    //  }

    //  return [];

    return (array_key_exists($uri, $routes)) ? [$uri => $routes[$uri]] : [];
}


// uri dinâmicas 
function regularExpressionMatchArrayRoutes($uri, $routes): array
{
    return array_filter(
        $routes,
        function ($value) use ($uri) {
            $regex = str_replace('/', '\/', ltrim($value, '/'));
            return preg_match("/^$regex$/", ltrim($uri, '/'));// verifico se o $regex bate com o uri
        },
        ARRAY_FILTER_USE_KEY  // pegar só o  índices do array ou  com array_keys($routes),
    );
}

function params($uri, $matchedUri)
{
    if (!empty($matchedUri)) {
        $matchedToGetParams = array_keys($matchedUri)[0];
        return array_diff(
            $uri,
            explode('/', ltrim($matchedToGetParams, '/'))
        );
    }
    return [];
}

function paramsFormat($uri, $params)
{
    $paramsData = [];
    foreach ($params as $index => $param) {
        $paramsData[$uri[$index - 1]] = $param;
    }

    return $paramsData;
}

function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH); // pegar o uri 
    
    $routes = require 'routes.php';

    $requestMethod = $_SERVER['REQUEST_METHOD']; //$_SERVER['REQUEST_URI'] trás  exatamente o requsição que está fazendo 

    // rotas exata
    $matchedUri = exactMatchUriInArrayRoutes($uri, $routes[$requestMethod]);  // se encontrar a rota exata

    // rota dinâmiica 
    $params = [];
    if (empty($matchedUri)) {
        $matchedUri = regularExpressionMatchArrayRoutes($uri, $routes);
        $uri = explode('/', ltrim($uri, '/'));
        $params = params($uri, $matchedUri);
        $params = paramsFormat($uri, $params);
   
    }

    if ($_ENV['MAINTENANCE'] === 'true') {
        $matchedUri = ['/maintenance' => 'Maintenance@index'];
    }
    
    //se não estiver vazio
    if (!empty($matchedUri)) {
        return loadController($matchedUri, $params);
        
    }

    throw new Exception("Opss ocorreu um erro");
    

}
