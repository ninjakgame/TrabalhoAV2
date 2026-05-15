<?php
$servername = "savir08bd.mysql.dbaas.com.br";
$username = "savir08bd";
$password = "savir#08BD";
$dbname = "savir08bd";

$conexao = new mysqli($servername, $username, $password, $dbname);
$conexao->set_charset("utf8mb4");

if($conexao->connect_error){
    die("000000Conexao falhou: " . $conexao->connect_error);
}
?>