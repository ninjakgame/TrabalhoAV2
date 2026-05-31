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
    $vCpf = trim($_POST["pCpf"] ?? '');
    $vNascimento = trim($_POST["pNascimento"] ?? '');
    $vTelefone = trim($_POST["pTelefone"] ?? '');

    if(
        $vNome == '' ||
        $vCpf == '' ||
        $vNascimento == ''||
        $vTelefone == ''
    ){
        throw new Exception(
            "Preencha todos os campos"
        );
    }

    $sqlVerifica = $conexao->prepare("
        SELECT pessoa_id
        FROM tbPessoas
        WHERE cpf = ?
    ");

    if(!$sqlVerifica){

        throw new Exception(
            "Erro no prepare da verificação: " .
            $conexao->error
        );

    }

    $sqlVerifica->bind_param(
        "s",
        $vCpf
    );

    $sqlVerifica->execute();
    $sqlVerifica->store_result();

    if($sqlVerifica->num_rows > 0){

        throw new Exception(
            "Este usuário já está cadastrado"
        );

    }

    $sql = $conexao->prepare("
        INSERT INTO tbPessoas
        (
            nome,
            cpf,
            nascimento,
            telefone
        )
        VALUES (?, ?, ?, ?)
    ");

    if(!$sql){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $sql->bind_param(
        "ssss",
        $vNome,
        $vCpf,
        $vNascimento,
        $vTelefone
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