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
$sql->store_result();

if($sql->num_rows > 0){
    $sql->bind_result($senhaBanco);
    $sql->fetch();

    if (password_verify($vSenha, $senhaBanco)) {
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "0";
}
?>