<?php

header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ALL);

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

require_once 'conexao.php';

$id = $_POST['pId'] ?? '';

$nome = $_POST['pNome'] ?? '';

$id = trim($id);

$nome = trim($nome);

if(
    $id == '' ||
    $nome == '' 
){

    echo json_encode([
        'status' => 'error',
        'message' => 'Preencha todos os campos obrigatórios'
    ]);

    exit;

}

if(!is_numeric($id)){

    echo json_encode([
        'status' => 'error',
        'message' => 'ID da pessoa inválido.'
    ]);

    exit;

}

try{

    $sql = "
        UPDATE tbEventoTipo
        SET
            nome = ?
        WHERE evento_tipo_id = ?
    ";

    $stmt = $conexao->prepare($sql);

    if(!$stmt){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $stmt->bind_param(
        "si",
        $nome,
        $id
    );

    if(!$stmt->execute()){

        throw new Exception(
            "Erro ao atualizar usuário: " .
            $stmt->error
        );

    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Usuário atualizado com sucesso.'
    ]);

    $stmt->close();

    $conexao->close();

}
catch (Exception $e){

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);

}

?>