<?php

header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ALL);

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

require_once 'conexao.php';

$id = $_POST['pId'] ?? '';

$nome = $_POST['pNome'] ?? '';

$login = $_POST['pLogin'] ?? '';

$senha = $_POST['pSenha'] ?? '';

$id = trim($id);

$nome = trim($nome);

$login = trim($login);

$senha = trim($senha);

if(
    $id == '' ||
    $nome == '' ||
    $login == '' ||
    $senha == ''
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
        'message' => 'ID do usuário inválido.'
    ]);

    exit;

}

try{

    $senhaHash = password_hash(
        $senha,
        PASSWORD_DEFAULT
    );

    $sql = "
        UPDATE tbUsuarios
        SET
            nome = ?,
            login = ?,
            senha = ?
        WHERE usuario_id = ?
    ";

    $stmt = $conexao->prepare($sql);

    if(!$stmt){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $stmt->bind_param(
        "sssi",
        $nome,
        $login,
        $senhaHash,
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