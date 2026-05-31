<?php

header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ALL);

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

require_once 'conexao.php';

$id = $_POST['pId'] ?? '';

$nome = $_POST['pNome'] ?? '';

$cpf = $_POST['pCpf'] ?? '';

$nascimento = $_POST['pNascimento'] ?? '';

$telefone = $_POST['pTelefone'] ?? '';

$id = trim($id);

$nome = trim($nome);

$cpf = trim($cpf);

$nascimento = trim($nascimento);

$telefone = trim($telefone);

if(
    $id == '' ||
    $nome == '' ||
    $cpf == '' ||
    $nascimento == ''||
    $telefone == ''
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
        UPDATE tbPessoas
        SET
            nome = ?,
            cpf = ?,
            nascimento = ?,
            telefone = ?
        WHERE pessoa_id = ?
    ";

    $stmt = $conexao->prepare($sql);

    if(!$stmt){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $stmt->bind_param(
        "ssssi",
        $nome,
        $cpf,
        $nascimento,
        $telefone,
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