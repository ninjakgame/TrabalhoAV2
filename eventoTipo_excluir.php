<?php
    require_once 'conexao.php';

    $retorno = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $evento_tipo_id = filter_input(INPUT_POST, "pEvento_tipo_id", FILTER_VALIDATE_INT);

        if(!$evento_tipo_id){
            echo "ID do evento está inválido.";
            exit;
        }

        try {
            $sql_delete = $conexao->prepare(
                "DELETE FROM tbEventoTipo WHERE evento_tipo_id = ?"
            );

            if(!$sql_delete){
                throw new Exception($conexao->error);
            }

            $sql_delete->bind_param("i", $evento_tipo_id);

            if($sql_delete->execute()){
                if($sql_delete->affected_rows > 0){
                    $retorno = "Evento excluído com sucesso!";
                } else {
                    $retorno = "Nenhum evento foi encontrado para excluir.";
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
