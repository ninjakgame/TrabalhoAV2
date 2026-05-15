<?php

require_once 'conexao.php';

$vLogin = $_POST['pLogin'] ?? '';
$vSenha = $_POST['pSenha'] ?? '';

$sql = $conexao->prepare("
    SELECT senha
    FROM tbUsuarios
    WHERE login = ?
");

$sql->bind_param("s", $vLogin);

$sql->execute();

$result = $sql->get_result();

if($result->num_rows > 0){

    $row = $result->fetch_assoc();

    $senhaBanco = $row['senha'];

    if(password_verify($vSenha, $senhaBanco)){

        echo "1";

    } else {

        echo "0";

    }

} else {

    echo "0";

}
?>