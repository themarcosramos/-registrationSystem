<?php

require 'bootstrap.php';

try {
     $data = router();
    
    //para ter acesso a variaveis na views
    // extract(['name'=>'Marcos']);


    //obrigo o ususario passa o índice data 
     if (!isset($data['data'])) {

        throw new Exception("O  índices data está faltando ");
     }


     if (!isset($data['data']['title'])) {
        throw new Exception('O índice title está faltando');
    }

   //verificar se não esta seta  no data  o índices chamado view 
    if (!isset($data['view'])) {
    
        throw new Exception("O  índices view está faltando ");
    
    }

    //verifica  se não exiete o arquivo de views
    if (!file_exists(VIEWS.$data['view'].'.php')) {
        throw new Exception("Essa view {$data['view']} não existe");
    }
    
     extract($data['data']);

     $view = $data['view'];

     require VIEWS.'master.php';

} catch (Exception $e) {
    var_dump(
        $e->getMessage()
    );
}



