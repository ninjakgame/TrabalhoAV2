<?php
    require_once 'conexao.php';

    $retorno = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $usuario_id = filter_input(INPUT_POST, "pUsuario_id", FILTER_VALIDATE_INT);

        if(!$usuario_id){
            echo "ID de usuário inválido.";
            exit;
        }

        try {
            $sql_delete = $conexao->prepare(
                "DELETE FROM tbUsuarios WHERE usuario_id = ?"
            );

            if(!$sql_delete){
                throw new Exception($conexao->error);
            }

            $sql_delete->bind_param("i", $usuario_id);

            if($sql_delete->execute()){
                if($sql_delete->affected_rows > 0){
                    $retorno = "Usuário excluído com sucesso!";
                } else {
                    $retorno = "Nenhum usuário encontrado para excluir.";
                }
            } else {
                $retorno = "Erro: " . $sql_delete->error;
            }

            $sql_delete->close();

            $conexao->close();
        }

        catch (Exception $e){
            $retorno = "Erro ao excluir: " . $e->getMessage();
        }
    }

    echo $retorno;
?>
