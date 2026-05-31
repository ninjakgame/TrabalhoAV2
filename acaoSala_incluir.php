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

    $vNumero = trim($_POST["pNumero"] ?? '');

    if(
        $vNumero == ''
    ){
        throw new Exception(
            "Preencha todos os campos"
        );
    }

    $sqlVerifica = $conexao->prepare("
        SELECT sala_id
        FROM tbSalas
        WHERE numero = ?
    ");

    if(!$sqlVerifica){

        throw new Exception(
            "Erro no prepare da verificação: " .
            $conexao->error
        );

    }

    $sqlVerifica->bind_param(
        "s",
        $vNumero
    );

    $sqlVerifica->execute();
    $sqlVerifica->store_result();

    if($sqlVerifica->num_rows > 0){

        throw new Exception(
            "Esta Sala já está cadastrado"
        );

    }

    $sql = $conexao->prepare("
        INSERT INTO tbSalas
        (
            numero
        )
        VALUES (?)
    ");

    if(!$sql){

        throw new Exception(
            "Erro no prepare: " .
            $conexao->error
        );

    }

    $sql->bind_param(
        "s",
        $vNumero
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