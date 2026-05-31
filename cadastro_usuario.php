<?php

include "conexao.php";

$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "
    INSERT INTO tbUsuarios
    (
        nome,
        login,
        senha
    )

    VALUES
    (
        '$nome',
        '$login',
        '$senha'
    )
";

mysqli_query($conexao, $sql);

echo "Usuário cadastrado";

?>