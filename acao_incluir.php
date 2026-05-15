<?php

header('Content-Type: application/json');

$retorno = [
    'status' => 'error',
    'message' => 'Erro desconhecido'
];

try{

    require_once 'conexao.php';

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        throw new Exception("Método inválido");
    }

    $vNome = trim($_POST["pNome"] ?? '');
    $vLogin = trim($_POST["pLogin"] ?? '');
    $vSenha = trim($_POST["pSenha"] ?? '');

    if(
        $vNome == '' ||
        $vLogin == '' ||
        $vSenha == ''
    ){
        throw new Exception(
            "Preencha todos os campos"
        );
    }

    $sqlVerifica = $conexao->prepare("
        SELECT usuario_id
        FROM tbUsuarios
        WHERE login = ?
    ");

    if(!$sqlVerifica){

        throw new Exception(
            "Erro no prepare da verificação: " .
            $conexao->error
        );

    }

    $sqlVerifica->bind_param(
        "s",
        $vLogin
    );

    $sqlVerifica->execute();

    $resultado = $sqlVerifica->get_result();

    if($resultado->num_rows > 0){

        throw new Exception(
            "Este usuário já está cadastrado"
        );

    }

    $vSenhaHash = password_hash(
        $vSenha,
        PASSWORD_DEFAULT
    );

    $sql = $conexao->prepare("
        INSERT INTO tbUsuarios
        (
            nome,
            login,
            senha
        )
        VALUES (?, ?, ?)
    ");

    if(!$sql){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $sql->bind_param(
        "sss",
        $vNome,
        $vLogin,
        $vSenhaHash
    );

    if($sql->execute()){

        $retorno = [
            'status' => 'success',
            'message' => 'Usuário cadastrado com sucesso',
            'id' => $conexao->insert_id
        ];

    } else {

        throw new Exception(
            "Erro ao gravar: " .
            $sql->error
        );

    }

    $sqlVerifica->close();

    $sql->close();

    $conexao->close();

}
catch (Throwable $e){

    $retorno = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];

}

echo json_encode($retorno);

exit;

?>