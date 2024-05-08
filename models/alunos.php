<?php

// Incluindo a biblioteca para lidar com requisições HTTP
require 'vendor/autoload.php';
use \Slim\Slim;
use \Slim\Http\Request;
use \Slim\Http\Response;

// Criando a aplicação Slim
$app = new Slim();

// Array de alunos para teste
$alunos = [
    "123" => ["nome" => "João", "curso" => "Ciência da Computação"],
    "456" => ["nome" => "Maria", "curso" => "Sistemas de Informação"],
    "789" => ["nome" => "Pedro", "curso" => "Engenharia Elétrica"],
];

// Endpoint para listar todos os alunos (GET /alunos)
$app->get('/alunos', function (Request $request, Response $response) {
    global $alunos;
    $response->write(json_encode($alunos));
    return $response;
});

// Endpoint para buscar um aluno pelo RM (GET /alunos/{rm})
$app->get('/alunos/{rm}', function (Request $request, Response $response, $args) {
    global $alunos;
    $rm = $args['rm'];

    if (isset($alunos[$rm])) {
        $response->write(json_encode($alunos[$rm]));
        return $response;
    } else {
        $response->write(json_encode(["mensagem" => "Aluno não encontrado"]));
        return $response->withStatus(404);
    }
});

// Endpoint para adicionar um novo aluno (POST /alunos)
$app->post('/alunos', function (Request $request, Response $response) {
    global $alunos;
    $data = json_decode($request->getBody(), true);

    if (isset($data['rm']) && isset($data['nome']) && isset($data['curso'])) {
        $rm = $data['rm'];
        $nome = $data['nome'];
        $curso = $data['curso'];

        $alunos[$rm] = ["nome" => $nome, "curso" => $curso];
        $response->write(json_encode($alunos[$rm]));
        return $response->withStatus(201);
    } else {
        $response->write(json_encode(["mensagem" => "Dados inválidos"]));
        return $response->withStatus(400);
    }
});

// Endpoint para atualizar um aluno pelo RM (PUT /alunos/{rm})
$app->put('/alunos/{rm}', function (Request $request, Response $response, $args) {
    global $alunos;
    $rm = $args['rm'];
    $data = json_decode($request->getBody(), true);

    if (isset($alunos[$rm]) && isset($data['nome']) && isset($data['curso'])) {
        $nome = $data['nome'];
        $curso = $data['curso'];

        $alunos[$rm]['nome'] = $nome;
        $alunos[$rm]['curso'] = $curso;
        $response->write(json_encode($alunos[$rm]));
        return $response;
    } else {
        $response->write(json_encode(["mensagem" => "Aluno não encontrado ou dados inválidos"]));
        return $response->withStatus(isset($alunos[$rm]) ? 400 : 404);
    }
});

// Endpoint para remover um aluno pelo RM (DELETE /alunos/{rm})
$app->delete('/alunos/{rm}', function (Request $request, Response $response, $args) {
    global $alunos;
    $rm = $args['rm'];

    if (isset($alunos[$rm])) {
        unset($alunos[$rm]);
        $response->write(json_encode(["mensagem" => "Aluno removido com sucesso"]));
        return $response->withStatus(200);
    } else {
        $response->write(json_encode(["mensagem" => "Aluno não encontrado"]));
        return $response->withStatus(404);
    }
});

// Executando a aplicação
$app->run();
