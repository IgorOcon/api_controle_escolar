<?php
class API{

  public function __construct(){

    if(!isset($_SERVER['HTTP_AUTH']) || empty($_SERVER['HTTP_AUTH'])){
      output_header(false,'Token nao enviado',array('consulte o manual da api','manual disponivel em nosso site'));
    }

    if($_SERVER['HTTP_AUTH'] != "123456"){
      output_header(false,'Token invalido',array('Token enviado nao encontrado','consulte o manual da api','manual disponivel em nosso site'));
    }		
  }

}