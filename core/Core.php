<?php
class Core{


//alterar esse arquivo para definir as rotas da nosso API
  

  public function exec(){
    //criando uma instancia do roteador
    $router = new Router();

    //configurar as rotas
    $router->addRoute('/', array(new homeController(), 'index'));
    $router->addRoute('/produtos', array(new produtosController(), 'index'));

    //configuracoes da api pokemon
    $router->addRoute('/pokemon', array(new pokemonController(), 'index'));
    $router->addRoute('/pokemon/lista', array(new pokemonController(), 'lista'));
    $router->addRoute('/pokemon/get', array(new pokemonController(), 'get'));
    $router->addRoute('/pokemon/search', array(new pokemonController(), 'search'));
    $router->addRoute('/pokemon/tipo', array(new pokemonController(), 'tipo'));

    //configurando rota de pagina nao encontrada
    $router->addRoute('/404', array(new notfoundController(), 'index'));

    //lidando com a requisicao
    $route = isset($_GET['route'])?'/'.$_GET['route']:'/';

    $router->handleRequest($route);
  }

}